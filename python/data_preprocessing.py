import pandas as pd
import unicodedata
import sys
import logging
import traceback

###
# Funciones de utilidad
###
def make_municipio_id_unique(data_frame: pd.DataFrame) -> pd.DataFrame:
    """Convierte el id del municipio en id único

    Debido a que los código de municipio son locales al estado, es decir que se
    repiten entre estados, es necesario modificarlos para que sean únicos.
    Se agrega la columna 'old_id' y se asigna un id autoincremental a la columna 'id'.

    Args:
        data_frame (pd.DataFrame): DataFrame de municipios

    Returns:
        pd.DataFrame: DataFrame con nuevo id y old_id
    """

    data_frame['old_id'] = data_frame['id']
    data_frame['id'] = [i + 1 for i in range(len(data_frame['id']))]
    return data_frame

def remove_accents(text: str) -> str:
    """Remueve acentos y ñ de textos"""

    # Normaliza a NFD (forma descompuesta de unicode)
    text = unicodedata.normalize('NFD', text)
    # Filtra los carácteres con acentos
    text = ''.join(char for char in text if not unicodedata.combining(char))
    # Reemplaza ñ por n
    text = text.replace('ñ', 'n').replace('Ñ', 'N')
    return text

###
# Procesado de datos
###
def process_estados(df: pd.DataFrame) -> pd.DataFrame:
    """Genera dataframe de estados"""

    # Filtrar únicamente columnas de id y nombre
    df_estados = df.filter(items=['estado_id', 'estado_nombre'])
    # Renombrar columnas
    df_estados = df_estados.rename(columns={ 'estado_id': 'id', 'estado_nombre': 'nombre' })
    # Remueve filas duplicadas
    df_estados = df_estados.drop_duplicates()
    # Ordenar por id
    df_estados = df_estados.sort_values(by='id')
    logging.debug(f'DF estados generado.')
    return df_estados

def process_municipios(df: pd.DataFrame) -> pd.DataFrame:
    """Genera dataframe de municipios"""

    # Toma solamente columnas necesarias
    df_municipios = df.filter(items=['municipio_id', 'estado_id', 'municipio_nombre'])
    # Renombra las columnas
    df_municipios = df_municipios.rename(columns={ 'municipio_id': 'id', 'municipio_nombre': 'nombre'})
    # Elimina filas duplicadas
    df_municipios = df_municipios.drop_duplicates()
    # Ordenar por estado y por id
    df_municipios = df_municipios.sort_values(by=['estado_id', 'id'])
    # Aplica función para convertir id a valores únicos
    df_municipios = make_municipio_id_unique(df_municipios)
    logging.debug(f'DF municipios generado.')
    return df_municipios

def process_asentamientos(df: pd.DataFrame, df_municipios: pd.DataFrame) -> pd.DataFrame:
    """Genera dataframe de asentamientos"""

    # Filtra columnas necesarias
    df_asentamientos = df.filter(items=['estado_id', 'municipio_id', 'nombre', 'tipo_asentamiento', 'ciudad', 'codigo_postal', 'tipo_zona'])
    # Asocia el asentamiento con el id único del municipio
    # Debido a que los id de los municipios cambiaron, es necesario hacer
    # una instersección de los registros tomando como campos el id antiguo de los
    # municipios y el id del estado.
    df_asentamientos = df_asentamientos.merge(df_municipios, 'inner', left_on=['municipio_id', 'estado_id'], right_on=['old_id', 'estado_id'])
    # Elimina columnas innecesarias y renombra otras
    df_asentamientos = df_asentamientos.drop(columns=['estado_id', 'nombre_y', 'old_id', 'municipio_id']).rename(columns={ 'nombre_x': 'nombre', 'id': 'municipio_id' })
    # Ordena las columnas y filas
    df_asentamientos = df_asentamientos[['municipio_id', 'nombre', 'tipo_asentamiento', 'ciudad', 'codigo_postal', 'tipo_zona']].sort_values(by=['municipio_id', 'nombre'])
    logging.debug(f'DF asentamientos generado.')
    return df_asentamientos

###
# Generacion de enus
###
def get_enum(df: pd.DataFrame, column: str) -> pd.DataFrame:
    """Genera un dataframe con los cases y values para un enum de una columna"""

    enum_cases = df.filter(items=[column]).drop_duplicates()[column]
    df_enum = pd.DataFrame({
        # Pasa a mayúsculas, reemplaza espacio por guión bajo, y remueve acentos.
        'cases': enum_cases.apply(lambda case: remove_accents(case.upper().replace(' ', '_'))),
        'values': enum_cases
    })
    return df_enum

def main():
    logging.info('Iniciado data preprocessing.')

    ### Carga de DF y renombramiento de columnas ###
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

    ### Procesamiento de datos ###
    # Estados
    df_estados = process_estados(df)

    # Municipios
    df_municipios = process_municipios(df)

    # Asentamientos
    df_asentamientos = process_asentamientos(df, df_municipios)

    ### Enums ###
    # Tipo asentamiento
    df_tipo_asentamiento = get_enum(df, 'tipo_asentamiento')

    # Tipo asentamiento
    df_tipo_zona = get_enum(df, 'tipo_zona')

    ### Exportacion a archivos CSV ###
    logging.debug(f'Exportando DF a CSV.')
    df_estados.to_csv(f'{export_path}/estados.csv', index=False)
    df_municipios.to_csv(f'{export_path}/municipios.csv', index=False)
    df_asentamientos.to_csv(f'{export_path}/asentamientos.csv', index=False)
    df_tipo_asentamiento.to_csv(f'{export_path}/tipo_asentamiento_cases.csv', index=False, header=False)
    df_tipo_zona.to_csv(f'{export_path}/tipo_zona_cases.csv', index=False, header=False)
    logging.debug(f'CSV exportados.')
    logging.info('Finalizado data preprocessing.')

if __name__ == "__main__":
    try:
        # Toma el tercer argumento como la ruta para guardar los logs
        logs_path = sys.argv[3]

        # Configuración del logger.
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
