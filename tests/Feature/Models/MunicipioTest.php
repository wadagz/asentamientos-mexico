<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;
use Wadagz\AsentamientosMexico\Models\Asentamiento;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->estado = Estado::factory()->create();
});

it('can create using MunicipioFactory',  function () {
    $municipio = Municipio::factory()->create();
    $this->assertModelExists($municipio);
});

it('can create Municipio', function () {
    $municipio = Municipio::create([
        'estado_id' => $this->estado->id,
        'nombre' => 'Guadalajara',
    ]);
    $this->assertModelExists($municipio);
});

it('can update Municipio', function () {
    $nombreOriginal = 'Guadalajara';
    $nombreNuevo = 'Tonalá';

    $municipio = Municipio::factory()
        ->state(['nombre' => $nombreOriginal])
        ->for($this->estado)
        ->create();

    $id = $municipio->id;

    $municipio = Municipio::where('id', $id)->first();
    $municipio->nombre = $nombreNuevo;

    expect($municipio->nombre)->not->toBe($nombreOriginal);
});

it('can associate only one Estado', function () {
    $estado = Estado::factory()->create();
    $estadoId = $estado->id;

    $municipio = Municipio::factory()
        ->for($estado)
        ->create();

    $municipio->estado()->associate($this->estado);
    $municipio->save();
    $municipio->refresh();

    expect($municipio->estado)->not->toBeNull();
    expect($municipio->estado->id)->not->toBe($estadoId);
});

it('can associate many Asentamientos', function () {
    $municipio = Municipio::factory()
        ->for($this->estado)
        ->create();

    $asentamientos = array();
    $numberOfAsentamientos = 10;
    for ($i = 0; $i < $numberOfAsentamientos; $i++) {
        $asentamientos[] = Asentamiento::factory()
            ->state(['municipio_id' => null])
            ->create();
    }

    $municipio->asentamientos()->saveMany($asentamientos);
    $municipio->refresh();

    expect($municipio->asentamientos)->toHaveCount($numberOfAsentamientos);
});
