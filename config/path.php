<?php
	// $url_path = "/e-commerce";
	$url_path = "https://ez-shopping.herokuapp.com";
	define("ROOT_DIR", realpath(__DIR__."/.."));
	define("ROOT_URL", $url_path);
	
	function get_dir() {
		$dir = ROOT_DIR;
		return $dir;	
	}

	function get_url() {
		echo $url = ROOT_URL;
	}
?>