<?php
header("content-type:text/xml;charset=utf-8");
session_start();
require_once("storms2_gdef.php");
require_once("storms2_users.php");
require_once("storms2_functions_display.php");

xml_head("./xsl/top.xsl");
echo "<user>";
	echo "<name>".$_SESSION["displayName"]."</name>";
echo "</user>";

?>