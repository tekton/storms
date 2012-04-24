<?php

	require_once("storms2_include.php");
	
    $id = $_GET["id"];
	echo xml_head("issue.xsl");
	
	//display_top();
	getData($id);
?>