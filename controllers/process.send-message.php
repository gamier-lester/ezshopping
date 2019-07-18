<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require '../vendor/autoload.php';

	if (
			!isset($_POST['receiver_id']) ||
			!isset($_POST['sender_id']) ||
			!isset($_POST['message_content'])
			) {
		$_SESSION['error_message'] = 'invalid parameters';
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	// sanitize data
	$receiver_id = sanitize_input($_POST['receiver_id']);
	$sender_id = sanitize_input($_POST['sender_id']);
	$message_content = sanitize_input($_POST['message_content']);

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	$query = "SELECT user_email FROM ecom_user_details WHERE user_id = $receiver_id";
	$result = $conn->query($query);

	$row = $result->fetch_array(MYSQLI_ASSOC);
	$receiver_email = $row['user_email'];

	$query = "SELECT user_email FROM ecom_user_details WHERE user_id = $sender_id";
	$result = $conn->query($query);

	$row = $result->fetch_array(MYSQLI_ASSOC);
	$sender_email = $row['user_email'];

	$query = "INSERT INTO ecom_message_details (status_id, sender_id, receiver_id) VALUES (2,$sender_id,$receiver_id)";

	if ($conn->query($query) === TRUE) {
		$last_id = $conn->insert_id;
		$query = "INSERT INTO ecom_message_content (message_id, message_content) VALUES ($last_id,'$message_content')";
		if ($conn->query($query) === TRUE) {
			$_SESSION['response_message']['message'] = 'Message Sent!';
			$_SESSION['response_message']['success'] = TRUE;
			try {
				$staff_email = 'ez.shopping.corp@gmail.com';
				$mail = new PHPMailer(true); 
				$subject = 'EZShopping - New Message!';
				$body = "
					<div style='width: 500px;'>
						<h1>You have received a new Message!</h1>
						<p style='text-align: justify; color: #4e4141;'>$message_content</p>
						<i style='display: block; float: right;'>Sent by @$sender_email</i>
					</div>
				";
			  //Server settings
			  $mail->SMTPDebug = 4;                                 // Enable verbose debug output
			  $mail->isSMTP();                                      // Set mailer to use SMTP
			  $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
			  $mail->SMTPAuth = true;                               // Enable SMTP authentication
			  $mail->Username = $staff_email;                       // SMTP username
			  $mail->Password = 'foreverinlov3';                     // SMTP password
			  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			  $mail->Port = 587;                                    // TCP port to connect to

			  //Recipients
			  $mail->setFrom($staff_email, 'EZShopping');
			  $mail->addAddress($receiver_email);  // Name is optional

			  //Content
			  $mail->isHTML(true);  // Set email format to HTML
			  $mail->Subject = $subject;
			  $mail->Body = $body;

			  // Route user to confirmation page
			  // $_SESSION['new_txn_number'] = $transaction_number;
			  // header('location: ../views/confirmation.php');

			  $mail->send();
			  // echo 'Message has been sent';
			  // print_r($_SERVER['HTTP_REFERER']);

			} catch (Exception $e) {
			  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			  echo "<script>window.location.assign('".$_SERVER['HTTP_REFERER']."')</script>";
			}
		  // header('Location: '.ROOT_URL."/views/modals/messaging.php?messageto=$receiver_id");
		  echo "<script>window.location.assign('".$_SERVER['HTTP_REFERER']."')</script>";
		} else {
			$_SESSION['response_message']['message'] = $conn->error;
			$_SESSION['response_message']['success'] = FALSE;
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
	} else {
		$_SESSION['response_message']['message'] = $conn->error;
		$_SESSION['response_message']['success'] = FALSE;
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

?>