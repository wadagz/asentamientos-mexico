<?php

namespace Wadagz\AsentamientosMexico\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Wadagz\AsentamientosMexico\Imports\AsentamientosImport;
use Wadagz\AsentamientosMexico\Imports\EstadosImport;
use Wadagz\AsentamientosMexico\Imports\MunicipiosImport;

class AsentamientosImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asent-mex:import-data {--e|estados= : Ruta del archivo csv de estados} {--m|municipios= : Ruta del archivo csv de municipios} {--a|asentamientos= : Ruta del archivo csv de asentamientos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa los datos ya preprocesados a las tablas.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $estadosCSV = $this->option('estados') ?? storage_path('temp/estados.csv');
        $municipiosCSV = $this->option('municipios') ?? storage_path('temp/municipios.csv');
        $asentamientosCSV = $this->option('asentamientos') ?? storage_path('temp/asentamientos.csv');

        Excel::import(new EstadosImport, $estadosCSV);
        Excel::import(new MunicipiosImport, $municipiosCSV);
        Excel::import(new AsentamientosImport, $asentamientosCSV);

        return Command::SUCCESS;
    }
}
