<?php

require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");
require_once("Tag.php");
require_once("Users.php");
require_once("comment.php");

/**
 * Generic case class for other entry types to build off of
 *
 * @var $id The basic internal tracking ID
 * @var $name The name of the entry, aka title
 * @var $body What could be called the "actual" entry
 * @var $comments An array of the comments that have been added to this entry
 * @var $updates An array of the updates that the system automagically comments on
 * @var $history the past versions of the body
 * 
 * @author tekton
 */
class Entry {
    public $id;
    public $name; //aka title
    public $body;
    public $user;
    public $created;
    
    public $comments;
    public $updates;
    
    public $tags;
    
    public $history;
    
    public $xml;
    
    function __construct($id="") {
        $this->id = $id;
        
        $this->tags = array();
        $this->history = array();
        $this->comments = array();
        $this->updates = array();
        if($this->id != "") {
            $this->getBaseFromDB();
            $this->getCommentsFromDB();
            $this->getHistoryFromDB();
        }
    }
    
    public function getBaseFromDB() {
        $q = "select * from `".TBLAPREFIX."_tdb` where id='".$this->id."'";
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->id = $result["id"];
            $this->name = $result["name"];
            $this->body = stripslashes($result["description"]);
            $this->created = $result["dateEntered"];
            $this->user = new Users($result["enteredBy"]);
        }
    }
    
    public function getHistoryFromDB() {
        $g_link = ConnectDB();
        $q = "select * from `".TBLAPREFIX."_description_history` where link_id='".$this->id."'"; //echo $q;
        $s = mysql_query($q, $g_link);
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->history[$result["id"]] = array();
            $this->history[$result["id"]]["body"] = $result["desc"];
            $this->history[$result["id"]]["posted"] = $result["posted"];
            $user = new Users();
            $this->history[$result["id"]]["user"] = $user->getDispName($result["user"]);
        }
    }
    
    public function getCommentsFromDB() {
        $q = "select id from `".TBLAPREFIX."_tdb_comments` where pertainsTo='".$this->id."'";
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->comments[$result["id"]] = new comment($this->id, $result["id"]);
        }
    }
    
    /**
     *  TODO: THIS NEEDS A LOT OF WORK 
     */
    public function getBasicTagsFromDB() {
        $q = "select uuid, name from `".TBLAPREFIX."_tags` where parent_id='".$this->id."' order by uuid asc, uuid desc";
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            //for non-unique tagging which requires a history DB or a "don't show" flag uncomment here
			/*
			$x = new Tag();
			$x->setUUID($result["uuid"]);
			$this->tags[] = $x;
			*/
			$this->tags[$result["name"]] = new Tag();
            $this->tags[$result["name"]]->setUUID($result["uuid"]);
        }
    }

    /****
     * XML object functions
     */
    
    function create_xml_object($stylesheet="") {
        $this->xml = new SimpleXMLElement("$stylesheet<root></root>");
        
        $entry = $this->xml->addChild("entry");
        
        $main_body = $entry->addChild("body", xsl_safe_test($this->body));
        $main_id = $entry->addChild("id", xsl_safe_test($this->id));
        $main_title = $entry->addChild("title", xsl_safe_test($this->name));
        
        $tags = $entry->addChild("tags");
        $comments = $entry->addChild("comments");
        $history = $entry->addChild("history");
            
        foreach ($this->tags as $name => $tag) {
            $t = $tags->addChild("tag");
                //$t->addAttribute("name", $tag->get_name());
                $t->addAttribute("name", $name);
				$t->addAttribute("value", $tag->get_value());
                //TODO Add a "return as xml" function to Tag
        }
        
        foreach ($this->history as $id => $val) {
            $h = $history->addChild("history");
                $h->addAttribute("id", $id);
            $name = $h->addChild("body", $val["body"]);
            $posted = $h->addChild("posted", $val["posted"]);
            $user = $h->addChild("user", $val["user"]);
        }
        
        foreach($this->comments as $comment) {
            $c = $comments->addChild("comment");
                $c->addChild("id", $comment->id);
                $c->addChild("pertainsTo", $comment->pertainsTo);
                $c->addChild("title", $comment->title);
                $c->addChild("description", $comment->description);
                $c->addChild("dateEntered", $comment->dateEntered);
                $c->addChild("dateModified", $comment->dateModified);
                $c->addChild("visible", $comment->visible);
                $c->addChild("user", $comment->user->display_name);
        }
    }
    
    /****** Migration Functions 
     * 
     *  Can be commented out to "save some room" on a per object basis technically 
     * 
    ******/
    public function migrate_to_tags() {
        //needed for the update from storms2 to storms3
        $q = "select * from `".TBLAPREFIX."_tdb` where id='".$this->id."'";
        $s = mysql_query($q, ConnectDB());
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            /*
             * id, int(20), NO, MUL, , 
                name, text, NO, , , 
                description, text, NO, , , 
                dateEntered, timestamp, YES, , , 
                dateModified, timestamp, NO, , 0000-00-00 00:00:00, on update CURRENT_TIMESTAMP
                issueInBuild, text, YES, , , 
                resolvedInBuild, text, YES, , , 
                type, text, YES, , , 
                sevarity, text, YES, , , 
                pertainsTo, text, YES, , , 
                parentIssue, bigint(20), YES, , , 
                project, varchar(255), YES, , , 
                enteredBy, varchar(256), YES, , , 
                visible, varchar(1), YES, , , 
                flagged, varchar(20), NO, , entered, 
                desc_id, int(11), YES, , , 
                milestone, varchar(255), YES, , , 
             */

            $this->tags_migrate("issueInBuild", $result["issueInBuild"]);
            $this->tags_migrate("resolvedInBuild", $result["resolvedInBuild"]);
            $this->tags_migrate("type", $result["type"]);
            $this->tags_migrate("sevarity", $result["sevarity"]);
            $this->tags_migrate("pertainsTo", $result["pertainsTo"]);
            $this->tags_migrate("parentIssue", $result["parentIssue"]);
            $this->tags_migrate("project", $result["project"]);
            $this->tags_migrate("visible", $result["visible"]);
            $this->tags_migrate("flagged", $result["flagged"]);
            $this->tags_migrate("milestone", $result["milestone"]);
        }
    }
    
    public function tags_migrate($index, $val) {
        $this->tags[$index] = new Tag($index, $val, $this->id);
        if($this->tags[$index]->checkDBForTag() == false) {
            $this->tags[$index]->createTagInDB();
        }
    }
}

?>