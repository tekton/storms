<?php
require_once('Entry.php');
/**
 * Description of GA_Entry
 *
 * @author tekton
 */
class GA_Entry extends Entry {
    public $body;
    public $title;
    public $verses;
    
    public $id;
    
    public $notes;
    
    function __construct($id="") {
        $this->verses = array();
        $this->notes = array();
        parent::__construct($id);
    }
    
    public function add_extras_to_xml() {
        //echo "add extras overridden!";
        $this->add_verses_to_xml();
        $this->add_notes_to_xml();
    }
    
    function add_verses_to_xml() {
        
    }
    
    function add_notes_to_xml() {
        
    }
    
    function migrate__set_post_date($datetime) {
        $q = "UPDATE `".TBLAPREFIX."_tdb` set dateEntered='$datetime'";
        mysql_query($q, ConnectDB());
    }
}

?>
