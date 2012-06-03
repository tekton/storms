<?php
/**
 * In a dev environment this should go through and dynamically add all controllers
 * 
 * In a live environment, this should be a compiled file to cut down on 
 * IO bottle necks since it's most important function is to create the 
 * traffic mapping from the the global sets in each controller file
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */

//check for traffic.php
$filecheck = dirname(dirname(__FILE__))."/traffic.php";
//if it exists then there's less IO needed to check all of the controllers...
//...this also means that not everything is loaded in every time, so files ill still need to be included like "normal" standards would imply
if(file_exists($filecheck)) {
	require_once($filecheck);
} else {
	$ro_dir = dirname(dirname(__FILE__))."/controllers/";
	if(is_dir($ro_dir)) {
	    if($dir = opendir($ro_dir)) {
	        while(($file = readdir($dir)) !== false) {
	            //echo "filename: $file : filetype: " . filetype($ro_dir . $file) . "<br />";
	            if(is_file($ro_dir . $file)) {
	                $file_info = pathinfo($ro_dir . $file);
	                if($file_info["extension"] == "php") {
	                    require_once($ro_dir . $file);
	                }
	            }
	        }
	    }
	}
	
	//create traffic.php!
	try {
		//$stuff = print_r($traffic);
		//file_put_contents($filecheck, $stuff);
		foreach($traffic as $key => $tag) {
			$str = '$traffic["'.$key.'"]="'.$tag."\";\n";
			file_put_contents($filecheck, $str, FILE_APPEND);
		}
	} catch(Exception $e) {
		
	}
}
?>
