<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisosController extends Controller
{
    public function index () {
    	set_layout_arg([
    		"subtitle" => "Avisos",
    		"footer.style" => "large"
    	]);
    	return layout_view("avisos");
    }
}
