<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function index () {
		set_layout_arg([
			"subtitle" => "Inicia Sesión",
			"empty_layout" => true,
			"background_content" => "#ffffff",
			"script" => [
				asset("js/login.js")
			]
		]);
		return layout_view("login", []);
	}
}
