<?php

namespace Wadagz\AsentamientosMexico\Imports;

use Illuminate\Console\OutputStyle;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Wadagz\AsentamientosMexico\Models\Asentamiento;

class AsentamientosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithProgressBar
{
    use Importable;

    /**
     * Cantidad de registros a insertar en un solo statement.
     *
     * @var positive-int
     */
    private $batchSizeProperty;

    /**
     * Cantidad de filas a cargar en memoria a la vez.
     *
     * @var positive-int
     */
    private $chunkSizeProperty;

    public function __construct(int $size = 1000)
    {
        if ($size > 5000) {
            $size = 5000;
        }
        if ($size <= 0) {
            $size = 1000;
        }
        $this->batchSizeProperty = $size;
        $this->chunkSizeProperty = $size;
    }

    /**
     * Indica cantidad de registros a insertar por query
     *
     * @return int
     */
    public function batchSize(): int
    {
        return $this->batchSizeProperty;
    }

    /**
     * Indica cantidad de filas a leer a la vez
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return $this->chunkSizeProperty;
    }

    /**
     * Importa asentamientos a modelos
     *
     * @param array<string> $row
     * @return Asentamiento
     */
    public function model(array $row): Asentamiento
    {
        return new Asentamiento([
            'municipio_id' => $row['municipio_id'],
            'nombre' => $row['nombre'],
            'tipo_asentamiento' => $row['tipo_asentamiento'],
            'ciudad' => $row['ciudad'],
            'codigo_postal' => $row['codigo_postal'],
            'tipo_zona' => $row['tipo_zona'],
        ]);
    }
}
