<?php
if(!isset($_POST["submit"])){
	header("Location: ../index.php?error=unexpectederror");
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$user = $_POST["user"];
$password = $_POST["password"];

if(empty($user) or empty($password)){
	header("Location: ../index.php?error=emptyfields");
	exit();
}

$sql = "SELECT * FROM accounts WHERE username=? or email=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "ss", $user, $user);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?error=requestnotfound");
	exit();
}

$passwordCheck = password_verify($password, $row["password"]);

if(!$passwordCheck){
	header("Location: ../index.php?error=wrongpassword");
	exit();
}

session_start();
$_SESSION["id"] = $row["id"];
$_SESSION["username"] = $row["username"];

header("Location: ../index.php?login=success&userId=".$_SESSION["id"]);
exit();

/*

List of errors:

emptyfields
sqlerror
requestnotfound
wrongpassword

*/