<h1>My listings</h1>
<?php
// work on this
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

$column = 0;

while($row = mysqli_fetch_assoc($result)){
	$id = $row["id"];
	$title = $row["title"];
	$description = $row["description"];
	$keywords = $row["keywords"];
	$category = $row["category"];
	$date = date("d/m/Y", $row["date"]);
	$image = "uploads/products/".$row["image"];
	$owner = $row["owner"];
	
	$url = "http://localhost/Bartr/index.php?listing=view&id=".$id."&title=".$title;
	
	// test this
	// patch the errors
	if($column == 0){
		?>
			<div class="row padding w-75 m-auto">
		<?php
	}

	include "catalog/listing-template.php";
	$column++;

	if($column > 3){
		?>
			</div>
		<?php
		$column = 1;
	}
}

?>