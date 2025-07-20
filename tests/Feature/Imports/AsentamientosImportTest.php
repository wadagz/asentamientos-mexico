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

/**
 * Prueba si se puede ejecutar AsentamientosImport.
 * Simula la ejecución del import por defecto debido a que puede tomar
 * demasiado tiempo la ejecución del import.
 */
it('can import Asentamientos', function () {
    $asentamientosCsvPath = storage_path('temp/asentamientos.csv');

    /**
     * Simular ejecución del import sin crear registros.
     * Comentar para ejecutar de verdad el import.
     */
    Excel::fake();

    /**
     * Descomentar lineas para probar la ejecución real del import.
     */
    // $estadosCsvPath = storage_path('temp/estados.csv');
    // Excel::import(new EstadosImport, $estadosCsvPath);
    // expect(Estado::exists())->toBeTrue();

    // $municipiosCsvPath = storage_path('temp/municipios.csv');
    // Excel::import(new MunicipiosImport, $municipiosCsvPath);
    // expect(Municipio::exists())->toBeTrue();

    Excel::import(new AsentamientosImport, $asentamientosCsvPath);

    /**
     * assertImported usado junto con Excel::fake()
     * expect() usado cuando se prueba la ejecución real del import.
     */
    Excel::assertImported($asentamientosCsvPath);
    // expect(Asentamiento::exists())->toBeTrue();
});

