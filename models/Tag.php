<?php

require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");
require_once("TableRow.php");

/**
 * Very basic tag support; things that should be in all tags!
 * 
 * @var id The internal Tag ID
 * @var name The basic name of the tag
 * @var value The basic value fo the tag
 * @var $parent_id
 * @var $tag_id 
 * @var iteration_id The "version" of this tag
 * @var uuid The database ID for this tag; seperate from tag ID due to history implementation
 * @var isPrimary Really for checks when cretion a new entry
 * 
 * @var row The individual quick edit for the tag
 * @var rows All of the data for the tag, extended edit
 * 
 * @author tekton
 */
class Tag {

    private $id;
    private $name;
    private $value;
    
    private $description;
    private $parent_id;
    private $tag_id;
    private $uuid;
    private $iteration_id;
    private $isPrimary;
    private $unique;
    
    private $row;
    
    function set_id($val) {
        $this->id = $val;
        //$this->getTagFromDB();
    }
    function get_id() { return $this->id; }
    
    function setUUID($uuid) {
        $this->uuid = $uuid;
        $this->getTagFromDBViaUUID();
    }

    function getUUID() {
		return $this->uuid;
	}

    function set_name($val) {
        $this->name = $val;
        $this->createTableRow();
    }
    function get_name() { return $this->name; }
    function set_value($val) { 
        $this->value = $val;
        $this->createTableRow();
    }
    function get_value() { return $this->value; }

    function setParentId($parent_id) {
		$this->parent_id = $parent_id;
	}
	function getParentId() {
		return $this->parent_id;
	}

    /**
     * The basic tag for everything that gets used...will create a basic TableRow for use
     * 
     * @param String $name The basic name that shows up, not required to create a tag
     * @param String $value The basic value fo the tag that you wish to create
     * 
     * @author tekton
     */  
    function __construct($name="", $value="", $parent="") {
        $this->name = $name;
        $this->value = $value;
        $this->parent_id = $parent;
        
        $this->createTableRow();
    }
    
    function createTableRow($type="text") {
        $this->row = new TableRow();
        $this->row->label = $this->name;
        $this->row->type = $type;
        $this->row->value = $this->value;
    }
    
    function checkDBForTag() {
        $q = "select * from `".TBLAPREFIX."_tags` where parent_id='".$this->parent_id."' AND name='".$this->name."'";
        $s = mysql_query($q, ConnectDB());
        if(mysql_affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function getTagFromDB() {
        //check to make sure all variables are set...
        
        //while it's getting from the DB, lets create the info for the TableRow
        $this->createTableRow();
    }
    
    function getTagFromDBViaUUID() {
        $q = "select * from `".TBLAPREFIX."_tags` where uuid='".$this->uuid."'";
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->name = $result["name"];
            $this->value = $result["value"];
            $this->description = $result["description"];
            
            $this->parent_id = $result["parent_id"];
            
            $this->tag_id = $result["tag_id"];
            $this->iteration_id = $result["iteration_id"];
            $this->isPrimary = $result["isPrimary"];
            $this->unique = $result["unique"];
        }
    }
    
    function getTag() {
        //return something with all the variables needed, possibly as an array?
        //given there's getters for everything, sholdn't really be needed unless there's a pressing matter version
    }
    
    /**
     * Just the initial creation of the tag 
     */
    function createTagInDB() {
        //check to see if there's a similar tag with a name and is flagged as unique...
        $db = ConnectDB();
        $q = "INSERT INTO `".TBLAPREFIX."_tags` (`name`,`value`,`parent_id`) 
            VALUES (\"". mysql_real_escape_string($this->name)."\",
            \"". mysql_real_escape_string($this->value)."\",
            \"". mysql_real_escape_string($this->parent_id)."\"
            )";
        $s = mysql_query($q, $db);
	$this->uuid = mysql_insert_id();
    }
    
    function updateTag() {
        //TODO: figure out what this really means...
    }
}

?>
