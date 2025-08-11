<?php

use Wadagz\AsentamientosMexico\Services\GenerateEnumsService;

it('can generate enum', function () {
    $generateEnumsService = new GenerateEnumsService;

    $enumName = 'TipoAsentamientoEnum';
    $namespace = 'Asentamiento';
    $fixtureEnumCases = __DIR__.'/../../Fixtures/GenerateEnums/tipo_asentamiento_cases.csv';

    $generateEnumsService->handle($enumName, $namespace, $fixtureEnumCases);

    $expectedFile = app_path("Enums/$namespace/$enumName.php");
    expect($expectedFile)->toBeFile();

    unlink($expectedFile);
});

it('throws error Enum Ya Existe on already existing Enum', function () {
    $generateEnumsService = new GenerateEnumsService;

    $enumName = 'TipoAsentamientoEnum';
    $namespace = 'Asentamiento';
    $fixtureEnumCases = __DIR__.'/../../Fixtures/GenerateEnums/tipo_asentamiento_cases.csv';

    $generateEnumsService->handle($enumName, $namespace, $fixtureEnumCases);

    $expectedFile = app_path("Enums/$namespace/$enumName.php");
    expect($expectedFile)->toBeFile();

    try {
        $generateEnumsService->handle($enumName, $namespace, $fixtureEnumCases);
    } catch (Exception $e) {
        unlink($expectedFile);
        throw new Exception($e->getMessage());
    }
})->throws(Exception::class, 'Enum Asentamiento/TipoAsentamientoEnum ya existe.');

