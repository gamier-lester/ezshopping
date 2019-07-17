<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	/*
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
		header("Location: ".ROOT_URL."/views/member/profile.php");
	} else {
		#
	}
	*/
	// print_r($_FILES["image-upload"]);

	// print_r($_POST);
	$media_link = sanitize_input($_POST['media_link']);
	$user_id = $_SESSION['user_credentials']['user_id'];

	$query = "SELECT id FROM ecom_user_media WHERE user_id = $user_id && type_id = 1 && status_id = 1";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while ($resultRow = $result->fetch_assoc()) {
			$result_id = $resultRow['id'];
		}
		$query = "UPDATE ecom_user_media SET status_id = 3 WHERE id = $result_id";
		if($conn->query($query) === TRUE) {
			$query = "INSERT INTO ecom_user_media (user_id, status_id, type_id, media_link) VALUES ($user_id, 1, 1, '$media_link')";
			if($conn->query($query) === TRUE) {
				$_SESSION['response_message']['message'] = 'Image is updated successfully';
				$_SESSION['response_message']['success'] = TRUE;
				header('Location: '.$_SERVER['HTTP_REFERER']);
			} else {
				$_SESSION['response_message']['message'] = 'Image update is unsuccessful';
				$_SESSION['response_message']['success'] = FALSE;
				header('Location: '.$_SERVER['HTTP_REFERER']);
			}
		} else {
			$_SESSION['error_message'] = 'Image update is unsuccessful';
			$_SESSION['response_message']['success'] = FALSE;
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	} else {
		$query = "INSERT INTO ecom_user_media (user_id, status_id, type_id, media_link) VALUES ($user_id, 1, 1, '$media_link')";
		if($conn->query($query) === TRUE) {
			$_SESSION['response_message']['message'] = 'Image is uploaded successfully';
			$_SESSION['response_message']['success'] = TRUE;
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			$_SESSION['response_message']['message'] = 'Image upload is unsuccessful';
			$_SESSION['response_message']['success'] = FALSE;
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}

?>