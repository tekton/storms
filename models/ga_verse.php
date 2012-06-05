<?php

require_once(dirname(dirname(__FILE__))."/config/storms_db.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verse
 *
 * @author tekton
 */
class ga_verse {
    public $verse_id;
    
    public $start_book;
    public $start_chapter;
    public $start_verse;
    public $end_book;
    public $end_chapter;
    public $end_verse;
    
    public $verse_array;
    public $json_array;
    
    public $id;
    
    public $db;
    
    function __construct() {
        $this->verse_array = array();
        $this->json_array = array();
        $this->db = ConnectDB();
    }
    
    public function getVerseFromDB() {
        $db = $this->db;
        $q = "SELECT * from `".TBLAPREFIX."_ga_verses` as v
        where v.id = '".$this->verse_id."'";
        $s = mysql_query($q, $db);
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            $this->verse_array["id"] = $result["id"];
            $this->verse_array["entry_id"] = $result["entry_id"];
            $this->verse_array["book"] = $result["name"];
            $this->verse_array["chapter"] = $result["start_chapter"];
            $this->verse_array["v_start"] = $result["start_verse"];
            $this->verse_array["v_end"] = $result["end_verse"];
        }
        $this->json_array = json_encode($this->verse_array);
    }
    
    public function getAllVersesFromDB() {
        $db = $this->db;
        $q = "SELECT * from `".TBLAPREFIX."_ga_verses` as v
            where v.entry_id = '".$this->id."' order by v.id asc";
        $s = mysql_query($q, $db);
        while($result = mysql_fetch_array($s, MYSQL_BOTH)) {
            //echo "<pre>"; print_r($result); echo "</pre>";
            $this->verse_array[$result["id"]] = array(
                "book" => $result["book"],
                "chapter" => $result["chapter_start"],
                "v_start" => $result["verse_start"],
                "v_end" => $result["verse_end"]
            );
        }
        
        $this->json_array = json_encode($this->verse_array);
    }
    
    public function putVerseInDB() {
        //try to insert, if that doesn't work, update!
        //hack test
        $db = $this->db;
        $this->add_escape_to_all();
        $q = "INSERT INTO `".TBLAPREFIX."_ga_verses` (`entry_id`,`book`,`chapter_start`, `verse_start`, `verse_end`) 
            VALUES (
                '".$this->id."',
                '".$this->start_book."',
                '".$this->start_chapter."',
                '".$this->start_verse."',
                '".$this->end_verse."'
            )";
        //echo $q;
        error_log($q);
        mysql_query($q, $this->db) or die("Error inserting verse:: ".mysql_error());
        $this->verse_id = mysql_insert_id();
    }
    
    public function single_verse_json() {
        $this->json_array = json_encode($this->verse_array);
    }
    
    function add_escape_to_all() {
        $this->start_book = mysql_real_escape_string($this->start_book, $this->db);
        $this->start_chapter = mysql_real_escape_string($this->start_chapter, $this->db);
        $this->start_verse = mysql_real_escape_string($this->start_verse, $this->db);
        $this->end_verse = mysql_real_escape_string($this->end_verse, $this->db);
    }
}

?>
