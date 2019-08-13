<?php
/***************************/
/* include				   */
/***************************/
require_once (absPath("2"). "/res/connection.php");

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
	return realpath(dirname(__dir__, $value));
}

/***************************/
/* post data               */
/***************************/
$postData = array("id", "showProduct");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* database query          */
/***************************/
$database->update("product",
["showProduct" => $showProduct],
["AND" => ["forum_topic_id" => $id]]);

//var_dump($database->error()); ?>