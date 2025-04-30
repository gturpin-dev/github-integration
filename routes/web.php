<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GithubRepositoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');
    });
