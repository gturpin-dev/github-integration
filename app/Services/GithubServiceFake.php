<?php

declare(strict_types=1);

namespace App\Services;

use App\Collections\Github\RepositoryCollection;
use App\Contracts\GithubContract;
use App\DataObjects\RepositoryData;
use App\DataObjects\NewRepositoryData;
use App\DataObjects\UpdateRepositoryData;
use Faker\Generator;

final class GithubServiceFake implements GithubContract
{
    private Generator $faker;

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
        throw new \Exception('Not implemented');
    }

    public function updateRepository(string $owner, string $repositoryName, UpdateRepositoryData $repositoryData): RepositoryData
    {
        throw new \Exception('Not implemented');
    }

    public function deleteRepository(string $owner, string $repositoryName): void
    {
        throw new \Exception('Not implemented');
    }

    private function fakeRepositoryData(): RepositoryData
    {
        $faker = app(Generator::class);

        $owner          ??= $faker->word();
        $repositoryName ??= $faker->word();

        return new RepositoryData(
            id         : $faker->randomNumber(),
            owner      : $owner,
            name       : $repositoryName,
            fullName   : $owner . '/' . $repositoryName,
            description: $faker->sentence(),
            isPrivate  : $faker->boolean(),
            createdAt  : now()
        );
    }
}
