<?php

require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author tekton
 */
class Users {
    //put your code here
    public $display_name;
    public $id;
    
    function __construct($user="") {
        if($user != "") {
            $this->id = $user;
            $this->getDispName($this->id);
        } else {
            //do nothing
        }
    }
    
    public function getDispName($user) { 
        $q = "SELECT disName from `".TBLAPREFIX."_users` WHERE id = '".$user."'";
        $user_query = mysql_query($q, ConnectDB()) or die(mysql_error());
        while($users = mysql_fetch_array($user_query, MYSQL_BOTH)) {
                $user = $users["disName"];
        }
        $this->display_name = $user;
        return $user;
    }
}

?>
