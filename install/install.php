<?php

	//remove older intall files
	
	//set variables
	$RewriteBase = $_POST["RewriteBase"];
	$DB = $_POST["DB"];
	$USER = $_POST["USER"];
	$PASSWORD = $_POST["PASSWORD"];
	$HOST = $_POST["HOST"];
	$TBLAPREFIX = $_POST["TBLAPREFIX"];
	$DBUG = $_POST["DBUG"];
	$URI_BASE = $_POST["URI_BASE"];
	
	$access_sample = "../.htacess_sample";
	$config = "../storms_gdef_sample.php";
	
	//open sample files and replace as needed!

?>