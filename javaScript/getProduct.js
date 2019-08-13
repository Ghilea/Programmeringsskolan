$(document).ready(function(){
    
    /***************************/
    /* variable                */
    /***************************/
    var pageID = "1";
    var regionID = "_";
    var categoryID = "_";
    var modelID = "_";
    var searchID = "_";
    var scrollValue = 0;
         
    /***************************/
    /* function                */
    /***************************/
    /*fetch data*/ 
    function getValue(value_pageid, value_region, value_category, value_model, value_search) {           
        $.post("/res/ajax/getProduct.php", {pageID: value_pageid, region: value_region, category: value_category, model: value_model, search: value_search}, function(data){
            $("#results").html(data);
            pageID++;
       });  
    }

    /***************************/
    /* scroll                  */
    /***************************/
    /*fetch data on scroll*/
    function getValue2(value, value2) {           
        $.post("/res/ajax/getProduct.php", {pageID: value, category: value2}, function(data){
            $("#results").append(data);
            scrollValue = 0;
            pageID++;
       });  
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
    function getSearch(value, value3){		
		$.post("/res/ajax/getProduct.php", {pageID: value, search: value3},function(data){
			$("#results").html(data);
		})
	};
    
    function resetSearch (){
        if ($("#search").val() == ""){
            getValue(pageID, regionID, categoryID, modelID);
        }
    }

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
    var test = [
        {".region": "regionID"}, 
        {".category": "categoryID"}, 
        {".model": "modelID"}
    ];
    
    $.each(test, function(index, value) { 
       
            console.log(index + " + " + value);
       
        /*$(index).on("click", function () {
            pageID = 1;
            item = $(this).attr("id");

            getValue(pageID, regionID, categoryID, modelID);
        });*/
    });

    /*/$(".region").on("click", function () {
        pageID = 1;
        regionID = $(this).attr("id");

        getValue(pageID, regionID, categoryID, modelID);
    });

    $(".category").on("click", function () {
        pageID = 1;
        categoryID = $(this).attr("id");

        getValue(pageID, regionID, categoryID, modelID);
    });

    $(".model").on("click", function () {
        pageID = 1;
        modelID = $(this).attr("id");

        getValue(pageID, regionID, categoryID, modelID);
    });*/

    /***************************/
    /* start 			       */
    /***************************/
    getValue(pageID, regionID, categoryID, modelID, searchID);
    scroll();
    
});