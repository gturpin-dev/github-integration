<?php

declare(strict_types=1);

namespace App\Services;

use App\Collections\Github\RepositoryCollection;
use App\Contracts\GithubContract;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\DataObjects\UpdateRepositoryData;

final class GithubService implements GithubContract
{
    public function __construct(
        private string $token,
    ) {}

    public function getRepositories(): RepositoryCollection { }

    public function getRepository(string $owner, string $repositoryName): RepositoryData { }

    public function getRepositoryLanguages(string $owner, string $repositoryName): array { }

    public function createRepository(NewRepositoryData $repositoryData): RepositoryData { }

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData { }

    public function deleteRepository(string $owner, string $repositoryName): void { }
}
