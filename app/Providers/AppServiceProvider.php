<?php

namespace App\Providers;

use App\Services\VerticalManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // VerticalManager is a singleton — one instance for the request lifecycle.
        $this->app->singleton(VerticalManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
