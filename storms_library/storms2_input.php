<?php

	require_once("storms2_include.php");

	if($_SESSION["loggedIn"] != true ) { dt_headerRedirect("index.php?login=true"); exit; }
	$date = date("Y-m-d H:i:s.0");
	$g_link = ConnectDB();
	//print_r($_POST);
	
	$id					=		uid();
	$type				=		mysql_real_escape_string($_POST["type"]);
	$in_build			=		mysql_real_escape_string($_POST["in_build"]);
	$resolved_in		=		mysql_real_escape_string($_POST["resolved_in"]);
	$milestone			=		mysql_real_escape_string($_POST["milestone"]);
	$pertains_to		=		mysql_real_escape_string($_POST["pertains_to"]);
	$parent_issue		=		mysql_real_escape_string($_POST["parent_issue"]);
	$issue_title		=		mysql_real_escape_string($_POST["issue_title"]);
	$issue_text			=		mysql_real_escape_string($_POST["issue_text"]);
	$project			=		mysql_real_escape_string($_POST["project"]);
	
	//comments disabled for original bug at this time
	//$comment_title		=		$_POST["comment_title"];
	//$comment_text		= 		$_POST["comment_text"];
	
	//$enteredBy		=		$_SERVER["PHP_AUTH_USER"];
	$enteredBy			=		$_SESSION["displayName"];
	$enteredByID		=		0;
	
	$q = "SELECT id FROM ".TBLAPREFIX."_users WHERE disName='$enteredBy'";
	$s = mysql_query($q,$g_link);
	while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
		$enteredByID = $result["id"];
	}
	
	//default issue schema 2007-07-26
	//id, name, description, dateEntered, dateModified, issueInBuild, resolvedInBuild, type, sevarity, pertainsTo, parentIssue, enteredBy

	

		$query = "INSERT INTO ".TBLAPREFIX."_TDB
		(id, name, description, dateEntered, issueInBuild, resolvedInBuild, type, pertainsTo, parentIssue, enteredBy, project, milestone)
        VALUES ('$id', '$issue_title', '$issue_text', '$date', '$in_build', '$resolved_in', '$type', '$pertains_to', '$parent_issue', '$enteredBy', '$project', '$milestone')";

	mysql_query($query) or die("Could not insert data because ".mysql_error());
	
	$link_id = $id;
	
	$history_entry = "INSERT INTO `".TBLAPREFIX."_description_history` (`link_id`, `desc`, `user`) VALUES ('$link_id', '$issue_text', '$enteredByID')";
	mysql_query($history_entry, $g_link) or die("Could not insert history data because ".mysql_error());
	
	//get last entry and go to that one...
		
	CleanUpDB($g_link);

	//need to add sevarity

	//redirect to page with new bug
	$link = "index.php?id=$id";
	dt_headerRedirect($link);

?>