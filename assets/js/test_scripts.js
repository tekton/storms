$(document).ready(function(){
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
 
     function get_tag_data() {
		var id = $( "#id" ).val();
        $("#tags_list_table").html("");
        $.getJSON(
            url_base+"/tags/all/"+id,
            function(data){
                $.each(data, function(name, val) {
                    append_tag_data(name, val);
                });
            }
        );        
    }

	function refresh_tag_data(data) {
        $.each(data, function(name, val) {
            append_tag_data(name, val);
        });		
	}
 
	function append_tag_data(name, val) {
		$("#tags_list_table").append("<tr><td class='tag'>"+name+"</td><td>"+val+"</td></tr>");
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
    ///// Variables for the tag entry diaglog /////
    var id = $( "#id" ).val(),
        name = $( "#name" ),
        value = $( "#value" ),
        allFields = $( [] ).add( name ).add( value ),
        tips = $( ".validateTips" );
   
    /////tag entry dialog - mostly taken straight from the jqueryui demo for this feature /////
    $("#tag-dialog-form").dialog({
        autoOpen: false,
        height: 200,
        width: 300,
        modal: true,
        buttons: {
            "Add Tag": function() {
                var bValid = true;
                allFields.removeClass( "ui-state-error" );

                //add validation for verse, chapter, and book ranges here someday

                if ( bValid ) {
                    $.post(url_base+"/tags/new/"+id, {"name": name.val(), "value": value.val()},
                    function(data){
                        //alert(data);
						//refresh_tag_data(data)
						//append_tag_data(data["name"], data["value"])
						get_tag_data();
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
    
    
    $( "#add-tag" ).button().click(function() {$( "#tag-dialog-form" ).dialog( "open" );});
    /////end tag dialog code/////
});