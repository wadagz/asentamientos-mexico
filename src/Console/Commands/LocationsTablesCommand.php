<?php

namespace Wadagz\AsentamientosMexico\Console\Commands;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;

class LocationsTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:locations-tables-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchData();
    }

    private function fetchData(): void
    {
        $url = 'https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx';
        $dataFormat = 'xls';
        $zipName = 'locations.zip';

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

        $this->info("Archivo $zipName descargado con éxito.");
        $this->info("Extrayendo datos de $zipName...");

        // Extrae los datos del zip al directorio storage/app/private/
        $zip = new ZipArchive();
        $zipPath = storage_path("app/private/$zipName");
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo(storage_path('app/private/'));
            $zip->close();
        } else {
            $this->error("No se pudo abrir el archivo zip $zipName.");
        }

        $this->info("Datos extraídos exitosamente en ".storage_path('app/private/')."CPdescarga.xls");

        // Borrar zip tras extraer datos.
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $this->info("Archivo $zipName eliminado exitosamente.");
    }
}
