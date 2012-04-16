<?php

require_once("Tag.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExtendedTag
 *
 * @author tekton
 */
class ExtendedTag extends Tag {
    
    public $parent;
    public $clarifier;
    public $type;
    public $display_val;
    public $current; //all can de false due to "deleted" states
    public $status;
    
    public $form_type; //really only important on a per variable basis...

    function set_parent($val) { $this->parent = $val; }
    function get_parent() { return $this->parent; }
    function set_clarifier($val) { $this->clarifier = $val; }
    function get_clarifier() { return $this->clarifier; }
    function set_type($val) { $this->type = $val; }
    function get_type() { return $this->type; }
    function set_display_val($val) { $this->display_val = $val; }
    function get_display_val() { return $this->display_val; }
    function set_current($val) { $this->current = $val; }
    function get_current() { return $this->current; } //all can de false due to "deleted" states
    function set_status($val) { $this->status = $val; }
    function get_status() { return $this->status; }
    
}

?>
