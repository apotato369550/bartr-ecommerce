<?php
	
	
require "dbh.inc.php";

$title = $_POST["title"];
$id = $_POST["id"];

// test 2c
// continue

if(isset($_POST["delete"])){
	$stmt = mysqli_stmt_init($connection);

	$sql = "SELECT * FROM listings WHERE id=? AND title=?";
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "is", $id, $title);
		mysqli_execute($stmt);
	}
	
	$result = mysqli_stmt_get_result($stmt);
	
	if(!$row = mysqli_fetch_assoc($result)){
		header("Location: ../index.php?view=listings&error=requestnotfoundboop");
		exit();
	}

	$sql = "SELECT * FROM comments WHERE parent=?";

	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "i", $id);
		mysqli_execute($stmt);
	}
	
	// review the code below before moving on
	// this looks ok? test it??
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

	
	$sql = "DELETE FROM listings WHERE id=? AND title=?";
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "is", $id, $title);
		mysqli_execute($stmt);
	}

	header("Location: ../index.php?view=listings&deletion=success");
	exit();

	// this works
} else if(isset($_POST["edit"])){
	// fix this mf
	$sql = "SELECT * FROM listings WHERE id=? AND title=?";
	$stmt = mysqli_stmt_init($connection);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "is", $id, $title);
		mysqli_execute($stmt);
	}

	$result = mysqli_stmt_get_result($stmt);
	// test below stuff out

	// this get
	if(!$row = mysqli_fetch_assoc($result)){
		// this don't work??
		// check edit listing filfe
		// why is this getting hit??
		// ohhhhhhhh
		// it's interfering with this
		header("Location: ../index.php?view=listings&error=requestnotfoundlol");
		exit();
	} else {
		// test this... tomorrow
		// check edit listings php file
		// test it
		header("Location: ../index.php?listing=edit&title=".$title."&id=".$id);
		exit();
	}
	// test these things below
} else {
	header("Location: ../index.php?view=listings&title=".$title."&id=".$id."&lolnope");
	exit();
}
