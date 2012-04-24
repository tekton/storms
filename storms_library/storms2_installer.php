<?php

	require_once("storms2_db.php"); //can't include other files as there's a chance they won't exist yet!

	/*** This function controls the Install process in order ***/
	function install_brain() {
		/* START Post section deciphering */
		$db 		= $_POST["db"];
		$user 		= $_POST["user"];
		$password 	= $_POST["pass"];
		$host 		= $_POST["host"];
		$prefix 	= $_POST["prefix"];
		
		$a_user		=  MD5($_POST["auser"]);
		$a_pass		=  MD5($_POST["apass"]);
		$a_disp		= $_POST["adisp"];
		
		/* END   Post section deciphering*/
		
		echo "Attempting to start install stuff...<br />";
		
		create_gdef_file($db, $user, $password, $host, $prefix, $g_link);
		
		require_once("storms2_gdef.php");
		
		$g_link = mysql_connect($host, $user, $password) or die('Could not connect to server.');
		
		create_database($db, $g_link);
		
		$g_link = ConnectDB();
		
		create_user_table($prefix, $g_link);
		create_main_table($prefix, $g_link);
		create_comments_table($prefix, $g_link);
		create_project_info_table($prefix, $g_link);
		create_eyeD_table($prefix, $g_link);
		//Once the outlines are created, create the main user
		
		$query = "INSERT INTO ".$prefix."_users (`us3r`, `pazz`, `disName`) VALUES ('$a_user', '$a_pass', '$a_disp')";
		mysql_query($query) or die("Could not insert data because ".mysql_error());
		
		// TODO: Once the user is created, create the base project info <-- NYI
		
	}

	function create_gdef_file($db, $user, $password, $host, $prefix, $g_link) {
		/* Create the file "storms2_gdef.php" to be used to store base information about the applications database access */
		
		$file_string = "<?php

		/*start global variables */
		define('DB', '$db');			// Database name -- all lower case OR uppercase, not both
		define('USER', '$user');				// MySQL username
		define('PASSWORD', '$password');		// MySQL password
		define('HOST', '$host');		// location of MySQL server
		define('TBLAPREFIX', '$prefix');		// In order to maintain multiple installs
		/*end global variables*/\n?>";
		
		$file = fopen("storms2_gdef.php", "w");
		$f_write = fwrite($file, $file_string);
		fclose($file);
		
		//Check to see if the write was successful, if so carry on, if not error out and kill the install
		echo "gdef file creation attempted...<br />";
	}

	function create_database($db, $g_link) {
		echo "Attempting to create database...<br />";
		$q = "CREATE DATABASE IF NOT EXISTS `$db`";
		mysql_query($q, $g_link) or die ("Error: ".mysql_error());
	}

	function create_user_table($prefix, $g_link) {
		echo "Attempting to create user table...<br />";
		$q = "CREATE TABLE IF NOT EXISTS `".$prefix."_users` (
			  `id` int(11) NOT NULL auto_increment,
			  `us3r` binary(32) default NULL,
			  `pazz` binary(32) default NULL,
			  `disName` varchar(255) default NULL,
			  `3mail` varchar(255) default NULL,
			  `credz` int(11) default '2',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `us3r` (`us3r`),
			  UNIQUE KEY `disName` (`disName`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1";
		mysql_query($q, $g_link) or die ("CUT: ".mysql_error());
	}

	function create_main_table($prefix, $g_link) {
		echo "Attempting to create main table...<br />";
		$q = "CREATE TABLE IF NOT EXISTS `".$prefix."_TDB` (
		  `id` int(20) NOT NULL,
		  `name` text NOT NULL,
		  `description` text NOT NULL,
		  `dateEntered` timestamp NULL default NULL,
		  `dateModified` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
		  `issueInBuild` text NULL,
		  `resolvedInBuild` text NULL,
		  `type` varchar(255) NULL,
		  `sevarity` varchar(255) NULL,
		  `pertainsTo` varchar(255) NULL,
		  `parentIssue` varchar(255) NULL,
		  `project` varchar(255) NOT NULL,
		  `enteredBy` varchar(256) NOT NULL,
		  `visible` varchar(1) NOT NULL default '1',
		  `flagged` varchar(20) NOT NULL default 'entered',
		  KEY `id` (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		mysql_query($q, $g_link) or die (mysql_error());
	}

	function create_comments_table($prefix, $g_link) {
		echo "Attempting to create comments table...<br />";
		$q = "CREATE TABLE IF NOT EXISTS `".$prefix."_TDB_Comments` (
		  `id` bigint(20) NOT NULL auto_increment,
		  `pertainsTo` bigint(20) NOT NULL,
		  `title` text NOT NULL,
		  `description` text NOT NULL,
		  `dateEntered` timestamp NOT NULL default CURRENT_TIMESTAMP,
		  `dateModified` timestamp NULL default NULL,
		  `visible` binary(1) NOT NULL,
		  `enteredBy` text NOT NULL,
		  KEY `id` (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1";
		mysql_query($q, $g_link) or die (mysql_error());
	}

	function create_project_info_table($prefix, $g_link) {
		echo "Attempting to create project info table...<br />";
		$q = "CREATE TABLE IF NOT EXISTS `".$prefix."_project_base_info` (
		  `p_id` int(11) NOT NULL auto_increment,
		  `title` varchar(255) NOT NULL,
		  `philosophy` text NOT NULL,
		  `url_conv` text NOT NULL,
		  `parameter_conv` text NOT NULL,
		  `language` varchar(255) NOT NULL,
		  `language_conv` text NOT NULL,
		  `ofp` varchar(255) NOT NULL,
		  `logo` varchar(255) NOT NULL,
		  `svn_loc` varchar(255) NOT NULL,
		  `stage` varchar(40) NOT NULL,
		  `createdOn` timestamp NULL default NULL,
		  `updatedOn` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  PRIMARY KEY  (`p_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		mysql_query($q, $g_link) or die (mysql_error());
	}

	function create_eyeD_table($prefix, $g_link) {
		echo "Attempting to create eyeD...<br />";
		$q = "CREATE TABLE IF NOT EXISTS `".$prefix."_eyeD` (
		  `id` bigint(20) default NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		mysql_query($q, $g_link) or die (mysql_error());
		$q = "INSERT into `".$prefix."_eyeD` (id) VALUES ('0')";
		mysql_query($q, $g_link) or die (mysql_error());
	}

	function create_character_table() {
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
		$g_link = ConnectDB();
		$s = mysql_query($q, $g_link) or die (mysql_error());
	}
	
	function create_history_table() {
		$q = "CREATE TABLE `".TBLAPREFIX."_description_history` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `link_id` int(11) DEFAULT NULL,
		  `posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `desc` text,
		  `user` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
		$g_link = ConnectDB();
		$s = mysql_query($q, $g_link) or die (mysql_error());
	}

	if(!$_POST) {
		header("content-type:text/xml;charset=utf-8");
		session_start();
		echo '<?xml version="1.0"?>';
		echo '<?xml-stylesheet type="text/xsl" href="../xsl/installer.xsl"?>';
		echo "<root/>";
	}
	else {
		foreach ($_POST as $key => $value) {
		    //echo "<pre>Key: $key; Value: $value</pre>\n";  //DEBUG OPTION
		}
		install_brain();
	}
?>
