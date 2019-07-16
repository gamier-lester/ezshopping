<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

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

	$query = "INSERT INTO ecom_message_details (status_id, sender_id, receiver_id) VALUES (2,$sender_id,$receiver_id)";

	if ($conn->query($query) === TRUE) {
		$last_id = $conn->insert_id;
		$query = "INSERT INTO ecom_message_content (message_id, message_content) VALUES ($last_id,'$message_content')";
		if ($conn->query($query) === TRUE) {
			$_SESSION['success_message'] = 'Message Sent!';
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			$_SESSION['error_message'] = $conn->error;
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
	} else {
		$_SESSION['error_message'] = $conn->error;
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	// ez.shopping.corp
	// Send email notification to customer
// ==============================================================================
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

$mail = new PHPMailer(true); 
// Passing `true` enables exceptions


$staff_email = 'ez.shopping.corp@gmail.com';
// $customer_email = $_SESSION['current_user']['email'];          //
$customer_email = 'gamier.lester@gmail.com';
$subject = 'EZShopping - TestMessage';
$body = '<div><h1>THIS IS A TEST MESSAGE</h1></div>';
try {
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
  $mail->addAddress($customer_email);  // Name is optional

  //Content
  $mail->isHTML(true);  // Set email format to HTML
  $mail->Subject = $subject;
  $mail->Body = $body;

  // Route user to confirmation page
  // $_SESSION['new_txn_number'] = $transaction_number;
  // header('location: ../views/confirmation.php');

  $mail->send();
  // echo 'Message has been sent';

} catch (Exception $e) {
  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


?>