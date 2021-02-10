<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FormatoDeclaracionController extends Controller
{
    public function index ($id) {
		$tramite = curlSendRequest("GET", getenv("TESORERIA_HOSTNAME")."/solicitudes-get-tramite-pdf/{$id}");
		if(isset($tramite->tramite) && count($tramite->tramite) > 0){
			$info = $tramite->tramite[0];
			return view("pdf/formatoDeclaracion", [ "info" => $info ]);
		}

		dd("No existe un trámite con el ID '{$id}' en nuestro registro.");
    }
}
