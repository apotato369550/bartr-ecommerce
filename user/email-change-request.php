<?php
	require "header.php"
	// email change system
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Change your email</h1>
			<p>In order to know that this is you, we need you to verify your identity. Please click the button below. </p>
			<hr class="light">
			<form method="POST" action="../includes/email-change-request.inc.php">
				<input type="hidden" value="<?php echo $_SESSION["username"] ?>" name="username" class="p-2 mb-4 border-0 rounded">
				<button type="submit" name="submit" class="btn btn-secondary">Change your email</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>