<?php

namespace Wadagz\AsentamientosMexico\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Wadagz\AsentamientosMexico\Services\FetchDataService;
use Wadagz\AsentamientosMexico\Services\GenerateEnumsService;
use Wadagz\AsentamientosMexico\Services\PreProcessDataService;

class AsentamientosTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:asentamientos-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las tablas de Asentamientos, Municipios y Estados.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        FetchDataService $fetchDataService,
        PreProcessDataService $preProcessDataService,
        GenerateEnumsService $generateEnumService
    ): int
    {
        $this->info('Descargando datos de Correos de México.');
        $fetchDataService->handle();

        $this->info('Realizando pre-procesado de datos.');
        $preProcessDataService->handle();

        $this->info('Generando Enums.');
        try {
            $generateEnumService->handle('TipoAsentamientoEnum', 'Asentamiento', storage_path('temp/tipo_asentamiento_cases.csv'));
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }
        try {
            $generateEnumService->handle('TipoZonaEnum', 'Asentamiento', storage_path('temp/tipo_zona_cases.csv'));
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
