<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(!isset($_POST["submit"])){
	header("Location: ../user/signup.php?error=unexpectederror");
	exit();
}

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$repeatPassword = $_POST["repeat-password"];

if(empty($username) or empty($email) or empty($password) or empty($repeatPassword)){
	header("Location: ../user/signup.php?error=emptyfields");
	exit();
} 

if(!filter_var($email, FILTER_VALIDATE_EMAIL) ){
	header("Location: ../user/signup.php?error=invalidemail&username=".$username);
	exit();
} 

if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
	header("Location: ../user/signup.php?error=invalidusername&email=".$email);
	exit();
} 

if($password != $repeatPassword){
	header("Location: ../user/signup.php?error=passwordcheck&username=".$username."&email=".$email);
	exit();
}


require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT username FROM accounts WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/signup.php?error=sqlerrorprep1");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
}

$results = mysqli_stmt_num_rows($stmt);

if($results > 0){
	header("Location: ../user/signup.php?error=usernameinuse&email=".$email);
	exit();	
}

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$url = "http://localhost/Bartr/user/verify-account.php?selector=".$selector."&validator=".bin2hex($token);
$expiry = date("U") + 1800;
$passwordHash = password_hash($password, PASSWORD_DEFAULT);


$sql = "DELETE FROM account_verify WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/signup.php?error=sqlerrorprep2");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
}

$sql = "INSERT INTO account_verify (email, username, password, selector, token, expiry) VALUES (?, ?, ?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/signup.php?error=sqlerrorprep3");
	exit();
} else {
	$hashedToken = password_hash($token, PASSWORD_DEFAULT);
	mysqli_stmt_bind_param($stmt, "sssssi", $email, $username, $passwordHash, $selector, $hashedToken, $expiry);
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
	$mail->Subject = 'Account Verification Request';
	$mail->Body = '<p>We received a request to create an account. The link to do so is down below. If  you did not make this request, feel free to ignore this email.</p>';
	$mail->Body .= '<p>Here is your link. It expires in 30 minutes:</p>';
	$mail->Body .= '<a href="'.$url.'">Click Here.</a>';
	
	$mail->send();
	
	header("Location: ../index.php?signup=success");
	exit();
} catch (Exception $e) {
	header("Location: ../user/signup.php?error=mailererror");
	exit();
}

/*

List of errors:

unexpectederror
emptyfields
invalidemail
invalidusername
passwordcheck
usernameinuse
mailererror

*/
