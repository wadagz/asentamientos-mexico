<?php

use Wadagz\AsentamientosMexico\Services\FetchDataService;
use Wadagz\AsentamientosMexico\Services\PreProcessDataService;

it('can pre-process data', function () {
    $preProcessDataService = new PreProcessDataService;

    if (!file_exists(storage_path('app/private/CPdescarga.txt'))) {
        $fetchDataService = new FetchDataService;
        $fetchDataService->handle();
    }

    $preProcessDataService->handle();

    expect(storage_path('temp/asentamientos.csv'))->toBeFile();
    expect(storage_path('temp/estados.csv'))->toBeFile();
    expect(storage_path('temp/municipios.csv'))->toBeFile();
    expect(base_path('app/Enums/TipoAsentamientoEnum.php'))->toBeFile();
    expect(base_path('app/Enums/TipoZonaEnum.php'))->toBeFile();
});