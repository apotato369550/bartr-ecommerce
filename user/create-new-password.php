<?php
	require "header.php";
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Reset Your Password</h1>
			<p>Reset your password by entering and repeating your new password.</p>
			
			<hr class="light">
			
			<form action="../includes/reset-password.inc.php" method="POST">
				<input type="hidden" name="selector" value="<?php echo $_GET["selector"] ?>">
				<input type="hidden" name="validator" value="<?php echo $_GET["validator"] ?>">

				<input type="password" name="password" placeholder="New Password" class="p-2 mb-4 border-0 rounded">
				<br>
				<input type="password" name="repeat-password" placeholder="Repeat Password" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Reset Password</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>