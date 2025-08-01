<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
   public function boot()
{
    $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
}
}
