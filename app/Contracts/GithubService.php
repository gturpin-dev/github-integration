<?php

declare(strict_types=1);

namespace App\Contracts;

interface GithubService
{
    public function getRepositories(): RepositoryCollection;

    public function getRepository(string $owner, string $repositoryName): Repository;

    /**
     * @return array<string>
     */
    public function getRepositoryLanguages(string $owner, string $repositoryName): array;

    public function createRepository(NewRepositoryData $repositoryData): Repository;

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): Repository;

    public function deleteRepository(string $owner, string $repositoryName): void;
}
