$(document).ready(function(){

//***************************/
//* function	            */
//***************************/
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    url = url.toLowerCase(); // This is just to avoid case sensitiveness  
    name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();// This is just to avoid case sensitiveness for query parameter name
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

//***************************/
//* variable	            */
//***************************/
var map;
var id = getParameterByName('id');

//***************************/
//* map		                */
//***************************/
$.post("/res/ajax/getDistrictZone.php", {value:id}, function(data){
    var cityMap = new google.maps.LatLng(data.latitude, data.longitude);
    
    //google map		
    var mapClassic = document.getElementById("styleMap");
    var mapClassicOptions = {
        center: cityMap,
        zoom: 11,
        minZoom: 10,
        maxZoom: 12,
        zoomControl: true,
        disableDefaultUI: true,
        scrollwheel: false,
        navigationControl: false,
        scaleControl: false,
        draggable: false,
        clickable: false,
        disableDoubleClickZoom: true,
        mapTypeId:google.maps.MapTypeId.TERRAIN//HYBRID
    };
            
    map = new google.maps.Map(mapClassic, mapClassicOptions);

    var layer = new google.maps.FusionTablesLayer({
        query: {
            select: "geometry",
            from: "1FDzgn9W0YqiN6bP7S3no08tf6FIX2ZsIOhh-FCK6",
            where: "'id' = "+data.id+""
        },
        map: map,
        styleId: 2,
        templateId: 2,
        clickable: false,
  });

}, "json");

});
