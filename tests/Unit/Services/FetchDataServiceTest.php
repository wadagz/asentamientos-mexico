<?php

use Wadagz\AsentamientosMexico\Services\FetchDataService;

it('can fetch data from Correos de México', function () {
    $filePath = storage_path('app/private/CPdescarga.txt');
    $fetchDataService = new FetchDataService;

    $fetchDataService->handle();

    expect($filePath)->toBeFile();

    unlink($filePath);
});
