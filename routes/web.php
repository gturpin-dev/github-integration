<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Github\ListGithubRepositoryLanguages;
use App\Http\Controllers\Github\GithubRepositoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');

        Route::get('/{owner}/{repositoryName}/languages', ListGithubRepositoryLanguages::class)->name('languages');
    });
