<?php

set_error_handler("customError");

function customError($errno, $errstr) {
    if($errno != 8) {
        echo "<!-- Error: [$errno] $errstr -->";
    }
     /*echo "Ending Script";*/
}

?>
