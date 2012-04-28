<?php

require_once("storms_entries.php");

/**
 * Description of default
 *
 * @author Tyler Agee <tyler@pyroturtle.com>
 */
class dflt {
//put your code here
    public function traffic_control() {
        $d = new storms_entries();
		$d->show_all("./viewers/entries_all.xsl");
    }
}
?>
