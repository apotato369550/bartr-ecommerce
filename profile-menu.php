
<!-- fix profile pic -->
<div class="dropdown">
	<?php require "account/get-profile-pic.php"; ?>
	<button 
		class="btn btn-secondary dropdown-toggle" 
		type="button" 
		id="dropdownMenuButton" 
		data-toggle="dropdown" 
		aria-haspopup="true" 
		aria-expanded="false"
	>
		<img 
			src="<?php echo $profilePic ?>" 
			width="40" 
			alt="Profile Picture"
			class="rounded-circle"
		>
	</button>
	
	<!-- try getting rid of the ul -->
	<div class="dropdown-menu dropdown-menu-right">
		<ul id="dropdown-list">
			<li><a href="index.php?view=profile" class="dropdown-item">View Profile</a></li>
			<li><a href="index.php?view=listings" class="dropdown-item">Manage Listings</a></li>
			<li><a href="index.php?view=mailbox" class="dropdown-item">Mailbox</a></li> 
			

			<div class="dropdown-divider"></div>

			<div class="button-group">
				<li>
					<form method="GET" action="index.php">
						<button type="submit" name="listing" value="create" class="dropdown-item">Create New Listing</button>
					</form>
				</li>
				<li>
					<form action="includes/logout.inc.php" method="POST">
						<button type="submit" name="logout-submit" class="dropdown-item">Logout</button>
					</form>
				</li>
			</div>
		</ul>
	</div>
</div>