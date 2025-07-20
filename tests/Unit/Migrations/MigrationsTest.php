<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;

it('can load and run migrations', function () {
    // Ejecuta las migraciones.
    $this->artisan('migrate:fresh')->assertExitCode(0);

    // Comprueba que las tablas hayan sido creadas.
    $this->assertTrue(Schema::hasTable('estados'));
    $this->assertTrue(Schema::hasTable('municipios'));
    $this->assertTrue(Schema::hasTable('asentamientos'));
});

it('can publish migrations', function () {
    $filesystem = new Filesystem();

    // Limpia el directorio donde se publican las migraciones
    $publishedPath = database_path('migrations');
    $filesystem->cleanDirectory($publishedPath);

    // Ejecuta el comando para publicar las migraciones
    $this->artisan('vendor:publish', [
        '--tag' => 'migrations',
        '--force' => true,
    ])->assertExitCode(0);

    // Comprueba que el directorio no esté vacio tras publicar migraciones
    $publishedMigrations = $filesystem->files($publishedPath);

    $this->assertNotEmpty($publishedMigrations, 'No se publicaron las migraciones.');
});
