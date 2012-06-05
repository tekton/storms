<?xml version="1.0" encoding="UTF-8" ?>
<!--
	head
	Created by TAgee on 2012-06-04.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">

<xsl:template name="ga_entry_extras_right">
    
        <div id="verses" class="ui-widget">
            <div class="ui-widget-header p5">Verses</div>
            <div id="verses_linked" class="ui-widget-content p5"></div>
            <div class="aRight">
                <button id="add-verse" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Add Reference </button>
            </div>
            
            <div id="verse-dialog-form" title="Verse Reference">
                <p class="validateTips"></p>
                <form>
                    <fieldset>
                        <table id="verses_table" class="ui-widget ui-widget-content">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Chapter</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </fieldset>
                </form>
            </div>
        </div>
    
</xsl:template>

</xsl:stylesheet>