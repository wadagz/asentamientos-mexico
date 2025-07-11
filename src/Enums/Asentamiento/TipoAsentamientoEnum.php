<?php

namespace Wadagz\AsentamientosMexico\Enums\Asentamiento;

enum TipoAsentamientoEnum: string
{
    case COLONIA = 'Colonia';
    case PUEBLO = 'Pueblo';
    case BARRIO = 'Barrio';
    case EQUIPAMIENTO = 'Equipamiento';
    case CAMPAMENTO = 'Campamento';
    case AEROPUERTO = 'Aeropuerto';
    case FRACCIONAMIENTO = 'Fraccionamiento';
    case CONDOMINIO = 'Condominio';
    case UNIDAD_HABITACIONAL = 'Unidad habitacional';
    case ZONA_COMERCIAL = 'Zona comercial';
    case RANCHO = 'Rancho';
    case RANCHERIA = 'Ranchería';
    case ZONA_INDUSTRIAL = 'Zona industrial';
    case GRANJA = 'Granja';
    case EJIDO = 'Ejido';
    case PARAJE = 'Paraje';
    case HACIENDA = 'Hacienda';
    case CONJUNTO_HABITACIONAL = 'Conjunto habitacional';
    case ZONA_MILITAR = 'Zona militar';
    case ZONA_FEDERAL = 'Zona federal';
    case PUERTO = 'Puerto';
    case EXHACIENDA = 'Exhacienda';
    case ZONA_NAVAL = 'Zona naval';
    case FINCA = 'Finca';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::COLONIA => 'Colonia',
            static::PUEBLO => 'Pueblo',
            static::BARRIO => 'Barrio',
            static::EQUIPAMIENTO => 'Equipamiento',
            static::CAMPAMENTO => 'Campamento',
            static::AEROPUERTO => 'Aeropuerto',
            static::FRACCIONAMIENTO => 'Fraccionamiento',
            static::CONDOMINIO => 'Condominio',
            static::UNIDAD_HABITACIONAL => 'Unidad habitacional',
            static::ZONA_COMERCIAL => 'Zona comercial',
            static::RANCHO => 'Rancho',
            static::RANCHERIA => 'Ranchería',
            static::ZONA_INDUSTRIAL => 'Zona industrial',
            static::GRANJA => 'Granja',
            static::EJIDO => 'Ejido',
            static::PARAJE => 'Paraje',
            static::HACIENDA => 'Hacienda',
            static::CONJUNTO_HABITACIONAL => 'Conjunto habitacional',
            static::ZONA_MILITAR => 'Zona militar',
            static::ZONA_FEDERAL => 'Zona federal',
            static::PUERTO => 'Puerto',
            static::EXHACIENDA => 'Exhacienda',
            static::ZONA_NAVAL => 'Zona naval',
            static::FINCA => 'Finca',
        };
    }

    /**
     * @return array<int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}