<?php

require "../includes/dbh.inc.php";

$username = $_SESSION["username"];
$profilePic = "../images/profile-pic.png";

$sql = "SELECT * FROM accounts WHERE username=?";
$stmt = mysqli_stmt_init($connection);


if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $image = $row["profile_picture"];
        if(!empty($image)){
            $profilePic = "../uploads/profile-pictures/".$image;
        }
    }
} 

?>