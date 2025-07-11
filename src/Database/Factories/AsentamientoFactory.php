<?php

namespace Wadagz\AsentamientosMexico\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoAsentamientoEnum;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoZonaEnum;
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
            'tipo_asentamiento' => fake()->randomElement(TipoAsentamientoEnum::values()),
            'ciudad' => fake()->city(),
            'codigo_postal' => fake()->numerify('#####'),
            'tipo_zona' => fake()->randomElement(TipoZonaEnum::values()),
        ];
    }
}