<?php

namespace Wadagz\AsentamientosMexico\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wadagz\AsentamientosMexico\Models\Asentamiento;
use Wadagz\AsentamientosMexico\Models\Municipio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Wadagz\AsentamientosMexico\Models\Asentamiento>
 */
class AsentamientoFactory extends Factory
{
    /**
     * @var class-string<Asentamiento>
     */
    protected $model = Asentamiento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'municipio_id' => Municipio::factory(),
            'nombre' => fake()->word(),
            'tipo_asentamiento' => fake()->word(),
            'ciudad' => fake()->city(),
            'codigo_postal' => fake()->numerify('#####'),
            'tipo_zona' => fake()->word(),
        ];
    }
}