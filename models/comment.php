<?php

require_once(dirname(dirname(__FILE__))."/models/storms_user.php");

/**
 * Description of comment will go here eventually...
 * 
 * @var $type Either a comment or a system update; they're basically the same thing really...
 *
 * @author pyro
 */
class comment {
    //put your code here
    public $type;
    public $id;
    public $pertainsTo;
    public $title;
    public $description;
    public $dateEntered;
    public $dateModified;
    public $visible;
    public $user;
    
    public $queries;
    
    function __construct($pertainsTo="", $id="") {
        $this->pertainsTo = $pertainsTo;
        $this->id = $id;
        
        $this->queries = array();
        
        if($id != "" && $pertainsTo != "") {
            $this->getFromDB();
        }
    }
    
    public function getFromDB() {
        $q = "select * from `".TBLAPREFIX."_tdb_comments` where id = '".$this->id."' AND pertainsTo='".$this->pertainsTo."'";
            $this->queries[] = $q;
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->title = $result["title"];
            $this->description = stripslashes($result["description"]);
            $this->dateEntered = $result["dateEntered"];
            $this->dateModified = $result["dateModified"];
            $this->visible = $result["visible"];
            $this->type = $result["type"];
            $this->user = new Users($result["enteredBy"]);
        }
    }
    
    public function addToDB(&$sql="") {
        
        $db = ConnectDB();
        
        $this->user = new storms_user();
        if($this->user->check_auth() == true) {
            $this->type = mysql_real_escape_string($this->type);
            $this->pertainsTo = mysql_real_escape_string($this->pertainsTo);
            $this->title = mysql_real_escape_string($this->title);
            $this->description = mysql_real_escape_string($this->description);
            $this->user = new storms_user();
                if($this->user->check_auth() == true) {
                    $q = "INSERT INTO `".TBLAPREFIX."_tdb_comments`
                            (`pertainsTo`, `title`, `description`, `enteredBy`, `type`)
                            VALUES
                            (
                                \"$this->pertainsTo\",
                                \"$this->title\",
                                \"$this->description\",
                                \"".$this->user->id."\",
                                \"$this->type\"
                            )";
                    $sql = $q;
                    mysql_query($q, $db) or die ("MySQL Error :: ".mysql_error());
                    
                } else {
                    return false;
                }
        } else {
            return false;
        }
    }
    
    public function asXML() {
        $xml = new SimpleXMLElement("<comment></comment>");
        $xml->addChild("id", $this->id);
        $xml->addChild("pertainsTo", $this->pertainsTo);
        $xml->addChild("title", $this->title);
        $xml->addChild("description", $this->description);
        $xml->addChild("dateEntered", $this->dateEntered);
        $xml->addChild("dateModified", $this->dateModified);
        $xml->addChild("visible", $this->visible);
        $xml->addChild("type", $this->type);
        $xml->addChild("user", $this->user->display_name);
        return $xml;
    }
}

?>
