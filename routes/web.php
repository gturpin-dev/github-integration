<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Github\ListGithubRepositoryLanguages;
use App\Http\Controllers\Github\GithubRepositoryController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/test', 'layout');

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');

        Route::post('/store', GithubRepositoryController::store(...))->name('store')->withoutMiddleware(VerifyCsrfToken::class);

        Route::get('/{owner}/{repositoryName}/languages', ListGithubRepositoryLanguages::class)->name('languages');
    });
