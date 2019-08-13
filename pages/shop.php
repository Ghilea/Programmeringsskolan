<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myBBCode = new BBCode();
$myPaging = new Paging();
    
/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["added"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* paging		           */
/***************************/
if(isset($_GET["page"])){
	$page = intval($_GET["page"]);
}else{
	$page = 1;
}

$perPage = 15;
$calc = $perPage * $page;
$start = $calc - $perPage;

$myPaging->setPaging("shop", "product", "id", null, $perPage, $page);

/***************************/
/* databas query           */
/***************************/
$queryProduct = $database->select("product",[
	"[><]account" => ["account_id" => "id"],
	"[><]account_information" => ["account.account_information_id" => "id"],
	"[><]account_settings" => ["account.account_settings_id" => "id"]
],[
	"product.id",
	"product.title",
	"product.content",
	"product.price",
	"product.image",
	"product.quantity_in_stock",
	"product.quantity_on_order",
	"account_information.firstname",
	"account_information.lastname",
	"account_information.phoneNumber",
	"account_information.email"
],[
	"ORDER" => ["product.title" => "ASC"],
	"LIMIT" => [$start, $perPage]]);

//var_dump($database->error());

/***************************/
/* array                  */
/***************************/ 
$categoryMenuArray = [
	["name" => "Hud & sår", "link" => "#"], 
	["name" => "Värk & leder", "link" => "#"],
	["name" => "Uppiggande", "link" => "#"],
	["name" => "Sport & träning", "link" => "#"],
	["name" => "Livsmedel & dryck", "link" => "#"],
	["name" => "Vitaminer & mineraler", "link" => "#"],
	["name" => "Skor & kläder", "link" => "#"],
	["name" => "Sport & träning", "link" => "#"],
	["name" => "Näsa, mun & hals", "link" => "#"],
	["name" => "Förkylning", "link" => "#"],
	["name" => "Intim, lust & sex", "link" => "#"],
]; ?>

<!-- section1 -->
<div class="styleShop">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<h2>Butik</h2>
							
							<h4>Ge ditt stöd till att göra alla kurser/aktiviteter helt gratis</h4>
						</div>
					</div>

				</div>
			</div>
		</header>
		
		<div class="col-full">
			<div class="wrap-col">
				
			<div class="col-3-12 col-4-12m categoryMenu">
				<div class="wrap-col">
				<div class="showShoping">
						<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/shoping_bag.svg" title="" alt="">
						<p>4 varor</p>
					</div>
					<h3>Produkter</h3>
					<ul>
						<?php foreach ($categoryMenuArray as $output){ ?>
						<a href="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>">
							<li>
								<p><?php echo $output["name"]; ?></p>
							</li>
						</a>
						<?php } ?>
					</ul>
				</div>
			</div>

				<div class="col-9-12 col-8-12m flex-container">

					<?php foreach($queryProduct as $output){ ?>
						
						<!-- information -->
						<div class="col-4-12 col-6-12m">
							<div class="wrap-col">

								<!-- picture -->				
								<div class="col-full">
									<div class="wrap-col">

										<div class="product">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="<?php echo $output["title"]; ?>">

											<div class="priceTag">
												<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/heart.svg" title="<?php echo $output["price"]; ?> kr" alt="">
												
												<div class="priceTagText">
													<?php echo $output["price"]; ?>:-
												</div>
											</div>

											
										</div>

									</div>
								</div>

								<!-- text -->
								<div class="col-full">
									<div class="wrap-col">

										<div class="tit"><?php echo $output["title"]; ?></div>

										<div class="sub">
											<?php echo $myBBCode->useBBCode($output["content"]); ?>
										</div>

										<!-- Section - link -->
										<div class="button">
											<a href="#">Köp</a>
										</div>
		
									</div>
								</div>

							</div>
						</div>

					<?php } ?>

				</div>

				<!-- paging -->
				<div class="col-full">
					<div class="wrap-col pagingBox">
						<?php echo $myPaging->getPaging(); ?>
					</div>
				</div>
				<!-- paging end -->

			</div>
		</div>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>