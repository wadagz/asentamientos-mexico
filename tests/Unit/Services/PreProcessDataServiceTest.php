<?php

use Wadagz\AsentamientosMexico\Services\PreProcessDataService;

it('can pre-process data', function () {
    $fixtureDataFilePath = __DIR__.'/../../Fixtures/PreProcessData/cp_descarga_sample.csv';
    $preProcessDataService = new PreProcessDataService;

    $preProcessDataService->handle(dataFilePath: $fixtureDataFilePath);

    expect(storage_path('temp/asentamientos.csv'))->toBeFile();
    expect(storage_path('temp/estados.csv'))->toBeFile();
    expect(storage_path('temp/municipios.csv'))->toBeFile();
    expect(storage_path('temp/tipo_asentamiento_cases.csv'))->toBeFile();
    expect(storage_path('temp/tipo_zona_cases.csv'))->toBeFile();
    expect(storage_path('logs/asentamientos_preprocessing.log'))->toBeFile();

    unlink(storage_path('temp/asentamientos.csv'));
    unlink(storage_path('temp/estados.csv'));
    unlink(storage_path('temp/municipios.csv'));
    unlink(storage_path('temp/tipo_asentamiento_cases.csv'));
    unlink(storage_path('temp/tipo_zona_cases.csv'));
    unlink(storage_path('logs/asentamientos_preprocessing.log'));
});