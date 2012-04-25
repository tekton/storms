<?php

    require_once("controllers/storms_users.php");
    require_once("controllers/storms3_traffic_control.php");
	//require the "require" file
        
        //require_once("models/Entry.php");
        //$entry = new Entry("179");
            //$entry->id = "179";
            //$entry->getHistoryFromDB();
            //$entry->migrate_to_tags();
        //echo "<pre>"; print_r($entry); echo "</pre>";
            //$entry->create_xml_object();
            //echo $entry->xml->asXML();
            
    //get the URI for passing to functions...
    //echo "<pre>"; print_r($_SERVER); echo "</pre>";

    
    
    $request = str_replace(URI_BASE, "", $_SERVER["REQUEST_URI"]);
    
    
    
            
?>
