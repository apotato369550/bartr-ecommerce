<?php

// i really need to work on this
// i really need to fix this lmao

if(!isset($_POST["submit"])){
    header("Location: ../index.php?view=listings&error=unexpectederror");
    exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$oldTitle = $_POST["old-title"];
$owner = $_POST["owner"];

$sql = "SELECT * FROM listings WHERE title=? AND owner=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?view=listings&error=sqlerrorprep");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "ss", $oldTitle, $owner);
    mysqli_stmt_execute($stmt);
}
	
$result = mysqli_stmt_get_result($stmt);

// this happens. why
if(!$row = mysqli_fetch_assoc($result)){
    header("Location: ../index.php?view=listings&error=requestnotfound&owner=".$owner."&title=".$oldTitle);
	exit();
}

// test this tomorrow
if(password_verify($_POST["user"], $owner)){
    header("Location: ../index.php?view=listings&error=usernotverified");
	exit();
}

$title = $_POST["new-title"];
$description = $_POST["description"];
$keywords = $_POST["keywords"];
$oldImages = explode(" ", $row["image"]);

if(empty($title) or empty($description) or empty($keywords)){
    header("Location: ../index.php?view=listings&error=emptyfields");
	exit();
}

if(strlen($title) > 50){
    header("Location: ../index.php?view=listings&error=longtitle");
	exit();
}

if(strlen($description) > 500){
    header("Location: ../index.php?view=listings&error=longdescription");
	exit();
}

$sql = "SELECT * FROM listings WHERE title=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?view=listings&error=sqlerrorprep");
	exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $title);
    mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result) && $title != $oldTitle){
    header("Location: ../index.php?view=listings&error=titlealreadyinuse");
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
		header("Location: ../index.php?view=listings&error=invalidextension");
		exit();
	}

	if($imageError !== 0){
		header("Location: ../index.php?view=listings&error=imageuploaderror");
		exit();
	}

	if($imageSize > 500000){
		header("Location: ../index.php?view=listings&error=filesizetoobig");
		exit();
	}
	
	$numberOfFiles++;
	if($numberOfFiles > 10){
		header("Location: ../index.php?view=listings&error=exceedmaxfiles");
		exit();
	}
	
	$newImageName = uniqid("", true).".".$fileExtension;
	
	array_push($fileNames, $newImageName);
	
	$destination = "../uploads/products/".$newImageName;
	move_uploaded_file($imageTempName, $destination);
}

foreach($oldImages as $image){
	$image = "../uploads/products/".$image;
	unlink($image);
}



$fileNames = implode(" ", $fileNames);
$currentTime = date("U");
$category = $_POST["category"];

$sql = "UPDATE listings SET title=?, category=?, description=?, image=?, keywords=?, last_updated=? WHERE title=? AND owner=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?view=listings&error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "sssssiss", $title, $category, $description, $fileNames, $keywords, $currentTime, $oldTitle, $owner);
	mysqli_stmt_execute($stmt);
}

header("Location: ../index.php?view=listings&change=success");
exit();



