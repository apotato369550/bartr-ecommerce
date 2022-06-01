<?php
	// do stuff here
require "dbh.inc.php";

$title = $_POST["title"];
$owner = $_POST["owner"];
$id = $_POST["id"];

if(isset($_POST["delete"])){
	// work on this
	$stmt = mysqli_stmt_init($connection);
	
	$sql = "SELECT * FROM listings WHERE id=? AND title=? AND owner=?";
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "iss", $id, $title, $owner);
		mysqli_execute($stmt);
	}
	
	$result = mysqli_stmt_get_result($stmt);
	
	if(!$row = mysqli_fetch_assoc($result)){
		header("Location: ../index.php?view=listings&error=requestnotfound&title=".$title."&owner=".$owner);
		exit();
	}
	
	// refactor and then test
	// you only needed one $stmt who knew??

	// execute these four
	// then test it out
	$sql = "SELECT * FROM comments WHERE parent=?";

	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "i", $id);
		mysqli_execute($stmt);
	}

	$result = mysqli_stmt_get_result($stmt);

	while($row = mysqli_fetch_assoc($result)){
		$parent = $row["id"];

		$sql = "DELETE FROM replies WHERE parent=?";

		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../index.php?view=listings&error=sqlerrorprep");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "i", $parent);
			mysqli_execute($stmt);
		}
	}

	$sql = "DELETE FROM comments WHERE parent=?";

	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "i", $id);
		mysqli_execute($stmt);
	}

	$sql = "DELETE FROM listings WHERE id=? AND title=? AND owner=?";
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "iss", $id, $title, $owner);
		mysqli_execute($stmt);
	}

	header("Location: ../index.php?view=listings&deletion=success");
	exit();


} else if(isset($_POST["edit"])){
	// edit this as well to include categories
	$sql = "SELECT * FROM listings WHERE id=? AND title=? AND owner=?";
	$stmt = mysqli_stmt_init($connection);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "iss", $id, $title, $owner);
		mysqli_execute($stmt);
	}
	
	$result = mysqli_stmt_get_result($stmt);
	
	if(!$row = mysqli_fetch_assoc($result)){
		header("Location: ../index.php?view=listings&error=requestnotfound&title=".$title."&owner=".$owner);
		exit();
	} else {
		header("Location: ../index.php?listing=edit&title=".$title."&owner=".$owner);
		exit();
	}
} 
	