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
        $this->scriptPath = $scriptPath ?? $this->scriptPath;
        $this->dataFilePath = $dataFilePath ?? $this->dataFilePath;
        $this->exportPath = $exportPath ?? $this->exportPath;
        $this->logsPath = $logsPath ?? $this->logsPath;

        $this->preProcessData();
    }

    /**
     * Realiza el pre-procesado de datos.
     *
     * @return void
     */
    private function preProcessData(): void
    {
        if (File::missing($this->dataFilePath)) {
            throw new Exception("Archivo {$this->dataFilePath} no existente.");
        }

        if (File::missing($this->exportPath)) {
            File::makeDirectory($this->exportPath);
        }
        if (File::missing($this->logsPath)) {
            File::makeDirectory($this->logsPath);
        }

        $result = Process::run([
            'python3',
            $this->scriptPath,
            '--dataFilePath',
            $this->dataFilePath,
            '--exportPath',
            $this->exportPath,
            '--logsPath',
            $this->logsPath
        ]);

        if ($result->failed()) {
            throw new Exception("El pre-procesamiento de datos falló: {$result->errorOutput()}");
        }
    }
}