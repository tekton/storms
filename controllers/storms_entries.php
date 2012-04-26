<?php

require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");
require_once(dirname(dirname(__FILE__))."/models/Entry.php");
require_once(dirname(dirname(__FILE__))."/models/entries.php");

/**
 * Description of storms_entries
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class storms_entries {

    public $id;
    public $entry;
    
    function __construct() {
        $this->id = null;
        $this->entry = null;
    }
    
    function setEntry() {
        if(isset($this->entry)) {
            return true;
        } else {
            if(isset($this->id)) {
                $this->entry = new Entry($this->id);
                return true;
            } else {
                return false;
            }
        }
    }
    
    function show() {
        $this->setEntry();
        $this->entry->getHistoryFromDB();
        $this->entry->getBasicTagsFromDB();
        echo "<pre>"; print_r($this->entry); echo "</pre>";
        $this->entry->create_xml_object();
        echo $this->entry->xml->asXML();
            
    //get the URI for passing to functions...
    //echo "<pre>"; print_r($_SERVER); echo "</pre>";
    }
    
    function migrate() {
        $this->setEntry();
        $this->entry->migrate_to_tags();
    }
    
    function show_all() {
		debug("show_all", "function");
        $entries = new entries();
        $s = $entries->search("SELECT id, name FROM storms_tdb");
		$entries->create_xml_object("<?xml-stylesheet type='text/xsl' href='../viewers/entries_all.xsl' ?>");
		
		global $body;
		$body = $entries->xml->asXML();
    }
    
    public function traffic_control($uri, $vars) {
        //echo "<div>TC URI:: $uri :: $vars</div>";
        switch($uri) {
            case "/entry/show/*":
                $this->id = $vars;
                $this->show();
                break;
            case "/entry/migrate/*":
                $this->id = $vars;
                $this->migrate();
                break;
            case "/entries/*":
                if($vars=="all") {
                    //list out all of the entries in a basic way...
                    debug("show all", null);
                    $this->show_all();
                } else {
                    //// ...i have no idea what else i would show...
                    debug("we got us some variables...", null);
                }
                break;
        }
    }
    
}

$traffic["/entry/"] = "storms_entries";
$traffic["/entry/show/*"] = "storms_entries"; //individual linking!
$traffic["/entry/edit/*"] = "storms_entries";
$traffic["/entry/migrate/*"] = "storms_entries";
$traffic["/entries/*"] = "storms_entries"; //basically becomes search for basic things...

?>
