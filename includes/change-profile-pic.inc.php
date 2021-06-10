<?php

if(!isset($_POST["submit"])){
	header("Location: ../index.php?view=profile&error=unexpectederror");
	exit();
}

$allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');

$imageName = $_FILES["image"]["name"];
$imageTempName = $_FILES["image"]["tmp_name"];
$imageSize = $_FILES["image"]["size"];
$imageError = $_FILES["image"]["error"];

$fileExtension = explode('.', $imageName);
$fileExtension = end($fileExtension);
$fileExtension = strtolower($fileExtension);

if(!in_array($fileExtension, $allowedExtensions)){
	header("Location: ../index.php?view=profile&listing=create&error=invalidfileextension&name=".$imageName);
	exit();
}

if($imageError !== 0){
	header("Location: ../index.php?view=profile&listing=create&error=imageuploaderror");
	exit();
}

if($imageSize > 500000){
	header("Location: ../index.php?view=profile&listing=create&error=filesizetoobig&image=".$imageName);
	exit();
}

$newFileName = uniqid("", true).".".$fileExtension;
$fileDestination = "../uploads/profile-pictures/".$newFileName;

if(!move_uploaded_file($imageTempName, $fileDestination)){
	header("Location: ../index.php?view=profile&error=cannotmovefile&tempname=".$imageTempName);
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$username = $_POST["username"];

$sql = "SELECT * FROM accounts WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?view=profile&error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute();
}

$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?view=profile&error=requestnotfound");
	exit();
}

$oldImageName = $row["profile_picture"];

if(!empty($oldImageName)){
	$oldImageName = "../uploads/profile-pictures/".$oldImageName;
	unlink($oldImageName);
}

$sql = "UPDATE accounts SET profile_picture=? WHERE username=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?view=profile&error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "ss", $newFileName, $username);
	mysqli_stmt_execute($stmt);
}

header("Location: ../index.php?view=profile&change=success&oldImageName=".$oldImageName."&newfilename=".$newFileName."&username=".$username);
exit();

// after checking if it's a valid image, query database for original file name, copy and replace existing profile pic, then go back to profile page