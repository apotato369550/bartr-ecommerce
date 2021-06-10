<?php
	require "header.php";
?>
	<!-- I am satisfied w/ this .
	apply this to change email, create-new-password, delete account and delete request, email change request, reset-password, signup, verify account, and verify email change
	copypaste this shiz
	-->
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Login to your account</h1>
			<hr class="light">
			<form action="../includes/login.inc.php" method="POST">
				<input type="text" placeholder="Username or Email" name="user" class="p-2 mb-4 border-0 rounded">
				<br>
				<input type="password" placeholder="Password" name="password" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">		
				<button type="submit" name="submit" class='btn btn-secondary'>Login</button>
			</form>
			<br>
			<a href="reset-password.php" class="unstyled m-3 text-white">Forgot your password? Click here!</a>
		</div>
	</main>	
	
<?php
	require "footer.php";
?>