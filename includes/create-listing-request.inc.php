<?php
// tfs wrong w/ this?
if(!isset($_POST["submit"])){
	header("Location: ../index.php?listing=create&error=unexpectederror");
	exit();
}

$title = $_POST["title"];
$description = $_POST["description"];
$keywords = explode(" ,", $_POST["keywords"]);

if(empty($title) or empty($description) or empty($keywords)){
	header("Location: ../index.php?listing=create&error=emptyfields");
	exit();
}

if(strlen($title) > 50){
	header("Location: ../index.php?listing=create&error=longtitle");
	exit();
}

if(strlen($description) > 500){
	header("Location: ../index.php?listing=create&error=longdescription");
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "SELECT * FROM listings WHERE title=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing=create&error=sqlerrorprep");
	exit();
}

mysqli_stmt_bind_param($stmt, "s", $title);

if(!mysqli_stmt_execute($stmt)){
	header("Location: ../index.php?listing=create&error=sqlerrorexe");
	exit();
}

$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?listing=create&error=titlealreadyinuse");
	exit();
}

$allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
$fileNames = array();
$numberOfFiles = 0;


foreach($_FILES["images"]["tmp_name"] as $key => $image){

	
	$imageName = $_FILES["images"]["name"][$key];
	$imageTempName = $_FILES["images"]["tmp_name"][$key];
	$imageSize = $_FILES["images"]["size"][$key];
	$imageError = $_FILES["images"]["error"][$key];

	$fileExtension = explode('.', $imageName);
	$fileExtension = end($fileExtension);
	$fileExtension = strtolower($fileExtension);
	
	if(!in_array($fileExtension, $allowedExtensions)){
		header("Location: ../index.php?listing=create&error=invalidfileextension&name=".$imageName);
		exit();
	}

	if($imageError !== 0){
		header("Location: ../index.php?listing=create&error=imageuploaderror");
		exit();
	}

	if($imageSize > 500000){
		header("Location: ../index.php?listing=create&error=filesizetoobig&image=".$imageName);
		exit();
	}
	
	$numberOfFiles++;
	if($numberOfFiles > 10){
		header("Location: ../index.php?listing=create&error=exceedmaxfiles");
		exit();
	}
	
	$newImageName = uniqid("", true).".".$fileExtension;
	
	array_push($fileNames, $newImageName);
	
	$destination = "../uploads/products/".$newImageName;
	move_uploaded_file($imageTempName, $destination);
}

$fileNames = implode(" ", $fileNames);
$keywords = implode(" ", $keywords);
$username = $_POST["username"];
$date = date("U");

// test if this will insert properly into the db
// afterwards, have catalogs display categories
// 
$category = $_POST["category"];

$sql = "INSERT INTO listings (title, category, date, description, image, owner, keywords) VALUES (?, ?, ?, ?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing-create&error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "ssissss", $title, $category, $date, $description, $fileNames, $username, $keywords);
	mysqli_stmt_execute($stmt);
}


header("Location: ../index.php?listing=create&creation=success");
exit();


/*
list of errors:

emptyfields
longdescription
longtitle
sqlerrorprep
sqlerrorexe
titlealreadyinuse
invalidfileextension
imageuploaderror
filesizetoobig
exceedmaxfiles

*/


// Send an email about the request to be approved by admin
// Request appears in the admin's email and in account
// But first, create profile and settings
