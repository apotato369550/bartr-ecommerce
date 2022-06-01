<?php
	session_start();
	
	if(isset($_GET["query"]) and !empty($_GET["query"])){
		if(isset($_COOKIE["searched"])){
			$query = $_GET["query"];
			$searched = $_COOKIE["searched"];
			$keywords = explode(" ", $searched." ".$query);
			
			for($i = count($keywords); $i > 10; $i--){
				array_shift($keywords);
			}
			
			$keywords = implode(" ", $keywords);
			setcookie("searched", $keywords, time() + 1800, "/");
		} else {
			$keywords = $_GET["query"];
			setcookie("searched", $keywords, time() + 1800, "/");
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Bartr.com | One man's junk, another man's treasure</title>

		<!-- 
			this works bitchVVVVVVVV
		-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
		<link href="media/style.css" rel="stylesheet">
	</head>
	<body>
		<!-- there's something wrong with profile dropdown trying to load when logged in -->
		<nav class="navbar navbar-expand-md navbar-dark bg-secondary sticky-top">
			<div class="container-fluid">
				
				<a href="index.php" class="navbar-brand"><h1>Bartr.com</h1><a>

				<div class="navbar-nav ml-auto">
					<ul class="navbar-nav ml-auto">
						<li>
							<a href="index.php" class="nav-link nav-item">Home</a>
						</li>
						<li>
							<a href="#" class="nav-link nav-item">About</a>
						</li>

						<?php if(!isset($_SESSION["username"])){ ?>
							<li>
								<a href="user/login.php" class="nav-link nav-item">Login</a>
							</li>
							<li>
								<a href="user/signup.php" class="nav-link nav-item">Signup</a>
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