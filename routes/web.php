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
