<?php 
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyCoordination.php");

foreach ($inc as $value) {
    require_once(absPath("2"). $value); 
}

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
	return realpath(dirname(__dir__, $value));
}

/***************************/
/* new class               */
/***************************/
$classArray = array("myCoordination");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* post data               */
/***************************/
if (isset($_POST['value'])){$value = $_POST['value'];}

/***************************/
/* databas query           */
/***************************/ 
$query = $database->select("product",
[
"[><]product_region" => ["product.product_region_id" => "id"],
"[><]product_region_city" => ["product.product_region_city_id" => "id"],
"[><]product_region_district" => ["product.product_region_district_id" => "id"]
],
[
"product_region_district.id",
"product_region_city.title(cityTitle)",
"product_region_district.title(districtTitle)"],
["AND" => ["product.forum_topic_id" => $value], "LIMIT" => "1"]);

//var_dump($database->error());

foreach($query as $output){

	$id = $output["id"];
	$cordination_title = $output["cityTitle"]. " + " .$output["districtTitle"];

	$coordination = $myCoordination->getCoordination($cordination_title);
	$latitude = $coordination['latitude'];
	$longitude = $coordination['longitude'];

}	

$arr = array("id" => $id, "latitude" => $latitude, "longitude" => $longitude);
	
	
echo json_encode($arr, JSON_PRETTY_PRINT); ?>