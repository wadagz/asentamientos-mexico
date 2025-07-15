<?php

namespace Wadagz\AsentamientosMexico\Console\Commands;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;

class AsentamientosTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:asentamientos-tables-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las tablas de Asentamientos, Municipios y Estados.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // $this->fetchData();
        $result = $this->preProcessData();
        if ($result !== Command::SUCCESS) {
            return $result;
        }

        return 0;
    }

    /**
     * Descarga el archivo con los datos de la página del gobierno.
     *
     * @return void
     */
    private function fetchData(): void
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

        $this->info("Datos extraídos exitosamente en ".storage_path('app/private/')."CPdescarga.txt");

        // Borrar zip tras extraer datos.
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $this->info("Archivo $zipName eliminado exitosamente.");
    }

    /**
     * Llama al script de python para pre procesar los datos.
     *
     * @return int
     */
    private function preProcessData(): int
    {
        $scriptPath = __DIR__.'/../../../python/data_preprocessing.py'; // Path del script
        $dataFilePath = storage_path("app/private/CPdescarga.txt"); // Path del archivo con datos
        $exportPath = storage_path('temp'); // Path donde exportar los CSV
        $logsPath = storage_path('logs'); // Path donde guardar los logs

        if (!file_exists($dataFilePath)) {
            $this->error("El archivo {$scriptPath} no existe.");
            return 1;
        }

        if (!file_exists($exportPath)) {
            mkdir($exportPath);
        }
        if (!file_exists($logsPath)) {
            mkdir($logsPath);
        }

        $result = Process::run([
            'python3',
            $scriptPath,
            $dataFilePath,
            $exportPath,
            $logsPath,

        ]);

        if ($result->failed()) {
            $this->error("El pre-procesamiento de datos falló: {$result->errorOutput()}.");
            // dd($result->output(), $result->errorOutput(), $result->exitCode());
            return 2;
        }

        return Command::SUCCESS;
    }
}
