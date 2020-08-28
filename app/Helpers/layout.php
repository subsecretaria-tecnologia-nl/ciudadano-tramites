<?php

if(!function_exists("set_layout_arg")){
	function set_layout_arg ($name, $value) {
		Config::set("layout.args.{$name}", $value);
	}
}

if(!function_exists("layout_view")){
	function layout_view ($viewPath, $args) {
		$globalArgs = Config::get("layout.args");
		$templatePath = env("TEMPLATE_PATH");

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