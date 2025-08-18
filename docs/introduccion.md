---
layout: default
title: Introducción rápida
nav_order: 2
---

# Introducción rápida
{: .no_toc }

Aquí se encuentra los pasos de instalación y una guía básica de uso del paquete.

## TABLA DE CONTENIDOS
{: .no_toc .text-delta }

- TOC
{:toc}

## Instalación

### Prerequisitos

El código de PHP hace uso de funcionalidades disponibles a partir de la versión 8 en adelante, por lo que es necesario
usar PHP 8+.

El paquete utiliza internamente un script en Python con Pandas para procesar los datos antes de importarlos, de forma que resulta
menester que estos se encuentren instalados de antemano.

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
            "url":  "git@github.com:dev-cucei-itrans/localidades-mexico.git"
        }
    ],
    "minimum-stability": "dev",
}
```

Debido a que el paquete se encuentra en un repositorio privado en GitHub puede resultar necesario hacer
uso un de token para obtener acceso al repositorio. Para ello sigue estos pasos:

1. Para generar el token se requiere acceder a la página de settings de tu perfil en [GitHub](https://github.com/settings/profile).
2. Selecciona la opción `Developer Settings` que se encuentra en el menú lateral izquierdo hasta abajo.
3. Selecciona `Personal access tokens` > `Tokens (classic)`.
4. Asigna un nombre y fecha de expiración al token.
5. En la sección `Select scopes` selecciona  la opción `repo` (la primera que se muestra).
6. Da clic en `Generate token`.
7. Se mostrará en pantalla el token generado. Cópialo y guárdalo en un lugar seguro.

Ahora instala el paquete.

```bash
composer require wadagz/asentamientos-mexico
```

Posiblemente se te muestre el mensaje: _The authenticity of host 'github.com (140.82.116.3)' can't be established..._ Escribe `yes` y presiona Enter.

Cuando composer solicite un token de acceso, copia y pega el token generado anteriormente.


## Uso

### Descarga e importación de datos

{: .info}
> Previo a hacer uso de los comandos incluidos ejecuta las migraciones con `php artisan db:migrate` para que
> las tablas necesarias sean creadas.

El paquete incluye dos comandos, uno para realizar la descarga y otro para importar los datos.

#### Descarga
Realiza la descarga de los datos de Correos de México, lleva a cabo un pre-procesamiento de los mismos y
genera archivos CSV para la posterior importación de los datos.
```bash
asent-mex:fetch-data
```

#### Importación
Ya teniendo los archivos CSV generados, mediante [Laravel Excel](https://docs.laravel-excel.com/3.1/getting-started/)
importa los datos a las tablas de estados, municipios y asentamientos.
```bash
asent-mex:import-data
```

{: .note }
> Con los parámetros por defecto la importación puede demorar alrededor de 4 a 5 minutos.

### Modelos, Factories y Enums

Se incluyen [modelos](explicacion_a_detalle/modelos.html) y [factories](explicacion_a_detalle/factories.html) de `Estado`, `Municipio` y `Asentamiento` para interactuar con las tablas
estados, municipios y asentamientos.

Hay dos atributos del modelo `Asentamiento` que cuentan con un conjunto establecido de posibles valores,
por lo que también se crean [enums](explicacion_a_detalle/enums.html) para dichos atributos.

- `TipoAsentamientoEnum`
- `TipoZonaEnum`
