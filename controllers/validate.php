<?php 

require_once("library.php");

// Initialize variables to null;
$firstnameErr = "";
$lastnameErr = "";
$firstname = $lastname = "";
$errors = 0;

// Validation
if(isset($_POST["submit"])) {
	if(empty($_POST["firstname"])) {
		$firstnameErr = "First Name is required";
		$errors++;
	} else {
		$firstname = sanitize_input($_POST["firstname"]);

		if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
			$firstnameErr = "Only letters and white space are allowed";
		}
	}

	if(empty($_POST["lastname"])) {
		$lastnameErr = "Last Name is required";
		$errors++;
	} else {
		$lastname = sanitize_input($_POST["lastname"]);

		if(!preg_match("/^[a-zA-Z]*$/", $lastname)) {
			$lastnameErr = "Only letters and white space are allowed";
		}
	}	
}