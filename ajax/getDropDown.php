<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php");

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
/* post data               */
/***************************/
$postData = array("id");

foreach($postData as $value){
    if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;} 
}
    
/***************************/
/* databas query           */
/***************************/
$query = $database->select("product_region_city",
["id","title"],
["AND" => 
[
"product_region_id" => $id
],
"ORDER" => "title ASC"
]);

//var_dump($database->error()); ?>

<div class="col-4-12 col-4-12m">
	<div class="wrap-col">							
				
        <select name="regionCity" id="regionCity">
		    <option>Välj Kommun</option>
								
			<?php foreach($query as $output){ ?>

				<option value="<?php echo $output["id"]; ?>">
                    <?php echo $output["title"]; ?>
                </option>

			<?php } ?>
								
		</select>
	</div>
</div>