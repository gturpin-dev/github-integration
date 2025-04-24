<?php

use App\Contracts\GithubContract;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/repositories/{owner}/{repositoryName}', function (string $owner, string $repositoryName, GithubContract $githubService) {
    dd(
        $owner,
        $repositoryName,
        $githubService->getRepository(
            $owner,
            $repositoryName,
        ),
    );
})->name('repositories.show');

Route::get('/repositories/{owner}', function (string $owner, GithubContract $githubService) {
    dd(
        $owner,
        $githubService->getRepositories($owner),
    );
})->name('repositories.index');
