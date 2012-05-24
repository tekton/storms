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
    
    function new_entry($vars="") {
        $stylesheet="../../viewers/entry_new.xsl";
        //do block out and set things up to send...
        $this->id = "";
        $this->setEntry();
        $this->entry->create_xml_object("<?xml-stylesheet type='text/xsl' href='$stylesheet' ?>");
		$this->entry->xml->addChild("urlBase", URI_BASE);
        global $body;
		$body = $this->entry->xml->asXML();
    }
    
    function show($stylesheet="../../viewers/entry.xsl") {
        $this->setEntry();
        $this->entry->getHistoryFromDB();
        $this->entry->getBasicTagsFromDB();
        //echo "<pre>"; print_r($this->entry); echo "</pre>";
			//double back since the basic URL patern /entry/show
        $this->entry->create_xml_object("<?xml-stylesheet type='text/xsl' href='$stylesheet' ?>");
		$this->entry->xml->addChild("urlBase", URI_BASE);
        global $body;
		$body = $this->entry->xml->asXML();
            
    //get the URI for passing to functions...
    //echo "<pre>"; print_r($_SERVER); echo "</pre>";
    }
    
    function migrate() {
        $this->setEntry();
        $this->entry->migrate_to_tags();
        $this->show();
    }
    
    function show_all($stylesheet="../viewers/entries_all.xsl") {
		debug("show_all", "function");
        $entries = new entries();
        $s = $entries->search("SELECT id, name FROM storms_tdb");
		$entries->create_xml_object("<?xml-stylesheet type='text/xsl' href='$stylesheet' ?>");
		$entries->xml->addChild("urlBase", URI_BASE);
		global $body;
		$body = $entries->xml->asXML();
    }
    
    
    /**
     *
     * @param type $vars Should just be the id...but just in case might as well send it...
     */
    function edit_column($vars) {
        //$this->setEntry(); //gets too much data, lets just do it ourselves...
        //only really have to worry about json here...
        
        $rtn_array = Array();
        
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //get the column that's being updated...
            $col = $_POST["column"];
            //get the value of the new update...
            $val = $_POST["value"];
            
            $this->entry = new Entry();
            $this->entry->id = $this->id;
            $this->entry->getBaseFromDB();
            
            if($col == "name") {
                $this->entry->name = $val;
                $rtn_array["column"] = "name";
                $rtn_array["value"] = $val;
            } else if ($col == "body") {
                $this->entry->body = $val;
            } else {
                $rtn_array["success"] = "false";
            }
            $sql = "";
            $success = $this->entry->updateEntryInDB($sql);
            
            $rtn_array["sql"] = $sql;
            $rtn_array["success"] = $success;
              
        } else {
            //wtf?! return an error of some kind...
            $rtn_array["success"] = "false";
        }
        
        return $rtn_array;
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
            case "/entry/new/*":
                $this->new_entry($vars);
                break;
            case "/entry/edit/*":
                $this->id = $vars;
                global $body, $return_type;
                $return_type = "json";
                $body = json_encode($this->edit_column($vars));
                break;
        }
    }
    
}

$traffic["/entry/"] = "storms_entries";
$traffic["/entry/new/*"] = "storms_entries";
$traffic["/entry/show/*"] = "storms_entries"; //individual linking!
$traffic["/entry/edit/*"] = "storms_entries";
$traffic["/entry/migrate/*"] = "storms_entries";
$traffic["/entries/*"] = "storms_entries"; //basically becomes search for basic things...

?>
