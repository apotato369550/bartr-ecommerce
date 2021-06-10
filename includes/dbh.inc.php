<?php

$serverName = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$databaseName = "bartr";

$connection = mysqli_connect($serverName, $databaseUsername, $databasePassword, $databaseName);

if (!$connection){
	die("Connection failed: ".mysqli_connect_error());
} 
	