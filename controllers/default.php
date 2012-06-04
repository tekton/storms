<?php

require_once("storms_entries.php");

/**
 * Description of dflt
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class dflt {
	//could be customized per install
	//todo: find a better/easier way to allo this to change...
    public function traffic_control($uri) {
        global $traffic, $class, $request, $body;
            $stylesheet= URI_BASE."/viewers/default.xsl";
            $xml = new SimpleXMLElement("<?xml-stylesheet type='text/xsl' href='$stylesheet' ?><root></root>");
            $xml->addChild("urlBase", URI_BASE);
            $xml->addChild("class", $class);
            $xml->addChild("request", $request);
            $t = $xml->addChild("traffic");
            foreach($traffic as $req => $loc) {
                $t->addChild($loc, $req);
            }
            $body = $xml->asXML();
    }
}

$traffic["/trafic"] = "default";

?>
