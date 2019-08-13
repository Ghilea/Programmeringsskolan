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
/* get data                */
/***************************/
$postData = array("id");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* databas query           */
/***************************/
$database->update("account_setup",
["mailReceived" => null],
["AND" => ["privilege" => $id]]);

//var_dump($database->error());

?>