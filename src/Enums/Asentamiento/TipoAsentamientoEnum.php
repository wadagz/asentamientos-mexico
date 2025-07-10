<?php

namespace Wadagz\AsentamientosMexico\Enums\Asentamiento;

enum TipoAsentamientoEnum: int
{
    case COLONIA = 1;
    case PUEBLO = 2;
    case BARRIO = 3;
    case EQUIPAMIENTO = 4;
    case CAMPAMENTO = 5;
    case AEROPUERTO = 6;
    case FRACCIONAMIENTO = 7;
    case CONDOMINIO = 8;
    case UNIDAD_HABITACIONAL = 9;
    case ZONA_COMERCIAL = 10;
    case RANCHO = 11;
    case RANCHERÍA = 12;
    case ZONA_INDUSTRIAL = 13;
    case GRANJA = 14;
    case EJIDO = 15;
    case PARAJE = 16;
    case HACIENDA = 17;
    case CONJUNTO_HABITACIONAL = 18;
    case ZONA_MILITAR = 19;
    case ZONA_FEDERAL = 20;
    case PUERTO = 21;
    case EXHACIENDA = 22;
    case ZONA_NAVAL = 23;
    case FINCA = 24;

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
            static::RANCHERÍA => 'Ranchería',
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
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}