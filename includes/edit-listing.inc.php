<?php

// fix this
// we might have to end up re-writing this shit lmao
// copy logic from create listing template tho
// get rid of old title logic

// test it now
// still requestnotfound... check html
// check manage listings button??
// check it next week


// get rid of comments??
// are we using the right file?


// comment everything out and only include a redirect.

// this might be the culpritVV
// fix this and then test it out tomorrow
// i might have to re-do this

// i am re-doing this portion

/*
if(!isset($_POST["submit"])){
	 // drinking coffee wil solve it
	header("Location: ../index.php?view=listings&error=unexpectederroroof");
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$title = $_POST["title"];
$description = $_POST["description"];
$keywords = explode(" ,", $_POST["keywords"]);

if(empty($title) or empty($description) or empty($keywords)){
	header("Location: ../index.php?listing=edit&error=emptyfields");
	exit();
}

if(strlen($title) > 50){
	header("Location: ../index.php?listing=edit&error=longtitle");
	exit();
}

if(strlen($description) > 500){
	header("Location: ../index.php?listing=edit&error=longdescription");
	exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);
$sql = "SELECT * FROM listings WHERE title=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing=edit&error=sqlerrorprep");
	exit();
}

mysqli_stmt_bind_param($stmt, "s", $title);

if(!mysqli_stmt_execute($stmt)){
	header("Location: ../index.php?listing=edit&error=sqlerrorexe");
	exit();
}

$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?listing=edit&error=titlealreadyinuse");
	exit();
}

$allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
$fileNames = array();
$numberOfFiles = 0;

// check if below works
foreach($_FILES["images"]["tmp_name"] as $key => $image){

	
	$imageName = $_FILES["images"]["name"][$key];
	$imageTempName = $_FILES["images"]["tmp_name"][$key];
	$imageSize = $_FILES["images"]["size"][$key];
	$imageError = $_FILES["images"]["error"][$key];

	$fileExtension = explode('.', $imageName);
	$fileExtension = end($fileExtension);
	$fileExtension = strtolower($fileExtension);
	
	if(!in_array($fileExtension, $allowedExtensions)){
		header("Location: ../index.php?listing=edit&error=invalidfileextension&name=".$imageName);
		exit();
	}

	if($imageError !== 0){
		header("Location: ../index.php?listing=edit&error=imageuploaderror");
		exit();
	}

	if($imageSize > 500000){
		header("Location: ../index.php?listing=edit&error=filesizetoobig&image=".$imageName);
		exit();
	}
	
	$numberOfFiles++;
	if($numberOfFiles > 10){
		header("Location: ../index.php?listing=edit&error=exceedmaxfiles");
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
$category = $_POST["category"];
$id = $_POST["id"];

// how do make an update query?
// we never got the id of the listing:(
$sql = "UPDATE listings SET (title, category, description, image, owner, keywords, last_updated), (?, ?, ?, ?, ?, ?, ?, ?) WHERE id=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing=edit&error=sqlerrorprep");
	exit();
}

mysqli_stmt_bind_param($stmt, "ssssssii", $title, $category, $description, $fileNames, $keywords, $id);

if(!mysqli_stmt_execute($stmt)){
	header("Location: ../index.php?listing=edit&error=sqlerrorexe");
	exit();
}

// test this tomorrow
// there are a lot of problems here
// it redirects you to the create field instead of the edit field
// change edit button
header("Location: ../index.php?listing=edit&edit=success");
exit();
*/

// start hereVVV

if(!isset($_POST["submit"])){
	// test this
	header("Location: ../index.php?bruh");
	exit();
} 

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$title = $_POST["title"];
$description = $_POST["description"];
$keywords = explode(" ,", $_POST["keywords"]);

if(empty($title) or empty($description) or empty($keywords)){
	header("Location: ../index.php?listing=edit&error=emptyfields");
	exit();
}

if(strlen($title) > 50){
	header("Location: ../index.php?listing=edit&error=longtitle");
	exit();
}

if(strlen($description) > 500){
	header("Location: ../index.php?listing=edit&error=longdescription");
	exit();
}

$sql = "SELECT * FROM listings WHERE title=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing=edit&error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $title);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?listing=edit&error=titlealreadyinuse");
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
		header("Location: ../index.php?listing=edit&error=invalidfileextension&name=".$imageName);
		exit();
	}

	if($imageError !== 0){
		header("Location: ../index.php?listing=edit&error=imageuploaderror");
		exit();
	}

	if($imageSize > 500000){
		header("Location: ../index.php?listing=edit&error=filesizetoobig&image=".$imageName);
		exit();
	}
	
	$numberOfFiles++;
	if($numberOfFiles > 10){
		header("Location: ../index.php?listing=edit&error=exceedmaxfiles");
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
$category = $_POST["category"];
$id = $_POST["id"];

$sql = "UPDATE listings SET (title, category, description, image, owner, keywords, last_updated), (?, ?, ?, ?, ?, ?, ?, ?) WHERE id=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: ../index.php?listing=edit&error=sqlerrorprep");
	exit();
}

mysqli_stmt_bind_param($stmt, "ssssssii", $title, $category, $description, $fileNames, $keywords, $id);

if(!mysqli_stmt_execute($stmt)){
	header("Location: ../index.php?listing=edit&error=sqlerrorexe");
	exit();
}

// test this tomorrow
// there are a lot of problems here
// it redirects you to the create field instead of the edit field
// change edit button
header("Location: ../index.php?listing=edit&edit=success");
exit();

// work on the uploading of files

// update shiz here

// image processing


// got rid of old titile
// move o
// continue here, but remove ol title condition


// find requestnotfound???
// test this out tomorrow?



