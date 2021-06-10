<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
	
if(!isset($_POST["submit"])){
	header("Location: ../user/reset-pasword.php?error=unexpectederror");
	exit();
}

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = "http://localhost/Bartr/user/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

$expiry = date("U") + 1800;

$email = $_POST["email"];

if(empty($email)){
	header("Location: ../user/reset-pasword.php?error=emptyfields");
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "DELETE FROM password_reset WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/reset-pasword.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
}

$sql = "INSERT INTO password_reset (email, selector, token, expiry) VALUES (?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/reset-pasword.php?error=sqlerrorprep");
	exit();
} else {
	$hashedToken = password_hash($token, PASSWORD_DEFAULT);
	
	mysqli_stmt_bind_param($stmt, "sssi", $email, $selector, $hashedToken, $expiry);
	mysqli_stmt_execute($stmt);
}

require "../vendor/autoload.php";

try{
	$mail = new PHPMailer(true);
	
	$mail->SMTPDebug = 2;                    
	$mail->isSMTP();                                          
	$mail->Host = 'smtp.gmail.com';                  
	$mail->SMTPAuth = true;                                
	$mail->Username = 'itwebsite000@gmail.com';               
	$mail->Password = 'Andre510';                              
	$mail->SMTPSecure = "tls";       
	$mail->Port = 587;      
	
	$mail->SMTPOptions = array(
	'ssl' => array(
	'verify_peer' => false,
	'verify_peer_name' => false,
	'allow_self_signed' => true
	)
	);
		   
	$mail->setFrom('itwebsite000@gmail.com', 'no-reply');
	$mail->addAddress($email);
	
	$mail->isHTML(True);
	$mail->Subject = 'Password Reset Request';
	$mail->Body = '<p>We received a request to reset your password. The link to do so is down below. If  you did not make this request, feel free to ignore this email.</p>';
	$mail->Body .= '<p>Here is your link. It expires in 30 minutes:</p>';
	$mail->Body .= '<a href="'.$url.'">Click Here.</a>';
	
	$mail->send();
	
	header("Location: ../index.php?reset=success");
	exit();
} catch (Exception $e) {
	header("Location: ../user/signup.php?error=mailererror");
	exit();
}

/*

List of errors:

unexpectederror
emptyfields
sqlerrorprep
mailererror

*/