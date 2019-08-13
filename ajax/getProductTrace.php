<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php");

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
$classArray = array("myDate", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* post data               */
/***************************/
$postData = array("pageID", "category", "search");

foreach($postData as $value){
    if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;} 
}

/***************************/
/* variable                */
/***************************/
//results show each time
$page_rows = 6;
    
/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_topic",[
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
"forum_thread.added",
"forum_thread.title",
"product.serialNumber",
"product_category.color",
"product_gear.title(gearTitle)",
"product_region_city.title(regionCityTitle)",
"product_region_district.title(regionDistrictTitle)"
],[
"AND" =>["OR" => ["forum_thread.title[~]" => $search, "product_region_district.title[~]" => $search, "product_region_city.title[~]" => $search, "product_category.id[~]" => $category],
"created" => "1",
"showProduct" => "1",
"product.product_type_id" => "2",
"forum_id" => "6"],
"ORDER" => "added DESC", 
"LIMIT" => [($pageID - 1) * $page_rows, $page_rows]]);

//var_dump($database->error());

/***************************/
/* output                  */
/***************************/
if (is_array($query) || is_object($query))
{
    foreach($query as $output){ ?>
    
    <!-- list -->
    <div class="col-full">
        <div class="wrap-col boxForum border<?php echo $output["color"]; ?>Left">
            
            <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">					
                <!-- Section 1 -->
                <div class="col-2-12 col-4-12m removeSM">
                    <div class="wrap-col">
                        <figure class="image">
                            <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $myCheck->safe($output["title"]); ?>" alt="<?php echo $myCheck->safe($output["title"]); ?>">
                        </figure>
                    </div>
                </div>
                                            
                <!-- Section 2 -->
                <div class="col-10-12 col-8-12m">
                    <div class="wrap-col txtLeft">

                        <h2 class="overflowText">
                            <?php if (empty($output["serialNumber"])){
                                echo $myCheck->safe($output["title"]);
                            }else{ 
                                echo $myCheck->safe($output["serialNumber"]); 
                            } ?>
                        </h2>
                
                        <p class="overflowText">
                            <span>
                                <?php $myDate->setReDate('%d %B %Y', $output["added"]); ?>
                                <?php echo $myDate->getReDate(); ?>
                            </span>
                        </p>
                                                
                        <p class="overflowText">
                            Plats: 
                            <?php echo $myCheck->safe($output["regionCityTitle"]); ?>
                            (<?php echo $myCheck->safe($output["regionDistrictTitle"]); ?>)
                        </p>
                                                
                        <p class="overflowText">
                            Växlar:
                            (<?php echo $myCheck->safe($output["gearTitle"]); ?>)
                        </p>
                        
                    </div>
                </div>
            </a>
        
        </div>
    </div>
			
<?php } 

} ?>
    
<script defer>
	var url = "/res/js/DeferringImages.js";
	$.getScript(url);
</script>