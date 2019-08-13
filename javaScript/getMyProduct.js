$(document).ready(function(){
    
    /***************************/
    /* variable                */
    /***************************/
    var pageid = "1";
    var categoryID = "_";
    
    /***************************/
    /* function                */
    /***************************/  
    function getValue(value, value2, value3) {           
        $.post("/res/ajax/getProduct.php",{id: value, category: value2},function(data){
           if (value3 == "html") {
               $("#results").html(data);
           }else if (value3 == "append"){
               $("#results").append(data);
           }
           
           pageid++;
       });  
    }

    /***************************/
    /* on click submenu        */
    /***************************/ 
    $(".link").on("click", function () {
        pageid = 1;
        categoryID = $(this).attr("id");
  
        getValue(pageid, categoryID, "html");
    });
    
    /***************************/
    /* on scroll bottom        */
    /***************************/   
    $(window).scroll(function(){
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            getValue(pageid, categoryID, "append");
        }
    });

    /***************************/
    /* start 			       */
    /***************************/
    getValue(pageid, categoryID, "html");
    
});