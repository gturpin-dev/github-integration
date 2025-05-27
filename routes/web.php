<?php

use App\Contracts\GithubContract;
use App\DataObjects\NewIssueData;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Github\ListGithubRepositoryLanguages;
use App\Http\Controllers\Github\GithubRepositoryController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/create', GithubRepositoryController::create(...))->name('create');

        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');

        Route::delete('/{owner}/{repositoryName}', GithubRepositoryController::destroy(...))->name('destroy');

        Route::get('/{owner}/{repositoryName}/languages', ListGithubRepositoryLanguages::class)->name('languages');
    });

Route::get('/test', function (GithubContract $githubService) {
    return $githubService->createIssue(
        owner: 'gturpin-dev',
        repositoryName: 'github-integration',
        newIssueData: new NewIssueData(
            title: 'test issue',
            description: 'test issue description',
            assignees: ['gturpin-dev'],
            milestone: 'v2.0',
            labels: ['test label'],
        )
    );
});
