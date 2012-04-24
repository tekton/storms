<?php

	function displayHead($container="container") {
		
		echo '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<title>storms2 test page</title>

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="generator" content="TextMate http://macromates.com/" />
			<meta name="author" content="Tyler Agee" />
			<!-- Date: 2007-07-22 -->
			<link rel="stylesheet" type="text/css" href="main.css" media="screen" />
		</head>
		<body>';

		displayTop();

		echo '<div id="'.$container.'">';
		
	}
	
	function xml_top() {
		if($_SESSION["loggedIn"] == true && $_SESSION["displayName"] != NULL) {
			/*echo "<user>";
				echo "<name>".$_SESSION["displayName"]."</name>";
			echo "</user>";*/
			
			$rtn_str = "<user>"."<name>".$_SESSION["displayName"]."</name>"."</user>";
			return $rtn_str;
		}
		else {
			//echo "<user/>";
			return "<user/>";
		}
	}
	
	function xml_head($stylesheet="display.xsl") {
		header("content-type:text/xml;charset=utf-8");
		return "<?xml version=\"1.0\"?>\n<?xml-stylesheet type=\"text/xsl\" href=\"$stylesheet\"?>";
	}
	
	function display_top() {}
	
	function displayTop() {
		
		//change most of this to xslt; only the login/logout should be conditional
		
		echo "\n\n<div id='top'>\n\t";
		echo '
		<div class="top_search">
		<form action="index.php" method="POST">
		<input type="hidden" name="searchCheck" id="searchCheck" value="true" />
		<input type="text" name="search" id="search" />
		<input type="submit" value="search" name="searchButton" id="searchButton" />
		</form></div>';
			echo '<div class="top_left"><a href="index.php">PROJECT NAME</a> | ';
			echo '<a href="?new=true">New</a> | Reports ';
			echo '[0001]&nbsp;';
			if($_SESSION["loggedIn"] == true && $_SESSION["displayName"] != NULL) {
				echo "Logged in as: ".$_SESSION["displayName"]. "- <a href='?logout=true'>Logout</a>";
			}
			else {echo "<a href='?login=true'>Login</a>";}
			echo '</div>'."\n\t"; //need to pull from the database
		echo '</div>
		<div class="cBoth"></div>
		';
	}
	
	function issueInformation($search) {
		echo "<root>";
		echo xml_top();
		while ($result = mysql_fetch_array($search, MYSQL_BOTH)) {

		$desc 	= stripslashes($result["description"]);
		$name 	= stripslashes(nameCheck($result["name"]));
		$id 	= stripslashes($result["id"]);
		$type 	= stripslashes($result["type"]);
		$iinBl 	= stripslashes($result["issueInBuild"]);
		$resBl 	= stripslashes($result["resolvedInBuild"]);
		$perta 	= stripslashes($result["pertainsTo"]);
		$paren 	= stripslashes($result["parentIssue"]);
		$by		= stripslashes($result["enteredBy"]);
		$proje 	= stripslashes($result["project"]);
		$flagg 	= stripslashes($result["flagged"]);
		$visib 	= stripslashes($result["visible"]);
		
		$milestone 	= stripslashes($result["milestone"]);
		
		echo "<issue id='$id'>";
			echo "<name>".$name."</name>";
			echo "<desc>". xsl_safe_test($desc)."</desc>";
			echo "<type>".xsl_safe_test($type)."</type>";
			echo "<inBuild>".$iinBl."</inBuild>";
			echo "<resolved>".$resBl."</resolved>";
			echo "<pertains>".xsl_safe_test($perta)."</pertains>";
			echo "<by>".xsl_safe_test($by)."</by>";
			echo "<project>".xsl_safe_test($proje)."</project>";
			echo "<visible>".$visib."</visible>";
			echo "<flagged>".$flagg."</flagged>";
			echo "<parent>".$paren."</parent>";
			echo "<milestone>".$milestone."</milestone>";
			//echo "<>".$."</>";
			
			$history_string = description_history_list($id);
			echo $history_string;
			
		echo "</issue>";
		//issueDisplay($desc, $name, $id);
		}
		
		$g_link = ConnectDB();
		$comments = mysql_query("SELECT * FROM ".TBLAPREFIX."_TDB_Comments WHERE pertainsTO=$id ORDER BY dateEntered",$g_link);
		display_comments($comments);
		//if logged in, allow comment input
		if($_SESSION["loggedIn"] == true && $_SESSION["displayName"] != NULL) {echo "<commentInput id='$id'/>";}
		echo "</root>";
	}

	function issueDisplay ($desc, $name, $id) {
		echo "<issue id='$id'>";
			echo "<name>".$name."</name>";
			echo "<desc>".$desc."</desc>";
		echo "</issue>";
	}

	function display_comments($search) {
		echo "<comments>";
		while ($result = mysql_fetch_array($search, MYSQL_BOTH)) {
			echo '<comment>';
				echo '<title>'.stripslashes($result["title"]).'</title>';
				echo '<by>'.stripslashes(nameCheck($result["enteredBy"])).'</by>';
				echo '<time>'.stripslashes($result["dateEntered"]).'</time>';
				echo '<data>'.stripslashes($result["description"]).'</data>';
			echo '</comment>';
		}
		echo "</comments>";
	}

	function getData($id) {
		$g_link = ConnectDB();
		$result = mysql_query("SELECT * FROM ".TBLAPREFIX."_TDB WHERE id=$id",$g_link);
		issueInformation($result);
		
		//echo "<!--"; var_dump(debug_backtrace()); echo "-->";
		
	}

	function commentInput($id) {
		echo '
				<!--<div class="cBoth">&nbsp;</div>-->
				<form action="index.php?id='.$id.'" method="POST">
				<div class="comment_top">&nbsp;<input type="text" id="comment_title" name="comment_title" /></div>
				<div class="comment_data">
					<textarea name="comment_text" rows="5" cols="60"></textarea>
				</div>
				<input type="hidden" name="id" id="id" value="'.$id.'" />
				<input type="hidden" name="newComment" id="newComment" value="true" />
				<input type="submit">
				</form>
			</div>

			</body>
			</html>
		';
	}
	
	function display_end() {
		echo '
			</div><!-- end container -->

			</body>
			</html>
		';
	}

	function newEntry() {
		echo '<form action="index.php" method="POST">
			<input type="hidden" name="newInput" id="newInput" value="true" />
		<div class="information">
			<div class="information_top">&nbsp;information</div>
			<div class="information_bottom">
				<!-- Design choice: drop down or fill out for these... -->

				<div class="cBoth">
					<div class="cLeft">type</div>
					<div class="cRight"><input type="text" id="type" name="type" size="10" /></div>
				</div>


				<div class="cBoth">
					<div class="cLeft">in build</div>
					<div class="cRight"><input type="text" id="in_build" name="in_build" size="10" /></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">resolved in</div>
					<div class="cRight"><input type="text" id="resolved_in" name="resolved_in" size="10" /></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">pertains to</div>
					<div class="cRight"><input type="text" id="pertains_to" name="pertains_to" size="10" /></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">parent issue</div>
					<div class="cRight"><input type="text" id="parent_issue" name="parent_issue" size="10" /></div>
				</div>
				<div class="cBoth"><div class="cLeft">project</div><div class="cRight"><input type="text" id="project" name="project" size="10" value="'.$project.'" /></div></div>

				<div class="cBoth">&nbsp;</div>

			</div>
		</div>


		<div class="issue">
			<div class="issue_top">&nbsp;<input type="text" id="issue_title" value="title" name="issue_title" size="60" /></div>
			<div class="issue_content">
				<textarea name="issue_text" rows="10" cols="60"></textarea>
			</div>
		</div>
		<!--<div class="cBoth">&nbsp;</div>-->

		<input type="submit">
		</form>';
	}

	function nameCheck($name) {
		
		if($name == "") {
			$name = "---";
		}
		
		return xsl_safe_test($name);
	}

	function dt_headerRedirect($link="index.php") {
		header("content-type:text/html;charset=utf-8");
		echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
		<meta http-equiv="refresh" content="0; URL='.$link.'" />
		</head>
		</html>';
	}

	function display_topTen($search) {
		
		$rtn_str = "<root>";
		$rtn_str .= xml_top();
		while ($result = mysql_fetch_array($search, MYSQL_BOTH)) {
			if($result["visible"]=="0") { } //check to see if the "issue" should be comming up in searches
				else {
				$name = stripslashes(nameCheck($result["name"]));
				$type = stripslashes(nameCheck($result["type"]));
				$inBuild = stripslashes(nameCheck($result["issueInBuild"]));
				$resolved = stripslashes(nameCheck($result["resolvedInBuild"]));
				$pertains = stripslashes(nameCheck($result["pertainsTo"]));
				$entered = stripslashes(nameCheck($result["dateEntered"]));
				$project = stripslashes(nameCheck($result["project"]));
				$dateModified = stripslashes(nameCheck($result["dateModified"]));
				
				$flagged = stripslashes(nameCheck($result["flagged"]));
				
				$sevarity = stripslashes(nameCheck($result["sevarity"]));
				$parentIssue = stripslashes(nameCheck($result["parentIssue"]));
				$visible = stripslashes(nameCheck($result["visible"]));
				$flagged = stripslashes(nameCheck($result["flagged"]));
				
				$id = $result["id"];
				$rtn_str .= "<result>";
					$rtn_str .= "<id>$id</id>";
					$rtn_str .= "<name>$name</name>";
				
					$rtn_str .= "<type>$type</type>";
					$rtn_str .= "<inBuild>$inBuild</inBuild>";
					$rtn_str .= "<resolved>$resolved</resolved>";
					$rtn_str .= "<pertains>$pertains</pertains>";
					$rtn_str .= "<entered>$entered</entered>";
					$rtn_str .= "<modified>$dateModified</modified>";
					$rtn_str .= "<project>$project</project>";
					
					$rtn_str .= "<flagged>$flagged</flagged>";
					
					$rtn_str .= "<sevarity>$sevarity</sevarity>";
					$rtn_str .= "<parentIssue>$parentIssue</parentIssue>";
					$rtn_str .= "<visible>$visible</visible>";
					$rtn_str .= "<flagged>$flagged</flagged>";
					
				$rtn_str .= "</result>"."\n";
				$count++;
			}
		}
		$rtn_str .= "</root>";
		
		return $rtn_str;
	}
	
	function defaultAction() {
		$str = xml_head("display.xsl");
		$g_link = ConnectDB();
		$result = mysql_query("SELECT * FROM ".TBLAPREFIX."_TDB WHERE id > 0 ORDER BY dateEntered DESC",$g_link);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		else {
			$str .= display_topTen($result);
		}
		
		echo $str;
	}
	
	function login_screen() {
		displayHead();
		display_user_login();
		echo '
			</div><!-- end container -->
			</body>
			</html>
		';
	}
	
	function xsl_safe_test($string) {
		//preg strings to make sure that text will output correctly
		$string = preg_replace('/\&/', '&amp;', $string);
		$string = preg_replace('/\</', '&lt;', $string);
		$string = preg_replace('/\>/', '&gt;', $string);
		
		return $string;
	}
	
	function spaces_strip($string) {
		$string = preg_replace('/ /', '_', $string);
		
		return $string;
	}

	function created_by_id() {
		//$g_link = ConnectDB();
		
		$enteredBy			=		$_SESSION["displayName"];
		$enteredByID		=		0;

		$q = "SELECT id FROM ".TBLAPREFIX."_users WHERE disName='$enteredBy'";
		$s = mysql_query($q);
		while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
			$enteredByID = $result["id"];
		}
		
		return $enteredByID;
	}

?>