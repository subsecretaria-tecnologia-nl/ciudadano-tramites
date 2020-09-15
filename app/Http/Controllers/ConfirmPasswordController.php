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
              asset("js/confirmpassword.js"),
              asset("https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js")
            ]
		]);

		return layout_view("confirmpassword");
    }
}
