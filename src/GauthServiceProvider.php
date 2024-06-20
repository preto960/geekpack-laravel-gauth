<?php

namespace Geekpack\gauth;

use Illuminate\Support\ServiceProvider;
use Geekpack\Api\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class GauthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->aliasMiddleware('valid.api.route', \Geekpack\Api\Http\Middleware\EnsureApiRouteIsValid::class);
        $this->app['router']->aliasMiddleware('auth:sanctum', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
        $this->app['router']->aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);
        $this->app['router']->aliasMiddleware('signed', \Illuminate\Routing\Middleware\ValidateSignature::class);
    }

    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/mail.php' => config_path('mail.php'),
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/Database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        \Illuminate\Support\Facades\Event::listen(
            \Geekpack\Api\Events\Registered::class,
            \Geekpack\Api\Listeners\SendEmailVerificationNotification::class,
        );

    }
}

