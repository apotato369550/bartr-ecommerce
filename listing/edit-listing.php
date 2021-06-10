<script src="./media/scripts/imageFunctions.js" type="text/javascript"></script>

<main>
	<div class="text-center jumbotron mx-auto text-white bg-dark w-75 mt-4 pt-4 pb-4">
		<div class="w-100 bg-secondary rounded p-1 m-3">
			<h2 class="display-4">Edit Listing</h2>
		</div>
		<?php
			// work on this below::
			
			require "includes/dbh.inc.php";

			$title = $_GET["title"];
			$id = $_GET["id"];

			$stmt = mysqli_stmt_init($connection);
			// owner instead of title
			// this works.  see if info displayed is correct tho
			$sql = "SELECT * FROM listings WHERE id=? AND title=?";
			// edit doesn't work

			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: index.php?view=listings&error=sqlerrorprep");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, "is", $id, $title);
				mysqli_execute($stmt);
			}
			$result = mysqli_stmt_get_result($stmt);
			
			if(!$row = mysqli_fetch_assoc($result)){
				// drinking cofefe will
				header("Location: index.php?view=listings&error=requestnotfoundlol");
				exit();
			} else {
				// test this
				$title = $row["title"];
				$images = $row["image"];
				$images = explode(" ", $images);
				$description = $row["description"];
				$keywords = $row["keywords"];
				$category = $row["category"];
				$id = $row["id"];

				// i have no fucking idea why this ain't working
				?>	
					<form method="POST" action="includes/edit-listing.inc.php" enctype="multipart/form-data">
						<div class="row">
							<div class="col-6">
								<input type="hidden" name="user" value="<?php echo $_SESSION["username"] ?>">
								<input type="hidden" name="id" value="<?php echo $id ?>">

								<div id="slides" class="carousel slide" data-ride="carousel">
									<ul class="carousel-indicators">
										<?php 
											for($i = 0; $i < count($images); $i++){
												if($i == 0){
													?>
													<li data-target="#slides" data-slide-to="<?php echo $i ?>" class="active default-indicator"></li>
													<?php
												} else {
													?>
													<li data-target="#slides" data-slide-to="<?php echo $i ?>"></li>
													<?php
												}
											}
										?>
									</ul>

									<div class="carousel-inner">
										<div class="carousel-item active default-slide">
											<!-- 
												query images from database on load
												display them here through php or javascript
												i think it's easier to use php to do this
											-->
										</div>
										<?php 
											// test this
											for($i = 0; $i < count($images); $i++){
												$imageUrl = "uploads/products/".array_pop($images);
												if($i == 0){
													?>
														<div class="carousel-item active default-slide">
															<img src="<?php echo $imageUrl ?>" class="img-responsive w-100">
														</div>
													<?php
												} else {
													?>
														<div class="carousel-item">
															<img src="<?php echo $imageUrl ?>" class="img-responsive w-100">
														</div>
													<?php
												}
											}
										?>
									</div>

									<a class="carousel-control-prev" href="#slides" role="button" data-slide="prev">
										<span class="carousel-control-prev-icon" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="carousel-control-next" href="#slides" role="button" data-slide="next">
										<span class="carousel-control-next-icon" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>
								</div>
							</div>
							<div class="col-6 text-center bg-secondary p-3 rounded">
								<!--- 
								there is something wrong w/ the includes
								fix the includes
								// test if the entire thing works w/o the id
								 -->
								<input type="hidden" name="owner" value="<?php echo $owner; ?>">

								<input type="text" name="title" placeholder="Title..." maxlength="50" value="<?php echo $title; ?>" class="p-2 mb-4 border-0 rounded w-100">
								<br>
								<select name="category" value="<?php echo $category ?>" class="p-2 mb-4 border-0 rounded col w-100">
									<option value="Electronic Devices">Electronic Devices</option>
									<option value="Appliances">Appliances</option>
									<option value="Health and Beauty">Health and Beauty</option>
									<option value="Babies and Toys">Babies and Toys</option>
									<option value="Groceries and Food">Groceries and Food</option>
									<option value="Pets and Pet goods">Pets and Pet Goods</option>
									<option value="Home, Living, and Furniture">Home, Living, and Furniture</option>
									<option value="Fashion and Clothing">Fashion and Clothing</option>
									<option value="Fashion Accessories">Fashion Accessories</option>
									<option value="Sports">Sports</option>
									<option value="Cars and Motor Vehicles">Cars and Motor Vehicles</option>
									<option value="Jewelry and Collectibles">Jewelrey and Collectibles</option>
									<option value="Other" selected="selected">Other</option>
								</select>
								<br>
								<textarea name="description" rows="7" cols="55" maxlength="500" placeholder="Enter your item description..." class="p-2 mb-4 border-0 rounded w-100"><?php echo $description; ?></textarea>
								<br>
								<input type="text" name="keywords" placeholder="Enter keywords here separated by a space and a comma... ( ,)" value="<?php echo $keywords; ?>" id="keywords" class="p-2 mb-4 border-0 rounded w-100">
								<br>
								<button class="btn btn-outline-light btn-lg m-4">
									<input type="file" name="images[]" multiple="multiple" src="<?php echo $image ?>" onchange="readURL(this);">
								</button>
								<br>
								<button type="submit" name="submit" class="btn btn-outline-light btn-lg">Edit Listing</button>
							</div>
						</div>
					</form>
				<?php
			}


		?>
		
	</div>
</main>
	