<?php
namespace Wadagz\AsentamientosMexico\Enums\Asentamiento;

enum TipoZonaEnum: string
{
    case URBANO = 'Urbano';
    case RURAL  = 'Rural';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::URBANO => 'Urbano',
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