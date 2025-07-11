<?php

namespace Wadagz\AsentamientosMexico\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wadagz\AsentamientosMexico\Database\Factories\AsentamientoFactory;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoAsentamientoEnum;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoZonaEnum;

/**
 * Asentamientos dentro de municipios
 *
 * @property positive-int $id
 * @property positive-int $municipio_id Id del municipio asociado
 * @property non-empty-string $nombre Nombre del asentamiento
 * @property TipoAsentamientoEnum $tipo_asentamiento Tipo del asentamiento
 * @property non-empty-string $ciudad Nombre de la ciudad
 * @property non-empty-string $codigo_postal Código postal del asentamiento
 * @property TipoZonaEnum $tipo_zona Tipo de la zona del asentamiento
 */
class Asentamiento extends Model
{
    /** @use HasFactory<\Wadagz\AsentamientosMexico\Database\Factories\AsentamientoFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'asentamientos';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'municipio_id',
        'nombre',
        'tipo_asentamiento',
        'ciudad',
        'codigo_postal',
        'tipo_zona',
    ];

    /**
     * Defines the factory to use for the model
     *
     * @return AsentamientoFactory
     */
    protected static function newFactory(): AsentamientoFactory
    {
        return AsentamientoFactory::new();
    }

    /**
     * @return BelongsTo<Municipio, $this>
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}