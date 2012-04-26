<?php
/**
 * Description of storms3_require_classes
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
