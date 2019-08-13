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
/* new class			   */
/***************************/
$classArray = array("myDate", "myCheck");

foreach ($classArray as $value) {
	${$value} = new $value();
}

/***************************/
/* post data			   */
/***************************/
$postData = array("pageID", "region", "category", "model", "search");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;} 
}


/***************************/
/* variable				   */
/***************************/
//results show each time
$page_rows = 6;
    
/***************************/
/* databas query		   */
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
"[><]product_region_district" => ["product.product_region_district_id" => "id"],
"[><]color" => ["product_category.color_id" => "id"],
],[
"forum_topic.id",
"forum_topic.image",
"forum_thread.added",
"forum_thread.title",
"product_category.title(categoryTitle)",
"product_model.title(modelTitle)",
"product_gear.title(gearTitle)",
"product_brand.title(brandTitle)",
"product_region_city.title(regionCityTitle)",
"product_region_district.title(regionDistrictTitle)"
],[
"AND" =>[

	"OR #the first condition" => ["product_region.id[~]" => $region, "forum_thread.title[~]" => $search, "product_region_district.title[~]" => $search, "product_region_city.title[~]" => $search],

	"OR #the second condition" => ["product_category.id[~]" => $category, "forum_thread.title[~]" => $search, "product_region_district.title[~]" => $search, "product_region_city.title[~]" => $search],

	"OR #the third condition" => ["product_model.id[~]" => $model, "forum_thread.title[~]" => $search, "product_region_district.title[~]" => $search, "product_region_city.title[~]" => $search],

	//"OR" => ["forum_thread.title[~]" => $search, "product_region_district.title[~]" => $search, "product_region_city.title[~]" => $search],

"created" => "1",
"showProduct" => "1",
"product.product_type_id" => "1",
"forum_id" => "6"],
"ORDER" => "added DESC", 
"LIMIT" => [($pageID - 1) * $page_rows, $page_rows]]);

//var_dump($database->error());

/***************************/
/* output                  */
/***************************/
echo "Region: ".$region."category: ".$category."model: ".$model."search: ".$search; ?>

<div class="styleLight">
	<div class="content">

        <?php foreach($query as $output){ ?>

            <div class="col-4-12 col-6-12m">
                <div class="wrap-col boxLight borderGreenTop">

                    <!-- Section 1 picture -->
                    <figure class="image">

                        <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $myCheck->safe($output["title"]); ?>" alt="<?php echo $myCheck->safe($output["title"]); ?>">

                        <figcaption>
                            <?php $myDate->setReDate('%d %B %Y', $output["added"]); ?>
                            <?php echo $myDate->getReDate(); ?>
                        </figcaption>
                    </figure>

                    <!-- Section 2 title and notes -->
                    <h2 class="overflowText">
                        <?php echo $myCheck->safe($output["title"]); ?>
                        </h2>

                    <!-- Section 2 notes-->
                    <p class="overflowText">
                        &#8227; <?php echo $myCheck->safe($output["regionCityTitle"]); ?> (<?php echo $myCheck->safe($output["regionDistrictTitle"]); ?>)
                    </p>

                    <p class="overflowText">
                        &#8227; <?php echo $myCheck->safe($output["modelTitle"]); ?>
                        <?php echo $myCheck->safe($output["categoryTitle"]); ?> 
                        </p>

                    <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">Boka</a>
 
                </div>
            </div>

        <?php } ?>

	</div>
</div>
<script defer src="/res/js/DeferringImages.js"></script>