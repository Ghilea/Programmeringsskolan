$(document).ready(function(){
    
    /***************************/
    /* on click                */
    /***************************/ 
    $(".bbCode").on("click", function () {

        var value = $(this).attr('id');

        var tgop = "[";     // character opening tag
        var tgen = "]";     // character ending tag

        if (value != "url") {

            var start = tgop+value+tgen;
            var end = tgop+"/"+value+tgen;

        }else{

            var start = tgop+value+"=http://"+tgen;
            var end = tgop+"/"+value+tgen;

        }

        var txtarea = document.getElementById("text");

        // Define into an array the start, and end of selected text, and the final text in textarea
        var rezult = new Array();
        
        rezult['startPos'] = txtarea.selectionStart;
        rezult['endPos'] = txtarea.selectionEnd;
        rezult['final_text'] = txtarea.value.substring(0, rezult['startPos']) + start + txtarea.value.substring(rezult['startPos'], rezult['endPos']) + end + txtarea.value.substring(rezult['endPos'], txtarea.value.length);

        // Add the new text in textarea, calls set_xpos() to position cursor to Xpos
        txtarea.value = rezult['final_text'];
        var Xpos = rezult['endPos']+start.length;

    });

});