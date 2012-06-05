<?php
require_once(dirname(dirname(__FILE__))."/config/storms_db.php");
require_once(dirname(dirname(__FILE__))."/controllers/storms_entries.php");
require_once(dirname(dirname(__FILE__))."/models/blog_entry.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog_entry
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class blog_entry_controller extends storms_entries {
    
    public function migrate() {
        //assumes the old DB is ga and the tables are entry, body        
        //get the current data to create the new entries...
        $q = "select post_title as title, post_content as body, post_date from wp_posts";
        $s = mysql_query($q, ConnectDB("other_dev")) or die ("database error ::: ".mysql_error());
        while($r = mysql_fetch_array($s, MYSQL_BOTH)) {
            $e = new blog_entry();
            $e->type = "blog";
            $id = $e->newEntry($r["title"]);
            $e->body = $r["body"];
            $e->updateEntryInDB($sql);
            $e->migrate__set_post_date($r["post_date"]);
        }
    }
    
    public function traffic_control($uri, $vars) {
        switch($uri) {
            case "/blog/*":
                $this->id = $vars;
                $this->show("/viewers/blog/show.xsl");
                break;
            case "/blog":
            case "/blog/":
                $this->show_all("/viewers/blog/show_all.xsl","blog");
                break;
            case "/blog/migrate":
                $this->migrate();
                break;
        }
    }
}

$traffic["/blog"] = "blog_entry_controller";
$traffic["/blog/"] = "blog_entry_controller";
$traffic["/blog/migrate"] = "blog_entry_controller";
$traffic["/blog/*"] = "blog_entry_controller";

?>
