<?php
require_once(dirname(dirname(__FILE__))."/config/storms_db.php");
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

    public $xml;

    private $db;

    function __construct() {
        $this->entries = array();
        $this->search = null;
        $this->search_params = array();
        $this->db = ConnectDB();
        $this->return_info = array();
    }
    
	/**
	*
	* The "heart" of this operation; it doesn't care what the columns are as it will just all them all to it's on array and store it
	* @param $search This function doesn't create sql statements, and if it isn't give one it ill return quickly
	*/
    public function search($search) {
        if($search == "" || $search == null) {
            //check search and return params?
            return false;
        } else {
            $this->search = $search;
        }
        
        $s = mysql_query($this->search, $this->db);
            //add in num rows, and other variables needed to return_info
		while(($result = mysql_fetch_array($s, MYSQL_ASSOC))) {
            //a_print($result, "result");
            //echo "<div>[s] [e] [m] <a href='../entry/show/".$result["id"]."'>".$result["name"]."</a></div>";
            //add id and name to xml object...
			$row = array();
			foreach($result as $key => $val) {
				$row[$key] = $val;
			}
			$this->return_info[] = $row;
        }
    }

    /****
     * XML object functions
     */
    
    public function create_xml_object($stylesheet) {
		//debug("create_xml_object", "function");
		//a_print($this->return_info, null);
        $this->xml = new SimpleXMLElement("$stylesheet<root></root>");
        $entries = $this->xml->addChild("entries");
		//use the information from $this->search() to create the entries that are needed...
        foreach ($this->return_info as $name => $data) {
            //a_print($data, "in foreach");
			$entry = $entries->addChild("entry");
				foreach($data as $key => $tag) {
                                        error_reporting(E_ALL ^ E_STRICT); ///this just got annoying and it didn't want to stop even with assigning to new variables
					$entry->addChild(xsl_safe_test($key), xsl_safe_test(stripslashes($tag)));
				}
        }
    }
}

?>
