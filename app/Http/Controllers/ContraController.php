<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContraController extends Controller
{
    public function index () {
		set_layout_arg([
            "empty_layout" => true,
			"background_content" => "#ffffff",
            "subtitle" => "Olvidaste tu contraseña"
		]);

		return layout_view("contra");
    }
}
