<?php

namespace Wadagz\AsentamientosMexico\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wadagz\AsentamientosMexico\Models\Estado;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Wadagz\AsentamientosMexico\Models\Estado>
 */
class EstadoFactory extends Factory
{
    /**
     * @var class-string<Estado>
     */
    protected $model = Estado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->word(),
        ];
    }
}