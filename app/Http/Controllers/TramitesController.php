<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function index ($type) {
    	set_layout_arg("subtitle", "Trámites: {$type}");
    	return layout_view("tramites.index", [ "type" => $type ]);
    }

    public function new () {
    	set_layout_arg("subtitle", "Nuevo Trámite");
    	return layout_view("tramites.new");
    }
}
