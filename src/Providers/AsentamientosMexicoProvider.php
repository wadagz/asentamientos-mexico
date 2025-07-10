<?php

namespace Wadagz\AsentamientosMexico\Providers;

use Illuminate\Support\ServiceProvider;
use Wadagz\AsentamientosMexico\Console\Commands\LocationsTablesCommand;

final class AsentamientosMexicoProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            __DIR__.'/../../database/migrations'
        ]);

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                LocationsTablesCommand::class,
            ]);
        }
    }
}
