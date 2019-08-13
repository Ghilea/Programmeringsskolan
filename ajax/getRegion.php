<?php 
/***************************/
/* include				   */
/***************************/
require(absPath(2). "/res/connection.php");

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
	return realpath(dirname(__dir__, $value));
}

/***************************/
/* post data               */
/***************************/
if (isset($_POST['searchKey'])){$searchKey = $_POST['searchKey'];}

/***************************/
/* databas query           */
/***************************/
if (isset($_POST['searchKey'])){
	$query = $database->select("product_region_city",
	["id","title"], 
	["AND" => ["product_region_id" => $searchKey],
	"ORDER" => "title ASC"]);

	//var_dump($database->error());
}
	
	
foreach($query as $output){

	$id[] = $output["id"];
	$title[] = $output["title"];
	
	$zone = array("id" => $id, "title" => $title);
	
}	
	
echo json_encode($zone, JSON_PRETTY_PRINT);
?>