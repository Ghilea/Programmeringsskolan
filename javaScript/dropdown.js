$(document).ready(function(){

/***************************/
/* variable				   */
/***************************/
var id;
var postCity = $("#region option:selected").val();
var postDistrict = $("#regionCity option:selected").val();
 
/***************************/
/* on change			   */
/***************************/
$("#region").change(function() {
 
 	//reset
	$('#regionCity option').each(function (index, option) {
		if(index!=0){
			$(this).remove();
		}
	});

	//get
	postCity = $("#region option:selected").val();
	dropDown("#regionCity", "getRegionCity", postCity);
});

$("#regionCity").change(function() {
	
	//reset
	$('#regionDistrict option').each(function (index, option) {
		if(index!=0){
			$(this).remove();
		}
	});
	
	//get
    postDistrict = $("#regionCity option:selected").val();   
	dropDown("#regionDistrict", "getRegionDistrict", postDistrict);
});

/***************************/
/* function select		   */
/***************************/
function dropDown(value, value2, value3){
   	
	$.post("/res/ajax/"+ value2 +".php",{key: value3},function(data){
		 
		for(x in data.id){
			
			id = $(""+ value +" option:selected").val();
	
			if(id == data.id[x]){
				var dataSelect = 'selected';
			}else{
				var dataSelect = '';
			};

	        $(value).append("<option value=" + data.id[x] + " " + dataSelect + ">" + data.title[x] + "</option>");
				
		};
		
	}, "json" );
}

/***************************/
/* start				   */
/***************************/	
//City
dropDown("#regionCity", "getRegionCity", postCity);

//District
dropDown("#regionDistrict", "getRegionDistrict", postDistrict);

});