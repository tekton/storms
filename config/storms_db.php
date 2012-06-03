<?php
date_default_timezone_set("America/Los_Angeles");
require_once("storms_gdef.php");

function ConnectDB($db="", $host="", $user="", $password="") {
	
	if($db == "") 		{$db = DB;}
	if($host == "") 	{$host = HOST;}
	if($user == "") 	{$user = USER;}
	if($password == "") {$password = PASSWORD;}
	
	$g_link = mysql_connect($host, $user, $password) or die('storms :: DB: Could not connect to server.'.mysql_error());
	mysql_select_db($db, $g_link) or die('storms :: DB: Could not select database :: '.mysql_error());
	return $g_link;
}

function CleanUpDB($db) {
	if( $db != false ) { mysql_close($db); }
	$db = false;
	return $db;
}

?>
