<?php

declare(strict_types=1);

use function Pest\Laravel\get;
use App\Services\GithubServiceFake;
use App\Exceptions\GithubException;
use App\DataObjects\NewRepositoryData;

use App\Contracts\GithubContract;
use App\Collections\Github\RepositoryCollection;

beforeEach(function () {
    $this->githubServiceFake = new GithubServiceFake;
    $this->swap(GithubContract::class, $this->githubServiceFake);
});

test('view can be returned with repositories', function () {
    $this->get(route('repositories.index', ['owner' => 'gturpin-dev']))
        ->assertOk()
        ->assertViewIs('github.repositories.index')
        ->assertViewHas('repositories', fn ( RepositoryCollection $repositories ) => $repositories->count() === 3);
});

test('repository can be created', function () {
    $newRepositoryData = new NewRepositoryData(
        name       : 'test-repo',
        description: 'Test repository description',
        isPrivate  : false,
    );

    $this->githubServiceFake->createRepository($newRepositoryData);

    $this->githubServiceFake->assertRepositoryCreated(
        owner    : null,
        name     : $newRepositoryData->name,
        isPrivate: $newRepositoryData->isPrivate,
    );
});

// test('repository cannot be created', function () {
//     $this->githubServiceFake->shouldFailWithException(
//         new GithubException('Failed to create repository')
//     );

//     $this->githubServiceFake->createRepository(new NewRepositoryData(
//         name       : 'test-repo',
//         description: 'Test repository description',
//         isPrivate  : true,
//     ));

//     $this->githubServiceFake->assertNoRepositoriesCreated();
// });
