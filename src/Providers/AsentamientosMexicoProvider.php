<?php

namespace Wadagz\AsentamientosMexico\Providers;

use Illuminate\Support\ServiceProvider;
use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosTablesCommand;

final class AsentamientosMexicoProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            __DIR__.'/../../database/migrations'
        ]);

        $this->loadFactoriesFrom([
            __DIR__.'../Database/Factories'
        ]);

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../Models/Asentamiento.php' => app_path('Models/Asentamiento.php'),
            __DIR__.'/../Models/Estado.php' => app_path('Models/Estado.php'),
            __DIR__.'/../Models/Municipio.php' => app_path('Models/Municipio.php'),
        ], 'models');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AsentamientosTablesCommand::class,
            ]);
        }
    }
}
