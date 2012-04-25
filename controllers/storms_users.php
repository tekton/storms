<?php

require_once(dirname(dirname(__FILE__))."/config/storms2_db.php");
require_once(dirname(dirname(__FILE__))."/models/storms_user.php");

/**
 * Description of storms_users
 *
 * @author tekton
 */
class storms_users {
    
    private $user;
    
    function __construct() {
        $this->user = new storms_user();
    }
    
    /**
     *
     * Expect information to be posted and return a json encoded 
     */
    public function json_login() {
        if($this->user->auth($_POST["user"], $_POST["pass"]) == true) {
            return json_encode(array("success" => "true", "disp" => $this->user->disp));
        } else {
            return json_encode(array("success" => "false"));
        }
    }
    
    public function new_user($type="json") {
        $r = $this->user->create_user($_POST["user"], $_POST["pass"], $_POST["pas2"], $_POST["disp"]);
        if($r != true) {
            //sad news, now return the data
            if($type=="json") {
                return json_encode(array("success" => "failure"));
            } else {
                //redirect to some page that shows they logged in...
            }
        } else {
            //good news, it was a success!
            if($type=="json") {
                return json_encode(array("success" => "true", "disp" => $this->user->disp));
            } else {
                //redirect to some page that shows they logged in...
            }
        }
    }
    
    public function traffic_control($uri) {
        switch($uri) {
            case "/json/login":
                return $this->json_login();
            default:
                break;
        }
    }
}

?>
