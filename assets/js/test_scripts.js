/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var verse_tbl_row="";
var tblRow = "";

$(document).ready(function(){

    get_entry_data();
    get_verses_data();
    
    tblRow += "<tr>";
    
    tblRow += "<td><select name='book' id='book'>";
    var options = "";
    

    $.each(books, function(k, v) {
        //alert(k+" :: "+v);
        options += "<option value='"+k+"'>"+v+"</option>";
    });

    tblRow += options;
    tblRow += "</select></td>";
    tblRow += "<td><input type=\"text\" name=\"chapter\" id='chapter' size='3' /></td>"+
            "<td><input type=\"text\" name=\"v_start\" size='3' id='v_start' /></td>"+
            "<td><input type=\"text\" name=\"v_end\" size='3' id='v_end' /></td>"+
            "</tr>"; //"<td><span class=\"ui-icon ui-icon-circle-plus\"> </span></td>"+

    $(tblRow).appendTo("#verses_table tbody");
    
    function get_entry_data() {
        $.getJSON(
            "json.php?id="+id,
            function(data){
                $("#title").html(data.title);
                $("#body").html(data.body);
                $("#notes").html(data.notes);
                    $('textarea#body_val').val(data.body);
                    $('textarea#notes_val').val(data.notes);
                    $('input#input_title').val(data.title);
            }
        );        
    }
 
     function get_verses_data() {
        //$("#verses_linked").html("");
        $.getJSON(
            "json.php?id="+id+"&type=verses",
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
                    $.post("json_post.php?id="+id+"&slot=verse", {"book": book.val(), "chapter": chapter.val(), "v_start": v_start.val(),"v_end": v_end.val()},
                    function(data){
                        get_verse_data(data);
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
    
    /////title, body, and notes dialog/////
    $("#title_dialog").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Update": function(){
                var text = $('input#input_title').val();
                /////alert(text);
                $.post("json_post.php?id="+id+"&slot=title", {"title": text},
                function(){
                    get_entry_data();
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
    
    $( "#post_title" ).click(function() {$("#title_dialog").dialog( "open" );});
    // end title //
    
    //     body //
    $("#body_dialog").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Update": function(){
                var text = $('textarea#body_val').val();
                /////alert(text);
                $.post("json_post.php?id="+id+"&slot=body", {"body": text},
                function(){
                    get_entry_data();
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
    
    $( "#post_body" ).click(function() {$("#body_dialog").dialog( "open" );});    
    
    // end body //
    
    //     notes //
     $("#notes_dialog").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Update": function(){
                var text = $('textarea#notes_val').val();
                /////alert(text);
                $.post("json_post.php?id="+id+"&slot=notes", {"notes": text},
                function(){
                    get_entry_data();
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });   
    
    $( "#post_notes" ).click(function() {$("#notes_dialog").dialog( "open" );});
    // end notes //

});

$.extend({
    urlParams: function(){
        var params = [], pair;
        var pairs = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        //alert(pairs);
        for(var i = 0; i < pairs.length; i++)
        {
            pair = pairs[i].split('=');
            params.push(pair[0]);
            params[pair[0]] = pair[1];
        }
        return params;
    }
});

/////legacy code/////
$('body').click(function(event) {
    if ($(event.target).is('.ui-icon-circle-plus')) {

        var book = $(event.target).parent().parent().contents().find("select[name='book']").val();
        var chapter = $(event.target).parent().parent().contents().find("input[name='chapter']").val();
        var v_start = $(event.target).parent().parent().contents().find("input[name='v_start']").val();
        var v_end = $(event.target).parent().parent().contents().find("input[name='v_end']").val();

        //alert(book + " :: " + chapter + " :: " + v_start + " :: " + v_end);

        $(tblRow).appendTo("#verses_table tbody");

        $(event.target).hide();

        $.post("json_post.php?id="+id+"&slot=verse", {"book": book, "chapter": chapter, "v_start": v_start,"v_end": v_end},
        function(data){
            get_verse_data(data);
        });
    }
});