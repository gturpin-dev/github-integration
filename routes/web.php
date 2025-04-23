<?php

use App\Contracts\GithubContract;
use App\Http\Integrations\Github\GithubConnector;
use App\Http\Integrations\Github\Requests\GetRepositoryRequest;
use App\Services\GithubService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/repositories/{owner}/{repositoryName}', function (string $owner, string $repositoryName, GithubContract $githubService) {
    dd(
        $owner,
        $repositoryName,
        $githubService,
        $githubService->getRepository(
            $owner,
            $repositoryName,
        ),
    );
})->name('repositories.show');
