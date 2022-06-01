<?php
	require "header.php";
	// make includes file
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Delete your account</h1>
			<p>To delete your account, please enter your email down below. An email will be sent with instructions on how to delete your account.</p>
			<p>Remember that once you delete your account, it cannot be undone. All your information, including your listings will be deleted.</p>
			<hr class="light">
			<form method="POST" action="../includes/delete-request.inc.php">
				<input type="email" name="email" placeholder="Email" class="p-2 mb-4 border-0 rounded">
				<br>
				<hr class="light">
				<button type="submit" name="submit" class="btn btn-secondary">Delete Your Account</button>
			</form>
		</div>
	</main>
<?php
	require "footer.php";
?>