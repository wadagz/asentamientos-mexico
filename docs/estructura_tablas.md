# Tablas / Migraciones incluidas

El paquete incluye una migración con tres tablas para almacenar los datos necesarios de estados,
municipios y asentamientos.

De ser necesario es posible modificar la migración publicandola con el comando `php artisan vendor:publish` y
seleccionando el paquete.

## Estructura de las tablas

### Estados
|Columna|Tipo        |Ejemplo                      |Notas|
|-------|------------|-----------------------------|-----|
|id     |bigInt      |23, 32, 20                   |     |
|nombre |varchar(255)|Chihuahua, Jalisco, Zacatecas|     |

### Municipios
|Columna  |Tipo        |Ejemplo                          |Notas|
|---------|------------|---------------------------------|-----|
|id       |bigInt      |293, 1403, 190                   |     |
|estado_id|bigInt      |1, 24, 12                        |     |
|nombre   |varchar(255)|Tangancícuaro, Ecuandureo, Zamora|     |

### Asentamientos
|Columna          |Tipo        |Ejemplo                                                   |Notas                           |
|-----------------|------------|----------------------------------------------------------|--------------------------------|
|id               |bigInt      |132434, 98093, 34234                                      |                                |
|municipio_id     |bigInt      |324, 434, 903                                             |                                |
|nombre           |varchar(255)|Francisco Sarabia, Residencial las Américas, Bellas Torres|                                |
|tipo_asentamiento|varchar(255)|Colonia, Pueblo, Barrio                                   |Se genera `TipoAsentamientoEnum`|
|ciudad           |varchar(255)|Ciudad de México, Pachuca de Soto, Guadalajara            |nullable                        |
|codigo_postal    |varchar(5)  |45234, 37977, 48817                                       |                                |
|tipo_zona        |varchar(255)|Urbano, Rural, Semiurbano                                 |Se genera `TipoZonaEnum`        |
