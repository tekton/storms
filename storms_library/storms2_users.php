<?php

/*
	There is no POST or GET code on this page it only does four things
	
		Display Code for User Login
		Display Code for User Creation
		House the functions for User Creation
		Check authentication and return true or false
		
*/

require_once("storms2_include.php");

function display_user_login() {
	echo "
		<form id='loginForm' action='index.php?loginForm=true' method='POST'>
		<div id='loginBox'>
		<table id='loginTable' width='100%'>
			<tr><td class='redCell'>User Name</td><td><input type='text' id='user' name='user' /></td></tr>
			<tr><td class='blueCell'>Password</td><td><input type='password' id='pass' name='pass' /></td></tr>
		</table>
		<input type=\"submit\" value='login' />
		</div>
		</form>
	";
}

function display_user_creation() {
	echo "
		<form id='loginForm' action='index.php?ucreate=true' method='POST'>
		<div id='loginBox'>
		Your display name and user name are two seperate things, you'll use your user name to login and people will see your display name. We suggest that you make them two separete names.
		<table id='loginTable' width='100%'>
			<tr><td class='redCell'>User Name</td><td><input type='text' id='user' name='user' /></td></tr>
			<tr><td class='redCell'>Display Name</td><td><input type='text' id='disp' name='disp' /></td></tr>
			<tr><td class='blueCell'>Password</td><td><input type='text' id='pass' name='pass' /></td></tr>
			<tr><td class='blueCell'>Password</td><td><input type='text' id='pass2' name='pass2' /></td></tr>
		</table>
		<span><input type='Submit' value='Create Login' /></span>
		</div>
		</form>
	";
}

function create_user() {
	$g_link = ConnectDB();
	$user = MD5($_POST["user"]);
	$disp = mysql_real_escape_string($_POST["disp"]);
	$pass = MD5($_POST["pass"]);
	$pas2 = MD5($_POST["pass2"]);
		if($pass == $pas2) {
			$query = "INSERT INTO ".TBLAPREFIX."_users (us3r, pazz, disName) VALUES ('$user', '$pass', '$disp')";
			mysql_query($query) or die("Could not insert data because ".mysql_error());
			//ui for "your user was created"
			displayHead();
			display_top();
			echo "Your User was created successfuly. Please remember that your display name and user name 
			are two separate things, you'll use your user name to login and people will see your display name.";
			echo '
				</div><!-- end container -->
				</body>
				</html>
			';
		}
		else {
			displayHead();
			display_top();
			echo "Invalid Passphrases";
			display_user_creation();
			echo '
				</div><!-- end container -->

				</body>
				</html>
			';
			exit;
		}

	CleanUpDB($g_link);
}

function auth() {
	if($_SESSION["loggedIn"]==true) {
		//echo "already logged in!";
		dt_headerRedirect();
		return true;
	}
	
	else {
		
		$ip = get_session_ip();
		
		if($_POST["user"]) {
			$g_link = ConnectDB();
			$user = MD5($_POST["user"]);
			$pass = MD5($_POST["pass"]);
			$query 	= "SELECT disName FROM ".TBLAPREFIX."_users WHERE us3r = '$user' AND pazz = '$pass'";
			$search = mysql_query($query, $g_link);// or die(mysql_error()); ///step 1, check the DB name!
			
			$q = "INSERT INTO ".TBLAPREFIX."_login_tracking 
				(`who`, `attempted_hash`, `attempted_ip`, `browser`, `success`) 
				VALUES 
				('$user', '$pass', '$ip', '".$_SERVER['HTTP_USER_AGENT']."', "; //finished up when it's a yes or no to the login
			
			while ($result = mysql_fetch_array($search, MYSQL_BOTH)) {
				$dispName = $result["disName"];
			}
			
			$counter = mysql_num_rows($search);
			
			if($counter > 1) {
				dt_headerRedirect("index.php?login=true");
				$q .= "'0')";
				$s = mysql_query($q);
				exit;
			}
			
			if($counter==1) {
				//echo "$dispName is logged in";
				$_SESSION["displayName"] = $dispName;
				$_SESSION["loggedIn"] = true;
				$q .= "'1')";
				//echo "<!-- $q -->";
				$s = mysql_query($q);// or die (mysql_error());
				dt_headerRedirect("index.php");
			}
			
			if($counter==0) {
				$q .= "'0')";
				$s = mysql_query($q);
				//dt_headerRedirect("index.php?login=true&reason=failed");
				echo "<!-- $q -->";
			}

		}
		//check for login
		//on success set SESSION variables
	}
}

?>