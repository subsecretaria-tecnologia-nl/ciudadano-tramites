<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function index () {
		set_layout_arg([
            "subtitle" => "Olvidaste tu contraseña",
            "empty_layout" => true,
            "background_content" => "#ffffff"
		]);

		return layout_view("recovery");
    }
}
