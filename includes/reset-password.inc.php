<?php

if(!isset($_POST["submit"])){
	header("Location: ../user/create-new-password.php?error=unexpectederror");
	exit();
}
$selector = $_POST["selector"];
$validator = $_POST["validator"];
$password = $_POST["password"];
$repeatPassword = $_POST["repeat-password"];

if(empty($password) or empty($repeatPassword)){
	header("Location: ../user/create-new-password.php?error=emptyfields");
	exit();
} 

if($password !== $repeatPassword){
	header("Location: ../user/create-new-password.php?error=passwordcheck");
	exit();
}

$currentDate = date("U");

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT * FROM password_reset WHERE selector=? AND expiry >= ?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/create-new-password.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate); 
	mysqli_stmt_execute($stmt);
}
	
$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/create-new-password.php?error=requestnotfound&selector=".$selector);
	exit();
}

$tokenBin = hex2bin($validator);
$tokenCheck = password_verify($tokenBin, $row["token"]);

if(!$tokenCheck){
	header("Location: ../user/create-new-password.php?error=falsetoken");
	exit();
}

$email = $row["email"];

$sql = "SELECT * FROM accounts WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/create-new-password.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
}
	
$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/create-new-password.php?error=requestnotfound");
	exit();
} 

$sql = "UPDATE accounts SET password=? WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/create-new-password.php?error=sqlerrorprep");
	exit();
} else {
	$newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
	mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $email);
	mysqli_stmt_execute($stmt);
}
	
$sql = "DELETE FROM password_reset WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/create-new-password.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	header("Location: ../index.php?passwordchange=success");
}

/*

List of errors:

unexpectederror
emptyfields
passwordcheck
sqlerrorprep
requestnotfound
falsetoken


*/