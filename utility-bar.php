

<div class="container-fluid padding">
	<div class="text-center bg-dark p-3 mt-2 mb-2 rounded">
		<form method="GET" action="index.php">
			<select id="search-category" name="search-category" class="col-1 p-2 m-1 rounded">
				<option value="All" selected="selected">All</option>
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
				<option value="Other">Other</option>
			</select>

			<input type="text" name="query" placeholder="Search" class="col-3 p-2 m-1 rounded">
				
			<!-- glyph icons don't work figure out why -->
			<!-- use the icon system in other bootstrap project -->
			<button type="submit" id="search" class="btn btn-secondary">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search text-white" viewBox="0 0 16 16">
					<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
				</svg>
			</button>

		
		</form>
	</div>
</div>





















<!--
	put this on the home slideshow thing
<?php
	if(isset($_SESSION["username"])){
?>
		<form method="GET" action="index.php">
			<button type="submit" name="listing" value="create">Bartr</button>
		</form>
<?php
	}
?>
-->