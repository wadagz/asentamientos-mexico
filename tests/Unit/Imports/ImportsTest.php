<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Wadagz\AsentamientosMexico\Imports\AsentamientosImport;
use Wadagz\AsentamientosMexico\Imports\EstadosImport;
use Wadagz\AsentamientosMexico\Imports\MunicipiosImport;
use Wadagz\AsentamientosMexico\Models\Asentamiento;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;

uses(RefreshDatabase::class);

it ('can import Estados', function () {
    $estadosCsvPath = __DIR__.'/../../Fixtures/Imports/estados.csv';
    Excel::import(new EstadosImport, $estadosCsvPath);
    expect(Estado::exists())->toBeTrue();
});

it ('can import Municipios', function () {
    $estadosCsvPath = __DIR__.'/../../Fixtures/Imports/estados.csv';
    Excel::import(new EstadosImport, $estadosCsvPath);

    $municipiosCsvPath = __DIR__.'/../../Fixtures/Imports/municipios.csv';
    Excel::import(new MunicipiosImport, $municipiosCsvPath);
    expect(Municipio::exists())->toBeTrue();
});

it('can import Asentamientos', function () {
    $asentamientosCsvPath = __DIR__.'/../../Fixtures/Imports/asentamientos.csv';

    $estadosCsvPath = __DIR__.'/../../Fixtures/Imports/estados.csv';
    Excel::import(new EstadosImport, $estadosCsvPath);
    expect(Estado::exists())->toBeTrue();

    $municipiosCsvPath = __DIR__.'/../../Fixtures/Imports/municipios.csv';
    Excel::import(new MunicipiosImport, $municipiosCsvPath);
    expect(Municipio::exists())->toBeTrue();

    Excel::import(new AsentamientosImport, $asentamientosCsvPath);

    expect(Asentamiento::exists())->toBeTrue();
});
