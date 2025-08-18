<?php

use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosFetchData;

it('can run asentamientos fetch data command', function () {
    $this->artisan(AsentamientosFetchData::class)
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

