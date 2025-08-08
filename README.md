# Asentamientos México

## Introducción

Este es un paquete para generación de tablas con información de estados,
municipios y asentamientos en México mediante migraciones en Laravel, todo
a partir de los datos proporcionados al público general por parte de Correos
de México.

Aquí se puede consultar la [documentación de uso](https://wadagz.github.io/asentamientos-mexico/).

## Guía de desarrollo

### Prerequisitos
- Git
- Docker

### Instalación
Clonar repositorio de github.
```bash
git clone https://github.com/wadagz/asentamientos-mexico.git
```

Ingresar al directorio creado
```bash
cd asentamientos-mexico
```

Construir contenedor con docker compose.
```bash
docker compose build
```

Ejecutar contenedor.
```bash
docker compose up
```

Instalar dependencias con composer.
```bash
docker exec asentamientos-mexico-development-1 composer install
```

### Ejecución de pruebas y análisis estático
Mediante Pest y PHPStan se realizan las pruebas y análisis estático del código.

Estos compandos deben ser ejecutados dentro del contenedor.

- Pruebas.
```bash
composer test
```

- Análisis estático.
```bash
composer phpstan
```
