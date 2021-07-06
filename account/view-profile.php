

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
// work on this
// copy first the signup ting
// is there a .css file here?
// work on this
?>

<main>
	<div class="text-center jumbotron mx-auto text-white bg-secondary user-profile">

		<h1 class="display-4">Your Profile: </h1>
		<div class="text-center m-auto">
			<img width="200" height="200" alt="<?php echo $profilePic ?>" src="<?php echo $profilePic ?>" class="rounded-circle m-2">
			<br>
			<!-- this works but is pretty ugly. fix it -->

			<button class="btn btn-outline-light mt-1 mb-3 btn-s" type="button" data-toggle="collapse" data-target="#profile-changer" aria-expanded="false" aria-controls="profile-changer">Edit Profile Pic</button>
			<br>
			<div id="profile-changer" class="collapse p-2 bg-dark rounded w-50 m-auto">
				<form method="POST" action="includes/change-profile-pic.inc.php" enctype="multipart/form-data">
					<input type="hidden" name="username" value="<?php echo $_SESSION["username"]; ?>">
					<input type="file" name="image" class="btn btn-outline-light btn-secondary btn-s m-2">
					<!-- make this button transparent -->
					<br>
					<button type="submit" name="submit" class="btn btn-outline-light btn-s">Edit</button>
				</form>
			</div>

		</div>
		<hr class="light">

		<div>
			<h1>Settings: </h1>
			<!-- continue to format this -->

			<div>
				<h3>Userame: </h3> <p> <?php echo $username; ?> </p>
				<h3>Email: </h3> <p> <?php echo $email; ?> </p>
			</div>
			<div>
			<!-- convert these to forms and get rid of anchor tags 
			figure out how to make the forms inline
			-->
				<form method="POST" action="user/email-change-request.php" class="m-3">
					<button type="submit" class="btn btn-dark btn-s"|> Change Email </button>
				</form>
				<form method="POST" action="user/reset-password.php" class="m-3">
					<button type="submit" class="btn btn-dark btn-s"|> Reset Password </button>
				</form>
				<form method="POST" action="user/delete-request.php" class="m-3">
					<button type="submit" class="btn btn-danger btn-s"|> Delete Account </button>
				</form>
			</div>
		</div>
	</div>
</main>




