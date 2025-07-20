<?php

namespace Wadagz\AsentamientosMexico\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wadagz\AsentamientosMexico\Models\Municipio;

class MunicipiosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
     * Indica cantidad de registros a insertar por query
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 5000;
    }

    /**
     * Indica cantidad de filas a leer a la vez
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 5000;
    }

    /**
     * Importa municipios a modelos
     *
     * @param array<string> $row
     * @return Municipio
     */
    public function model(array $row): Municipio
    {
        return new Municipio([
            'id' => $row['id'],
            'estado_id' => $row['estado_id'],
            'nombre' => $row['nombre'],
        ]);
    }
}
