<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myBBCode = new BBCode();
$myCheck = new Check($_SESSION["privilege"]);

/***************************/
/* check data		       */
/***************************/
$myCheck->onlineCheck();
$myCheck->getAccess(4);

/***************************/
/* post data               */
/***************************/
$postData = ["privilege", "color", "title", "text", "error"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* databas query           */
/***************************/
$queryColor = $database->select("system_color",["id", "title","color"]);

$queryPrivilege = $database->select("system_privilege",["id", "title"]);

//var_dump($database->error());

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    /***************************/
	/* validate data	       */
	/***************************/
	$check = [
		["name" => "privilege", "regex" => "title", "error" => "privilegeError", "message" => "Du behöver välja rättigheter."],
		["name" => "color", "regex" => "title", "error" => "colorError", "message" => "Du behöver välja färg."],
		["name" => "title", "regex" => "title", "error" => "titleError", "message" => "Du kan använda bokstäver, nummer och de vanligaste symbolerna."],
		["name" => "text", "regex" => "bbCode", "error" => "textError", "message" => "Du kan använda bokstäver, nummer och många av de vanligaste symbolerna."]
	];
	
	foreach($check as $output) {

		//empty space
		if(!$myCheck->checkEmptySpace(${$output["name"]})){

			$error = 1;
			${$output["error"]} = $output["message"];

		//characters
		}else if(!$myCheck->checkInput(${$output["name"]}, $output["regex"])){

			$error = 1;
		    ${$output["error"]} = $output["message"];
		}
	}

	/***************************/
	/* no error			       */
	/***************************/
	if(empty($error)){

		//add to forum
		$database->insert("forum",["title" => $title, "content" => $text, "system_privilege_id" => $privilege, "system_color_id" =>  $color]);

        //send location
        $headerMessage = "Location: /pages/forum.php";
		header($headerMessage); 
	 } 
} ?>

<!-- form -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">

	<!-- section 1 -->
	<div class="styleLight">
		<div class="content">

			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Skapa forumdel</h2>
					    <h4>Välj vilka som kan se denna forumdel, färg och skriv sedan en rubrik och beskriv forumdelen.</h4>
					</div>
				</div>
			</header>
			
			<!-- box -->
			<div class="col-4-12 col-4-12m">
				<div class="wrap-col">
					
					<!-- privilege -->	
					<div class="col-full">
						<div class="wrap-col">
						
							<?php if(isset($privilegeError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $privilegeError;?></p></div><?php } ?>

							<select <?php if(isset($privilegeError)){ ?> class="inputError"; <?php } ?> name="privilege" id="privilege">
								<option value="">Välj privilegier *</option>

									<?php foreach($queryPrivilege as $outputPrivilege){ ?>
									
										<?php if ($privilege == $outputPrivilege["id"]){
											$privilegeData = 'selected="selected"';
										}else{
											$privilegeData = "";
										} ?>
										
										<option value="<?php echo $outputPrivilege["id"]; ?>" <?php echo $privilegeData; ?>> 
											<?php echo $outputPrivilege["title"]; ?>
										</option>
										
									<?php } ?>

							</select>
						</div>
					</div>
					
					<!-- color -->		
					<div class="col-full">
						<div class="wrap-col">

							<?php if(isset($colorError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $colorError;?></p></div><?php } ?>

							<select <?php if(isset($colorError)){ ?> class="inputError"; <?php } ?> name="color" id="color">
								<option value="">Välj färg *</option>
                          
									<?php foreach($queryColor as $outputColor){ ?>
									
										<?php if ($color == $outputColor["id"]){
											$colorData = 'selected="selected"';
										}else{
											$colorData = "";
										} ?>
										
										<option value="<?php echo $outputColor["id"]; ?>" <?php echo $colorData; ?>> 
											<?php echo $outputColor["title"]; ?>
										</option>
										
									<?php } ?>

							</select>
						</div>
					</div>

				</div>
			</div>
			
			<!-- box -->
			<div class="col-8-12 col-8-12m">
				<div class="wrap-col">

					<!-- title -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($titleError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $titleError;?></p></div><?php } ?>

							<input <?php if(isset($titleError)){ ?> class="inputError"; <?php } ?> type="text" name="title" placeholder="Rubrik *" <?php if($myCheck->checkEmptySpace($title)){ ?> value="<?php echo $title; ?>"<?php } ?>>
						</div>
					</div>
					
					<!-- bbcode -->
					<div class="col-full">
						<div class="wrap-col bbCodeMenu">
							<?php echo $myBBCode->bbCodeMenu(); ?>
						</div>
					</div>

					<!-- text -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($textError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $textError;?></p></div><?php } ?>

							<textarea <?php if(isset($textError)){ ?> class="inputError"; <?php } ?> id="text" name="text" rows="10" cols="30" placeholder="Information *"><?php if($myCheck->checkEmptySpace($text)){ echo $text; } ?></textarea>
						</div>
					</div>
	
				</div>
			</div>

			<!-- button -->		
			<div class="col-full">
				<div class="wrap-col">
					<button>Lägg till</button>
				</div>
			</div>

		</div>
	</div>	

</form>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>

<!-- bbCode get to right place in textbox after clicking on a button -->
<script defer src="/javaScript/bbCode.js"></script>