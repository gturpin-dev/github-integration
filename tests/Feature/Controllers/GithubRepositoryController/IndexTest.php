<?php

declare(strict_types=1);

use App\Collections\Github\RepositoryCollection;
use App\Contracts\GithubContract;
use App\Services\GithubServiceFake;

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
