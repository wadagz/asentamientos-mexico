# Modelos

Tres modelos son incluidos en el paquete:
- Estado
- Municipio
- Asentamiento

## Estado
El modelo `Estado` solo incluye dos propiedades:
- `@property positive-int $id`
- `@property non-empty-string $nombre Nombre del estado`

Cuenta con una única relación con el modelo `Municipio` de N:1.
- `municipio()`

## Municipio
El modelo `Municipio` cuenta con las siguientes propiedades:
- `@property positive-int $id`
- `@property positive-int $estado_id Id del estado asociado`
- `@property non-empty-string $nombre Nombre del municipio`

Cuenta con dos relaciones:
- `estado()` 1:N
- `asentamientos()` N:1

## Asentamiento
El modelo `asentamiento` cuenta con las siguientes propiedades:
- `@property positive-int $id`
- `@property positive-int $municipio_id Id del municipio asociado`
- `@property non-empty-string $nombre Nombre del asentamiento`
- `@property non-empty-string $tipo_asentamiento Tipo del asentamiento`
- `@property non-empty-string $ciudad Nombre de la ciudad`
- `@property non-empty-string $codigo_postal Código postal del asentamiento`
- `@property non-empty-string $tipo_zona Tipo de la zona del asentamiento`

Cuenta con una única relación.
- `municipio()` 1:N
