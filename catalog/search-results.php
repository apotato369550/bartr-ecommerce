<?php
require "includes/dbh.inc.php";

$query = $_GET["query"];
$category = $_GET["search-category"];

?>
<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Search Results for: "<?php echo $query ?>"</h1>
			<p>In Category: "<?php echo $category ?>"</p>
		</div>
	</div>
</div>
<?php

$keywords = explode(" ", $query);

$stmt = mysqli_stmt_init($connection);

if(empty($query)){
	echo "Please Enter a valid query";
	return;
} else {
	$sql = "SELECT * FROM ";

	if($category == "All"){
		$sql.="listings ";
	} else {
		$sql.="(SELECT * FROM listings WHERE category='$category') AS list ";
	}
	
	$sql.="WHERE title LIKE '%$query%' OR keywords LIKE '%$query%' ";
	
	if(count($keywords) > 1){
		foreach($keywords as $key){
			$sql.="OR keywords LIKE '%$key%' ";
		}
		foreach($keywords as $key){
			$sql.="OR title LIKE '%$key%' ";
		} 
	}
}

// $sql = "SELECT * FROM listings WHERE category='$category'";

// I should probably test this

if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "There was an error in preparing the sql statement ";
	echo $sql;
	return;
} 

if(!mysqli_stmt_execute($stmt)){
	echo "There was an error executing the sql statement ";
	echo $sql;
	return;
}

// create new listings with different keywords and stuff
// test the new search queries and stuff

$result = mysqli_stmt_get_result($stmt);

// work on the styling of this motherfucker

$column = 0;

while($row = mysqli_fetch_assoc($result)){
	$id = $row["id"];
	$title = $row["title"];
	$description = $row["description"];
	$keywords = $row["keywords"];
	$lastUpdated = date("d/m/Y", $row["last_updated"]);
	$category = $row["category"];
	$date = date("d/m/Y", $row["date"]);
	

	// fix this
	// make image into an array instead and display it like a slideshow
	$image = explode(" ", $row["image"]);
	$image = "uploads/products/".$image[0];
	
	$owner = $row["owner"];
	
	$url = "http://localhost/Bartr/index.php?listing=view&id=".$id."&title=".$title;
	
	if($column == 0){
		?>
			<div class="row padding w-75 m-auto">
		<?php
	}

	include "listing-template.php";
	$column++;

	if($column > 3){
		?>
			</div>
		<?php
		$column = 1;
	}
}

echo $sql;

?>