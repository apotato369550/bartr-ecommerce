<?php
	require "header.php";
?>
	<main>
		<div class="text-center jumbotron mx-auto text-white bg-dark user-form">
			<h1 class="display-6">Verify Your Account</h1>
			<?php
				if(isset($_GET["selector"]) and isset($_GET["validator"])){
					$selector = $_GET["selector"];
					$validator = $_GET["validator"];
					
					if(empty($selector) or empty($validator)){
						?> <p>Could not validate your account</p> <?php
					} 
					
					if(ctype_xdigit($selector) == False and ctype_xdigit($validator) == False){
						?> <p>Could not validate your account</p> <?php
					} else {
						?>
						<hr class="light">
						<form action="../includes/verify-account.inc.php" method="post">
							<input type="hidden" name="selector" value="<?php echo $selector ?>" class="p-2 mb-4 border-0 rounded">
							<input type="hidden" name="validator" value="<?php echo $validator ?>" class="p-2 mb-4 border-0 rounded">
							<button name="submit" type="submit" class="p-2 mb-4 border-0 rounded">Click this button to verify your account.</button>
						</form>
						<?php
					}
					
				}
			?>
		</div>
		<!-- do this and the next one next-->
	</main>
<?
	require "footer.php";
?>