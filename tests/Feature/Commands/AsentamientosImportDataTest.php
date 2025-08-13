<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wadagz\AsentamientosMexico\Console\Commands\AsentamientosImportData;
use Wadagz\AsentamientosMexico\Models\Asentamiento;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;

uses(RefreshDatabase::class);

it('can run asentamientos import data command', function () {
    $this->artisan(AsentamientosImportData::class, [
        '--estados' => __DIR__.'/../../Fixtures/Imports/estados.csv',
        '--municipios' => __DIR__.'/../../Fixtures/Imports/municipios.csv',
        '--asentamientos' => __DIR__.'/../../Fixtures/Imports/asentamientos.csv',
    ]) ->assertSuccessful();

    expect(Estado::exists())->toBeTrue();
    expect(Municipio::exists())->toBeTrue();
    expect(Asentamiento::exists())->toBeTrue();
});

