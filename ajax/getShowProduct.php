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
$postData = array("id", "value");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_topic",
[
"[><]forum" => ["forum_topic.forum_id" => "id"],
"[><]forum_thread" => ["forum_thread_id" => "id"],
"[><]forum_thread_setup" => ["forum_thread.forum_thread_setup_id" => "id"],
"[><]product" => ["forum_topic.id" => "forum_topic_id"],
"[><]product_category" => ["product.product_category_id" => "id"],
"[><]product_brand" => ["product.product_brand_id" => "id"],
"[><]product_gear" => ["product.product_gear_id" => "id"],
"[><]product_model" => ["product.product_model_id" => "id"],
"[><]product_capacity" => ["product.product_capacity_id" => "id"],
"[><]product_region" => ["product.product_region_id" => "id"],
"[><]product_region_city" => ["product.product_region_city_id" => "id"],
"[><]product_region_district" => ["product.product_region_district_id" => "id"]
],[
"forum_topic.id",
"forum_topic.image",
"forum_topic.forum_id",
"forum_thread.title",
"forum_thread.added",
"forum_thread.text",
"forum_topic.topic_id",
"product_category.color",
"product_category.title(categoryTitle)",
"product_gear.title(gearTitle)",
"product_brand.title(brandTitle)",
"product_region_city.title(regionCityTitle)",
"product_region_district.title(regionDistrictTitle)",
"product.showProduct",
"created"
],
["AND" =>["forum_topic.forum_id" => "6", "forum_topic.account_id" => "1"], 
"ORDER" => "created DESC", "added ASC"]);

//var_dump($database->error());

foreach($query as $output){
  
    
        if ($output["showProduct"] == 1){
            $data[] = 'Göm';
         }else{ 
            $data[] = 'Visa';
        }
        
        $arr = array("title" => $data);
    
} 
    echo json_encode($arr, JSON_PRETTY_PRINT);
?>