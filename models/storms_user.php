<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of storms_user
 *
 * @author tekton
 */
class storms_user {
    
    public $user;
    public $pass;
    
    public $authed;
    
    /**
     *
     * Check for a session variable set to see if things even need to be run again 
     */
    function __construct() {
        //attempt to get user/pass from session variable
        $this->user = null;
        $this->pass = null;
        $this->authed = false;
    }
    
    public function auth($user, $pass){
        $user = MD5($pass);
        $pass = MD5($pass);
    }
    
    /**
     *
     * Check session variables for all login variables being accounted for
     *  
     */
    public function check_auth() {
        
    }
    
    /**
     * Used for when information is going to be entered into a database
     * 
     * Uses the session variables for user/pass to insert data
     * 
     */
    public function check_auth_db() {
        
    }
    
    /**
     *
     * Create a user in the database
     * 
     * @param String $user
     * @param String $pass
     * @param String $pas2
     * @return String If the user was able to be created
     */
    public function create_user($user, $pass, $pas2) {
        $user = MD5($pass);
        $pass = MD5($pass);        
        $pas2 = MD5($pas2);
        if($pass != $pas2) {
            return "Non matched passwords";
        } else {
            //run db stuff to create the user...
        }
    }
}

?>
