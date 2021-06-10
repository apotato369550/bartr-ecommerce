<?php

if(isset($_GET["view"])){ return; }
if(isset($_GET["query"])){
	require "catalog/search-results.php";
} else {
	require "catalog/recommended.php";
}

?>