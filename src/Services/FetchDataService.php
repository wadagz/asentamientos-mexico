<?php

namespace Wadagz\AsentamientosMexico\Services;

use Exception;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;

class FetchDataService
{
    /**
     * Handle function
     *
     * @return string FilePath del archivo con datos.
     */
    public function handle(): string
    {
        $filePath = $this->fetchData();
        return $filePath;
    }

    /**
     * Descarga el archivo con los datos de la página del gobierno.
     *
     * @return string FilePath del archivo con datos.
     */
    private function fetchData(): string
    {
        $url = 'https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx';
        $dataFormat = 'txt';
        $zipName = 'asentamientos.zip';

        // Petición para obtener los campos ocultos del form
        $cookieJar = new CookieJar();
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ',
            'Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
        ])->withOptions([
            'cookies' => $cookieJar,
        ])->get($url);

        // Se extraen los campos ocultos del form
        $crawler = new Crawler($response->body());

        $viewstate = $crawler->filter('#__VIEWSTATE')->attr('value');
        $viewstategenerator = $crawler->filter('#__VIEWSTATEGENERATOR')->attr('value');
        $eventvalidation = $crawler->filter('#__EVENTVALIDATION')->attr('value');

        // Datos necesarios para hacer la petición
        $data = [
            '__VIEWSTATE' => $viewstate,
            '__VIEWSTATEGENERATOR' => $viewstategenerator,
            '__EVENTVALIDATION' => $eventvalidation,
            'cboEdo' => '00',
            'rblTipo' => $dataFormat,
            'btnDescarga.x' => 42,
            'btnDescarga.y' => 13,
        ];

        $response = Http::asForm()->post($url, $data);

        Storage::put($zipName, $response->body());

        // Extrae los datos del zip al directorio storage/app/private/
        $zip = new ZipArchive();
        $zipPath = storage_path("app/private/$zipName");
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo(storage_path('app/private/'));
            $zip->close();
        } else {
            throw new Exception("No se pudo abrir el archivo zip $zipName.");
        }

        // Borrar zip tras extraer datos.
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        return storage_path('app/private/CPdescarga.txt');
    }
}