<?php

if(!function_exists("set_layout_arg")){
	function set_layout_arg ($name, $value = null) {
		$args = [];
		if(!is_array($name)) $name = [$name];
		if(!is_array($value)) $value = [$value];
		foreach($name as $k => $v){
			$key = (!is_int($k)) ? $k : $v;
			$val = (!is_int($k)) ? $v : $value[$k];

			Config::set("layout.args.{$key}", $val);
		}
	}
}

if(!function_exists("layout_view")){
	function layout_view ($viewPath, $args = [], $templatePath = null) {
		$globalArgs = Config::get("layout.args");
		if(!$templatePath) $templatePath = env("TEMPLATE_PATH");

		$uri = Route::getCurrentRoute()->uri;
		$parameters = Route::getCurrentRoute()->parameters;

		foreach($parameters as $key => $val){
			$uri = str_replace("{{$key}}", $val, $uri);
		}

		$layoutArgs = [
			"viewPath" => $viewPath,
			"args" => $args,
			"currentPath" => "/$uri",
			"user" => session()->get("user")
		];
		$layoutArgs = array_merge($layoutArgs, $globalArgs);
		return view($templatePath, $layoutArgs);
	}
}

if(!function_exists("to_object")){
	function to_object ($arr){
		return json_decode(json_encode($arr));
	}
}

if(!function_exists("curlSendRequest")){
	function curlSendRequest ($method, $endpoint, $data = [], $headers = [], $timeout = null) {
		if(!$timeout) $timeout = env("WS_TIMEOUT");
		$req = curl_init();
		// $data = json_encode($data);
		curl_setopt($req, CURLOPT_URL, $endpoint);
		curl_setopt($req, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($req, CURLOPT_POSTFIELDS, $data);
		curl_setopt($req, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($req, CURLOPT_TIMEOUT, $timeout * 1000);
		$response = curl_exec($req);
		curl_close($req);
		return json_decode($response);
	}
}
