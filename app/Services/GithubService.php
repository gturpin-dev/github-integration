<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Integrations\Github\Requests\GetRepositoryRequest;
use App\Http\Integrations\Github\Requests\GetRepositoriesRequest;
use App\Http\Integrations\Github\GithubConnector;
use App\DataObjects\UpdateRepositoryData;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\Contracts\GithubContract;
use App\Collections\Github\RepositoryCollection;
use App\Http\Integrations\Github\Requests\CreateRepositoryRequest;
use App\Http\Integrations\Github\Requests\DeleteRepositoryRequest;
use App\Http\Integrations\Github\Requests\GetRepositoryLanguagesRequest;
use Illuminate\Support\Facades\Log;
use Saloon\Http\Auth\TokenAuthenticator;

final readonly class GithubService implements GithubContract
{
    public function __construct(
        private string $installationId,
        private string $clientId,
        private string $privateKey,
        private string $personalAccessToken,
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

    /**
     * @return array<string> Languages names
     */
    public function getRepositoryLanguages(string $owner, string $repositoryName): array {
        return $this->connector()
            ->send(
                new GetRepositoryLanguagesRequest(
                    $owner,
                    $repositoryName,
                )
            )
            ->collect()
            ->keys()
            ->all();
    }

    public function createRepository(NewRepositoryData $repositoryData): RepositoryData
    {
        return $this->connector()
            ->authenticate(
                new TokenAuthenticator(
                    $this->personalAccessToken
                )
            )
            ->send(
                new CreateRepositoryRequest(
                    $repositoryData,
                )
            )
            ->dtoOrFail();
    }

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData { }

    public function deleteRepository(string $owner, string $repositoryName): void
    {
        $this->connector()
            ->authenticate(
                new TokenAuthenticator(
                    $this->personalAccessToken
                )
            )
            ->send(
                new DeleteRepositoryRequest(
                    $owner,
                    $repositoryName,
                )
            );
    }

    protected function connector(): GithubConnector
    {
        return app(GithubConnector::class, [
            'installationId' => $this->installationId,
            'clientId'       => $this->clientId,
            'privateKey'     => $this->privateKey,
        ]);
    }
}
