<?php

namespace Geekpack\Gauth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
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
            __DIR__.'/Resources/Views/app.blade.php' => resource_path('views/app.blade.php'),
        ], 'views');

        $this->publishes([
            __DIR__.'/Routes/web.php' => base_path('routes/web.php'),
        ], 'routes');      
        
        $this->publishes([
            __DIR__.'/Middleware/HandleInertiaRequests.php' => base_path('App/Http/Middleware/HandleInertiaRequests.php'),
        ], 'routes');   

        $this->publishes([
            __DIR__.'/Database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        \Illuminate\Support\Facades\Event::listen(
            \Geekpack\Api\Events\Registered::class,
            \Geekpack\Api\Listeners\SendEmailVerificationNotification::class,
        );

        /* $this->executeNpmCommand(); */

    }

    /* public function executeNpmCommand()
    {
        // Ejemplo de comando npm para instalar un paquete
        $command = 'npm install @inertiajs/vue3';

        // Ejecutar el comando y obtener la salida
        $output = [];
        exec($command, $output, $returnCode);

        // Verificar el código de retorno (0 significa éxito)
        if ($returnCode === 0) {
            // Éxito: hacer algo con la salida si es necesario
            dd($output);
        } else {
            // Error: manejar el error como sea necesario
            dd("Error al ejecutar el comando: $command");
        }
    } */
}

