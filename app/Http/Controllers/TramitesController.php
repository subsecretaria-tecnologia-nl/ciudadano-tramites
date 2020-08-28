<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function index ($type) {
    	// set_global_arg("title", "TE YOYO MI REINA");
    	return layout_view("tramites", [ "type" => $type ]);
    }
}
