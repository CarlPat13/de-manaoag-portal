<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Pilitin ang HTTPS sa production
        if (env('FORCE_HTTPS') || $this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}