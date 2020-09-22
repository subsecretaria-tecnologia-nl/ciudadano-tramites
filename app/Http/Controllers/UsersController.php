<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index () {
		set_layout_arg([
			"subtitle" => "Usuarios",
			"fluid_container"=> true
		]);

		return layout_view("usuarios");
    }
}
