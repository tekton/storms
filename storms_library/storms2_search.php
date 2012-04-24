<?php

	require_once("storms2_include.php");
	
    $id     = $_GET["id"];
	$g_link = ConnectDB();
	$name = $_POST["search"];
	$pertainsTO = $_POST["search"];
	$description = $_POST["search"];
	
	$result = mysql_query("SELECT * FROM ".TBLAPREFIX."_TDB WHERE
    name LIKE '%$name%' 
    || pertainsTO LIKE '%$pertainsTO%'
    || description LIKE '%$description%'
    ORDER BY dateEntered DESC
    ",$g_link);
	
	$str	=  xml_head();
	$str	.= display_topTen($result);
	
	echo $str;
?>