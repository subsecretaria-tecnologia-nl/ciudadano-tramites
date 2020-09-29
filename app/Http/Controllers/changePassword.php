<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class changePassword extends Controller
{
    public function index () {
		set_layout_arg([
			"subtitle" => "cambiar contraseña",
			"fluid_container"=> true,
			"script" => [
				asset("js/changepassowd.js"),
				asset("https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js")
			]
		]);
	$me = session()->get("user");
	$user = curlSendRequest("GET",   "https://session-api-stage.herokuapp.com/users/me", [], [ "Authorization: Bearer { $me }" ]);
	// $user = curlSendRequest("GET",  env("SESSION_HOSTNAME") . "/users/me", [], [ "Authorization: Bearer {$login->response->token}" ]);
	if($user->data == "response"){
		$session = [
			"authenticated" => [
				"created_at" => date("Y-m-d H:i:s"),
				"until_at" => $login->response->expires_in
			],
			"session" => $login->response,
			"user" => $user->response->user
		];
	}else{
		return abort(401);
	}

	$body = [ "token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zZXNzaW9uLWFwaS1zdGFnZS5oZXJva3VhcHAuY29tXC9sb2dpbiIsImlhdCI6MTYwMDIwMDk2MSwiZXhwIjoxNjAyNzkyOTYxLCJuYmYiOjE2MDAyMDA5NjEsImp0aSI6ImZCMHBYMDVqempMZTFFMVkiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.WF2eMAmTDyivSw21G2e65va5yIPOWtW2bhGETJELvEo" ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $body);
    $result = curl_exec($ch);
	if (curl_errno($ch)) { 
      print curl_error($ch); 
   	}
    $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);
	$result =  json_decode( $result ) ;
	$valid_token = ($result->data == 'response' ) ? true : false;
	return layout_view("changepassword");
	}
}
