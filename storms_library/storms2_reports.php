<?php

	require_once("storms2_include.php");

	function basic_xml_output() {
		$g_link = ConnectDB();
		
		$q = "select * from ".TBLAPREFIX."_project_base_info";
		$s = mysql_query($q, $g_link) or die("Could not get data because ".mysql_error());
		
		while ($result = mysql_fetch_array($s, MYSQL_BOTH)) {
			echo "<".spaces_strip($result[7]).">";
				echo "<id>".$result[0]."</id>";
				echo "<name>".xsl_safe_test($result[1])."</name>";
				echo "<description>".xsl_safe_test($result[2])."</description>";
				echo "<dateEntered>".$result[3]."</dateEntered>";
				echo "<dateModified>".$result[4]."</dateModified>";
				echo "<issueInBuild>".$result[5]."</issueInBuild>";
				echo "<resolvedInBuild>".$result[6]."</resolvedInBuild>";
				echo "<type>".$result[7]."</type>";
				echo "<sevarity>".$result[8]."</sevarity>";
				echo "<pertainsTo>".$result[9]."</pertainsTo>";
				echo "<parentIssue>".$result[10]."</parentIssue>";
				echo "<project>".$result[11]."</project>";
				echo "<enteredBy>".$result[12]."</enteredBy>";
				echo "<visible>".$result[13]."</visible>";
				echo "<flagged>".$result[14]."</flagged>";
			echo "</".spaces_strip($result[7]).">\n";
		}
	}
?>