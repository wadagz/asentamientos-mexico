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
        $dataFormat = 'txt';
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

        // Extraer zip
        $zip = new ZipArchive();
    }
}
