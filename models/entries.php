<?php
require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");
/**
 * A model that is a collection of Entry objects
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class entries {
    public $entries;
    public $search;
    public $search_params;
    public $return_params;
    public $return_info;
    
    private $db;
    
    function __construct() {
        $this->entries = array();
        $this->search = null;
        $this->search_params = array();
        $this->db = ConnectDB();
        $this->return_info = array();
    }
    
    public function search($search) {
        if($search == "" || $search == null) {
            //check search and return params?
            return false;
        } else {
            $this->search = $search;
        }
        
        $s = mysql_query($this->search, $this->db);
            //add in num rows, and other variables needed to return_info
        return $s;
    }
    
}

?>
