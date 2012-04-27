<?php

require_once(dirname(dirname(__FILE__))."/models/Tag.php");

class storms_tags {
	public $name;
	public $parent;
	public $value;
	
	function __construct() {
		$this->name = "";
		$this->parent = "";
		$this->value = "";
	}
	
	public function traffic_control($uri, $vars) {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//a_print($_POST);
			$this->name = $_POST["name"];
			$this->parent = $vars;
			$this->value = $_POST["value"];
			$tag = new Tag($this->name, $this->value, $this->parent);
			$tag->createTagInDB();
			global $body,$return_type;
			$return_type = "json";
			$body = json_encode(array("id" =>$tag->getUUID(), "value" => $tag->get_value(), "name" => $tag->get_name(), "parent" => $tag->getParentId()));		
		} else {
			//that's right, NOTHING
			global $body,$return_type;
			$return_type = "json";
			$body = json_encode(array("success" =>"ERROR", "msg"=>"Nothing was Posted!"));
		}
	}
}

$traffic["/tags/new/*"] = "storms_tags";
$traffic["/tags/get/*"] = "storms_tags";
$traffic["/tags/set/*"] = "storms_tags";
$traffic["/tags/update/*"] = "storms_tags";

?>