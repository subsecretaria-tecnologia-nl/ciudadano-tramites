<?php

$globalArgs = [];

if(!function_exists("set_global_arg")){
	function set_global_arg ($name, $value) {
		global $globalArgs;
		$globalArgs[$name] = $value;
	}
}

if(!function_exists("layout_view")){
	function layout_view ($viewPath, $args) {
		global $globalArgs;
		$templatePath = env("TEMPLATE_PATH");
		if(!$globalArgs["title"]) $globalArgs["title"] = env("APP_NAME") ?? "Gobierno del Estado de Nuevo León";

		$uri = Route::getCurrentRoute()->uri;
		$parameters = Route::getCurrentRoute()->parameters;

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