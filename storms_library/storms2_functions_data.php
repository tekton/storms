<?php

	function uid() {
	$db = ConnectDB();
	$result = mysql_query("SELECT * FROM ".TBLAPREFIX."_eyeD WHERE id IS NOT NULL",$db);
	while ($myrow = mysql_fetch_array($result, MYSQL_BOTH)) { $id = $myrow["id"]; }
		//echo $id." ";
	    //update the value of id in trackID
	    $uid = $id + 1;
	    $update = mysql_query("UPDATE ".TBLAPREFIX."_eyeD SET id = '$uid' WHERE id = $id", $db);
	        //echo "<div id ='cef'>Inserted into database as: ".$uid."</div>";
	        return $uid;
	}

	function get_session_ip() {
		
		// mainly used for checking the login IP for trackings sake
		
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$s_ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$s_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; //gah, took long enough to find that it's for proxy use :(
		} else {
			//this is the most common way, but can sometimes be blank...grrrrr
			$s_ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $s_ip;
	}

?>