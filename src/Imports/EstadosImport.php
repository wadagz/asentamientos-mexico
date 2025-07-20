<?php

namespace Wadagz\AsentamientosMexico\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wadagz\AsentamientosMexico\Models\Estado;

class EstadosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
     * Indica cantidad de registros a insertar por query
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Indica cantidad de filas a leer a la vez
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Importa estados a modelos
     *
     * @param array<string> $row
     * @return Estado
     */
    public function model(array $row): Estado
    {
        return new Estado([
            'nombre' => $row['nombre'],
        ]);
    }
}