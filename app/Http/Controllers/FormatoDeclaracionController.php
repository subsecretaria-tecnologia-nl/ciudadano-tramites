<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;


class FormatoDeclaracionController extends Controller
{
    public function index ($id , $campoIndex = 0) {
		$tramite = curlSendRequest("GET", getenv("TESORERIA_HOSTNAME")."/solicitudes-get-tramite-pdf/{$id}");
		if(isset($tramite->tramite) && count( $tramite->tramite->solicitudes) > 0){
			$info = $tramite->tramite;
			$enajenante = (array)  $info->solicitudes[0]->info->campos;
			$enajenante = $enajenante['Listado de enajenantes'];
			$pdf = PDF::loadView('pdf.formatoDeclaracion', compact('info', 'campoIndex', 'enajenante'));
        	return $pdf->stream('formatoDeclaracion.blade.pdf');
		}

		dd("No existe un trámite con el ID '{$id}' en nuestro registro.");
    }
}
