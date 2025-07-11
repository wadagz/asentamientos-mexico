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
    expect($municipio->estado)->not->toBeArray();
    expect($municipio->estado->id)->not->toBe($estadoId);
});
