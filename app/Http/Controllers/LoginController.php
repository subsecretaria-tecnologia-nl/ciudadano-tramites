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
		$session = [
			"authenticated" => [
				"created_at" => date("Y-m-d H:i:s"),
				"until_at" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")." + ".env("SESSION_LIFETIME")." minutes"))
			],
			"user" => [
				"name" => "",
				"last_name" => "",
				"email" => "",
				"username" => "",
				"job" => ""
			]
		];

		if(session($session))
			response(200);
	}

	public function logout () {
		session()->forget(["user", "authenticated"]);
		return redirect("/login");
	}
}
