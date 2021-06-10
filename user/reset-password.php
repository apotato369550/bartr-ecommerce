<?php
	require "header.php"
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Reset Your Password</h1>
			<p>An email will be sent containing instructions on how to reset your password. To reset your password, please enter your email address below: </p>
			<hr class="light">
			<form method="POST" action="../includes/reset-request.inc.php">
				<input type="email" placeholder="Enter your email here..." name="email" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Reset your Password</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>