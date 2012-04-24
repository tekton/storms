<?php

	require_once("storms2_include.php");

	function create_initial_archive() {
		
		//go through current entries and create entries in the history DB
		
	}

	function description_history_list($id) {
		$g_link = ConnectDB();
		
		$rtn_str = "<histories>\n";
		
		$q = "select a.id as id, a.posted, b.disName as user from `".TBLAPREFIX."_description_history` as a
		 LEFT JOIN (select id, disName from `".TBLAPREFIX."_users`) as b on b.id = a.user
		where link_id = '$id' order by 1 desc limit 10";
		$s = mysql_query($q, $g_link);
		
		while ($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$rtn_str .= "<history>\n";
				$rtn_str .= "\t<user>".$row["user"]."</user>\n";
				$posted = date("Y-m-d", strtotime($row["posted"]));
				$rtn_str .= "\t<posted>".$posted."</posted>\n";
				$rtn_str .= "\t<id>".$row["id"]."</id>\n";
			$rtn_str .= "</history>\n";
		}
		
		$rtn_str .= "</histories>\n";
		
		return $rtn_str;
		
	}
	
	function get_description_history($history_id) {
		$link_id = "";
		$desc = "";
		$posted = "";
		$user = "";
		
		$g_link = ConnectDB();
		$q = "SELECT * FROM `".TBLAPREFIX."_description_history` where id = '$history_id'";
		$s = mysql_query($q, $g_link) or die(mysql_error());
		
		while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$link_id = $row["link_id"];
			$desc = $row["desc"];
			$posted = $row["posted"];
			
			$q = "SELECT disName from `".TBLAPREFIX."_users` WHERE id = '".$row["user"]."'";
			$user_query = mysql_query($q, $g_link) or die(mysql_error());
			while($users = mysql_fetch_array($user_query, MYSQL_BOTH)) {
				$user = $users["disName"];
			}
		}
		
		$q = "SELECT * FROM `".TBLAPREFIX."_TDB` where id = '$link_id'";
		$s = mysql_query($q, $g_link) or die(mysql_error());
		
		while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
			$desc 	= stripslashes($desc);
			$name 	= stripslashes(nameCheck($result["name"]));
			$id 	= stripslashes($result["id"]);
			$type 	= stripslashes($result["type"]);
			$iinBl 	= stripslashes($result["issueInBuild"]);
			$resBl 	= stripslashes($result["resolvedInBuild"]);
			$perta 	= stripslashes($result["pertainsTo"]);
			$paren 	= stripslashes($result["parentIssue"]);
			$by	= stripslashes($result["enteredBy"]);
			$proje 	= stripslashes($result["project"]);
			$flagg 	= stripslashes($result["flagged"]);
			$visib 	= stripslashes($result["visible"]);
		}
		
		echo "<issue id='$id'>";
			echo "<name>".$name."</name>";
			echo "<desc>". xsl_safe_test($desc)."</desc>";
			echo "<type>".$type."</type>";
			echo "<inBuild>".$iinBl."</inBuild>";
			echo "<resolved>".$resBl."</resolved>";
			echo "<pertains>".$perta."</pertains>";
			echo "<by>".$by."</by>";
			echo "<project>".$proje."</project>";
			echo "<visible>".$visib."</visible>";
			echo "<flagged>".$flagg."</flagged>";
			echo "<parent>".$paren."</parent>";
			//echo "<>".$."</>";
			
			echo "<history_user>".$user."</history_user>";
			echo "<history_time>".$posted."</history_time>";
			
			$history_string = description_history_list($id);
			echo $history_string;
			
		echo "</issue>";
		
		$comments = mysql_query("SELECT * FROM ".TBLAPREFIX."_TDB_Comments WHERE pertainsTO=$id ORDER BY dateEntered",$g_link);
		display_comments($comments);
		//if logged in, allow comment input
		if($_SESSION["loggedIn"] == true && $_SESSION["displayName"] != NULL) {echo "<commentInput id='$id'/>";}
	}

?>