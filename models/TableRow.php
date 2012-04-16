<?php

/**
 * Creating, Editing, Updating all take about the same info...might as well 
 * return it easier to show in a table based format.
 *
 * @author tekton
 */
class TableRow {
    public $id;
    public $label;
    public $type;
    public $value;
    public $name;
    public $input_id;
    public $display_value;
    
    /**
     *
     * Creation of "getters" and "setters" in PHP  
     * 
     * find: public \$(.*);
     * replace: function set_\1($val) { $this->\1 = $val; }\nfunction get_\1() { return $this->\1; }
     * 
     * @param type $val 
     */
    
    function set_id($val) { $this->id = $val; }
    function get_id() { return $this->id; }
    function set_label($val) { $this->label = $val; }
    function get_label() { return $this->label; }
    function set_type($val) { $this->type = $val; }
    function get_type() { return $this->type; }
    function set_value($val) { $this->value = $val; }
    function get_value() { return $this->value; }
    function set_name($val) { $this->name = $val; }
    function get_name() { return $this->name; }
    function set_input_id($val) { $this->input_id = $val; }
    function get_input_id() { return $this->input_id; }
    function set_display_value($val) { $this->display_value = $val; }
    function get_display_value() { return $this->display_value; }  

    function set_all($id, $label, $type, $value, $name, $input_id, $display_value) {
        $this->set_id($id);
        $this->set_label($label);
        $this->set_type($type);
        $this->set_value($value);
        $this->set_name($name);
        $this->set_input_id($input_id);
        $this->set_display_value($display_value);
    }
    
    public function validate($str) {
        return $str;
    }
    
    public function dispVal($val) {
        $val = $this->validate($val);
    }
    
    public function print_row() {
        $xml_str = "<tableRow>";
            $xml_str .= "<id>".$this->get_id()."</id>";
            $xml_str .= "<label>".$this->get_label()."</label>";
            $xml_str .= "<type>".$this->get_type()."</type>";
            $xml_str .= "<value>".$this->get_value()."</value>";
            $xml_str .= "<name>".$this->get_name()."</name>";
            $xml_str .= "<input_id>".$this->get_input_id()."</input_id>";
            $xml_str .= "<display_value>".$this->get_display_value()."</display_value>";
        $xml_str .= "</tableRow>";
        
        return $xml_str;
    }
}
?>
