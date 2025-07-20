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
    $estadosCsvPath = storage_path('temp/estados.csv');
    Excel::import(new EstadosImport, $estadosCsvPath);
    expect(Estado::exists())->toBeTrue();
});

it ('can import Municipios', function () {
    $estadosCsvPath = storage_path('temp/estados.csv');
    Excel::import(new EstadosImport, $estadosCsvPath);

    $municipiosCsvPath = storage_path('temp/municipios.csv');
    Excel::import(new MunicipiosImport, $municipiosCsvPath);
    expect(Municipio::exists())->toBeTrue();
});

it('can import Asentamientos', function () {
    $estadosCsvPath = storage_path('temp/estados.csv');
    Excel::import(new EstadosImport, $estadosCsvPath);
    expect(Estado::exists())->toBeTrue();

    $municipiosCsvPath = storage_path('temp/municipios.csv');
    Excel::import(new MunicipiosImport, $municipiosCsvPath);
    expect(Municipio::exists())->toBeTrue();

    $asentamientosCsvPath = storage_path('temp/asentamientos.csv');
    Excel::import(new AsentamientosImport, $asentamientosCsvPath);
    expect(Asentamiento::exists())->toBeTrue();
});

