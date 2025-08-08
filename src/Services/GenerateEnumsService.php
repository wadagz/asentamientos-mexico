<?php

namespace Wadagz\AsentamientosMexico\Services;

use Illuminate\Support\Facades\File;

class GenerateEnumsService
{
    public function handle()
    {
        $this->generateEnum("a", "a.csv");
    }

    /**
     * Genera los enums de las columnas pertinentes
     *
     * @param string $name Nombre del Enum.
     * @param string $casesFile Ruta del archivo donde están los cases.
     * @return int
     */
    private function generateEnum(string $name, string $casesFile)
    {
        // $this->info("Generando Enum $name...");

        $namespace = 'App\\Enums';
        $backingType = 'string';
        $path = base_path('app/Enums/'.$name.'.php');

        if (File::exists($path)) {
            // $this->info("Enum {$name} ya existe.");
            return 3;
        }

        File::ensureDirectoryExists(dirname($path));

        // Comprueba si se retornó un integer o string para corroborar si hubo error o no.
        $result = $this->getCases($casesFile);
        if (gettype($result) === 'integer') {
            return $result;
        }

        [$cases, $labels] = $result;

        // Obtiene el stub para generar enums.
        $stub = File::get(__DIR__.'/../../stubs/enum.backed.stub');

        // Rellena los placeholders.
        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ backingType }}', '{{ cases }}', '{{ labels }}'],
            [$namespace, $name, $backingType, $cases, $labels],
            $stub
        );

        File::put($path, $stub);

        $this->info("Enum $name creado en $path");

        return Command::SUCCESS;
    }

    /**
     * Obtiene los cases y labels para un enum a partir del archivo generado de cases del mismo.
     *
     * @param string $filePath Ruta del archivo a usar.
     * @return array<string>|int
     */
    private function getCases(string $filePath)
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
            // $this->error("No se pudo abrir archivo $filePath para generar Enums.");
            return 4;
        }

        return [$cases, $labels];
    }
}