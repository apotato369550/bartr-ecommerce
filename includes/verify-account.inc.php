<?php
if(!isset($_POST["submit"])){
	header("Location: ../user/verify-account.php?error=unexpectederror");
	exit();
} 

$selector = $_POST["selector"];
$validator = $_POST["validator"];

$currentDate = date("U");

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT * FROM account_verify WHERE selector=? AND expiry >= ?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-account.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/verify-account.php?error=requestnotfound");
	exit();
}

$tokenBin = hex2bin($validator);
$tokenCheck = password_verify($tokenBin, $row["token"]);

if(!$tokenCheck){
	header("Location: ../user/verify-account.php?&error=falsetoken");
	exit();
}

$email = $row["email"];
$username = $row["username"];
$passwordHash = $row["password"];

$sql = "INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-account.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
	mysqli_stmt_execute($stmt);
}


$sql = "DELETE FROM account_verify WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-account.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
}

header("Location: ../user/signup.php?signup=success");

/*

List of errors:

unexpectederror
sqlerrorprep
requestnotfound
falsetoken

*/
