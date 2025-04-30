<?php

use Saloon\Http\Auth\TokenAuthenticator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Services\GithubService;
use App\Http\Integrations\Github\Requests\GenerateInstallationAccessTokenRequest;
use App\Http\Integrations\Github\GithubConnector;
use App\Http\Controllers\GithubRepositoryController;
use App\DataObjects\GithubJWTData;
use App\DataObjects\GithubInstallationAccessTokenData;
use App\Contracts\GithubContract;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('repositories')
    ->name('repositories.')
    ->group(function () {
        Route::get('/{owner}/{repositoryName}', GithubRepositoryController::show(...))->name('show');
        Route::get('/{owner}', GithubRepositoryController::index(...))->name('index');
    });

Route::get('/test', function(GithubContract $githubService) {
    $connector = $githubService->connector();

    $request = (new GenerateInstallationAccessTokenRequest(
        installationId: config('services.github.installation_id'),
        jwt           : GithubJWTData::from_credentials(
            clientId  : config('services.github.client_id'),
            privateKey: Storage::disk('private')->get(config('services.github.private_key_path')),
        )
    ))
    ->debugRequest()
    ->debugResponse()
    ;

    /** @var GithubInstallationAccessTokenData */
    $installationAccessToken = $githubService
        ->connector()
        ->send($request)
        ->dtoOrFail();

    $tokenAuthenticator = new TokenAuthenticator($installationAccessToken->value);

    Cache::put('github.token-authenticator', $tokenAuthenticator, $installationAccessToken->expires_at);

});
