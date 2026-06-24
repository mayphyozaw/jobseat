<?php

namespace App\Providers;

use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\CountryRepoInterface;
use App\Repositories\Interfaces\UserRepoInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepoInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            CountryRepoInterface::class,
            CountryRepository::class
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
