<?php

use Wadagz\AsentamientosMexico\Console\Commands\LocationsTablesCommand;

it('can run the command successfully', function () {
    $this
        ->artisan(LocationsTablesCommand::class)
        ->assertSuccessful();
});

