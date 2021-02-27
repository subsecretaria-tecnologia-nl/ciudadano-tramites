<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendienteFirmaController extends Controller
{
    //
    public function index () {
        $idTramites = [];
		set_layout_arg([
			"subtitle" => "perfil",
			"fluid_container"=> true
		]);
		$user = session()->get("user");
		$tramites = curlSendRequest("GET", getenv("TESORERIA_HOSTNAME")."/solicitudes-info/{$user->id}/firma");

        // for ($i=0; $i < count($tramites->tramites[0]->solicitudes)  ; $i++) { 
        //     # code...
        //     array_push($idTramites , $tramites->tramites[0]->solicitudes[$i]->id);
        // }
        // $idProcesso = $tramites->tramites[0]->tramite_id;

        $idTramites = $tramites->tramites;
		return layout_view("pendienteFirma", ['user' => json_encode($user), 'idTramites' => json_encode($idTramites)]);
    }

}
