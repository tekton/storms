<?php
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
            $this->description = $result["description"];
            $this->dateEntered = $result["dateEntered"];
            $this->dateModified = $result["dateModified"];
            $this->visible = $result["visible"];
            $this->user = new Users($result["enteredBy"]);
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
        $xml->addChild("user", $this->user->display_name);
        return $xml;
    }
}

?>
