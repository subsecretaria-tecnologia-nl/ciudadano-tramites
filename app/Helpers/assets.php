<?php
if(!function_exists("assets")){
	function assets ( $path ) {
		if(preg_match( '/https?:\/\//', $path ) > 0)
			return $path;

		if(!file_exists($path))
			return $path;

		$date = filemtime ( $path );
		if(!preg_match( '/\?/', $path ))
			$path .= "?d=$date";
		return asset( $path );
	}
}