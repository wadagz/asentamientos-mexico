<?php

namespace Wadagz\AsentamientosMexico\Tests;

use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Wadagz\AsentamientosMexico\Providers\AsentamientosMexicoProvider;
use Orchestra\Testbench\TestCase;

class PackageTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            AsentamientosMexicoProvider::class,
            ExcelServiceProvider::class,
        ];
    }
}

