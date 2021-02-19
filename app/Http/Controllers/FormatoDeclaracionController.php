<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;


class FormatoDeclaracionController extends Controller
{
    public function index ($id) {
		// dd( json_decode($info) );
		$tramite = curlSendRequest("GET", getenv("TESORERIA_HOSTNAME")."/solicitudes-get-tramite-pdf/{$id}");
		if(isset($tramite->tramite) && count( $tramite->tramite->solicitudes) > 0){
			$info = $tramite->tramite;
 			// $info =json_decode($info[0]);
			//  dd(gettype($info));
			$pdf = PDF::loadView('pdf.formatoDeclaracion5', compact('info'));
        	return $pdf->stream('formatoDeclaracion5.blade.pdf');
		}

		dd("No existe un trámite con el ID '{$id}' en nuestro registro.");
    }
}
