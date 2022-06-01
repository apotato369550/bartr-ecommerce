<?php

// check email
// check repeat-email
// check password
// query database for shiz

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
	header("Location: ../user/verify-email-change.php?error=sqlerrorprep&selector=".$selector."&validator=".$validator);
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

$oldEmail = $_POST["old-email"];

$sql = "SELECT * FROM accounts WHERE email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-email-change.php?error=sqlerrorprep&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $oldEmail); 
	mysqli_stmt_execute($stmt);
}
	
$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/verify-email-change.php?error=accountnotfound&selector=".$selector."&validator=".$validator);
	exit();
}

$username = $row["username"];
$email = $row["email"];
$newEmail = $_POST["new-email"];

if($email != $oldEmail){
	header("Location: ../user/verify-email-change.php?error=wrongemail&selector=".$selector."&validator=".$validator);
	exit();
}

if($oldEmail == $newEmail or $email == $newEmail){
	header("Location: ../user/verify-email-change.php?error=sameemail&selector=".$selector."&validator=".$validator);
	exit();
}

$sql = "UPDATE accounts SET email=? WHERE email=? AND username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-email-change.php?error=sqlerrorprep&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "sss", $newEmail, $email, $username); 
	mysqli_stmt_execute($stmt);
}

$sql = "DELETE FROM email_change WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/verify-email-change.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
}

header("Location: ../index.php?change=success");
exit();

	