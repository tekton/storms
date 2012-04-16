<?php

	//require the "require" file
        
require_once("models/Entry.php");

        $entry = new Entry("179");
            //$entry->id = "179";
            //$entry->getHistoryFromDB();
            $entry->migrate_to_tags();
        //echo "<pre>"; print_r($entry); echo "</pre>";
            $entry->create_xml_object();
            echo $entry->xml->asXML();
?>
