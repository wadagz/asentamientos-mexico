<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Wadagz\AsentamientosMexico\Imports\AsentamientosInitialImport;

// uses(RefreshDatabase::class);

it('can import Asentamientos', function () {
    $this->artisan('migrate:fresh');
    Excel::import(new AsentamientosInitialImport, 'CPdescarga.txt', 'local');
    Excel::assertImported('CPdescarga.txt', 'local');
});
