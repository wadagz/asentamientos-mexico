<?php

namespace Wadagz\AsentamientosMexico\Services;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class PreProcessDataService
{
    /**
     * Handle function.
     *
     * @return void
     */
    public function handle(string|null $dataFilePath = null): void
    {
        $dataFilePath = $dataFilePath ?? storage_path('app/private/CPdescarga.txt');
        $this->preProcessData($dataFilePath);
    }

    /**
     * Realiza el pre-procesado de datos.
     *
     * @param non-empty-string $dataFilePath Path del archivo con datos a procesar.
     * @return void
     */
    private function preProcessData(string $dataFilePath): void
    {
        $scriptPath = __DIR__.'/../../python/data_preprocessing.py'; // Path del script
        // $dataFilePath = storage_path('app/private/CPdescarga.txt'); // Path del archivo con datos
        $exportPath = storage_path('temp'); // Path donde exportar los CSV
        $logsPath = storage_path('logs'); // Path donde guardar los logs

        if (File::missing($dataFilePath)) {
            throw new Exception("Archivo $dataFilePath no existente.");
        }

        if (File::missing($exportPath)) {
            // mkdir($exportPath);
            File::makeDirectory($exportPath);
        }
        if (File::missing($logsPath)) {
            // mkdir($logsPath);
            File::makeDirectory($exportPath);
        }

        $result = Process::run([
            'python3',
            $scriptPath,
            '--dataFilePath',
            $dataFilePath,
            '--exportPath',
            $exportPath,
            '--logsPath',
            $logsPath
        ]);

        if ($result->failed()) {
            throw new Exception("El pre-procesamiento de datos falló: {$result->errorOutput()}");
        }
    }
}