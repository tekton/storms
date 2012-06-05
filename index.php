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

    /*** Session Stuff ***/
    session_start();
    /*** END SESSION STUFF ***/
    
    /*** Requires and other misc settings ***/
    require_once("config/storms_require_classes.php");
    register_shutdown_function('fatal_catch');
    /*** END MISC SETTINGS ***/
    
    /*** VARIABLES 
     * 
     * can be accesses with 'global' in front of new variable names in classes
     * 
     * ***/
    $request = str_replace(URI_BASE, "", $_SERVER["REQUEST_URI"]);
    $class = "dflt"; //since default can't be a class
    $vars = "";
    
    $return_type = "xml"; //defaults to xml, JSON is the other I'm expecting to possibley be used more...    
    $xml_head = "<?xml version=\"1.0\"?>";		
    $stylesheet = ""; //basically setting the "view" that will be returned
    $body = "";
    
    /*** END VARIABLES ***/
    
    /**
     *
     * This isn't pretty, but it does go faster if everything is coded simply in the controllers!
	 * REMINDER: set the URI_BASE so that its parsed correctly!
     * 
     * TODO: add debug statements!
     * 
     */
    if(array_key_exists($request, $traffic)) {
        $class = $traffic[$request];
    } else {
        //strip it down to /xxxxxx/* and see if that exists...
        $sub_request = preg_split("/\//", $request, 3);
        $request_sub_test = "/".$sub_request[1]."/*";
        if(array_key_exists($request_sub_test, $traffic)) {
            $class = $traffic[$request_sub_test];
            $vars = $sub_request[2];
            $request = $request_sub_test;
        } else {
            //check /xxx/xxx/xxx/*
            $request_test_final = preg_split("/\//", $request, null, PREG_SPLIT_OFFSET_CAPTURE);
            $c = count($request_test_final) - 1;
            $test_str = substr($request, 0, $request_test_final[$c][1]);
            $vars = substr($request, $request_test_final[$c][1]);
            $request_test_final = $test_str."*";
            if(array_key_exists($request_test_final, $traffic)) {
                $class = $traffic[$request_test_final];
                $request = $request_test_final;
            }
        }
    }
    
    try {
        $c_load = new $class;
        $c_load->traffic_control($request, $vars);
    } catch(Exception $e) {
        //header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
    }
 
    //a_print($traffic, $request);
    //debug($class, "class");
    //a_print($c_load, null);
    
	if($return_type=="xml") {
		header ("Content-Type:text/xml");
                /*$xslt = new XSLTProcessor();
                
                $xslDoc = new DOMDocument();
                $xslDoc->load($stylesheet);
                
                $xslt->importStylesheet($xslDoc);
                
                $body = $xslt->transformToXml(new SimpleXMLElement($body));*/
	} else {
		header ("Content-Type:application/json");
	}
    echo $body;
?>
