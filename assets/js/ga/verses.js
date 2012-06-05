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

});