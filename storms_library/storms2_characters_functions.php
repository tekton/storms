<?php

	require_once("storms2_include.php");

        /**
         *  if/then switch for character display, creation, search and editing logic 
         */
	function character_logic() {
		if ($_GET["character"]=="install") {
			character_table_creation();
		}
		else if ($_GET["character"]=="new") {
			echo character_view_new();
		}
		else if ($_GET["character"]=="edit") {
			//check for cid in url, if it's not there, go to error page
			character_view_edit($_GET["cid"]);
		}
		else if ($_GET["character"]=="view") {
			character_view_display($_GET["cid"]);
		}
		else if ($_GET["character"]=="list") {
			//list out by name | DOB | Hometown
			$g_link = ConnectDB();
			$q = "SELECT * FROM `".TBLAPREFIX."_characters_info`";
			$s = mysql_query($q, $g_link) or die (mysql_error());
			
			echo xml_head("./xsl/character_list.xsl");
			echo "<root>";
			echo xml_top();
			echo character_view_search_result($s);
			echo "</root>";
		}
	}

	//set of other required files here
	
        /**
         * In order to show the character, the information needs to be retreived somehow...
         * 
         * @method get
         * @param Integer $id The ID of the character from the DB
         * @return string 
         */
	function character_get_info($id) {
		$g_link = ConnectDB();
		
		$rtn_str = "<character>";
		
		$q = "SELECT * FROM `".TBLAPREFIX."_characters_info` where id='$id'";
		$s = mysql_query($q, $g_link) or die (mysql_error());
		while ($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$rtn_str .= "<id>".stripslashes($row["id"])."</id>\n";
			$rtn_str .= "<name>".stripslashes($row["name"])."</name>\n";
			$rtn_str .= "<parent1>".stripslashes($row["parent1"])."</parent1>\n";
			$rtn_str .= "<parent2>".stripslashes($row["parent2"])."</parent2>\n";
			$rtn_str .= "<dob>".stripslashes($row["dob"])."</dob>\n";
			$rtn_str .= "<birth_loc>".stripslashes($row["birth_loc"])."</birth_loc>\n";
			$rtn_str .= "<hometown>".stripslashes($row["hometown"])."</hometown>\n";
			$rtn_str .= "<race>".stripslashes($row["race"])."</race>\n";
			$rtn_str .= "<hair>".stripslashes($row["hair"])."</hair>\n";
			$rtn_str .= "<eyes>".stripslashes($row["eyes"])."</eyes>\n";
			$rtn_str .= "<max_height>".stripslashes($row["max_height"])."</max_height>\n";
			$rtn_str .= "<demeanor>".stripslashes($row["demeanor"])."</demeanor>\n";
			$rtn_str .= "<significant_other>".stripslashes($row["significant_other"])."</significant_other>\n";
			$rtn_str .= "<marital_status>".stripslashes($row["marital_status"])."</marital_status>\n";
			$rtn_str .= "<bio>".stripslashes($row["bio"])."</bio>\n";
			$user = stripslashes($row["user"]);
		}
		
		$q = "SELECT * FROM `".TBLAPREFIX."_characters_tags` where link_id = '$id' ";
		$s = mysql_query($q, $g_link) or die (mysql_error());
		$rtn_str .= "<tags>\n";
		while ($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$rtn_str .= "\t<type>".stripslashes($row["type"])."</type><info>".stripslashes($row["tag"])."</info>\n";
		}
		$rtn_str .= "</tags>\n";
		
		//get user display name
		$q = "SELECT disName from `".TBLAPREFIX."_users` where id = '$user'";
		$s = mysql_query($q, $g_link) or die (mysql_error());
		while ($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$rtn_str .= "<user>".$row["disName"]."</user>\n";
		}
		
		$rtn_str .= "</character>";
		
		return $rtn_str;
	}
	
        /**
         * Get the information to view the character, put the view in XSL
         * 
         * @method get
         * @param Integer $id Character ID in the DB
         */
	function character_view_display($id){
		echo xml_head("./xsl/character_view.xsl");
		echo "<root>";
		echo xml_top();
		echo character_get_info($id);
		echo "</root>";
	}
	
        /**
         * Create the XML entries for each character that's found
         * 
         * @method post
         * @param Results $s Send in the search results
         * @return string 
         */
	function character_view_search_result($s) {
		//$rtn_str = "<characters>";
		
		while ($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$rtn_str .= "<character>";
			
			$rtn_str .= "<id>".stripslashes($row["id"])."</id>\n";
			$rtn_str .= "<name>".stripslashes($row["name"])."</name>\n";

			$rtn_str .= "<dob>".stripslashes($row["dob"])."</dob>\n";
			$rtn_str .= "<birth_loc>".stripslashes($row["birth_loc"])."</birth_loc>\n";
			$rtn_str .= "<hometown>".stripslashes($row["hometown"])."</hometown>\n";
			$rtn_str .= "<race>".stripslashes($row["race"])."</race>\n";
			
			$rtn_str .= "</character>";
		}
		
		//$rtn_str .= "</characters>";
		
		return $rtn_str;
	}
        /**
         * TODO: creation search of characters 
         */
	function character_view_search_form() {}
	
	/**
         * View for creating a new character
         * 
         * @method get
         * @return string 
         */
	function character_view_new() {
		//xml stuff with character_new.xsl
		$rtn_str  = xml_head("./xsl/character_input.xsl");
		$rtn_str .= "\n<root>\n";
		$rtn_str .= xml_top()."\n";
		$rtn_str .= "\t<newCharacter/>\n</root>";
		
		return $rtn_str;
	}
	//unable to find character!
	function character_view_error() {}
	
        /**
         * Get the character information, set XSL to edit mode
         * 
         * @param Integer $id Character ID in the DB
         * @method get
         */
	function character_view_edit($id) {
		echo xml_head("./xsl/character_edit.xsl");
		echo "<root>";
		echo xml_top();
		echo character_get_info($id);
		echo "</root>";
	}
	
	/**
         * Post processing for editing new character 
         * @method post
         */
	function character_edit() {
		$g_link = ConnectDB();
		
		$id = mysql_real_escape_string($_POST["id"]);
		$name = mysql_real_escape_string($_POST["name"]);
		$parent1 = mysql_real_escape_string($_POST["parent1"]);
		$parent2 = mysql_real_escape_string($_POST["parent2"]);
		$dob = mysql_real_escape_string($_POST["dob"]);
		$birth_loc = mysql_real_escape_string($_POST["birth_loc"]);
		$hometown = mysql_real_escape_string($_POST["hometown"]);
		$race = mysql_real_escape_string($_POST["race"]);
		$hair = mysql_real_escape_string($_POST["hair"]);
		$eyes = mysql_real_escape_string($_POST["eyes"]);
		$max_height = mysql_real_escape_string($_POST["max_height"]);
		$demeanor = mysql_real_escape_string($_POST["demeanor"]);
		$significant_other = mysql_real_escape_string($_POST["significant_other"]);
		$marital_status = mysql_real_escape_string($_POST["marital_status"]);
		$bio = mysql_real_escape_string($_POST["bio"]);
		
		$q = "UPDATE `".TBLAPREFIX."_characters_info` SET
		
			name = '$name',
			parent1 = '$parent1',
			parent2 = '$parent2',
			dob = '$dob',
			birth_loc = '$birth_loc',
			hometown = '$hometown',
			race = '$race',
			hair = '$hair',
			eyes = '$eyes',
			max_height = '$max_height',
			demeanor = '$demeanor',
			significant_other = '$significant_other',
			marital_status = '$marital_status',
			bio = '$bio'
		
		where id = '$id'";
		
		$s = mysql_query($q, $g_link) or die (mysql_error());
		
		dt_headerRedirect("index.php?character=view&cid=$id");
	}
	
        /**
         * Post handling for character creation 
         */
	function character_create() {
		
		$g_link = ConnectDB();
		
		$name = mysql_real_escape_string($_POST["name"]);
		$parent1 = mysql_real_escape_string($_POST["parent1"]);
		$parent2 = mysql_real_escape_string($_POST["parent2"]);
		$dob = mysql_real_escape_string($_POST["dob"]);
		$birth_loc = mysql_real_escape_string($_POST["birth_loc"]);
		$hometown = mysql_real_escape_string($_POST["hometown"]);
		$race = mysql_real_escape_string($_POST["race"]);
		$hair = mysql_real_escape_string($_POST["hair"]);
		$eyes = mysql_real_escape_string($_POST["eyes"]);
		$max_height = mysql_real_escape_string($_POST["max_height"]);
		$demeanor = mysql_real_escape_string($_POST["demeanor"]);
		$significant_other = mysql_real_escape_string($_POST["significant_other"]);
		$marital_status = mysql_real_escape_string($_POST["marital_status"]);
		$bio = mysql_real_escape_string($_POST["bio"]);
		$user = created_by_id();
		
		$q = "INSERT INTO `".TBLAPREFIX."_characters_info` (`name`,
		`parent1`,
		`parent2`,
		`dob`,
		`birth_loc`,
		`hometown`,
		`race`,
		`hair`,
		`eyes`,
		`max_height`,
		`demeanor`,
		`significant_other`,
		`marital_status`,
		`bio`,
		`user`) VALUES ('$name',
		'$parent1',
		'$parent2',
		'$dob',
		'$birth_loc',
		'$hometown',
		'$race',
		'$hair',
		'$eyes',
		'$max_height',
		'$demeanor',
		'$significant_other',
		'$marital_status',
		'$bio',
		'$user')";
		
		$s = mysql_query($q, $g_link) or die (mysql_error());
		$id = mysql_insert_id($g_link);
		dt_headerRedirect("index.php?character=view&cid=$id");
	}
	
	//character table creation -- aka install
	function character_table_creation() {
		$q = "CREATE TABLE `".TBLAPREFIX."_characters_info` (
		  `id` int(11) DEFAULT NULL,
		  `name` int(11) DEFAULT NULL,
		  `parent1` int(11) DEFAULT NULL,
		  `parent2` int(11) DEFAULT NULL,
		  `dob` int(11) DEFAULT NULL,
		  `birth_loc` int(11) DEFAULT NULL,
		  `hometown` int(11) DEFAULT NULL,
		  `race` int(11) DEFAULT NULL,
		  `hair` int(11) DEFAULT NULL,
		  `eyes` int(11) DEFAULT NULL,
		  `max_height` int(11) DEFAULT NULL,
		  `demeanor` varchar(255) DEFAULT NULL,
		  `significant_other` int(11) DEFAULT NULL,
		  `marital_status` int(11) DEFAULT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1";
	}

?>