<?php

require_once("storms_entries.php");

/**
 * Description of default
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class dflt {
//put your code here
    public function traffic_control($uri) {
        if($uri == "/") {
            $d = new storms_entries();
            $d->show_all("./viewers/entries_all.xsl");
        } else {
            global $traffic, $class, $request, $body;
            $xml = new SimpleXMLElement("<root></root>");
            $xml->addChild("class", $class);
            $xml->addChild("request", $request);
            $t = $xml->addChild("traffic");
            foreach($traffic as $req => $loc) {
                $t->addChild($loc, $req);
            }
            $body = $xml->asXML();
        }
    }
}

$traffic["/trafic"] = "default";

?>
