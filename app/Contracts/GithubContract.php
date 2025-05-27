<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataObjects\IssueData;
use App\DataObjects\NewIssueData;
use App\DataObjects\UpdateRepositoryData;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\Collections\Github\RepositoryCollection;

interface GithubContract
{
    public function getRepositories(string $owner): RepositoryCollection;

    public function getRepository(string $owner, string $repositoryName): RepositoryData;

    /**
     * @return array<string>
     */
    public function getRepositoryLanguages(string $owner, string $repositoryName): array;

    public function createRepository(NewRepositoryData $repositoryData): RepositoryData;

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData;

    public function deleteRepository(string $owner, string $repositoryName): void;

    public function createIssue(string $owner, string $repositoryName, NewIssueData $newIssueData): IssueData;
}
