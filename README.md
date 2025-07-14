# Ubicaciones en México (Nombre Provisional)

## Introducción

Este es un paquete para generación de tablas con información de estados,
municipios y locaciones en México mediante migraciones en Laravel, todo
a partir de los datos proporcionados al público general por parte del Gobierno
de México.

## Guía de desarrollo

### Prerequisitos
- Git
- Docker

### Instalación
Clonar repositorio de github.
```bash
git clone git@github.com:wadagz/asentamientos-mexico.git
```

Construir contenedor con docker compose.
```bash
docker compose build
```

Ejecutar contenedor con el argumento `--watch` para que se sincronicen los archivos
dentro del contenedor al hacer cambios a estos.
```bash
docker compose up --watch
```

Instalar dependencias de composer.
```bash
docker exec asentamientos-mexico-development-1 composer install
```

o dentro del contenedor:

```bash
docker exec -it asentamientos-mexico-development-1 bash
composer install
```

### Ejecución de pruebas y análisis estático
Mediante Pest y PHPStan se realizan las pruebas y análisis estático del código.

Estos compandos pueden ser ejecutados con `docker exec asentamientos-mexico-development-1 <nombre-comando>` o dentro del contenedor mediante
`docker exec -it asentamientos-mexico-development-1 bash`.

Para ejecutar las pruebas.
```bash
composer test
```

Para ejecutar el análisis estático.
```bash
composer phpstan
```