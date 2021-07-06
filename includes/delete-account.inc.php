<?php

if(!isset($_POST["submit"])){
	header("Location: ../user/delete-account.php?error=unexpectederror");
	exit();
}

$selector = $_POST["selector"];
$validator = $_POST["validator"];
$currentDate = date("U");
$username = $_POST["username"];

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT * FROM account_delete WHERE selector=? AND expiry >= ?";

// fix sql preparation errors
if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep1&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "si", $selector, $currentDate); 
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/delete-account.php?error=requestnotfound&selector=".$selector."&validator=".$validator);
	exit();
}

$tokenBin = hex2bin($validator);
$tokenCheck = password_verify($tokenBin, $row["token"]);

if(!$tokenCheck){
	header("Location: ../user/delete-account.php?error=falsetoken&selector=".$selector."&validator=".$validator);
	exit();
}

$codeBin = hex2bin($row["verification_code"]);
$codeCheck = $_POST["code"];

if(!$codeCheck){
	header("Location: ../user/delete-account.php?error=incorrectcode&selector=".$selector."&validator=".$validator);
	exit();
}

$sql = "SELECT * FROM listings WHERE owner=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep2&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username); 
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result)){
	$image = $row["image"];
	
	if(!empty($image)){
		$profilePicture = "../uploads/products/".$oldImageName;
		unlink($profilePicture);
	}
}

$sql = "DELETE * FROM listings WHERE owner=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep2&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username); 
	mysqli_stmt_execute($stmt);
}

$sql = "SELECT * FROM accounts WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep3&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username); 
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../user/delete-account.php?error=requestnotfound&selector=".$selector."&validator=".$validator);
	exit();
}

$profilePicture = $row["profile_picture"];

if(!empty($profilePicture)){
	$profilePicture = "../uploads/profile-pictures/".$oldImageName;
	unlink($profilePicture);
}

$sql = "DELETE * FROM accounts WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep4&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username); 
	mysqli_stmt_execute($stmt);
}

$sql = "DELETE * FROM account_delete WHERE selector=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../user/delete-account.php?error=sqlerrorprep5&selector=".$selector."&validator=".$validator);
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $selector); 
	mysqli_stmt_execute($stmt);
}

require "logout.inc.php";
