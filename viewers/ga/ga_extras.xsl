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
        <script>
            $(document).ready(function(){
                ///// Variables for the verse entry diaglog /////
                var book = $( "#book" ),
                    chapter = $( "#chapter" ),
                    v_start = $( "#v_start" ),
                    v_end = $("#v_end"),
                    allFields = $( [] ).add( book ).add( chapter ).add( v_start ).add(v_end),
                    tips = $( ".validateTips" );

                /////verse entry dialog - mostly taken straight from the jqueryui demo for this feature /////
                $("#verse-dialog-form").dialog({
                    autoOpen: false,
                    height: 300,
                    width: 500,
                    modal: true,
                    buttons: {
                        "Add Verse": function() {
                            var bValid = true;
                            allFields.removeClass( "ui-state-error" );

                            //add validation for verse, chapter, and book ranges here someday

                            if ( bValid ) {
                                var id = $( "#id" ).val();
                                $.post(url_base+"/ga/verse/add/"+id, {"book": book.val(), "chapter": chapter.val(), "v_start": v_start.val(),"v_end": v_end.val()},
                                function(data){
                                    //get_verse_data(data);
                                    //get_verses_data();
                                });
                                //do what's gotta be done
                                $( this ).dialog( "close" );
                            }
                        },
                        Cancel: function() {
                                $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                            allFields.val("").removeClass( "ui-state-error" );
                    }
                });


                $( "#add-verse" ).button().click(function() {$( "#verse-dialog-form" ).dialog( "open" );});
                /////end verse dialog code/////
            });
        </script>
</xsl:template>

</xsl:stylesheet>