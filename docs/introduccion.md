# Introducción rápida

_Asentamientos México_ es un paquete diseñado para descargar datos de estados, municipios y asentamientos dentro de
la república mexicana, disponibles públicamente por parte de Correos de México, y generar tablas junto con sus
respectivos modelos y factories en un proyecto de Laravel de forma automática.

## Instalación

### Prerequisitos

El paquete utiliza internamente un script en Python con Pandas para procesar los datos antes de importarlos, por lo que resulta
necesario que estos se encuentren instalados de antemano.

El script se ha probado con las versiones:
- Python: 3.11.2
- Pandas: 1.5.3

### Composer.json

Actualmente el paquete no se encuentra disponible en servicios como `packagist` o similares, sino que es necesario incluir manualmente
el repositorio en el archivo `composer.json`.

```json
{
    "require": {
        "wadagz/asentamientos-mexico": "dev-main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/wadagz/asentamientos-mexico"
        }
    ]
}
```

Posteriormente ejecuta `composer install` o `composer update`.

## Uso

### Importación de datos

> INFO
>
> Previo a hacer uso de los comandos incluidos ejecuta las migraciones `php artisan db:migrate` para que
> las tablas necesarias sean creadas.

El paquete incluye un comando para realizar la descarga e importación de los datos:

```bash
db:asentamientos-tables-command
```

Esto descargará el archivo con los datos de la base de datos pública de Correos de México, realizará un preprocesado
de con Python, y procederá a importarlos mediante la librería [Laravel Excel](https://docs.laravel-excel.com/3.1/getting-started/).

> NOTA
>
> Con los parámetros por defecto la importación puede demorar alrededor de 4 minutos.

### Modelos, Factories y Enums

Se incluyen [modelos](modelos.md) y [factories](factories.md) de `Estado`, `Municipio` y `Asentamiento` para interactuar con las tablas
estados, municipios y asentamientos.

Hay dos atributos del modelo `Asentamiento` que cuentan con un conjunto establecido de posibles valores,
por lo que también se crean [enums](enums.md) para dichos atributos.

- `TipoAsentamientoEnum`
- `TipoZonaEnum`
