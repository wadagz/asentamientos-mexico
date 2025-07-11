<?php

namespace Wadagz\AsentamientosMexico\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Wadagz\AsentamientosMexico\Models\Municipio>
 */
class MunicipioFactory extends Factory
{
    /**
     * @var Municipio
     */
    protected $model = Municipio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estado_id' => Estado::factory(),
            'nombre' => fake()->word(),
        ];
    }
}
