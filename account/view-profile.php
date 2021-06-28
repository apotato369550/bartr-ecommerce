

<?php

require "includes/dbh.inc.php";

$username = $_SESSION["username"];

$sql = "SELECT * FROM accounts WHERE username=?";
$stmt = mysqli_stmt_init($connection);

if(!mysqli_stmt_prepare($stmt, $sql)){
	header("Location: index.php?error=sqlerrorprep");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
}

$result = mysqli_stmt_get_result($stmt);

if(!$row = mysqli_fetch_assoc($result)){
	echo "request not found";
}

$email = $row["email"];
$profilePic = "uploads/profile-pictures/".$row["profile_picture"];

if(empty($row["profile_picture"])){
	$profilePic = "images/profile-pic.png";
}

// work on thisVVV
// copy format from login and register fields but w/ secondary color instead of dark
// figure out the ting
?>

<div class="text-center jumbotron mx-auto text-white bg-secondary jumbotron">

	<h1 class="display-6">Your Profile: </h1>
	<img width="200" height="200" alt="<?php echo $profilePic ?>" src="<?php echo $profilePic ?>">

	<div>
		<p>Userame: <?php echo $username; ?> </p>
		<p>Email: <?php echo $email; ?> </p>

		<h1>Settings: </h1>

		<button onclick="document.getElementById('change-profile-pic-form-container').style.display = 'block';">Edit Profile Pic</button>
		<div id="change-profile-pic-form-container" style="display: none;">
			<form method="POST" action="includes/change-profile-pic.inc.php" enctype="multipart/form-data">
				<input type="hidden" name="username" value="<?php echo $_SESSION["username"]; ?>">
				<input type="file" name="image">
				<button type="submit" name="submit">Edit</button>
			</form>
		</div>
		<a href="user/email-change-request.php">Change Email</a>
		<a href="user/reset-password.php">Reset Password</a>
		<a href="user/delete-request.php">Delete Account</a>
	</div>
</div>


