<?php

require_once("storms2_include.php");

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
	$s = mysql_query($q, $g_link);

	$str = "";

	if(!$s) {
		$str = "Couldn't create History table...maybe it already exists? Let see what happened... ".mysql_error();
	} else {
		$str = "History table created!";
		//go back and create entries?
	}
	
	return $str;
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
	$s = mysql_query($q, $g_link);
	
	$str = "";
	
	if(!$s) {
		$str = "Couldn't create Character table...maybe it already exists? Let see what happened... ".mysql_error();
	} else {
		$str = "Character table created!";
	}
	
	return $str;
}

function update_milestone_1() {

	$g_link = ConnectDB();

	$q = "CREATE TABLE `".TBLAPREFIX."_characters_tags` (id INT)"; $s = mysql_query($q, $g_link);
	$q = "CREATE TABLE `".TBLAPREFIX."_outlines_tags` (id INT)"; $s = mysql_query($q, $g_link);
	
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` ADD `bio` text NULL DEFAULT NULL  AFTER `marital_status`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` ADD `user` int NULL DEFAULT NULL  AFTER `bio`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `birth_loc` `birth_loc` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `birth_loc` `birth_loc` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `eyes` `eyes` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `eyes` `eyes` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `hair` `hair` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `hair` `hair` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `hometown` `hometown` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `hometown` `hometown` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `id` `id` int(11) NOT NULL  auto_increment PRIMARY KEY"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `max_height` `max_height` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `max_height` `max_height` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `name` `name` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `race` `race` varchar(11) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `race` `race` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` CHANGE `significant_other` `significant_other` int(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` ADD `link_id` int NULL DEFAULT NULL  AFTER `id`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` ADD `tag` int NULL DEFAULT NULL  AFTER `link_id`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` ADD `type` int NULL DEFAULT NULL  AFTER `tag`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` CHANGE `tag` `tag` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` CHANGE `type` `type` varchar(255) NULL DEFAULT NULL"; $s = mysql_query($q, $g_link);
	
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` ADD `link_id` int NULL DEFAULT NULL  AFTER `type`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` ADD `tag` varchar(255) NULL DEFAULT NULL  AFTER `id`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` ADD `type` varchar(255) NULL DEFAULT NULL  AFTER `tag`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` CHANGE `id` `id` int(11) NULL  auto_increment PRIMARY KEY"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` MODIFY COLUMN `link_id` int(11) DEFAULT NULL AFTER `id`"; $s = mysql_query($q, $g_link);
	
	$q = "ALTER TABLE `".TBLAPREFIX."_TDB` ADD `desc_id` int(11) NULL DEFAULT NULL  AFTER `flagged`"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_TDB` ADD `milestone` varchar(255) NULL DEFAULT NULL  AFTER `desc_id`"; $s = mysql_query($q, $g_link);
	

	return "Attempted to create outline and character tag tables. Also, changed a lot of characters_info...or at least so the theory goes";

}

function user_login_tracking() {
	$g_link = ConnectDB();
	$q = "CREATE TABLE `".TBLAPREFIX."_login_tracking` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `who` binary(11) NOT NULL,
	  `attempted_hash` binary(11) NOT NULL,
	  `attempted_ip` varchar(255) NOT NULL,
	  `when` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `success` tinyint(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1";
	$s = mysql_query($q, $g_link);
	
	echo "Attempted to create user login tracking database";
}

function update_login_tracking() {
	$g_link = ConnectDB();

	$q = "ALTER TABLE `".TBLAPREFIX."_login_tracking`ADD `browser` varchar(255) NULL DEFAULT NULL  AFTER `success`"; $s = mysql_query($q, $g_link);
	$s = mysql_query($q, $g_link);
	
	$str = "";
	
	if(!$s) {
		$str = "Couldn't alter login tracking table...maybe it already exists? Let see what happened... ".mysql_error();
	} else {
		$str = "Login checking table altered!";
	}
	
	return $str;
}

function update_290() {
	$g_link = ConnectDB();
	
	$q = "ALTER TABLE `".TBLAPREFIX."_outlines_tags` TYPE = InnoDB"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_milestone_list` TYPE = InnoDB"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_description_history` TYPE = InnoDB"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_tags` TYPE = InnoDB"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_characters_info` TYPE = InnoDB"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_login_tracking` CHANGE `who` `who` binary(32) NOT NULL"; $s = mysql_query($q, $g_link);
	$q = "ALTER TABLE `".TBLAPREFIX."_login_tracking` CHANGE `attempted_hash` `attempted_hash` binary(32) NOT NULL"; $s = mysql_query($q, $g_link);
	
	$q = "CREATE TABLE `".TBLAPREFIX."_project_sections` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `p_id` int(11) DEFAULT NULL,
	  `section_name` varchar(255) DEFAULT NULL,
	  `section_base_notes` text,
	  `section_hover_text` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
	$s = mysql_query($q, $g_link);
	
	$q = "CREATE TABLE `".TBLAPREFIX."_project_notes` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `p_id` int(11) DEFAULT NULL,
	  `project_section_id` int(11) DEFAULT NULL,
	  `tag_title` varchar(255) DEFAULT NULL,
	  `tag_note` text,
	  `created` timestamp NULL DEFAULT NULL,
	  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COMMENT='project_section_id is the link ID to _project_sections'";
	$s = mysql_query($q, $g_link);
	
	return "Altered lots of tables...hope that worked!";
}

if($_GET) {
	
	$message = "";
	
	if($_GET["msone"]=="install") {
		$message .= "<div>".create_character_table()."</div>";
		$message .= "<div>".create_history_table()."</div>";
		$message .= "<div>".user_login_tracking()."</div>";
		$message .= "<div>".update_milestone_1()."</div>";
	} else {
		$message .= "<div>".update_290()."</div>";
	}
	
	echo $message;
	
} else {
	dt_headerRedirect("../index.php");
}

?>