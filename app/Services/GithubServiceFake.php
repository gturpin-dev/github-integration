<?php

declare(strict_types=1);

namespace App\Services;

use PHPUnit\Framework\Assert;
use Illuminate\Support\Collection;
use Faker\Generator;
use App\Exceptions\GithubException;
use App\DataObjects\UpdateRepositoryData;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\Contracts\GithubContract;
use App\Collections\Github\RepositoryCollection;

final class GithubServiceFake implements GithubContract
{
    private Collection $repositoriesToCreate;

    private GithubException $failureException;

    public function __construct()
    {
        $this->repositoriesToCreate = Collection::make();
    }

    public function getRepositories(string $owner): RepositoryCollection
    {
        return RepositoryCollection::make([
            $this->fakeRepositoryData(),
            $this->fakeRepositoryData(),
            $this->fakeRepositoryData(),
        ]);
    }

    public function getRepository(string $owner, string $repositoryName): RepositoryData
    {
        throw new \Exception('Not implemented');
    }

    public function getRepositoryLanguages(string $owner, string $repositoryName): array
    {
        throw new \Exception('Not implemented');
    }

    public function createRepository(NewRepositoryData $repositoryData): RepositoryData
    {
        $this->repositoriesToCreate = $this->repositoriesToCreate->push($repositoryData);

        return $this->fakeRepositoryData(
            repositoryName: $repositoryData->name,
            isPrivate     : $repositoryData->isPrivate,
        );
    }

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData
    {
        throw new \Exception('Not implemented');
    }

    public function deleteRepository(string $owner, string $repositoryName): void
    {
        throw new \Exception('Not implemented');
    }

    public function assertRepositoryCreated(
        ?string $owner,
        string $name,
        bool $isPrivate,
    ): void
    {
        $repositoryToBeCreated = $this->repositoriesToCreate
            ->when($owner !== null, fn (Collection $repositories) => $repositories->where('owner', $owner) )
            ->where('name', $name)
            ->where('is_private', $isPrivate);

        Assert::assertTrue(
            $repositoryToBeCreated->isNotEmpty(),
            'The repository was not created'
        );
    }

    public function assertNoRepositoriesCreated(): void
    {
        Assert::assertEmpty(
            $this->repositoriesToCreate,
            'Repositories were created'
        );
    }

    public function shouldFailWithException(GithubException $exception): self
    {
        $this->failureException = $exception;

        return $this;
    }

    private function fakeRepositoryData(
        ?string $owner = null,
        ?string $repositoryName = null,
        bool $isPrivate = false,
    ): RepositoryData
    {
        $faker = app(Generator::class);

        $owner          ??= $faker->word();
        $repositoryName ??= $faker->word();
        $isPrivate      ??= $faker->boolean();

        return new RepositoryData(
            id         : $faker->randomNumber(),
            owner      : $owner,
            name       : $repositoryName,
            fullName   : $owner . '/' . $repositoryName,
            description: $faker->sentence(),
            isPrivate  : $isPrivate,
            createdAt  : now()
        );
    }
}
