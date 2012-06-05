<?php
require_once('Entry.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog_entry
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class blog_entry extends Entry {
    function migrate__set_post_date($datetime) {
        $q = "UPDATE `".TBLAPREFIX."_tdb` set dateEntered='$datetime'";
        mysql_query($q, ConnectDB());
    }
}

?>
