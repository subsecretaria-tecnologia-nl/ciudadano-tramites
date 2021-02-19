<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
    	$notary = \Session::get('user')->notary->id;
    	$draft = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 80, "notary_id" => (int)$notary ]);
    	$pendingPayment = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 99, "notary_id" => (int)$notary ]);
    	$waiting = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 3, "notary_id" => (int)$notary ]);
    	$progress = curlSendRequest('POST', getenv("TESORERIA_HOSTNAME")."/solicitudes-filtrar", [ "estatus" => 1, "notary_id" => (int)$notary ]);
    	$total = 5;

		set_layout_arg([
			"subtitle" => "Dashboard",
			"fluid_container"=> true
		]);

		return layout_view("dashboard", [
			"totals" => [
				"draft" => count($draft),
				"pendingPayment" => count($pendingPayment),
				"waiting" => count($waiting),
				"progress" => count($progress),
			],
			"draft" => array_splice($draft, 0, $total),
			"pendingPayment" => array_splice($pendingPayment, 0, $total),
			"waiting" => array_splice($waiting, 0, $total),
			"progress" => array_splice($progress, 0, $total)
		]);
    }
}
