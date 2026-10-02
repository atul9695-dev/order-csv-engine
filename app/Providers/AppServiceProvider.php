<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Force HTTPS in production / cloud environments to fix mixed content warnings
        if (config('app.env') === 'production' || env('APP_ENV') === 'production' || str_contains(request()->url(), 'onrender.com')) {
            URL::forceScheme('https');
        }
    }
}
