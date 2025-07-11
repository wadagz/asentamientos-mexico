<?php

namespace Wadagz\AsentamientosMexico\Imports;

use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoAsentamientoEnum;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoZonaEnum;
use Wadagz\AsentamientosMexico\Models\Asentamiento;
use Wadagz\AsentamientosMexico\Models\Estado;
use Wadagz\AsentamientosMexico\Models\Municipio;

class AsentamientosInitialImport implements OnEachRow, WithChunkReading, WithCustomCsvSettings, WithHeadingRow, WithStartRow
{
    use RemembersRowNumber;

    /**
     * Tamaño de los chunks
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Configuración de CSV
     *
     * @return array<string>
     */
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter' => '|',
        ];
    }

    /**
     * Indica la fila donde se encuentra el header
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 2;
    }

    /**
     * Indica la fila por la cual comenzar.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * Itera sobre las filas del archivo, creando
     * registros de Asentamiento, asociados a Estado y Municipio.
     * Primero comprueba si el Estado y Municipio ya existen y los crea
     * si no es el caso.
     *
     * @param Row $row Fila del archivo
     * @return void
     */
    public function onRow(Row $row): void
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        try {
            $estado = Estado::firstOrCreate(
                ['id' => $row['c_estado']],
                ['nombre' => $row['d_estado']]
            );

            $municipio = Municipio::firstOrCreate(
                ['id' => $row['c_mnpio']],
                [
                    'estado_id' => $estado->id,
                    'nombre' => $row['d_mnpio'],
                ],
            );

            Asentamiento::create([
                'municipio_id' => $municipio->id,
                'nombre' => $row['d_asenta'],
                'tipo_asentamiento' => TipoAsentamientoEnum::from($row['d_tipo_asenta']),
                'ciudad' => $row['d_ciudad'] ?? null,
                'codigo_postal' => $row['d_codigo'],
                'tipo_zona' => TipoZonaEnum::from($row['d_zona']),
            ]);
        } catch (Exception $e) {
            echo($e->getMessage());
            Log::debug($e->getMessage(), [
                'rowIndex' => $rowIndex,
                'rowNumber' => $this->getRowNumber(),
                'row' => $row,
            ]);
            return;
        }
    }
}
