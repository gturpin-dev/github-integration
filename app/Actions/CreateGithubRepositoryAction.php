<?php

namespace App\Actions;

use App\DataObjects\NewRepositoryData;
use App\Contracts\GithubContract;
use App\DataObjects\RepositoryData;

final class CreateGithubRepositoryAction
{
    public function __construct(
        private readonly NewRepositoryData $newRepositoryData,
    ) {}

    public function execute(): RepositoryData
    {
        return resolve(GithubContract::class)->createRepository(
            $this->newRepositoryData
        );
    }
}
