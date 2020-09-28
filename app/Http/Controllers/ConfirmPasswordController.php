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

    $url = "https://session-api-stage.herokuapp.com" . "$_SERVER[REQUEST_URI]";
    $email = $_GET["e"];
    $actual_link = str_replace('?e=', '?email=', $url );
    $ch = curl_init($actual_link);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    if (curl_errno($ch)) { 
      print curl_error($ch); 
   }
    $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);
    $result =  json_decode( $result ) ;
   $valid_token = ($result->data == 'response' ) ? true : false;
    
    return layout_view("confirmpassword", ["valid_token"=> $valid_token ]);
    }
}
