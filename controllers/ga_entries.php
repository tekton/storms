<?php
/* Required as part of the "plugin" */

require_once(dirname(dirname(__FILE__))."/config/storms_db.php");
require_once(dirname(dirname(__FILE__))."/models/GA_Entry.php");
require_once(dirname(dirname(__FILE__))."/models/ga_verse.php");
require_once(dirname(dirname(__FILE__))."/controllers/storms_entries.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ga_entry
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class ga_entries extends storms_entries {
    //put your code here
    function setEntry() {
        if(isset($this->entry)) {
            return true;
        } else {
            if(isset($this->id)) {
                $this->entry = new GA_Entry($this->id);
                return true;
            } else {
                return false;
            }
        }
    }

    public function add_verse($vars) {
        
    }
    
    public function migrate() {
        //assumes the old DB is ga and the tables are entry, body        
        //get the current data to create the new entries...
        $q = "select entry.id, entry.title, entry.post_date, body.body from entry LEFT JOIN body on body.entry_id = entry.id";
        $s = mysql_query($q, ConnectDB("ga")) or die ("database error ::: ".mysql_error());
        $sql="";
        while($r = mysql_fetch_array($s, MYSQL_BOTH)) {
            $e = new GA_Entry();
            $e->type = "ga_entry";
            $id = $e->newEntry($r["title"]);
            $e->body = $r["body"];
            $e->updateEntryInDB($sql);
            $e->migrate__set_post_date($r["post_date"]);
        }
        echo $sql;
    }
    
    public function traffic_control($uri, $vars) {
        //echo "<div>TC URI:: $uri :: $vars</div>";
        switch($uri) {
            case "/ga/show/*":
                $this->id = $vars;
                $this->show("/viewers/ga/ga_entry.xsl");
                break;
            case "/ga":
            case "/ga/":
                $vars = "all";
            case "/ga/all":
                $this->show_all("/viewers/ga/ga_entries_all.xsl","ga_entry");
                break;
            case "/ga/new/*":
                $this->new_entry($vars);
                break;
            case "/ga/new":
                $this->new_entry();
                break;
            case "/ga/edit/*":
                $this->id = $vars;
                global $body, $return_type;
                $return_type = "json";
                $body = json_encode($this->edit_column($vars));
                break;
            case "/ga/verse/add/*":
                global $body, $return_type;
                $return_type = "json";
                $verse = new ga_verse();
                    $verse->id = $vars;
                    $verse->start_book = $_POST["book"];
                    $verse->start_chapter = $_POST["chapter"];
                    $verse->start_verse = $_POST["v_start"];
                    $verse->end_verse = $_POST["v_end"];
                    $verse->putVerseInDB();
                $body = json_encode($verse->verse_id);
                break;
            case "/ga/verses/*":
                global $body, $return_type;
                $return_type = "json";
                $verse = new ga_verse();
                    $verse->id = $vars;
                    $verse->getAllVersesFromDB();
                $body = $verse->json_array;
                break;
            case "/ga/migrate":
                $this->migrate();
                break;
        }
    }
    
}


$traffic["/ga/"] = "ga_entries";
$traffic["/ga"] = "ga_entries";
$traffic["/ga/migrate"] = "ga_entries";
$traffic["/ga/new/*"] = "ga_entries";
$traffic["/ga/new"] = "ga_entries";
$traffic["/ga/show/*"] = "ga_entries"; //individual linking!
$traffic["/ga/edit/*"] = "ga_entries";
$traffic["/ga/all*"] = "ga_entries"; //basically becomes search for basic things...
$traffic["/ga/verse/add/*"] = "ga_entries";
$traffic["/ga/verses/*"] = "ga_entries";

?>
