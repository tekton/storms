<?php
	session_start();
	require_once("./storms_library/storms2_include.php");
	
    $id     = $_GET["id"];
	if ($_GET && !$_POST) {
		
		if($_SESSION["loggedIn"] != true ) {
			if($_GET["newUser"]==true) {
				header("content-type:text/html;charset=utf-8");
				displayHead();
				display_top();
				display_user_creation();
				echo '
					</div><!-- end container -->

					</body>
					</html>
				';
				exit;				
			} else {
				login_screen();
				exit;
			}
		}
		
		if($_GET["new"]==true) {
			echo xml_head("./xsl/new.xsl");
			echo "<root>";
			echo xml_top();
			echo "<newEntry/>";
			echo "</root>";
			//newEntry();
		}
		else if($_GET["edit"] > 0) {
			
			require_once("./storms_library/edit_gui.php");
			//echo "<!-- break in get but edit -->";
			
		}
		else if($_GET["id"] > 0) {
			require_once("./storms_library/storms2_get.php");
			//echo "<!--break get non post-->";
		}
		else if($_GET["history_id"] > 0) {
			echo xml_head("issue.xsl");
			echo "<root>";
			echo xml_top();
			get_description_history($_GET["history_id"]);
			echo "</root>";
		}
		else if($_GET["login"]==true) {
			displayHead();
			display_user_login();
			echo '
				</div><!-- end container -->
				</body>
				</html>
			';
		}
		else if($_GET["newUser"]==true) {
			header("content-type:text/html;charset=utf-8");
			displayHead();
			display_top();
			display_user_creation();
			echo '
				</div><!-- end container -->

				</body>
				</html>
			';
		}
		else if($_GET["logout"]==true) {
			$_SESSION["loggedIn"]=false;
			$_SESSION["displayName"]=NULL;
			unset($_SESSION["loggedIn"]);
			unset($_SESSION["displayName"]);
			//defaultAction();
			displayHead();
			display_user_login();
			echo '
				</div><!-- end container -->
				</body>
				</html>
			';
		}
		
		else if($_GET["pm_new"]==true) {
			echo xml_head("./xsl/project_new.xsl");
			echo "<root>";
			echo xml_top();
			require_once("./pm/project-management.php");
			project_new_gui();
		}
		
		else if($_GET["pm_edit"]) {
			require_once("./pm/project-management.php");
			project_edit_gui($_GET["pm_edit"]);			
		}
		else if($_GET["pm_list"]) {
			require_once("./pm/project-management.php");
			projects_list();
		}
		
		else if($_GET["project"]) {
			require_once("./pm/project-management.php");
			show_project_section($_GET["project"], $_GET["section"]);
		}
		
		else if($_GET["reports"]) {
			require_once("./storms_library/storms2_reports.php");
			
			xml_head("./xsl/".$_GET["reports"].".xsl");
			echo "<root>";
			echo xml_top();
			
			echo "<report><bugs>";
				basic_xml_output();
			echo "</bugs></report>";
			echo "</root>";
		}
		else if($_GET["installDebugInfo"]) {
			exec("svn info", $out);
			print_r($out);
		}
		else if($_GET["character"]) {
			//go go character logic!
			require_once("./storms_library/storms2_characters_functions.php");
			character_logic();
		}
		else {
			defaultAction();
		}
	}
	
	if ($_POST) {
		if($_GET["ucreate"]==true) {
			create_user();
		}
		
		if($_GET["loginForm"]==true) {
			auth();
		}
		
		if($_POST["searchCheck"]==true) {
			//echo 'searching!';
			require_once("./storms_library/storms2_search.php");
		}
		
		if($_POST["newComment"]==true) {
			require_once("./storms_library/storms2_comment_input.php");
		}
		
		if($_POST["edit"]=="edit") {
			require_once("./storms_library/edit_gui.php");
			//echo "<!-- break in post -->";
			//how does this show anything?!
		}
		
		if($_POST["character_input"]==true) {
			require_once("./storms_library/storms2_characters_functions.php");
			character_create();
		}
		
		if($_POST["character_edit"]=="edit") {
			require_once("./storms_library/storms2_characters_functions.php");
			character_edit($_POST["id"]);
		}
		
		if($_POST["newInput"]==true) {
			require_once("./storms_library/storms2_input.php");
		}
		
		if($_POST["newProject"]==true) {
			require_once("./pm/project-management.php");
			project_create();
		}
		
		if($_POST["pm_edit"]==true) {
			require_once("./pm/project-management.php");
			project_edit($_POST["pm_id"]);
		}
		
	}
	
	if(!$_GET && !$_POST) {
		
		if($_SESSION["loggedIn"] != true ) {
			login_screen();
			exit;
		}
		
		defaultAction();
	}
	
?>
