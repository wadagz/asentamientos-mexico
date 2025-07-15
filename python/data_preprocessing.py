import pandas as pd
import sys
import logging
import traceback

"""
Funciones para Municipios
"""
# Debido a que los código de municipio son locales al estado, es decir que se
# repiten entre estados, se modifican para que sean únicos.
# El código del estado se multiplica por 1000 y se le suma el código del
# municipio para crear un código único.
def make_municipio_id_unique(row):
  estado_id = row['estado_id']
  municipio_id = row['id']
  old_id = row['id']
  estado_id = estado_id * 1000
  municipio_id = estado_id + municipio_id
  row['id'] = municipio_id
  row['old_id'] = old_id

  return row

def main():
    logging.info('Iniciado data preprocessing.')
    """
    Carga de DF y renombramiento de columnas
    """
    # Toma el primer argumento como la ruta del archivo a cargar.
    file_path = sys.argv[1]
    # Tomal el segundo argumento como la ruta para exportar.
    export_path = sys.argv[2]

    logging.debug(f'Intentando abrir archivo {file_path}')

    df = pd.read_csv(file_path, delimiter='|', header=1, encoding='latin_1');
    logging.debug(f'Renombrando columnas del dataframe.')
    df = df.rename(columns={
        'd_codigo': 'codigo_postal',
        'd_asenta': 'nombre',
        'd_tipo_asenta': 'tipo_asentamiento',
        'D_mnpio': 'municipio_nombre',
        'd_estado': 'estado_nombre',
        'd_ciudad': 'ciudad',
        'c_estado': 'estado_id',
        'c_tipo_asenta': 'tipo_asentamiento_codigo',
        'c_mnpio': 'municipio_id',
        'd_zona': 'tipo_zona',
    })

    """
    Estados
    """
    # Filtrar únicamente columnas de id y nombre
    df_estados = df.filter(items=['estado_id', 'estado_nombre'])
    # Renombrar columnas
    df_estados = df_estados.rename(columns={ 'estado_id': 'id', 'estado_nombre': 'nombre' })
    # Remueve filas duplicadas
    df_estados = df_estados.drop_duplicates()
    # Ordenar por id
    df_estados.sort_values(by='id')
    logging.debug(f'DF estados generado.')

    """
    Municipios
    """
    # Toma solamente columnas necesarias
    df_municipios = df.filter(items=['municipio_id', 'estado_id', 'municipio_nombre'])
    # Renombra las columnas
    df_municipios = df_municipios.rename(columns={ 'municipio_id': 'id', 'municipio_nombre': 'nombre'})
    # Elimina filas duplicadas
    df_municipios = df_municipios.drop_duplicates()
    # Aplica función para convertir id a valores únicos
    df_municipios = df_municipios.apply(make_municipio_id_unique, axis='columns')
    # Ordena por id
    df_municipios = df_municipios.sort_values(by='id')
    logging.debug(f'DF municipios generado.')

    """
    Asentamientos
    """
    df_asentamientos = df.filter(items=['estado_id', 'municipio_id', 'nombre', 'tipo_asentamiento', 'ciudad', 'codigo_postal', 'tipo_zona'])
    # Asocia el asentamiento con el id único del municipio
    df_asentamientos = df_asentamientos.merge(df_municipios, 'inner', left_on=['municipio_id', 'estado_id'], right_on=['old_id', 'estado_id'])
    # Elimina columnas innecesarias y renombra otras
    df_asentamientos = df_asentamientos.drop(columns=['estado_id', 'nombre_y', 'old_id', 'municipio_id']).rename(columns={ 'nombre_x': 'nombre', 'id': 'municipio_id' })
    # Ordena las columnas y filas
    df_asentamientos = df_asentamientos[['municipio_id', 'nombre', 'tipo_asentamiento', 'ciudad', 'codigo_postal', 'tipo_zona']].sort_values(by='municipio_id')
    logging.debug(f'DF asentamientos generado.')

    """
    Exportacion a archivos CSV
    """
    logging.debug(f'Exportando DF a CSV.')
    df_estados.to_csv(f'{export_path}/estados.csv', index=False)
    df_municipios.to_csv(f'{export_path}/municipios.csv', index=False)
    df_asentamientos.to_csv(f'{export_path}/asentamientos.csv', index=False)
    logging.debug(f'CSV exportados.')

    logging.info('Finalizado data preprocessing.')

if __name__ == "__main__":
    try:
        # Toma el tercer argumento como la ruta para guardar los logs
        logs_path = sys.argv[3]
        logging.basicConfig(
            format='%(asctime)s %(levelname)s:%(message)s',
            level=logging.DEBUG,
            filename=f'{logs_path}/asentamientos_preprocessing.log',
            datefmt='%Y-%m-%d %H:%M:%S'
        )
        main()
    except Exception as e:
        logging.error(traceback.format_exc())
        sys.exit(traceback.format_exc())
