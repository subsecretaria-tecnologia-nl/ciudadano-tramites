<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index () {
		set_layout_arg([
			"subtitle" => "perfil",
			"fluid_container"=> true
		]);
		$user = session()->get("user");

		return layout_view("profile", ['user' => $user]);
    }
}
