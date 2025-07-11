<?php

namespace Wadagz\AsentamientosMexico\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wadagz\AsentamientosMexico\Database\Factories\EstadoFactory;

/**
 * Estados de la república mexicana
 *
 * @property positive-int $id
 * @property non-empty-string $nombre Nombre del estado
 */
class Estado extends Model
{
    /** @use HasFactory<\Wadagz\AsentamientosMexico\Database\Factories\EstadoFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'estados';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Defines the factory to use for the model
     *
     * @return EstadoFactory
     */
    protected static function newFactory(): EstadoFactory
    {
        return EstadoFactory::new();
    }

    /**
     * @return HasMany<Municipio, $this>
     */
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }
}

