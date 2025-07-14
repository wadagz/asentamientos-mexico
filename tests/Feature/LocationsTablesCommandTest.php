<?php

use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosTablesCommand;

it('can run the command successfully', function () {
    $this->artisan(AsentamientosTablesCommand::class)
        ->assertSuccessful();
});

