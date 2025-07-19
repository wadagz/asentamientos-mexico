<?php

use Illuminate\Filesystem\Filesystem;

it('can publish models', function () {
    $filesystem = new Filesystem();

    // Limpia el directorio donde se publican los modelos
    $publishedPath = app_path('Models');
    $filesystem->cleanDirectory($publishedPath);

    // Ejecuta el comando para publicar las migraciones
    $this->artisan('vendor:publish', [
        '--tag' => 'models',
        '--force' => true,
    ])->assertExitCode(0);

    // Comprueba que el directorio no esté vacio tras publicar migraciones
    $publishedModels = $filesystem->files($publishedPath);

    $this->assertNotEmpty($publishedModels, 'No se publicaron los modelos.');
});
