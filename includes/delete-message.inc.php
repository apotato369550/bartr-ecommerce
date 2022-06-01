<?php
if(!isset($_POST["submit"])){
    header("Location: ../index.php?error=unexpectederror");
    exit();
}

$id = $_POST["id"];
$subject = $_POST["subject"];
$user = $_POST["user"];

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);
$sql = "SELECT * FROM messages WHERE id=? AND subject=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "is", $id, $subject); 
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?error=requestnotfound");
	exit();
}

$sender = $row["user_from"];
$receiver = $row["user_to"];
$value = "1";
// wtf was i high when naming this?
// add feature to outbox
// and test if it will really delete?
if($user == $sender){
	$stmt = mysqli_stmt_init($connection);
	$sql = "UPDATE messages SET sender_delete=? WHERE id=?"; 
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?error=sqlerrorprep2");
		exit();
	} else {
		if(!mysqli_stmt_bind_param($stmt, "si", $value, $id)){
			header("Location: ../index.php?error=sqlerrorbindparam");
			exit();
		}
		if(!mysqli_stmt_execute($stmt)){
			header("Location: ../index.php?error=sqlerrorexe");
			exit();
		}
	}
} else if($user == $receiver){
	// test this later
	$stmt = mysqli_stmt_init($connection);
	$sql = "UPDATE messages SET recepient_delete=? WHERE id=?";
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?error=sqlerrorprep3");
		exit();
	} else {
		if(!mysqli_stmt_bind_param($stmt, "si", $value, $id)){
			header("Location: ../index.php?error=sqlerrorbindparam");
			exit();
		}
		if(!mysqli_stmt_execute($stmt)){
			header("Location: ../index.php?error=sqlerrorexe");
			exit();
		}
	}
} else {
	header("Location: ../index.php?error=invalidrequest");
	exit();
}

$sql = "SELECT * FROM messages WHERE id=? AND subject=?";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "is", $id, $subject); 
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	header("Location: ../index.php?error=requestnotfound");
	exit();
}

$senderDelete = $row["sender_delete"];
$recepientDelete = $row["recepient_delete"];
// this works:DDDD
// add feature where it displays if it's deleted na or not
if($senderDelete == 1 && $recepientDelete == 1){
	$sql = "DELETE FROM message_replies WHERE reply_to=? AND subject=?";
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "is", $id, $subject); 
		mysqli_stmt_execute($stmt);
	}

	$sql = "DELETE FROM messages WHERE id=? AND subject=?";

	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../index.php?error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "is", $id, $subject); 
		mysqli_stmt_execute($stmt);
	}

}

// figure out why it ain't working
// how to update enums
header("Location: ../index.php?deletion=success&senderdelete=".$senderDelete."&user=".$user."&sender=".$sender."&value=".$value."&id=".$id);
exit();
// test this