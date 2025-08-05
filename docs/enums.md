# Enums

El modelo `Asentamiento` cuenta con dos propiedades que tienen un conjunto finito
de posibles valores:
- `@property non-empty-string $tipo_asentamiento Tipo del asentamiento`
- `@property non-empty-string $tipo_zona Tipo de la zona del asentamiento`

Los valores son obtenidos durante el pre-procesado de datos, de forma que se
generan archivos CSV con la lista de los mismos. Con estas listas
se generan Enums mediante el uso de stubs.

El motivo por el cual se indica que son `non-empty-string` en lugar de enums
es porque existe la posibilidad de que los valores se actualicen, de forma
que resulta necesario generar los enums de manera dinámica.

Los enums generados son:
- `TipoAsentamientoEnum`
- `TipoZonaEnum`

## Funciones
Los enums incluyen dos funciones:
- `label()`
- `values()`

### label()
A partir de una instancia del enum, regresa su etiqueta para mostrar al usuario.

```php
<?php
$tipoAsentamiento = TipoAsentamientoEnum::COLONIA;
$tipoAsentamiento->label();
// Retorna la cadena "Colonia".
```

### values()
Función estática. Regresa un arreglo con los posibles valores del enum.

```php
<?php
$valuesTipoAsentamiento = TipoAsentamientoEnum::values();
// Retorna un arreglo como el que sigue
// ['Colonia', 'Fraccionamiento', ...]
```

