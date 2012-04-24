<?php

require_once("storms2_include.php");

if($_SESSION["loggedIn"] != true ) { dt_headerRedirect("index.php?login=true"); exit; }
if($_POST) {
	
	$date = date("Y-m-d H:i:s");
	$g_link = ConnectDB();
	//print_r($_POST);
	$id					=		mysql_real_escape_string($_POST["id"]);
	$type				=		mysql_real_escape_string($_POST["type"]);
	$in_build			=		mysql_real_escape_string($_POST["in_build"]);
	$resolved_in		=		mysql_real_escape_string($_POST["resolved_in"]);
	$milestone			=		mysql_real_escape_string($_POST["milestone"]);
	$pertains_to		=		mysql_real_escape_string($_POST["pertains_to"]);
	$parent_issue		=		mysql_real_escape_string($_POST["parent_issue"]);
	$issue_title		=		mysql_real_escape_string($_POST["issue_title"]);
	$issue_text			=		mysql_real_escape_string($_POST["issue_text"]);
	$project			=		mysql_real_escape_string($_POST["project"]);
	$flagged			=		mysql_real_escape_string($_POST["flagged"]);
	$visible			=		mysql_real_escape_string($_POST["visible"]); //add check to make sure it's only one character

	$enteredBy			=		$_SESSION["displayName"];
	$enteredByID		=		0;
	
	$q = "SELECT id FROM ".TBLAPREFIX."_users WHERE disName='$enteredBy'";
	$s = mysql_query($q,$g_link);
	while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
		$enteredByID = $result["id"];
	}

	$change_comment = "";
	$q = "SELECT * FROM ".TBLAPREFIX."_TDB WHERE id='$id'";
	$s = mysql_query($q,$g_link);

	while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
		if($result["type"]				!= $_POST["type"]) {
			$change_comment .= "Type changed from ".$result["type"]." to ".$type."\n";
		}
		
		if($result["issueInBuild"] != $_POST["in_build"]) {
			$change_comment .= "Start Build changed from ".$result["issueInBuild"]." to ".$in_build."\n";
		}
		
		if($result["resolvedInBuild"] != $_POST["resolved_in"]) {
			$change_comment .= "Updated Build changed from ".$result["resolvedInBuild"]." to ".$resolved_in."\n";
		}
		
		if($result["milestone"] != $_POST["milestone"]) {
			$change_comment .= "Milestone changed from ".$result["milestone"]." to ".$milestone."\n";
		}
		
		if($result["pertainsTo"] != $_POST["pertains_to"]) {
			$change_comment .= "Pertains To changed from ".$result["pertainsTo"]." to ".$pertains_to."\n";
		}
		
		if($result["parentIssue"] != $_POST["parent_issue"]) {
			$change_comment .= "Parent Issue changed from ".$result["parentIssue"]." to ".$parent_issue."\n";
		}
		
		if($result["visible"] != $_POST["visible"]) {
			$change_comment .= "Visibility changed from ".$result["visible"]." to ".$visible."\n";
		}
		
		if($result["name"] != $_POST["issue_title"]) {
			$change_comment .= "Title changed from ".$result["name"]." to ".$issue_title."\n";
		}
		
		if($result["flagged"] != $_POST["flagged"]) {
			$change_comment .= "Flagged changed from ".$result["flagged"]." to ".$flagged."\n";
		}
		
		if($result["description"]	!= $_POST["issue_text"])	{
			$change_comment .= "Description changed\n";
			
			//enter change in the history tab
			
			$link_id = $id;
			
			$history_entry = "INSERT INTO `".TBLAPREFIX."_description_history` (`link_id`, `desc`, `user`) VALUES ('$link_id', \"$issue_text\", '$enteredByID')";
			mysql_query($history_entry, $g_link) or die(mysql_error());
		}
	}

	$_POST["comment_title"] = "Entry updated"; //" by $enteredBy"; //needs to get session user name
	$_POST["comment_text"] = "Modifications were made to this entry on ".$date."\n".$change_comment;
	
	if($change_comment != "") {
		$update = mysql_query("UPDATE ".TBLAPREFIX."_TDB SET
		type = '$type',
		issueInBuild = '$in_build',
		resolvedInBuild = '$resolved_in',
		milestone = '$milestone',
		pertainsTo = '$pertains_to',
		parentIssue = '$parent_issue',
		project = '$project',
		visible = '$visible',
		name = '$issue_title',
		flagged = '$flagged',
		description = '$issue_text' 
		WHERE id = $id", $g_link);
		CleanUpDB($g_link);
	
		require_once("storms2_comment_input.php"); //this is what ultimately causes the info to be drawn on the screen...this is bad imo
	} else {
		dt_headerRedirect("index.php?id=$id");
	}
	
	//echo "<!-- break in edit post "; var_dump(debug_backtrace()); echo "-->";
}
else {
	$id = $_GET["edit"];
	echo xml_head("edit.xsl");
	getData($id);
	//echo "<!-- break in edit "; var_dump(debug_backtrace()); echo "-->";
	//dt_headerRedirect("index.php?id=$id");
}
?>