<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
	
if(!isset($_POST["submit"])){
	header("Location: ../user/email-change-request.php?error=unexpectederror");
	exit();
}

$username = $_POST["username"];

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "DELETE FROM email_change WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/email-change-request.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
}

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$code = sprintf("%06d", mt_rand(1, 999999));
$expiry = date("U") + 1800;

$sql = "SELECT * FROM accounts WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/email-change-request.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/email-change-request.php?error=requestnotfound");
	exit();
}

$sql = "INSERT INTO email_change (username, verification_code, selector, token, expiry) VALUES (?, ?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/email-change-request.php?error=sqlerrorprep");
	exit();
} else {
	$hashedToken = password_hash($token, PASSWORD_DEFAULT);
	$hashedCode = password_hash($code, PASSWORD_DEFAULT);
	
	mysqli_stmt_bind_param($stmt, "ssssi", $username, $hashedCode, $selector, $hashedToken, $expiry);
	mysqli_stmt_execute($stmt);
}

$email = $row["email"];

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
	$mail->Subject = 'Email Change Request';
	$mail->Body = '<p>We received a request change your email. The verification code is down below. Be sure to type it before it expires in 30 minutes. If  you did not make this request, feel free to ignore this email.</p>';
	$mail->Body .= '<p>Here is your 6 digit verification code which expires in 30 minutes:</p>';
	// try and make text unselectable
	$mail->Body .= '<h2>'.$code.'</h2>';
	
	$mail->send();

	header("Location: ../user/verify-email-change.php?selector=".$selector."&validator=".bin2hex($token));
	exit();
} catch (Exception $e) {
	echo $e;
	header("Location: ../user/email-change-request.php?error=mailererror");
}

//

/*

List of errors:

unexpectederror
emptyfields
sqlerrorprep
mailererror

*/