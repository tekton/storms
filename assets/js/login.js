/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
   
   function login() {
       user = $("#user").val();
       pass = $("#pass").val();
       
       $.post(url_base+"/json/login", {"user": user, "pass": pass},
            function(data){
                //alert(data);
                //refresh_tag_data(data)
                //append_tag_data(data["name"], data["value"])
                //get_tag_data();
            });
   }
   
       /////tag entry dialog - mostly taken straight from the jqueryui demo for this feature /////
    $("#login-dialog-form").dialog({
        autoOpen: false,
        height: 200,
        width: 300,
        modal: true,
        buttons: {
            "Login": function() {
                var bValid = true;

                if ( bValid ) {
                    login();
                    //do what's gotta be done
                    $( this ).dialog( "close" );
                }
            },
            Cancel: function() {
                    $( this ).dialog( "close" );
            }
        },
        close: function() {
        }
    });
    
    
    $( "#login-btn" ).button().click(function() {$( "#login-dialog-form" ).dialog( "open" );});
    /////end tag dialog code/////
   
});
