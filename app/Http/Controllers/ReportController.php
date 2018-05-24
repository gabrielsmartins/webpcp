<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PHPJasper\PHPJasper;
use Symfony\Component\HttpFoundation\Request;
use function abort;
use function base_path;
use function env;
use function public_path;
use function response;
use function view;

class ReportController extends Controller {

    public function getDatabaseConfig() {
        return [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [],
            'db_connection' => [
                'driver' => env('DB_CONNECTION'),
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'database' => env('DB_DATABASE'),
                //'jdbc_driver' => 'com.mysql.cj.jdbc.Driver',
                //'jdbc_url' => 'jdbc:mysql://' . env('DB_HOST') . ':' . env('DB_PORT') . '/' . env('DB_DATABASE'),
                'jdbc_dir' => base_path() . env('JDBC_DIR', '/vendor/lavela/phpjasper/src/JasperStarter/jdbc'),
        ]
            ];
    }

    public function filterStockReport() {
        return view('report.report_stock');
    }

    public function filterProductionReport() {
        return view('report.report_production');
    }

    public function stock(Request $request) {

        $tipo = $request->input('tipo');

        $output = public_path() . '/reports/' . time() . '_Estoque';

        $report = new PHPJasper();



        $report->process(public_path() . '/reports/Material.jrxml', $output, $this->getDatabaseConfig())->execute();

        $file = $output . '.pdf';
        $path = $file;

        if (!file_exists($file)) {
            abort(404);
        }

        $file = file_get_contents($file);

        unlink($path);

        // return response(var_dump($this->getDatabaseConfig()));
        return response($file, 200)
                        ->header('Content-Type', 'application/pdf')
                        ->header('Content-Disposition', 'inline; filename="cliente.pdf"');
    }

    public function production(Request $request) {

        $output = public_path() . '/reports/' . time() . '_Clientes';

        $report = new PHPJasper();


        $report->process(
                public_path() . '/reports/Customers.jrxml', $output, ['pdf'], [], $this->getDatabaseConfig()
        )->execute();

        $file = $output . '.pdf';
        $path = $file;

        if (!file_exists($file)) {
            abort(404);
        }

        $file = file_get_contents($file);

        unlink($path);

        return response($file, 200)
                        ->header('Content-Type', 'application/pdf')
                        ->header('Content-Disposition', 'inline; filename="cliente.pdf"');
    }

}
