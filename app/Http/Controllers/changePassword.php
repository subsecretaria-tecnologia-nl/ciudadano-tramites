<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class changePassword extends Controller
{
    public function index () {
		set_layout_arg([
			"subtitle" => "cambiar contraseña",
			"fluid_container"=> true
		]);

		return layout_view("changepassword");
    }
}
