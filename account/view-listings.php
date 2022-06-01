<h1>My listings</h1>
<?php

require "includes/dbh.inc.php";

$username = $_SESSION["username"];

$sql = "SELECT * FROM listings WHERE owner=?";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "There was an error while trying to display your listings";
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result)){
	$id = $row["id"];
	$title = $row["title"];
	$description = $row["description"];
	$keywords = $row["keywords"];
	$date = date("d/m/Y", $row["date"]);
	$image = "uploads/products/".$row["image"];
	$category = $row["category"];
	$owner = $row["owner"];
	
	$url = "http://localhost/Bartr/index.php?listing=view&id=".$id."&title=".$title;
	
	include "catalog/listing-template.php";
	// work on being able to edit listings
}

?>