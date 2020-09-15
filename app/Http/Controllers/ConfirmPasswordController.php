<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmPasswordController extends Controller
{
    public function index () {
		set_layout_arg([
            "subtitle" => "Confirmar la contraseña nueva",
            "empty_layout" => true,
            "background_content" => "#ffffff",
            "script" => [
              asset("js/confirmpassword.js")
            ]
		]);

		return layout_view("confirmpassword");
    }
}
