<?php

use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosTablesCommand;

it('can run the command successfully', function () {
    $this->artisan(AsentamientosTablesCommand::class)
        ->assertSuccessful();
    expect(storage_path('app/private/CPdescarga.txt'))->toBeFile();
    expect(storage_path('temp/asentamientos.csv'))->toBeFile();
    expect(storage_path('temp/estados.csv'))->toBeFile();
    expect(storage_path('temp/municipios.csv'))->toBeFile();
    expect(app_path('Enums/TipoAsentamientoEnum.php'))->toBeFile();
    expect(app_path('Enums/TipoZonaEnum.php'))->toBeFile();
});

