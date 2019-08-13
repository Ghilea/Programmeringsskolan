<?php
/***************************/
/* include				   */
/***************************/
require (absPath("2"). "/res/connection.php");

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
	return realpath(dirname(__dir__, $value));
}

/***************************/
/* post data               */
/***************************/
if (isset($_POST['key'])){$key = $_POST['key'];}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("product_region_city",
["id","title"],
["AND" => ["product_region_id" => $key, "id" => "243"],
"ORDER" => "title ASC"]);

//var_dump($database->error());

/***************************/
/* output 		           */
/***************************/
foreach($query as $output){

	$id[] = $output["id"];
	$title[] = $output["title"];
	
	$arr = array("id" => $id, "title" => $title);
	
}	
	
echo json_encode($arr, JSON_PRETTY_PRINT); ?>