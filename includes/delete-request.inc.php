<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
	

if(!isset($_POST["submit"])){
	header("Location: ../user/delete-request.php?error=unexpectederror");
	exit();
}

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$code = sprintf("%06d", mt_rand(1, 999999));

$url = "http://localhost/Bartr/user/delete-account.php?selector=".$selector."&validator=".bin2hex($token);

$expiry = date("U") + 1800;

$email = $_POST["email"];

if(empty($email)){
	header("Location: ../user/delete-request.php?error=emptyfields");
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "DELETE FROM account_delete WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-request.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
}

// dis bitch does not insert

$sql = "INSERT INTO account_delete (email, selector, token, verification_code, expiry) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-request.php?error=sqlerrorprep");
	exit();
} else {
	$hashedToken = password_hash($token, PASSWORD_DEFAULT);
	$hashedCode = password_hash($code, PASSWORD_DEFAULT);
	
	// it was because i lacked an additional "s"
	mysqli_stmt_bind_param($stmt, "ssssi", $email, $selector, $hashedToken, $hashedCode, $expiry);
	mysqli_stmt_execute($stmt);
}

require "../vendor/autoload.php";

try{
	$mail = new PHPMailer(true);
	
	$mail->SMTPDebug = 2;                    
	$mail->isSMTP();                                          
	$mail->Host = 'smtp.mail.yahoo.com';                  
	$mail->SMTPAuth = true;                                
	$mail->Username = 'it.website@yahoo.com';               
	$mail->Password = 'haweztpfjwtylkuu';                              
	$mail->SMTPSecure = "ssl";       
	$mail->Port = 465;      
	
	$mail->SMTPOptions = array(
	'ssl' => array(
	'verify_peer' => false,
	'verify_peer_name' => false,
	'allow_self_signed' => true
	)
	);
		   
	$mail->setFrom('it.website@yahoo.com', 'no-reply');
	$mail->addAddress($email);
	
	$mail->isHTML(True);
	$mail->Subject = 'Account Deletion Request';
	$mail->Body = '<p>We received a request to delete your account. The link to do so is down below. If  you did not make this request, feel free to ignore this email.</p>';
	$mail->Body .= '<p>Here is your link. It expires in 30 minutes:</p>';
	$mail->Body .= '<a href="'.$url.'">Click Here.</a>';
	$mail->Body .= '<p>Here is your verification code:</p>';
	$mail->Body .= '<h2>'.$code.'</h2>';
	
	$mail->send();
	
	header("Location: ../index.php?request=success");
	exit();
} catch (Exception $e) {
	header("Location: ../user/signup.php?error=mailererror");
	exit();
}

// test this shit
