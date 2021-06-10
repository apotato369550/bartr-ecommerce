<?php


if(!isset($_POST["submit"])){
    header("Location: ../index.php?error=unexpectederror");
    exit();
}

// forgot to get the parent listing
$parent = $_POST["id"];
$username = $_POST["username"];
$title = $_POST["title"];
$comment = $_POST["comment"];
$date = date("U");

if(empty($comment)){
    header("Location: ../index.php?listing=view&id=".$parent."&title=".$title."&error=emptyfields");
    exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "INSERT INTO comments (parent, owner, text, date) VALUES (?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorprep");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "issi", $parent, $username, $comment, $date);
    mysqli_stmt_execute($stmt);
}

// redirect to product page
// afterwards, make it so that when you delete a listing, all the comment's listings and replies go as well
// display comments
// make reply feature

// make page system for shop

// fix this
header("Location: ../index.php?listing=view&id=".$parent."&title=".$title."&comment=success");
exit();