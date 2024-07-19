<?php

namespace Mchervenkov\BnbFixing;
use Illuminate\Support\ServiceProvider;
use Mchervenkov\BnbFixing\Commands\SyncBnbFixings;

class BnbFixingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/bnb_fixing.php' => config_path('bnb_fixing.php'),
            ], 'bnbfixing-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'bnbfixing-migrations');

            $this->publishes([
                __DIR__ . '/Models/' => app_path('Models'),
            ], 'bnbfixing-models');

            $this->publishes([
                __DIR__ . '/Commands/' => app_path('Console/Commands'),
            ], 'bnbfixing-commands');

            // Registering package commands.
            $this->commands([
                SyncBnbFixings::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/bnb_fixing.php', 'bnbfixing');
    }
}
