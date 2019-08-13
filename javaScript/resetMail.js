$(document).ready(function(){
 
    /***************************/
    /* on click				   */
    /***************************/
    $("#reset").on("click", function(){
        var value = $("#privilege option:selected").val();

         $.post("/res/ajax/resetmail.php",{id: value});
    });

});