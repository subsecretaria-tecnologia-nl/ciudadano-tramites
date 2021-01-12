<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
    	$draft = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 80 ]);
    	$pendingPayment = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 99 ]);
    	$waiting = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 3 ]);
    	$progress = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 1 ]);
    	$total = 5;

    	// dd($draft);

		set_layout_arg([
			"subtitle" => "Dashboard",
			"fluid_container"=> true
		]);

		return layout_view("dashboard", [
			"draft" => array_splice($draft, 0, $total),
			"pendingPayment" => array_splice($pendingPayment, 0, $total),
			"waiting" => array_splice($waiting, 0, $total),
			"progress" => array_splice($progress, 0, $total)
		]);
    }
}
