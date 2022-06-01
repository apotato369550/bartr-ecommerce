<h2>Edit Listing</h2>
<?php
	// werk on dis
	require "includes/dbh.inc.php";
	
	$title = $_GET["title"];
	$owner = $_GET["owner"];
	
	$sql = "SELECT * FROM listings WHERE title=? AND owner=?";
	$stmt = mysqli_stmt_init($connection);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: index.php?view=listings&error=sqlerrorprep");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "ss", $title, $owner);
		mysqli_execute($stmt);
	}
	
	// figure out why this no work
	$result = mysqli_stmt_get_result($stmt);
	
	if(!$row = mysqli_fetch_assoc($result)){
		header("Location: index.php?view=listings&error=requestnotfound");
		exit();
	}
	
	$owner = $row["owner"];
	$username = $_SESSION["username"];
	
	if($owner != $username){
		echo "You do not have permission to edit this listing";
		return;
	} else {
		$title = $row["title"];
		$images = $row["image"];
		$image = explode(" ", $images);
		$image = $image[0];
		$description = $row["description"];
		$keywords = $row["keywords"];
		$category = $row["category"];
		
		?>
		<img alt="Product Image Goes Here" width="200" height="200" id="product-image" src="uploads/products/<?php echo $image; ?>">
		
		<form method="POST" action="includes/edit-listing.inc.php" enctype="multipart/form-data">
			<input type="hidden" name="old-title" value="<?php echo $title ?>">

			<input type="hidden" name="owner" value="<?php echo $owner; ?>">

			<input type="hidden" name="user" value="<?php echo password_hash($_SESSION["username"], PASSWORD_DEFAULT); ?>">
			
			<label for="images">New Images to be used:</label>
			<input type="file" name="images[]" multiple="multiple" id="product-image-slide" id="images" src="<?php echo $image ?>">

			<label for="title">Title</label>
			<input type="text" name="new-title" placeholder="Title..." maxlength="50" value="<?php echo $title; ?>" id="title">

			<label for="category">Category</label>
			<select id="category" name="category" value="<?php echo $category ?>">
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

			<label for="description">Description</label>
			<textarea name="description" rows="7" cols="55" maxlength="500" placeholder="Enter your item description..." id="description"><?php echo $description; ?></textarea>

			<label for="keywords">Keywords</label>
			<input type="text" name="keywords" placeholder="Enter keywords here separated by a space and a comma... ( ,)" value="<?php echo $keywords; ?>" id="keywords">

			<button type="submit" name="submit">Edit Listing</button>
		</form>
		
		<script>
		// add this feature to edit-listing
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
		<?php
	}
	// add categorization
?>