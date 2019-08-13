$(document).ready(function(){
    
    /***************************/
    /* variable   			   */
    /***************************/
    var id, value;
    
    /***************************/
    /* function   			   */
    /***************************/
    function updateValue(value, value2){
        $.post("/res/ajax/updateShowProduct.php", {id:value, showProduct:value2},function(data){
            //getValue();
            location.reload();
        })   
    }
    
    function getValue(){

        $.post("/res/ajax/getShowProduct.php", function(data){
               
        },"json")   
    }

    /***************************/
    /* on click				   */
    /***************************/
    $(".show").on("click", function(){

        id = $(this).attr('id');
        value = $(this).attr('title');
        
        console.log(value);
        
        if (value == "1") {
            var output = null;
        }else{
            var output = "1";
        }

        updateValue(id, output);
       
    });
    
    /***************************/
    /* start				   */
    /***************************/
    getValue();

});