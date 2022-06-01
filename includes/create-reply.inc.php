<?php

if(isset($_POST["submit"])){
    header("Location: ../index.php?error=unexpectederror");
    exit();
}
// get all post method inputs from reply box

// for redirect
// don't forget "listing=view"
$id = $_POST["id"];
$title = $_POST["title"];

$owner = $_POST["username"];
$commentId = $_POST["comment-id"];
$title = $_POST["title"];

$reply = $_POST["reply"];
$date = date("U");

// continue the rest of the scripting here:)

if(empty($reply)){
    header("Location: ../index.php?listing=view&id=".$id."&title=".$title."&comment-id=".$commentId."&error=emptyfields");
    exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "INSERT INTO replies (parent, owner, text, date) VALUES (?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorprep");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "issi", $commentId, $owner, $reply, $date);
    mysqli_stmt_execute($stmt);
}

header("Location: ../index.php?listing=view&id=".$id."&title=".$title."&comment-id=".$commentId."&reply=success");
exit();
// eyy this works:D
// I should get rid of the anchor system
// you probably should ^^