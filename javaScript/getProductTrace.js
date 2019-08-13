$(document).ready(function(){
    
    /***************************/
    /* variable                */
    /***************************/
    var pageID = "1";
    var categoryID = "_";
    var scrollValue = 0;
         
    /***************************/
    /* function                */
    /***************************/  
    function getValue(value, value2) {           
        $.post("/res/ajax/getProductTrace.php", {pageID: value, category: value2}, function(data){
            $("#results").html(data);
            pageID++;
       });  
    }
    
    function getValue2(value, value2) {           
        $.post("/res/ajax/getProductTrace.php", {pageID: value, category: value2}, function(data){
            $("#results").append(data);
            scrollValue = 0;
            pageID++;
       });  
    }

    function getSearch(value, value3){		
		$.post("/res/ajax/getProductTrace.php", {pageID: value, search: value3},function(data){
			$("#results").html(data);
		})
	};
    
    function resetSearch (){
        if ($("#search").val() == ""){
            getValue("1", "_");
        }
    }

    function scroll (value){
        $(window).scroll(function(){

             $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    
                    if (scrollValue == 0){
                        getValue2(pageID, categoryID);
                        scrollValue = 1;
                        console.log("bottom!");
                    }
                    
                }
            });
        });   
    } 
    
	/***************************/
    /* search                  */
    /***************************/
    $("#search").on({
        keyup: function() {
            var search = $("#search").val();
            getSearch("1", search);
            resetSearch();
        },
        blur: function() {resetSearch();},
        focus: function() {console.log('focus!');}
    });

    /***************************/
    /* on click - subMenu      */
    /***************************/ 
    $(".link").on("click", function () {
        pageID = 1;
        categoryID = $(this).attr("id");

        getValue(pageID, categoryID);
    });

    /***************************/
    /* start 			       */
    /***************************/
    getValue(pageID, categoryID);
    scroll();
    
});