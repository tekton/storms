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


?>
