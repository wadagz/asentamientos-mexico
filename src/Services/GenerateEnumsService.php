<?php

namespace Wadagz\AsentamientosMexico\Services;

use Exception;
use Illuminate\Support\Facades\File;

class GenerateEnumsService
{
    /**
     * @var string 
     */
    private $enumName;

    /**
     * @var string
     */
    private $casesFilePath;

    /**
     * @var string
     */
    private $namespace;

    /**
     * Handle function
     *
     * @param string $enumName Nombre del enum a generar.
     * @param string $namespace Namespace del enum a generar.
     * @param string $casesFilePath Ruta del archivo con los cases del enum.
     */
    public function handle(
        string $enumName,
        string $namespace,
        string $casesFilePath,
    ): void
    {
        $this->enumName = $enumName;
        $this->namespace = $namespace;
        $this->casesFilePath = $casesFilePath;

        $this->generateEnum();
    }

    /**
     * Genera los enums de las columnas pertinentes
     *
     * @return void
     */
    private function generateEnum(): void
    {
        $backingType = 'string';
        $path = base_path("app/Enums/{$this->namespace}/{$this->enumName}.php");

        File::ensureDirectoryExists(dirname($path));

        if (File::exists($path)) {
            throw new Exception("Enum {$this->namespace}/{$this->enumName} ya existe.");
        }

        [$cases, $labels] = $this->getCases($this->casesFilePath);

        // Obtiene el stub para generar enums.
        $stub = File::get(__DIR__.'/../Stubs/enum.backed.stub');

        // Rellena los placeholders.
        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ backingType }}', '{{ cases }}', '{{ labels }}'],
            ["App\\Enums\\".$this->namespace, $this->enumName, $backingType, $cases, $labels],
            $stub
        );

        File::put($path, $stub);
    }

    /**
     * Obtiene los cases y labels para un enum a partir del archivo generado de cases del mismo.
     *
     * @param string $filePath Ruta del archivo a usar.
     * @return array<string>
     */
    private function getCases(string $filePath): array
    {
        $cases = '';
        $labels = '';
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, separator: ",")) !== FALSE) {
                $cases = $cases."    case $data[0] = '$data[1]';\n";
                $labels = $labels."            static::$data[0] => '$data[1]',\n";
            }
            fclose($handle);
        } else {
            throw new Exception("No se pudo abrir archivo $filePath para generar Enums.");
        }

        return [$cases, $labels];
    }
}