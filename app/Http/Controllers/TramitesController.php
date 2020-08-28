<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function index ($type) {
    	set_layout_arg("subtitle", "Trámites: {$type}");
    	return layout_view("tramites", [ "type" => $type ]);
    }
}
