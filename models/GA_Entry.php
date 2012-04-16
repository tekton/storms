<?php

/**
 * Description of GA_Entry
 *
 * @author tekton
 */
class GA_Entry {
    public $body;
    public $title;
    public $verses;
    
    public $id;
    
    public $notes;
    
    function __construct() {
        $this->verses = array();
        $this->notes = array();
    }
    
    public function asXML() {
        
    }
}

?>
