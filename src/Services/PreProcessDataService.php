<?php

namespace Wadagz\AsentamientosMexico\Services;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class PreProcessDataService
{

    /**
     * @var string
     */
    private $scriptPath;

    /**
     * @var string
     */
    private $dataFilePath;

    /**
     * @var string
     */
    private $exportPath;

    /**
     * @var string
     */
    private $logsPath;

    public function __construct()
    {
        $this->scriptPath = __DIR__.'/../../python/data_preprocessing.py';
        $this->dataFilePath = storage_path('app/private/CPdescarga.txt');
        $this->exportPath = storage_path('temp');
        $this->logsPath = storage_path('logs');
    }

    /**
     * Handle function.
     *
     * @param string|null $scriptPath Ruta del archivo del script a ejecutar.
     * @param string|null $dataFilePath Ruta del archivo con datos a procesar.
     * @param string|null $exportPath Ruta donde escribir los archivos generados.
     * @param string|null $logsPath Ruta donde escribir los logs.
     * @return void
     */
    public function handle(
        string|null $scriptPath = null,
        string|null $dataFilePath = null,
        string|null $exportPath = null,
        string|null $logsPath = null,
    ): void
    {
        $scriptPath = $scriptPath ?? $this->scriptPath;
        $dataFilePath = $dataFilePath ?? $this->dataFilePath;
        $exportPath = $exportPath ?? $this->exportPath;
        $logsPath = $logsPath ?? $this->logsPath;

        $this->preProcessData(
            $scriptPath,
            $dataFilePath,
            $exportPath,
            $logsPath
        );
    }

    /**
     * Realiza el pre-procesado de datos.
     *
     * @param non-empty-string $scriptPath Ruta del archivo del script a ejecutar.
     * @param non-empty-string $dataFilePath Ruta del archivo con datos a procesar.
     * @param non-empty-string $exportPath Ruta donde escribir los archivos generados.
     * @param non-empty-string $logsPath Ruta donde escribir los logs.
     * @return void
     */
    private function preProcessData(string $scriptPath, string $dataFilePath, string $exportPath, string $logsPath): void
    {
        if (File::missing($dataFilePath)) {
            throw new Exception("Archivo $dataFilePath no existente.");
        }

        if (File::missing($exportPath)) {
            File::makeDirectory($exportPath);
        }
        if (File::missing($logsPath)) {
            File::makeDirectory($logsPath);
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