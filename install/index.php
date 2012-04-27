<?php

    /*** function for general processing, including overrides ***/
    function fatal_catch() {
        $error = error_get_last();
        if ($error['type'] == 1) {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
            //and then log the error, etc
        }
    }
    
    function debug($text, $title) {
		if(DBUG >= 1) {
        	echo "<pre>$title :: ".$text."</pre>";
		}
    }
    
    function a_print($array, $title) {
        if(DBUG >= 1) {
			echo "<pre>::$title\n"; print_r($array); echo "</pre>";
		}
    }
    
    function xsl_safe_test(&$string) {
        //preg strings to make sure that text will output correctly
        $string = preg_replace('/\&/', '&amp;', $string);
        $string = preg_replace('/\</', '&lt;', $string);
        $string = preg_replace('/\>/', '&gt;', $string);
        return $string;
    }
    
    /*** END FUNCTIONS ***/
?>
<html>
	<body>
		
			<form action="install.php" method="get" accept-charset="utf-8">
				<table>
					<tr>
						<th>Label</th>
						<th>Input</th>
					</tr>
					<tr><td>RewriteBase</td><td><input type="text" name="RewriteBase" /></td></tr>
					<tr><td>DB</td><td><input type="text" name="DB" /></td></tr>
					<tr><td>USER</td><td><input type="text" name="USER" /></td></tr>
					<tr><td>PASSWORD</td><td><input type="text" name="PASSWORD" /></td></tr>
					<tr><td>HOST</td><td><input type="text" name="HOST" /></td></tr>
					<tr><td>TBLAPREFIX</td><td><input type="text" name="TBLAPREFIX" /></td></tr>
					<tr><td>DBUG</td><td><input type="text" name="DBUG" /></td></tr>
					<tr><td>URI_BASE</td><td><input type="text" name="URI_BASE" /></td></tr>
				</table>
				<p><input type="submit" value="Continue &rarr;"></p>
				
			</form>
			
	</body>	
</html>