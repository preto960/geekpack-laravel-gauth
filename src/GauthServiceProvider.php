<?php

namespace Geekpack\Gauth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\HandleInertiaRequests;

class GauthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);
        $this->app['router']->aliasMiddleware('signed', \Illuminate\Routing\Middleware\ValidateSignature::class);
        $this->app['router']->aliasMiddleware('inertia', \App\Http\Middleware\HandleInertiaRequests::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/inertia.php',
            'inertia'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/mail.php',
            'mail'
        );

        $this->app->booted(function () {
            $this->app['router']->pushMiddlewareToGroup('web', HandleInertiaRequests::class);
        });
    }

    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/mail.php' => config_path('mail.php'),
            __DIR__.'/../config/inertia.php' => config_path('inertia.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/vite.config.js' => base_path('vite.config.js'),
            __DIR__.'/postcss.config.js' => base_path('postcss.config.js'),
            __DIR__.'/tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__.'/package.json' => base_path('package.json'),
        ], 'config'); 

        $this->publishes([
            __DIR__.'/Resources/Views/app.blade.php' => resource_path('views/app.blade.php'),
        ], 'views');

        $this->publishes([
            __DIR__.'/Resources/Js/app.js' => resource_path('js/app.js'),
            __DIR__.'/Resources/Js/Components' => resource_path('js/Components'),
            __DIR__.'/Resources/Js/Pages' => resource_path('js/Pages'),
        ], 'views');

        $this->publishes([
            __DIR__.'/Routes/web.php' => base_path('routes/web.php'),
        ], 'routes');      
        
        $this->publishes([
            __DIR__.'/Http/Middleware/HandleInertiaRequests.php' => app_path('Http/Middleware/HandleInertiaRequests.php'),
        ], 'middleware');   

        $this->publishes([
            __DIR__.'/Database/migrations/' => database_path('migrations'),
        ], 'migrations'); 

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        \Illuminate\Support\Facades\Event::listen(
            \Geekpack\Api\Events\Registered::class,
            \Geekpack\Api\Listeners\SendEmailVerificationNotification::class,
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Geekpack\Gauth\Database\seeders\GauthSeeder::class
            ]);
        }

    }
}

