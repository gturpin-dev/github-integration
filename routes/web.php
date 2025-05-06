<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Github\ListGithubRepositoryLanguages;
use App\Http\Controllers\Github\GithubRepositoryController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/test', 'layout');

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/create', GithubRepositoryController::create(...))->name('create');
        Route::post('/store', GithubRepositoryController::store(...))->name('store');

        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');

        Route::get('/{owner}/{repositoryName}/languages', ListGithubRepositoryLanguages::class)->name('languages');
    });
