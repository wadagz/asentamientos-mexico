<?php
namespace Wadagz\AsentamientosMexico\Enums\Asentamiento;

enum TipoZonaEnum: int
{
    case URBANA = 1;
    case RURAL  = 2;

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::URBANA => 'Urbana',
            static::RURAL  => 'Rural',
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