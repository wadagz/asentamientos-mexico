<?php

use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosTablesCommand;

it('can run the command successfully', function () {
    $this->artisan(AsentamientosTablesCommand::class)
        ->assertSuccessful();

    expect(storage_path('app/private/CPdescarga.txt'))->toBeFile();
    expect(storage_path('temp/asentamientos.csv'))->toBeFile();
    expect(storage_path('temp/estados.csv'))->toBeFile();
    expect(storage_path('temp/municipios.csv'))->toBeFile();
    expect(app_path('Enums/Asentamiento/TipoAsentamientoEnum.php'))->toBeFile();
    expect(app_path('Enums/Asentamiento/TipoZonaEnum.php'))->toBeFile();

    unlink(storage_path('app/private/CPdescarga.txt'));
    unlink(storage_path('temp/asentamientos.csv'));
    unlink(storage_path('temp/estados.csv'));
    unlink(storage_path('temp/municipios.csv'));
    unlink(app_path('Enums/Asentamiento/TipoAsentamientoEnum.php'));
    unlink(app_path('Enums/Asentamiento/TipoZonaEnum.php'));
});

