<?php
	if(isset($_GET["view"])){
		$view = $_GET["view"];
		if($view == "profile"){
			require "account/view-profile.php";
		} else if($view == "listings"){
			require "account/view-listings.php";
		} else if($view == "mailbox"){
			require "account/view-mailbox.php";
		}
		return;
	}
	
	if(!isset($_GET["listing"])){
		require "home.php";
		return;
	}
	
	if($_GET["listing"] == "view"){
		require "listing/view-listing.php";
	} else if($_GET["listing"] == "create"){
		require "listing/create-listing.php";
	} else if($_GET["listing"] == "edit"){
		require "listing/edit-listing.php";
	}
?>