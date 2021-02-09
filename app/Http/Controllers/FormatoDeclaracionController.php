<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;


class FormatoDeclaracionController extends Controller
{
    public function index ($id) {
		$tramite = curlSendRequest("GET", getenv("TESORERIA_HOSTNAME")."/solicitudes-get-tramite-pdf/{$id}");
		if(isset($tramite->tramite) && count( $tramite->tramite->solicitudes) > 0){
			$info = $tramite->tramite;
			$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.formatoDeclaracion', compact('info'));
        	return $pdf->stream('formatoDeclaracion.blade.pdf');
			// return view("pdf/formatoDeclaracion5", [ "info" => ($info) ]);
		}

		dd("No existe un trámite con el ID '{$id}' en nuestro registro.");
    }
}
