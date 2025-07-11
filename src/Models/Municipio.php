<?php

namespace Wadagz\AsentamientosMexico\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wadagz\AsentamientosMexico\Database\Factories\MunicipioFactory;

/**
 * Municipios de los diversos estados
 *
 * @property positive-int $id
 * @property positive-int $estado_id Id del estado asociado
 * @property non-empty-string $nombre Nombre del municipio
 */
class Municipio extends Model
{
    /** @use HasFactory<\Wadagz\AsentamientosMexico\Database\Factories\MunicipioFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'municipios';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'estado_id',
        'nombre',
    ];

    /**
     * Defines the factory to use for the model
     *
     * @return MunicipioFactory
     */
    protected static function newFactory(): MunicipioFactory
    {
        return MunicipioFactory::new();
    }

    /**
     * @return BelongsTo<Estado, $this>
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    /**
     * @return HasMany<Asentamiento, $this>
     */
    public function asentamientos(): HasMany
    {
        return $this->hasMany(Asentamiento::class);
    }
}

