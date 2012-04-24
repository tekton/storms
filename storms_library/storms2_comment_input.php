<?php

	require_once("storms2_include.php");
	
	if($_SESSION["loggedIn"] != true ) { dt_headerRedirect("index.php?login=true"); exit; }
	$date = date("Y-m-d H:i:s.0");
	$g_link = ConnectDB();
	//print_r($_POST);
	
	$id				=		mysql_real_escape_string($_POST["id"]);
	$pertainsTo		=		mysql_real_escape_string($_POST["id"]);
	$title			=		mysql_real_escape_string($_POST["comment_title"]);
	$description	=		mysql_real_escape_string($_POST["comment_text"]);
	//$visible		=		$_POST["id"];
	$enteredBy		=		"";
	$enteredBy		=		$_SESSION["displayName"];
	
	//default issue schema 2007-08-29
	//id, pertainsTo, title, description, dateEntered, dateModified, visible, enteredBy

	

		$query = "INSERT INTO ".TBLAPREFIX."_TDB_Comments
		(pertainsTo, title, description, enteredBy)
        VALUES ('$pertainsTo', '$title', '$description', '$enteredBy')";

		//"touch" the main entry
		$q2 = "UPDATE ".TBLAPREFIX."_TDB SET dateModified = NOW() WHERE id='$id'";

	mysql_query($query) or die("Could not insert data because ".mysql_error());
	mysql_query($q2) or die("Could not insert data because ".mysql_error());
	
	//get last entry and go to that one...
		
	CleanUpDB($g_link);

	//need to add sevarity
	//due to consolidating pages, the diplay code on here is no longer needed
	//displays the last few entries made...
	
	//Commenting out next two lines as they cause some weird behaviours in updating issues
	//xml_head("issue.xsl");
	//getData($id);
	dt_headerRedirect("index.php?id=$id");
?>