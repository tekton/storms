<?php

require_once(dirname(dirname(__FILE__))."/config/storms_db.php");

/**
 * Model for each user to follow from the storms_users controller
 *
 * @author tekton
 */
class storms_user {
    
    public $user;
    public $pass;
    public $disp;
    public $id;
    
    public $roles;
    
    public $authed;
    
    public $db;
    public $e;
    public $ip;
    public $agent; //$_SERVER['HTTP_USER_AGENT']
    
    /**
     *
     * Check for a session variable set to see if things even need to be run again 
     */
    function __construct() {
        //attempt to get user/pass from session variable
        $this->user = null;
        $this->pass = null;
        $this->authed = false;
        $this->e = null;
        $this->db = null;
        $this->ip = $this->get_session_ip(); //$this->ip = null;
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->roles = array();
    }
    
    /**
     *
     * To make it easier to check authentivation, we'll just let the controller pass what it needs and return if it worked or not...don't really want to tell the hacker why it failed...
     * 
     * @param type $user A non-hashed string of what the user is submitting
     * @param type $pass A non-hashed password string
     * @return type 
     */
    public function auth($user, $pass){
        $this->user = MD5($user);
        $this->pass = MD5($pass);
        
        return $this->check_auth_db(); //this->disp will be set if it's true!
    }
    
    /**
     *
     * Check session variables for all login variables being accounted for
     *  @return bool And if they are logged in, set the user variables accordingly!
     */
    public function check_auth() {
        if(isset($_SESSION["user"]) && isset($_SESSION["pass"]) && isset($_SESSION["disp"])) {
            $this->authed = true;
            $this->user = $_SESSION["user"];
            $this->pass = $_SESSION["pass"];
            $this->disp = $_SESSION["disp"];
            $this->id   = $_SESSION["u_id"];
            return true;
        } else {
            $this->authed = false;
            return false;
        }
    }
    
    /**
     * Used for when information is going to be entered into a database
     * 
     * Uses the session variables for user/pass to insert data
     * 
     */
    public function check_auth_db() {
        $this->db();
        
        $q = "SELECT disName, id FROM ".TBLAPREFIX."_users WHERE us3r = '$this->user' AND pazz = '$this->pass'";
        $s = mysql_query($q, $this->db);
        if(mysql_numrows($s) == 1) {
            //good news, you're in!
            while ($result = mysql_fetch_array($s, MYSQL_BOTH)) {
                $this->disp = $result["disName"];
                $this->id = $result["id"];
            }
            $this->set_logged_in();
            $this->login_track(1);
            return true;
        } else {
            //bad news, you're out...
            $this->login_track(0);
            return false;
        }
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
    public function create_user($user, $pass, $pas2, $disp) {   
        $this->db();
        
        $user = MD5($pass);
        $pass = MD5($pass);        
        $pas2 = MD5($pas2);
        $disp = mysql_real_escape_string($disp);
        if($pass != $pas2) {
            return "Non matched passwords";
        } else {
            //run db stuff to create the user...
            $q = "INSERT INTO ".TBLAPREFIX."_users (us3r, pazz, disName) VALUES ('$user', '$pass', '$disp')";
            mysql_query($q, $$this->db);
            
            if (mysql_errno()) {
                $this->e = "MySQL ERROR:: ".mysql_errno().": ".mysql_error();
                //add switch for error numbers to let it know why registration wasn't able to be done
                return "Unable to add user";
            } else {
                $this->user = $user;
                $this->pass = $pass;
                $this->disp = $disp;
                $this->authed = true;
                $this->set_logged_in();
                return true;
            }
        }
    }
    
    /// Utility Functions ///
    
    public function set_logged_in() {
        $_SESSION["user"] = $this->user;
        $_SESSION["pass"] = $this->pass;
        $_SESSION["disp"] = $this->disp;
        $_SESSION["u_id"] = $this->id;
        $this->authed = true;
    }
    
    public function db() {
        if($this->db == "" || $this->db == null) {
            $this->db = ConnectDB();
        }
    }

    function get_session_ip() {

            // mainly used for checking the login IP for trackings sake

            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $s_ip = $_SERVER['HTTP_CLIENT_IP'];
            } 
            else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $s_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; //gah, took long enough to find that it's for proxy use :(
            } else {
                    //this is the most common way, but can sometimes be blank...grrrrr
                    $s_ip = $_SERVER['REMOTE_ADDR'];
            }

            return $s_ip;
    }
    
    public function login_track($success) {
        $this->db();
        $q = "INSERT INTO ".TBLAPREFIX."_login_tracking 
                (`who`, `attempted_hash`, `attempted_ip`, `browser`, `success`) 
                VALUES 
                ('$this->user', '$this->pass', '$this->ip', '".$this->agent."', '$success')";
        mysql_query($q, $this->db) or die ("Login tracking error:: ".mysql_error());
        
        //this erroring out doesn't really matter, but once there's logging...
        
        //TODO add logging support for login_tracking
    }
}

?>
