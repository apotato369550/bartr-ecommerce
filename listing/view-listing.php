<?php

if(!isset($_GET["id"]) or !isset($_GET["title"])){
	echo "id and/or title not set";
	return;
}

$id = $_GET["id"];
$title = $_GET["title"];

if(empty($title) or empty($id)){
	echo "Not a valid lising";
	return;
}

require "includes/dbh.inc.php";

$sql = "SELECT * FROM listings WHERE id=? AND title=?";
$stmt = mysqli_stmt_init($connection);


if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "There was an error in preparing the sql statement";
	return;
} 

mysqli_stmt_bind_param($stmt, "is", $id, $title);

if(!mysqli_stmt_execute($stmt)){
	echo "There was an error executing the sql statement";
	return;
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	echo "This listing does not exist.";
}

$date = date("d/m/Y", $row["date"]);
$description = $row["description"];
$owner = $row["owner"];
$category = $row["category"];

$images = $row["image"];

if(empty($image)){
	$imagePath = "images/default-product-pic";
} 

$sql = "SELECT * FROM comments WHERE parent=?";

	
// fix this
// figure out why red squiggly line shows up
if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "Unable to prepare statement";
} else {
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
}

$numberOfComments = mysqli_num_rows(mysqli_stmt_get_result($stmt));

?>

<!-- find optimal layout for this shiz -->
<main>
	<div class="container-fluid mt-4 w-75">
		<div class="row jumbotron product-viewer text-justify m-auto">
			<div class="col">
				<image id="product-image-slide">
			</div>
			<div class="col text-dark">
				<h1>View <?php echo $title ?></h1>
				<br>
				<h3>Category: </h3>
				<span><?php echo $category ?></span>
				<hr class="dark">
				<h3>Description: </h3>
				<span><?php echo $description; ?></span>
				<hr class="dark">
				<h3>Date Posted: </h3>
				<span><?php echo $date; ?></span>
				<hr class="dark">
				<h3>Posted By: </h3>
				<span><?php echo $owner; ?></span>
				<hr class="dark">
				<div class="mt-3">
					<?php 
						if(!isset($_SESSION["username"])){
							echo "You must login to contact this user";
						} else if($_SESSION["username"] != $owner){
							?>
							<div class="text-center">
								<div>
									<button onclick="document.getElementById('messenger').style.display = 'block'; this.style.display = 'none'" class="btn btn-outline-dark btn-lg">Message</button>
								</div>
						
								<div id="messenger" style="display: none;">
									<h3>Send a Message to this user</h3>
									<form method="POST" action="includes/send-message.inc.php">
										<input name="owner" value="<?php echo $owner; ?>" type="hidden">
										<input name="product-id" value="<?php echo $id; ?>" type="hidden">
										<input name="product-title" value="<?php echo $title; ?>" type="hidden">
										<input name="username" value="<?php echo $_SESSION["username"] ?>" type="hidden">
						
										<textarea name="message" rows="7" cols="55" maxlength="500"></textarea>
										<br>
										<button type="submit" name="submit" class="btn btn-outline-dark btn-lg">Send Message</button>
									</form>
								</div>
							</div>
							<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<!-- maybe add commend section as part of second div
	figure out what to do with coment section
	 -->
</main>

<!-- add comment section here
how it works:
give each listing a unique id
each comment has an id of a listing that it belongs to
each reply has an id of a comment it belongs to

// when deleting listing, make sure to delete comments and replies
// when deleting user, make sure to delete listings and stuff above
-->

<div class="container-fluid mt-2 w-75">
	<div class="jumbotron text-justify m-auto">
		<?php
			if(!isset($_SESSION["username"])){
				?>
				<p>You must be logged in to enter a comment...</p> 
				<?php
			} else {
				// i drew a basic sketch,
				// try and replicate the sketch here belowVV
				require "account/get-profile-pic.php";
				?>
				<div class="d-flex p-2">	
					<form method="POST" action="includes/create-comment.inc.php">
						<input type="hidden" name="username" value="<?php echo $username ?>">
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<input type="hidden" name="title" value="<?php echo $title ?>">
						<img src="<?php echo $profilePic ?>" width="60" alt="Profile Picture" class="rounded-circle m-1">
						<!-- 
						make the image align with text-area
						search online how to make image align with paragraph in the center first,
						then figure out how to do it in bootstrap
						do the same in the comment section and replies
						increase the font size of comments and replies
						-->
						<textarea name="comment" rows="2" cols="55" maxlength="500" placeholder="Say Something..." class="m-1" style="vertical-align: middle;" required></textarea>
						<button type="submit" name="submit" class="btn btn-outline-dark btn-m m-1">Comment</button>
						<hr class="dark">
					</form>
				</div>
				<?php
			}
		?>


		<!-- if number of replies == 0, don't display this button -->
		<!-- IT WORKS:DD -->
		
		<?php 
			if($numberOfComments > 0){
				// test this mf
				?>
					<div>
						<button onclick="document.getElementById('comments').style.display = 'block'; this.style.display = 'none'" class="btn btn-outline-dark btn-m">View Comments</button>
					</div>
				<?php
			}
		?>

		<div id="comments" style="display: none;" class="m-4">
			<?php require "listing/view-comments.php";?>
		</div>
	</div>
</div>


<script>
// add this feature to edit-listing
// remove this
var images = '<?php echo $images ?>';
var images = images.split(" ");

var i = 0;
var time = 1000;

function changeImage(){
	if(images.length == 1){
		document.getElementById("product-image-slide").src = "uploads/products/" + images[i];
		return;
	} 
	
	if(i < images.length - 1){
		i++;
	} else {
		i = 0;
	}
	
	setTimeout("changeImage()", time);
}

changeImage();
</script>
