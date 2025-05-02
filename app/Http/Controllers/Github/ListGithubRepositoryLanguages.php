<?php

namespace App\Http\Controllers\Github;

use App\Contracts\GithubContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListGithubRepositoryLanguages extends Controller
{
    /**
     * @return array<string>
     */
    public function __invoke(string $owner, string $repositoryName, GithubContract $githubService): array
    {
        return $githubService->getRepositoryLanguages($owner, $repositoryName);
    }
}
