<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListadoController extends Controller
{
    public function index () {
		set_layout_arg([
			"subtitle" => "Listado",
			"fluid_container"=> true
		]);

		return layout_view("listado");
    }
}