<main>
	<!--

	<h1>Welcome <?php 
		if(isset($_SESSION["username"])){ echo $_SESSION["username"]; }
	?>!</h1>
	
	<p>This is your user feed/landing page, the place where all your stuff goes!</p>
	 

	add captions for welcome slide
	make screen default focus href on search form on search

	the caption depends on whether or not the user is logged in.
	copy header to account changing info shiz
	
	-->

	<div id="slides" class="carousel slide mb-4" data-ride="carousel">
		<ul class="carousel-indicators">
			<li data-target="#slides" data-slide-to="0" class="active"></li>
			<li data-target="#slides" data-slide-to="1"></li>
			<li data-target="#slides" data-slide-to="2"></li>
			<li data-target="#slides" data-slide-to="3"></li>
			<li data-target="#slides" data-slide-to="4"></li>
		</ul>

		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="images/carousel/welcome.jpg" class="img-responsive w-100">
				<!-- what displays here depends on whether or not the use is logged in... -->
				<div class="carousel-caption p-4">
					<h3 class="display-3">One man's trash, another man's treasure.</h3>
					<?php 
					
					if(!isset($_SESSION["username"])){
						?> 
							<!-- fix this row -->
							<form action="user/login.php" class="d-inline">
								<button type="submit" class="btn btn-outline-light btn-lg">Login</button>
							</form>

							<form action="user/signup.php" class="d-inline">
								<button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
							</form>
						<?php
					} else {
						?> 
							<form method="GET" action="index.php">
								<button type="submit" name="listing" value="create" class="btn btn-outline-light btn-lg">Bartr</button>
							</form>
						<?php
					}

					?>
				</div>
			</div>
			<div class="carousel-item">
				<img src="images/carousel/image-1.jpg" class="img-responsive w-100">
			</div>
			<div class="carousel-item">
				<img src="images/carousel/image-2.jpg" class="img-responsive w-100">
			</div>
			<div class="carousel-item">
				<img src="images/carousel/image-3.jpg" class="img-responsive w-100">
			</div>
			<div class="carousel-item">
				<img src="images/carousel/image-4.jpg" class="img-responsive w-100">
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

	<?php
		/*
		if(isset($_SESSION["username"])){
			?>
				<p>Feel free to log out when you're done :)</p>
				<a>You can also choose to delete your account by clicking here:)</a>
			<?php
		} else {
			?> <p>If you wanna see what's available, why not log in?</p> <?php
		}
		*/

		require "utility-bar.php";
	?>
</main>