<?php

require_once("./storms_library/storms2_include.php");

class pm {
	public $g_link = "";
	
	public $id = "";
	
	public $title = "";
	public $description = "";
	
	public $logo_url = "";
	public $active_section = "";
	
	//public $sections = array();
	public $sections_string = "";
	public $section_string = "";
	
        /**
         * Section is optional
         * 
         * @param Int $id the project ID in the DB
         * @param Int $section the section of the page to show
         */
	function __construct($id, $section=0) {
		$this->id = $id;
		$this->active_section = $section;
		$this->g_link = ConnectDB();
		
		$this->get_sections();
		$this->get_section_notes();
		$this->get_logo();
	}
	
	function get_sections() {
		//get sections from TBLAPREFIX_project_sections -- this also gives on_hover and alt text
		$q = "SELECT * from `".TBLAPREFIX."_project_sections` where p_id='$this->id'";
		$s = mysql_query($q, $this->g_link);
		//new pm_section for each result
		while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			if($row["id"]==$this->active_section) {
				$sec = "section_active";
				$this->title = $row["section_name"];
				$this->description = $row["section_base_notes"];
			} else {
				$sec = "section";
			}
			$this->sections_string .= "<section class=\"$sec\" disp=\"".$row["section_name"]."\" link=\"?project=".$this->id."&amp;section=".$row["id"]."\" />";
		}
	}
	
	function get_section_notes() {
		$q = "SELECT * from `".TBLAPREFIX."_project_notes` where p_id='$this->id' AND project_section_id = '$this->active_section'";
		$s = mysql_query($q, $this->g_link) or die(mysql_error());
		$this->section_string = "<section>";
		while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			//MUST check XML safe on many parts of this one...
			$note_id = $row["id"];
			$title = $row["tag_title"];
			$tag_note = $row["tag_note"];
			$created = $row["created"];
			$modified = $row["modified"];
			
			
				$this->section_string .= "<tag>";
					$this->section_string .= "<title>".$title."</title>";
					$this->section_string .= "<created>".$created."</created>";
					$this->section_string .= "<modified>".$modified."</modified>";
					$this->section_string .= "<text>".$tag_note."</text>";
				$this->section_string .= "</tag>";
		}
		$this->section_string .= "</section>";		
	}
	
	function get_logo() {
		$q = "SELECT * from `".TBLAPREFIX."_project_base_info` where p_id='$this->id'";
		$s = mysql_query($q, $this->g_link) or die(mysql_error());
		while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
			$this->logo_url = $row["logo"];
		}
	}
}

class pm_section {
	public $name = "";
	public $url = "";
	public $alt_text = "";
	public $hover_text = "";
	public $base_text = "";
}
/*

On an empty get, show all of the projects that the person can see

On an id get, show that projects options, status, etc.
	If edit=true is with it, show edit options

Design option: a second library, or it's own set of pages?
	Own set creates a "seamless" url pedigree
	Library means that people can't always get to it as easily when it's all they want

*/


function get_project_info($id) {
	
	$q = "SELECT * FROM `".TBLAPREFIX."_project_base_info` where id='$id'";
	/*
	Project Title - varchar(255)
	Philosophy - Text
	URL Convention - Text
	Parameters Convention - Text
	Language - varchar(40)
	Language Conventions - Text
	Objects or Functions or Procedural - 
	Logo - Blob or URL
	SVN Location - varchar(255)
	Stage (Alpha, Beta, Planning, Release) - Varchar(40)
	created - timestamp
	edited - timestamp - on_update
	*/
	
}

function project_new_gui() {
	//xml_head("./xsl/project_new.xsl");
	echo '
<center>
<input name="title" display="Title" type="text"/>

<input name="stage" display="Stage"/>
<input name="svn" display="SVN"/>
<input name="logo" display="Logo"/>

<input name="philosophy" display="Philosophy" type="textarea"/>
<input name="url_conv" display="URL Conventions" type="textarea"/>
<input name="parameter_conv" display="Parameter Conventions" type="textarea"/>
<input name="language" display="Language(s)" type="text"/>
<input name="language_conv" display="Language Conventions" type="textarea"/>
<f_type name="newProject" value="true"/>
</center>
';
	echo "</root>";
	
}

function project_edit_gui($id) {
	$g_link = ConnectDB();
	$q = "SELECT * FROM `".TBLAPREFIX."_project_base_info` WHERE p_id = '$id'";
	$search = mysql_query($q, $g_link) or die ("SQL Call failed: ".mysql_error());
	
	echo xml_head("./xsl/project_new.xsl");
	echo "<root>";
	echo xml_top();
	
	while($project = mysql_fetch_array($search, MYSQL_BOTH)) {
		echo '<center>
		<input name="title" display="Title" type="text" value="'.$project["title"].'"/>

		<input name="stage" display="Stage" value="'.$project["stage"].'"/>
		<input name="svn" display="SVN" value="'.$project["svn_loc"].'"/>
		<input name="logo" display="Logo" value="'.$project["logo"].'"/>

		<input name="philosophy" display="Philosophy" type="textarea">'.$project["philosophy"].'</input>
		<input name="url_conv" display="URL Conventions" type="textarea">'.$project["url_conv"].'</input>
		<input name="parameter_conv" display="Parameter Conventions" type="textarea">'.$project["parameter_conv"].'</input>
		<input name="language" display="Language(s)" type="text" value="'.$project["language"].'"/>
		<input name="language_conv" display="Language Conventions" type="textarea">'.$project["language_conv"].'</input>
		<f_type name="pm_edit" value="true"/>
		<f_type name="pm_id" value="'.$project["p_id"].'"/>
		</center>';
	}
	
	echo "</root>";
	
}

function project_create() {
	if($_SESSION["loggedIn"] != true ) { dt_headerRedirect("index.php?login=true"); exit; }
	
	$date = date("Y-m-d H:i:s.0");
	$g_link = ConnectDB();
	
	$title	= $_POST["title"];
	
	$stage	= $_POST["stage"];
	$svn	= $_POST["svn"];
	$logo	= $_POST["logo"];
	
	$phil	= $_POST["philosophy"];
	$uconv	= $_POST["url_conv"];
	$pconv	= $_POST["parameter_conv"];
	$lang	= $_POST["language"];
	$lconv	= $_POST["language_conv"];
	
	//print_r($_POST); //DEBUG OPTION
	
	$q = "INSERT INTO `".TBLAPREFIX."_project_base_info` 
		(`title`, `stage`, `svn_loc`, `logo`, `philosophy`, `url_conv`, `parameter_conv`, `language`, `language_conv`, `createdOn`) 
		VALUES ('$title', '$stage', '$svn', '$logo', '$phil', '$uconv', '$pconv', '$lang', '$lconv', '$date')";
	//echo "<!--".$q."-->";
	mysql_query($q) or die("Could not insert data because ".mysql_error());
	
	echo "<!--".$q."-->";
	dt_headerRedirect("index.php?pm_list=true");
}

function project_edit($id) {
	
	/*
		Get the information to check it out to see what changes
	*/
	
	if($_SESSION["loggedIn"] != true ) { dt_headerRedirect("index.php?login=true"); exit; }
	
	$g_link = ConnectDB();
	
	$title	= $_POST["title"];
	
	$stage	= $_POST["stage"];
	$svn	= $_POST["svn"];
	$logo	= $_POST["logo"];
	
	$phil	= $_POST["philosophy"];
	$uconv	= $_POST["url_conv"];
	$pconv	= $_POST["parameter_conv"];
	$lang	= $_POST["language"];
	$lconv	= $_POST["language_conv"];
	
	$change_comment="";
	
	$q = "SELECT * FROM `".TBLAPREFIX."_project_base_info` WHERE p_id = '$id'";
	$search = mysql_query($q, $g_link) or die ("SQL Call failed: ".mysql_error());
	
	while($project = mysql_fetch_array($search, MYSQL_BOTH)) {
		if($project["title"]			!= $title)	{$change_comment .= "Title changed from ".$project["title"]." to ".$title."\n";}
		if($project["svn_loc"]			!= $svn) 	{$change_comment .= "SVN changed from ".$project["svn_loc"]." to ".$svn."\n";}
		if($project["stage"]			!= $stage)	{$change_comment .= "Stage changed from ".$project["stage"]." to ".$stage."\n";}
		if($project["logo"]				!= $logo) 	{$change_comment .= "Logo changed from ".$project["logo"]." to ".$logo."\n";}
		if($project["philosophy"]		!= $phil) 	{$change_comment .= "Philisophy changed from ".$project["philosophy"]." to ".$phil."\n";}
		if($project["url_conv"]			!= $uconv) 	{$change_comment .= "URL Convention changed from ".$project["url_conv"]." to ".$uconv."\n";}
		if($project["parameter_conv"]	!= $pconv) 	{$change_comment .= "Parameter Conevention changed from ".$project["parameter_conv"]." to ".$pconv."\n";}
		if($project["language"]			!= $lang) 	{$change_comment .= "Language(s) changed from ".$project["language"]." to ".$lang."\n";}
		if($project["language_conv"]	!= $lconv) 	{$change_comment .= "Language Conventions changed from ".$project["language_conv"]." to ".$lconv."\n";}
	}
	
	echo "<change_log>";
		echo $change_comment;
	echo "</change_log>";
	
	//Set the new values
	//Call the comment code with the Change Log
	//Edit the change log?
	//redirect to view the project, that way the new info will be there with the change log at the bottom
	
	
}

function projects_list() {
	
	$q = "SELECT * FROM `".TBLAPREFIX."_project_base_info`";
	$g_link = ConnectDB();
	$search = mysql_query($q, $g_link) or die ("SQL Call failed: ".mysql_error());
	
	echo xml_head("./xsl/project_list.xsl");
	echo "<root>";
	echo xml_top();
	echo "<projects>";
	while($project = mysql_fetch_array($search, MYSQL_BOTH)) {
		//echo "<pre>"; print_r($project); echo "</pre>";
		echo "\n<project id=\"".$project["p_id"]."\">";
		echo "\n\t<title>".$project["title"]."</title>";
		echo "\n\t<svn>".$project["svn_loc"]."</svn>";
		echo "\n\t<stage>".$project["stage"]."</stage>";
		echo "\n\t<philosophy>".$project["philosophy"]."</philosophy>";
		echo "\n\t<url_conv>".$project["url_conv"]."</url_conv>";
		echo "\n\t<parameter_conv>".$project["parameter_conv"]."</parameter_conv>";
		echo "\n\t<language>".$project["language"]."</language>";
		echo "\n\t<language_conv>".$project["language_conv"]."</language_conv>";
		echo "\n</project>\n";
		
		
	}
	echo "</projects>";
	echo "</root>";
}

function project_left_nav_generate($section) {
  
}

function show_project_base() {
  
}

/**
 *
 * Creates a new pm object to navigate and use for xml creation
 * 
 * @param Int $id Need the ID of the project in the DB
 * @param Int $section The section/entry to show
 */
function show_project_section($id, $section) {
	$x = new pm($id, $section);
	echo xml_head("./pm/pm_base.xsl");
	echo "<root>";
	echo xml_top();
	echo "\n<navigation>\n\t";
		echo $x->sections_string;
		//get the logo
		echo "<logo src='".$x->logo_url."' alt=\"\" />";
	echo "\n</navigation>\n\t";
	//get the title
	echo "<title>".$x->title."</title>";
	echo "<description>".$x->description."</description>";
	echo $x->section_string;
	echo "</root>";
}

?>
