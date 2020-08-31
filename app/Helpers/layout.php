<?php
use Illuminate\Support\Facades\Cookie;

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
		// $session = Cookie::get("session");

		$globalArgs = Config::get("layout.args");
		if(!$templatePath) $templatePath = env("TEMPLATE_PATH");

		$uri = Route::getCurrentRoute()->uri;
		$parameters = Route::getCurrentRoute()->parameters;
		
		// if(!$session && $uri != "login") return redirect("/login");

		foreach($parameters as $key => $val){
			$uri = str_replace("{{$key}}", $val, $uri);
		}

		$layoutArgs = [
			"viewPath" => $viewPath,
			"args" => $args,
			"currentPath" => "/$uri"
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