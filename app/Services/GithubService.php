<?php

declare(strict_types=1);

namespace App\Services;

use Saloon\Http\Auth\TokenAuthenticator;
use App\Http\Integrations\Github\Requests\GetRepositoryRequest;
use App\Http\Integrations\Github\GithubConnector;
use App\DataObjects\UpdateRepositoryData;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\Contracts\GithubContract;
use App\Collections\Github\RepositoryCollection;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Storage;
use Saloon\Http\Auth\BasicAuthenticator;

final class GithubService implements GithubContract
{
    public function __construct(
        private string $privateKey,
    ) {}

    public function getRepositories(): RepositoryCollection { }

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
