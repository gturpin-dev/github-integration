<?php

declare(strict_types=1);

namespace App\Services;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Auth\BasicAuthenticator;
use Illuminate\Support\Facades\Storage;
use Firebase\JWT\JWT;
use App\Http\Integrations\Github\Requests\GetRepositoryRequest;
use App\Http\Integrations\Github\Requests\GetRepositoriesRequest;
use App\Http\Integrations\Github\GithubConnector;
use App\DataObjects\UpdateRepositoryData;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\Contracts\GithubContract;
use App\Collections\Github\RepositoryCollection;

final class GithubService implements GithubContract
{
    public function __construct(
        private string $privateKey,
    ) {}

    public function getRepositories(string $owner): RepositoryCollection {
        $request = new GetRepositoriesRequest( $owner );

        return new RepositoryCollection(
            $request->paginate($this->connector())->collect()
        );
    }

    public function getRepository(string $owner, string $repositoryName): RepositoryData {
        return $this->connector()
            ->send(
                new GetRepositoryRequest(
                    $owner,
                    $repositoryName,
                )
            )
            ->dtoOrFail();
    }

    public function getRepositoryLanguages(string $owner, string $repositoryName): array { }

    public function createRepository(NewRepositoryData $repositoryData): RepositoryData { }

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData { }

    public function deleteRepository(string $owner, string $repositoryName): void { }

    protected function connector(): GithubConnector
    {
        return app(GithubConnector::class, [
            'privateKey' => $this->privateKey,
        ]);
    }
}
