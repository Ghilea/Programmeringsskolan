<?php 

spl_autoload_register('autoloadclass');

function autoloadclass($className){

	$path = $_SERVER["DOCUMENT_ROOT"]."/classes/";
	$extension = "_class.php";
	$fullPath = $path . $className . $extension;

	if(!file_exists($fullPath)){
		return false;
	}

	include_once($fullPath);
}

?>