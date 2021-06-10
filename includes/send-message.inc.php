<?php

if(!isset($_POST["submit"])){
    header("Location: ../index.php?error=unexpectederror");
    exit();
}

$owner = $_POST["owner"];
$productId = $_POST["product-id"];
$productTitle = $_POST["product-title"];
$username = $_POST["username"];

$message = $_POST["message"];

$date = date("U");

if(empty($message)){
    header("Location: ../index.php?id=".$productId."&title=".$productTitle."&error=emptyfields");
    exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "INSERT INTO messages (user_to, user_from, subject, message, date) VALUES (?, ?, ?, ?, ?)";


if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?id=".$productId."&title=".$productTitle."&error=sqlerrorprep");
    exit();
} else {
    // this works
    mysqli_stmt_bind_param($stmt, "ssssi", $owner, $username, $productTitle, $message, $date);
    mysqli_stmt_execute($stmt);
}


header("Location: ../index.php?id=".$productId."&title=".$productTitle."&message=success");
exit();

// test this out later


// continue here

// work on this
// get post information,
// if empty, redirect and display error message
// insert values into database

// if done right, go to product view page and display done message

// this did not fucking work why(????)
