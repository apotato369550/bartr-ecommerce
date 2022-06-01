<?php
	require "header.php";
	// make includes file
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Delete your account</h1>
			<p>To delete your account, enter your password and the verification code down below.</p>
			<p>Remember that once you delete your account, it cannot be undone. All your information, including your listings will be deleted.</p>

			<hr class="light">
			
			<form method="POST" action="../includes/delete-account.inc.php">
				<input type="hidden" value="<?php echo $_SESSION["username"] ?>" name="username">
				<input type="hidden" name="selector" value="<?php echo $_GET["selector"] ?>">
				<input type="hidden" name="validator" value="<?php echo $_GET["validator"] ?>">

				<input type="password" name="password" placeholder="Password" class="p-2 mb-4 border-0 rounded">
				<br> 
				<input type="text" name="code" placeholder="Verification Code" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Delete Your Account</button>
			</form>
		</div>
	</main>
<?php
	// continue with this
	require "footer.php";
?>