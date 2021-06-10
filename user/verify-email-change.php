<?php
	require "header.php";
	// test this
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Change your email</h1>
			<p>In order to know that this is you, we need you to verify your identity. </p>
			<p>We sent an email to your address containing the six-digit verification code to change your email. Please enter it here.</p>
			
			<p>Your verification code</p>
			
			<form method="POST" action="../includes/verify-email-change.inc.php">
				<input type="hidden" name="selector" value="<?php echo $_GET["selector"] ?>">
				<input type="hidden" name="validator" value="<?php echo $_GET["validator"] ?>">

				<input type="text" placeholder="Verification Code" name="code" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Change your email</button>
			</form>
			
			<hr class="light">

			<p>If you didn't receive the email, you can choose to</p>
			<form method="POST" action="../includes/email-change-request.inc.php">
				<input type="hidden" value="<?php echo $_SESSION["username"] ?>">
				<button type="submit" name="submit" class="btn btn-secondary">Send another request</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>