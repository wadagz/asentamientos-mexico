---
layout: default
title: Factories
parent: Explicación a detalle
nav_order: 3
---

# Factories

Cada modelo tiene asociado una factory para facilitar el testing.

## EstadoFactory
Simplemente genera un nombre falso para el estado.

```php
<?php
public function definition(): array
{
    return [
        'nombre' => fake()->word(),
    ];
}
```

## MunicipioFactory
Al crear un nuevo municipio mediante factory se crea automáticamente un estado
asociado con su respectiva factory. Además se genera un nombre falso para el municipio.

```php
<?php
public function definition(): array
{
    return [
        'estado_id' => Estado::factory(),
        'nombre' => fake()->word(),
    ];
}
```

## AsentamientoFactory
Al crear un asentamiento mediante factory se crea un municipio asociado haciendo uso
de su respectiva factory. Además se crean datos falsos para nombre, tipo_asentamiento,
ciudad, codigo_postal y tipo_zona.

```php
<?php
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
```

## Creación con relaciones
Existen métodos para asociar los registros a crear con registros ya existentes.
<a href="https://laravel.com/docs/12.x/eloquent-factories#factory-relationships">Factory relationships</a>.
