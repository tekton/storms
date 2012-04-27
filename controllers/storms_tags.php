<?php

require_once(dirname(dirname(__FILE__))."/models/Tag.php");
require_once(dirname(dirname(__FILE__))."/models/Entry.php");

class storms_tags {
	public $name;
	public $parent;
	public $value;
	public $uuid;
	
	function __construct() {
		$this->name = "";
		$this->parent = "";
		$this->value = "";
		$this->uuid = "";
	}
	
	function get_all_for_parent() {
		$entry = new Entry($this->parent);
		$entry->getBasicTagsFromDB();
		$t = $entry->tags;
		$tags = array();
		foreach($t as $tag) {
			//echo $tag->get_name()." :: ";
			//echo $tag->get_value()."<br />";
			$tags[$tag->get_name()] = $tag->get_value();
		}
		return $tags;
	}
	
	public function traffic_control($uri, $vars) {
		global $body,$return_type;
		$return_type = "json";
		
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//a_print($_POST);
			$this->name = $_POST["name"];
			$this->parent = $vars;
			$this->value = $_POST["value"];
			$tag = new Tag($this->name, $this->value, $this->parent);
			$tag->createTagInDB();
			$body = json_encode(array("id" =>$tag->getUUID(), "value" => $tag->get_value(), "name" => $tag->get_name(), "parent" => $tag->getParentId()));		
		} else {
			//that's right, NOTHING, except all the retreival stuff...
			switch($uri) {
				case "/tags/get/*":
					$this->uuid = $vars;
					break;
				case "/tags/all/*":
					$this->parent = $vars;
					$body = json_encode($this->get_all_for_parent());
					break;
			}
			/*global $body,$return_type;
			$return_type = "json";
			$body = json_encode(array("success" =>"ERROR", "msg"=>"Nothing was Posted!"));*/
		}
	}
}

$traffic["/tags/new/*"] = "storms_tags"; //POST!
$traffic["/tags/get/*"] = "storms_tags";
$traffic["/tags/all/*"] = "storms_tags";
$traffic["/tags/set/*"] = "storms_tags";
$traffic["/tags/update/*"] = "storms_tags";
$traffic["/tags/report/*"] = "storms_tags";

?>