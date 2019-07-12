<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	session_destroy();

	header("Location: ".ROOT_URL."/views/login.php");
?>