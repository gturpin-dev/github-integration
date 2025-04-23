<?php

namespace App\Providers;

use App\Contracts\GithubContract;
use App\Services\GithubService;
use Illuminate\Support\ServiceProvider;

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
                token: config('services.github.token'),
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
