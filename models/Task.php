<?php

require_once("Tag.php");

/**
 * Description of task
 *
 * @author pyro
 */

class Task {

    public $name;
    public $type;
    public $value;

    public $tags;
    public $comments;
    public $system_updates;
    
    public $uid;

    /**
     * Every Tasks is just a set of tags 
     */
    public function __construct() {
        $this->tags = array();

        $this->tags["updatedBy"]    = new Tag("updatedBy");
            //$this->tags["updatedBy"]->set_name("updatedBy");
            $this->tags["updatedBy"]->set_value("tekton");
        $this->tags["project"]      = new Tag("project");
            //$this->tags["project"]->set_name("project");
            $this->tags["project"]->set_value("storms3");
        $this->tags["enteredBy"]    = new Tag("enteredBy");
            //$this->tags["enteredBy"]->set_name("enteredBy");
            $this->tags["enteredBy"]->set_value("tekton");
    }

    public function getName() {
            return $this->name;
    }
    public function  setName($name) {
            $this->name = $name;
    }
    public function  getType() {
            return $this->type;
    }
    public function  setType($type) {
            $this->type = $type;
    }
    public function  getValue() {
            return $this->value;
    }
    public function  setValue($value) {
            $this->value = $value;
    }
    public function  getLabel() {
            return $this->label;
    }
    public function  setLabel($label) {
            $this->label = $label;
    }
    public function  getSize() {
            return $this->size;
    }
    public function  setSize($size) {
            $this->size = $size;
    }
    public function  getOther() {
            return $this->other;
    }
    public function  setOther($other) {
            $this->other = $other;
    }

    public function getFromDB() {
        return;
    }

    public function putInDB() {}

    public function updateInDB() {}
	
}

?>