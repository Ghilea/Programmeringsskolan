<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php", "/res/class/classMyBBCode.php");

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
$classArray = array("myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* post data               */
/***************************/
$postData = array("id", "category");

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
"forum_thread.title",
"product_category.title(categoryTitle)",
"product_gear.title(gearTitle)",
"product_brand.title(brandTitle)",
"product_region_city.title(regionCityTitle)",
"product_region_district.title(regionDistrictTitle)"
],[
"AND" =>["OR" => ["product_category.id[~]" => $category],
"created" => "1",
"showProduct" => "1",
"forum_id" => "6"],
"ORDER" => "added DESC", 
"LIMIT" => [($id - 1) * $page_rows, $page_rows]]);

//var_dump($database->error());

/***************************/
/* output                  */
/***************************/
foreach($query as $output){ ?>
					
		<div class="col-2-12 col-4-12m">
			<div class="wrap-col boxForum borderWhiteLeft">

			    <figure class="image">
                    <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">
					    <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $myCheck->safe($output["title"]); ?>" alt="<?php echo $myCheck->safe($output["title"]); ?>">
                    </a>
				</figure>

				<h2 class="overflowText" title="<?php echo $myCheck->safe($output["title"]); ?>">
                    <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">
                        <?php echo $myCheck->safe($output["title"]); ?>
                    </a>
                </h2>
                    	
				<p class="overflowText"><?php echo $myCheck->safe($output["gearTitle"]); ?> (<?php echo $myCheck->safe($output["brandTitle"]); ?>)</p>

                <p class="overflowText txtRight">
                    <span>
                        <?php echo $myCheck->safe($output["regionCityTitle"]); ?> (<?php echo $myCheck->safe($output["regionDistrictTitle"]); ?>)
                    </span>
                </p>

			</div>
		</div>

<?php } ?>

<script defer src="/res/js/DeferringImages.js"></script>