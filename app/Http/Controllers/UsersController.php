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
		$user = session()->get("user");
		if(isset( session()->get('user')->notary->id ) ){
			$notary =  session()->get('user')->notary->id;
		}else{
			$notary = null;
		}

		// dd($user);
		return layout_view("usuarios", ['notary' => $notary, "user" => $user]);
    }
}
