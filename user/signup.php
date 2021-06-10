<?php
	require "header.php";
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Create an Account</h1>
			<hr class="light">
			<form action="../includes/signup.inc.php" method="POST">
				<input type="text" placeholder="Username" name="username" class="p-2 mb-4 border-0 rounded">
				<br>
				<input type="email" placeholder="Email" name="email" class="p-2 mb-4 border-0 rounded">
				<br>
				<input type="password" placeholder="Password" name="password" class="p-2 mb-4 border-0 rounded">
				<br>
				<input type="password" placeholder="Repeat Password" name="repeat-password" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Sign Up!</button>
			</form>
			
			<a href="reset-password.php" class="unstyled m-3 text-white">Forgot your password? Click here!</a>
		</div>
	</main>
<?php
	require "footer.php";
?>