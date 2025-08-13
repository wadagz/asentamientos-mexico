---
layout: default
title: Importación de datos
parent: Explicación a detalle
nav_order: 2
---
 
# Importación de datos

Para importar los datos se incluye el comando `asent-mex:import-data` se encarga de
importar los datos a partir de los archivos CSV generados por el comando
`asent-mex:fetch-data` mediante el uso de la librería
[Laravel Excel](https://docs.laravel-excel.com/3.1/getting-started/).

Este comando cuenta las opciones:

|Opción               |Descripción                           |Valor por defecto                       |
|---------------------|--------------------------------------|----------------------------------------|
|`-e --estados`       |Ruta del archivo CSV de estados       |`storage_path('temp/estados.csv')`      |
|`-m --municipios`    |Ruta del archivo CSV de municipios    |`storage_path('temp/municipios.csv')`   |
|`-a --asentamientos` |Ruta del archivo CSV de asentamientos |`storage_path('temp/asentamientos.csv')`|

```bash
php artisan asent-mex:fetch-data
```

