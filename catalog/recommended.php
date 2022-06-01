<div class="container-fluid">

<?php
require "includes/dbh.inc.php";

if(isset($_COOKIE["searched"])){
	?> 
		<div class="container-fluid padding">
			<div class="row welcome text-center">
				<div class="col-12">
					<h1 class="display-4">Your Recommended: </h1>
					<p>(Based on what you searched)</p>
				</div>
			</div>
		</div>
	<?php
	
	$cookie = $_COOKIE["searched"];
	$keywords = explode(" ", $cookie);
	
	$sql = "SELECT * FROM listings WHERE keywords LIKE '%$cookie%'";
	$stmt = mysqli_stmt_init($connection);

	if(count($keywords) > 1){
		foreach($keywords as $key){
			$sql.= " OR keywords LIKE '%$key%'";
		}
	}

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "There was an error in preparing the sql statement";
		return;
	} 

	if(!mysqli_stmt_execute($stmt)){
		echo "There was an error executing the sql statement";
		return;
	}
	
	$result = mysqli_stmt_get_result($stmt);
	$column = 0;
	
	while($row = mysqli_fetch_assoc($result)){
		$id = $row["id"];
		$title = $row["title"];
		$description = $row["description"];
		$keywords = $row["keywords"];
		$date = date("d/m/Y", $row["date"]);
		$lastUpdated = $row["last_updated"];
		$category = $row["category"];
		
		// fix this
		// make image into an array instead and display it like a slideshow
		// focus on this first
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
}
?>
	<div class="container-fluid padding">
		<div class="row welcome text-center">
			<div class="col-12">
				<h1 class="display-4">Recently Added: </h1>
				<p>(Things you might be interested in)</p>
			</div>
		</div>
	</div>
<?php

$sql = "SELECT * FROM listings ORDER BY date DESC";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "There was an error in preparing the sql statement";
	return;
} 

if(!mysqli_stmt_execute($stmt)){
	echo "There was an error executing the sql statement";
	return;
}

$result = mysqli_stmt_get_result($stmt);
$column = 0;

while($row = mysqli_fetch_assoc($result)){
	$id = $row["id"];
	$title = $row["title"];
	$description = $row["description"];
	$keywords = $row["keywords"];
	$date = date("d/m/Y", $row["date"]);
	$lastUpdated = $row["last_updated"];
	$category = $row["category"];

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
?>
</div>
