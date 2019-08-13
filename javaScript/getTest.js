$(document).ready(function(){
         
    /***************************/
    /* function                */
    /***************************/
    /*fetch data*/ 
    function getValue() {           
        $.post("/res/ajax/getTest.php", function(data){
            $("#results").html(data);
       });  
    }

    /***************************/
    /* start 			       */
    /***************************/
    getValue();    
});