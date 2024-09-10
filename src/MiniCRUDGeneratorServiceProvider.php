<?php

namespace Davion153808\MiniCRUDGenerator;

use Illuminate\Support\ServiceProvider;

class MiniCRUDGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/minicrud.php' => config_path('minicrud.php'),
            ], 'config');

            // Registering package commands.
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/minicrud.php', 'minicrud');

        // Register the main class to use with the facade
        $this->app->singleton('mini-curd-generator', function () {
            return new MiniCRUDGenerator;
        });
    }
}
