<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;

uses(RefreshDatabase::class);

it('can use EstadoFactory', function () {
    $estado = Estado::factory()->create();
    $this->assertModelExists($estado);
});

it('can create Estado', function () {
    $estado = Estado::create([
        'nombre' => 'Jalisco',
    ]);

    $this->assertModelExists($estado);
    $this->assertDatabaseHas('estados', [
        'nombre' => 'Jalisco',
    ]);
});

it('can read Estado', function () {
    Estado::create(['nombre' => 'Jalisco']);

    $estado = Estado::where('nombre', 'Jalisco')
        ->first();
    $this->assertModelExists($estado);
});

it('can update Estado', function () {
    Estado::create(['nombre' => 'Jalisco']);

    $estado = Estado::where('nombre', 'Jalisco')
        ->first();
    $estado->nombre = 'Oaxaca';
    $estado->save();

    $this->assertDatabaseHas('estados', [
        'nombre' => 'Oaxaca',
    ]);
});

it('can associate many Municipios', function () {
    $estado = Estado::factory()->create();
    $estado->municipios()->save(Municipio::factory()->create());
    $estado->municipios()->save(Municipio::factory()->create());
    $estado->save();
    $estado->refresh();
    expect($estado->municipios)->not->toBeEmpty();
    expect($estado->municipios)->toHaveCount(2);
});
