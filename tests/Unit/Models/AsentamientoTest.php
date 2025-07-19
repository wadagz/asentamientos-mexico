<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoAsentamientoEnum;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoZonaEnum;
use Wadagz\AsentamientosMexico\Models\Asentamiento;
use Wadagz\AsentamientosMexico\Models\Municipio;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->municipio = Municipio::factory()->create();
});

it('can create using AsentamientoFactory', function () {
    $asentamiento = Asentamiento::factory()
        ->for($this->municipio)
        ->create();

    $this->assertModelExists($asentamiento);
});

it('can create Asentamiento', function () {
    $asentamiento = Asentamiento::create([
        'municipio_id' => $this->municipio->id,
        'nombre' => 'Americana',
        'tipo_asentamiento' => TipoAsentamientoEnum::COLONIA,
        'ciudad' => 'Guadalajara',
        'codigo_postal' => '45569',
        'tipo_zona' => TipoZonaEnum::URBANO,
    ]);

    $this->assertModelExists($asentamiento);
});

it('can update Asentamiento', function () {
    $datosNuevos = [
        'nombre' => 'Parques del Bosque',
        'tipo_asentamiento' => (string)TipoAsentamientoEnum::FRACCIONAMIENTO->value,
        'ciudad' => 'Tlaquepaque',
        'codigo_postal' => '45610',
        'tipo_zona' => (string)TipoZonaEnum::RURAL->value,
    ];

    $asentamiento = Asentamiento::factory()->create();

    Asentamiento::where('id', $asentamiento->id)
        ->update($datosNuevos);

    $asentamiento->refresh();

    expect($asentamiento->nombre)->toBe($datosNuevos['nombre']);
    expect($asentamiento->tipo_asentamiento)->toBe($datosNuevos['tipo_asentamiento']);
    expect($asentamiento->ciudad)->toBe($datosNuevos['ciudad']);
    expect($asentamiento->codigo_postal)->toBe($datosNuevos['codigo_postal']);
    expect($asentamiento->tipo_zona)->toBe($datosNuevos['tipo_zona']);
});

it('can associate only one Municipio', function () {
    $asentamiento = Asentamiento::factory()
        ->for($this->municipio)
        ->create();

    $munNuevo = Municipio::factory()->create();

    $asentamiento->municipio()->associate($munNuevo);
    $asentamiento->save();
    $asentamiento->refresh();

    expect($asentamiento->municipio)->not->toBeNull();
    expect($asentamiento->municipio->id)->toBe($munNuevo->id);
});
