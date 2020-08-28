<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisosController extends Controller
{
    public function index () {
    	// set_global_arg("title", "TE YOYO MI REINA");
    	return layout_view("avisos", [ "hello" => "world" ]);
    }
}
