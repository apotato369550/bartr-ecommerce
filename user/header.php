<?php
	session_start();
	
	// continue moving other user files into user folder and edit includes as necessary
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bartr.com | One man's junk, another man's treasure</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
		<link href="../media/style.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-secondary sticky-top">
			<div class="container-fluid">
				
				<a href="../index.php" class="navbar-brand"><h1>Bartr.com</h1><a>

				<div class="navbar-nav ml-auto">
					<ul class="navbar-nav ml-auto">
						<li>
							<a href="../index.php" class="nav-link nav-item">Home</a>
						</li>
						<li>
							<a href="#" class="nav-link nav-item">About</a>
						</li>
						<?php if(!isset($_SESSION["username"])){ ?>
							<li>
								<a href="login.php" class="nav-link nav-item">Login</a>
							</li>
							<li>
								<a href="signup.php" class="nav-link nav-item">Signup</a>
							</li>
						<?php } else {
							?> 
							<li>
							<?php
								require "profile-menu.php";
							?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</nav>