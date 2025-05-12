<?php

declare(strict_types=1);

use App\Collections\Github\RepositoryCollection;
use App\Contracts\GithubContract;
use App\Services\GithubServiceFake;

test('view can be returned with repositories', function () {
    $githubServiceFake = new GithubServiceFake;

    $this->swap(GithubContract::class, $githubServiceFake);

    $this->get(route('repositories.index', ['owner' => 'gturpin-dev']))
        ->assertOk()
        ->assertViewIs('github.repositories.index')
        ->assertViewHas('repositories', fn ( RepositoryCollection $repositories ) => $repositories->count() === 3);
});
