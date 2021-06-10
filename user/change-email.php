<?php
	require "header.php";
	// make includes file
	// fix the fields
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Change your email</h1>
			<p>Please enter your new email address.</p>

			<hr class="light">
		
			<form method="POST" action="../includes/change-email.inc.php">
				<input type="hidden" name="selector" value="<?php echo $_GET["selector"] ?>">
				<input type="hidden" name="validator" value="<?php echo $_GET["validator"] ?>">

				<input type="email" name="old-email" placeholder="Old address here" class="p-2 mb-4 border-0 rounded">
				<br>

				<input type="email" name="new-email" placeholder="New email address here" class="p-2 mb-4 border-0 rounded">
				<br>

				<input type="password" name="password" placeholder="Password" class="p-2 mb-4 border-0 rounded">
				<br>

				<hr class="light">

				<button type="submit" name="submit" class="btn btn-secondary">Change your email</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>