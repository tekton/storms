/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var verse_tbl_row="";
var tblRow = "";

$(document).ready(function(){
    get_verses_data();
    
    tblRow += "<tr>";
    
    tblRow += "<td><select name='book' id='book'>";
    var options = "";
    

    $.each(books, function(k, v) {
        //alert(k+" :: "+v);
        options += "<option value='"+v+"'>"+v+"</option>";
    });

    tblRow += options;
    tblRow += "</select></td>";
    tblRow += "<td><input type=\"text\" name=\"chapter\" id='chapter' size='3' /></td>"+
            "<td><input type=\"text\" name=\"v_start\" size='3' id='v_start' /></td>"+
            "<td><input type=\"text\" name=\"v_end\" size='3' id='v_end' /></td>"+
            "</tr>"; //"<td><span class=\"ui-icon ui-icon-circle-plus\"> </span></td>"+

    $(tblRow).appendTo("#verses_table tbody");
 
     function get_verses_data() {
        //$("#verses_linked").html("");
        var id = $( "#id" ).val();
        $.getJSON(
            url_base+"/ga/verses/"+id,
            function(data){
                $.each(data, function(verse, vals) {
                    text = vals["book"]+" "+vals["chapter"]+":"+vals["v_start"]+"-"+vals["v_end"];
                    $("#verses_linked").append("<div class='verse'>"+text+"</div>");
                });
            }
        );        
    }
 
      function get_verse_data(v_id) {
        //$("#verses_linked").html("");
        $.getJSON(
            "json.php?id="+id+"&type=verse&v_id="+v_id,
            function(vals){
                text = vals["book"]+" "+vals["chapter"]+":"+vals["v_start"]+"-"+vals["v_end"];
                $("#verses_linked").append("<div class='verse'>"+text+"</div>");
            }
        );        
    }   
    
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
                        get_verses_data();
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