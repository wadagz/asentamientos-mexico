<?php

namespace Wadagz\AsentamientosMexico\Providers;

use Illuminate\Support\ServiceProvider;
use Wadagz\AsentamientosMexico\Console\Commands\LocationsTablesCommand;

final class AsentamientosMexicoProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LocationsTablesCommand::class,
            ]);
        }
    }
}

