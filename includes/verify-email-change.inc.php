<?php

if(!isset($_POST["submit"])){
	header("Location: ../user/verify-email-change.php?error=unexpectederror&selector=".$selector."&validator=".$validator);
	exit();
}

$selector = $_POST["selector"];
$validator = $_POST["validator"];
$currentDate = date("U");

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT * FROM email_change WHERE selector=? AND expiry >= ?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/create-new-password.php?error=sqlerrorprep&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate); 
	mysqli_stmt_execute($stmt);
}
	
$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/verify-email-change.php?error=requestnotfound&selector=".$selector."&validator=".$validator);
	exit();
}

$tokenBin = hex2bin($validator);
$tokenCheck = password_verify($tokenBin, $row["token"]);

if(!$tokenCheck){
	header("Location: ../user/verify-email-change.php?error=falsetoken&selector=".$selector."&validator=".$validator);
	exit();
}

$codeBin = hex2bin($row["verification_code"]);
$codeCheck = $_POST["code"];

if(!$codeCheck){
	header("Location: ../user/verify-email-change.php?error=incorrectcode&selector=".$selector."&validator=".$validator);
	exit();
}

header("Location: ../user/change-email.php?selector=".$selector."&validator=".$validator);
exit();

// redirect to email change php site
// change email there
// tell them to also add current password_verify
// redirect to home page/home account


/*

List of errors:

unexpectederror
sqlerrorprep
mailererror
requestnotfound
falsetoken
incorrectcode


*/