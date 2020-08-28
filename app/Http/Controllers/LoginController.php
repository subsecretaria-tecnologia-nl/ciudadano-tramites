<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

	public function validation (Request $request) {
		return response(true)->cookie(
			'session', true, env("SESSION_LIFETIME")
		);
	}

	public function logout () {
		$cookie = Cookie::forget('session');
		return redirect("/login")->withCookie($cookie);
	}
}
