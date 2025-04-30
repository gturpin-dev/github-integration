<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Firebase\JWT\JWT;
use App\Services\GithubService;
use App\Contracts\GithubContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: GithubContract::class,
            concrete: fn (): GithubContract => new GithubService(
                installationId: config('services.github.installation_id'),
                clientId      : config('services.github.client_id'),
                privateKey    : Storage::disk('private')->get(config('services.github.private_key_path')),
            )
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
