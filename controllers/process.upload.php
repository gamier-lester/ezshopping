<?php 
	session_start();

	require_once("../config/path.php");

	$fileName = $_FILES["image-upload"]["name"];
	$fileSize = $_FILES["image-upload"]["size"];
	$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	$fileTmpName = $_FILES["image-upload"]["tmp_name"];

	$isImage = false;

	if($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg" || $fileType == "gif" || $fileType == "ico") {
		$isImage = true;
		$fileName = "profile.";
		$fileName .= $fileType;
	}

	if ($fileSize > 0 && $isImage) {
		$oldpics = glob("../assets/images/profile.*");

		for ($i=0; $i < count($oldpics); $i++) { 
			unlink($oldpics[$i]);
		}

		$finalFilePath = "../assets/images/" . $fileName;
		move_uploaded_file($fileTmpName, $finalFilePath);
		$_SESSION["profile-pic"] = 1;
		// $_SESSION["filetype"]
		header("Location: ".ROOT_URL."/views/profile.php");
	} else {
		#
	}

	// print_r($_FILES["image-upload"]);
?>