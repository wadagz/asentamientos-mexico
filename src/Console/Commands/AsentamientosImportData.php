<?php

namespace Wadagz\AsentamientosMexico\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Schema;
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
        /** @var string $estadosCSV */
        $estadosCSV = $this->option('estados') ?? storage_path('temp/estados.csv');
        /** @var string $municipiosCSV */
        $municipiosCSV = $this->option('municipios') ?? storage_path('temp/municipios.csv');
        /** @var string $asentamientosCSV */
        $asentamientosCSV = $this->option('asentamientos') ?? storage_path('temp/asentamientos.csv');

        if (!Schema::hasTable('estados')) {
            $this->fail('La tabla estados no existe.');
        }
        if (!Schema::hasTable('municipios')) {
            $this->fail('La tabla municipios no existe.');
        }
        if (!Schema::hasTable('asentamientos')) {
            $this->fail('La tabla asentamientos no existe.');
        }

        $this->info('Importando estados.');
        /** @var float $estadosImportDuration */
        $estadosImportDuration = Benchmark::measure(function () use($estadosCSV) {
            Excel::import(new EstadosImport, $estadosCSV);
        });
        $estadosImportDuration /= 1000;
        $this->info("Importación de estados demoró: $estadosImportDuration segundos.");

        $this->info('Importando municipios.');
        /** @var float $municipiosImportDuration */
        $municipiosImportDuration = Benchmark::measure(function () use($municipiosCSV) {
            Excel::import(new MunicipiosImport, $municipiosCSV);
        });
        $municipiosImportDuration /= 1000;
        $this->info("Importación de municipios demoró: $municipiosImportDuration segundos.");

        $this->output->title('Importando asentamientos');
        /** @var float $asestamientosImportDuration */
        $asestamientosImportDuration = Benchmark::measure(function () use($asentamientosCSV) {
            (new AsentamientosImport)->withOutput($this->output)->import($asentamientosCSV);
        });
        $asestamientosImportDuration /= 1000;

        $this->info("La importación de asentamientos demoró: $asestamientosImportDuration segundos.");

        return Command::SUCCESS;
    }
}
