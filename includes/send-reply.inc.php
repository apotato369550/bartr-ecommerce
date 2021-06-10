<?php

if(!isset($_POST["submit"])){
    header("Location: ../index.php?error=unexpectederror");
    exit();
}

$recepient = $_POST["recepient"];
$sender = $_POST["sender"];
$subject = $_POST["subject"];
$replyTo = $_POST["reply-to"];
$message = $_POST["message"];
$date = date("U");

if(empty($message)){
    header("Location: ../index.php?error=emptyfields");
    exit();
}

require "dbh.inc.php";

$stmt = mysqli_stmt_init($connection);

$sql = "INSERT INTO message_replies (user_to, user_from, reply_to, subject, message, date) VALUES (?, ?, ?, ?, ?, ?)";

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorprep");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "ssissi", $recepient, $sender, $replyTo, $subject, $message, $date);
    mysqli_stmt_execute($stmt);
}

header("Location: ../index.php?reply=success");
exit();

// this works, now work on the display

