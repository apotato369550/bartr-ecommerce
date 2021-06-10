
<div class="col-md-4 p-2">
	<div class="card m-2">
		<img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" class="card-img-top img-responsive">

		<div class="card-body">
			<h2><?php echo $title; ?></h2>
			<div class="card-text">
				<p>Posted by: <?php echo $owner; ?> </p>
				<p><?php echo $description; ?></p>
				<p><?php echo $category; ?></p>
				<p>Posted: <?php echo $date; ?>.</p>
			</div>
			<?php
				if(isset($lastUpdated) && $lastUpdated != 0){
					?> <p>Last Updated: <?php echo $lastUpdated ?> </p> <?php
				}
			?>
			<a href=" <?php echo $url; ?> ">Click here to check it out</a>
			<?php
				if(isset($_SESSION["username"]) && (isset($_GET["view"]) && $_GET["view"] == "listings")){
					if($_SESSION["username"] == $owner){
						?>
							<div class="mt-3 row">
								<form method="POST" action="includes/manage-listings.inc.php">
									<input type="hidden" name="title" value="<?php echo $title; ?>">
									<input type="hidden" name="owner" value="<?php echo $owner; ?>">
									<input type="hidden" name="id" value="<?php echo $id; ?>">
									<button class="btn btn-dark m-2" type="submit" name="edit">Edit Listing</button>
									<button class="btn btn-dark m-2" type="submit" name="delete">Delete Listing</button>
								</form>
							</div>
						<?php 
					}
				} 
			?>
		</div>
	</div>
</div>
<!-- fix these buttons-->