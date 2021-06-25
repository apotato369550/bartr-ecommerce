<script src="./media/scripts/imageFunctions.js" type="text/javascript"></script>

<main>
	<div class="text-center jumbotron mx-auto text-white bg-dark w-75 mt-4 pt-4 pb-4">
		<div class="w-100 bg-secondary rounded p-1 m-3">
			<h2 class="display-4">Create a Listing</h2>
		</div>
		<form method="POST" action="includes/create-listing-request.inc.php" enctype="multipart/form-data">
			<div class="row">
				<div class="col-6">
					<input type="hidden" name="username" value="<?php echo $_SESSION["username"]; ?>" required>
					
					<div id="slides" class="carousel slide" data-ride="carousel">
						<ul class="carousel-indicators">
							<li data-target="#slides" data-slide-to="0" class="active default-indicator"></li>
						</ul>

						<div class="carousel-inner">
							<div class="carousel-item active default-slide">
								<!-- 
									make carousel and input two column area

									figure out the css for the two column area
									copy the styling from bootstrap project
								-->
								<img src="./images/default-product-image.jpg" class="img-responsive w-100" id="image-lmao">
							</div>
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
					<input type="text" name="title" placeholder="Title" maxlength="50" id="title" class="p-2 mb-4 border-0 rounded w-100" required>
					<br>
					<select id="category" name="category" class="p-2 mb-4 border-0 rounded col w-100">
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
					<textarea name="description" rows="7" cols="55" maxlength="500" placeholder="Description" id="description" class="p-2 mb-4 border-0 rounded w-100" required></textarea>
					<br>
					<input type="text" name="keywords" placeholder="Keywords (,)" id="keywords" class="p-2 mb-4 border-0 rounded w-100" required>
					<br>
					<button class="btn btn-outline-light btn-lg m-4">
						<input type="file" name="images[]" multiple="multiple" id="product-images" onchange="readURL(this);" required>
					</button>
					<br>
					<button type="submit" name="submit" class="btn btn-outline-light btn-lg">Create Listing</button>
				</div>
			</div>
		</form>
	</div>
</main>

<!-- 
	work on this mf
	maybe make the card a carousel when viewed as well.
-->
