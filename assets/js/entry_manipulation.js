$(document).ready(function(){
    function check_for_id() {
        if($( "#id" ).val().is(":empty")) {
            return false;
        } else {
            return true;
        }
    }
    
    function set_id(id) {
        $("#id").val() = id;
    }
    
    function update_title(title) {
        if(check_for_id() == true) {
            update_title_in_db(title);
        } else {
            new_entry("title", title);
        }
    }
    
    function update_body() {
        if(check_for_id() == true) {
            update_body_in_db();
        } else {
            new_entry("body");
        }
    }
    
    function get_new_entry_id() {
        //send off to json to create a new entry, return just the ID!
    }
    
    function set_title_val(title) {
        //clear the title just in case...
        $("#entry_title").html="";
        $("#entry_title").append=title;
        $("#title_input").val=title;
    }
    
    $("#title_edit").click(function() {
       //check for the visible state of the input item!
       //if it's visible, submit the title!
       if($("#title_input_span").is(":visible")) {
           if($.trim($("#title_input").val()).length == 0) {
               //do nothing!
           } else {
               //send off the input to update the, or create a new, entry...
               alert("about to call some json in this here place");
           }
           $("#entry_title").show();
           $("#title_input_span").hide();
       } else { //if it's not, make the input visible...
           $("#entry_title").hide();
           $("#title_input_span").show();
           $("#title_input").val($("#entry_title").text());
       }
       
    });
    
});