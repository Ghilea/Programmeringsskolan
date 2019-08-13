<?php
/***************************/
/* include				   */
/***************************/
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php");

/***************************/
/* new class               */
/***************************/
$myCheck = new Check($_SESSION["privilege"]);
$myCheck->onlineCheck();

$account = new DataAccess();
$account->getAccount($_SESSION["id"]);

$logout = new DataAccess();

$uploadImg = new Upload();

/***************************/
/* postdata                */
/***************************/
$postData = ["email", "image", "address", "city", "zipCode", "phoneNumber", "password", "repassword", "showImage", "showMail", "showPhoneNumber"];

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* array                   */
/***************************/
$data = ["OCR", "Datum", "Status", "Summa"];

/***************************/
/* logout				   */
/***************************/
if(isset($_GET['logout'])) {
	
	$logout->logout($_SESSION["id"]);

	$newSession->closeSession();
	
	header("Location: /index.php"); exit;
}

/***************************/
/* database                */
/***************************/
$linkArray = [
	["name" => "Lägg till kurser", "link" => "addEducation.php", "image" => "editor-pencil-pen-edit-write-glyph.svg"],
	["name" => "Lägg till nyheter", "link" => "account.php", "image" => "editor-pencil-pen-edit-write-glyph.svg"],
	["name" => "Bokningar", "link" => "#", "image" => "editor-notebook-outline-stroke.svg"], 
	["name" => "Avsluta medlemskap", "link" => "#", "image" => "editor-pencil-pen-edit-write-glyph.svg"],
	["name" => "Logga ut", "link" => "account.php?logout", "image" => "editor-pencil-pen-edit-write-glyph.svg"],
];

/***************************/
/* send form               */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	/***************************/
	/* validate data	       */
	/***************************/
    /*$check = [
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
	}*/

	//error message
	$checkError = "<h3>Du måste fylla i alla fält som kräver det.</h3>";
	
	//no error message
	$noErrorMessage = "<h3>Informationen ändrades utan några problem.</h3>";
	
	//header message
	$headerMessage = "location: /pages/account.php";

	/***************************/
	/* validate data	       */
	/***************************/
	$check = $email && $address && $city && $zipCode && $phoneNumber;
    
	if(!$myCheck->checkEmptySpace($check)){
		$errorMessage = $checkError;
	}else{
	
        $checkInput = [
            "city" => "letters",
            "address" => "letters&numbers",
            "phoneNumber" => "phoneNumber",
            "zipCode" => "zipCode"
		];
        
        $inputErrors = [
            "Staden får bara innehålla bokstäver.",
            "Adressen får bara innehålla bokstäver.",
            "Telefonnummret får bara innehålla siffror.",
            "Postnummret får bara innehålla siffror."
		];
        
        //variable
        $x = 0;
        
        //create inputcheck
        foreach($checkInput as $value => $value2){
            
            if(!$myCheck->checkInput(${$value}, $value2)){
		        $errorMessage = $inputErrors[$x];
	        }
            
            $x++;
        }
        
		//email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errorMessage = "E-postadressen verkar inte vara giltig skriven."; 
		}
			
		//email already exist
		if(!$database->has("account_information",["AND" => ["email" => $email]])){
			$errorMessage = 'E-postadressen finns redan.';
		}
	
		/*if ($myCheck->checkEmptySpace($password)){
			
            //password
			if (strlen ($password) < 6)
			{
				$errorMessage = 'Lösenordet måste minst innehålla 6 tecken.';
			}
			
            //password must be the same
			if($password != $repassword)
			{
				$errorMessage = 'Lösenorden måste vara likadana.';
			}
			
		}*/
        
        //upload image
		if(!empty($_FILES['image']['name'])){

			//check image size
			if ($_FILES["image"]["size"] > 500000){
				$errorMessage = 'Bilden är för stor.';
			}

			//check image format
			if($_FILES["image"]["type"] != "image/jpg" && $_FILES["image"]["type"] != "image/png" && $_FILES["image"]["type"] != "image/jpeg"){
				$errorMessage =  "Du kan bara ladda JPG, JPEG eller PNG bilder.";
			}
		}

	}
	
	/***************************/
	/* no errorMessage	       */
	/***************************/
	if(empty($errorMessage)){ 
		
        //add account_setup		
		/*$database->update("account_settings",
		["showImage" => $showImage, "showMail" => $showMail, "showPhoneNumber" => $showPhoneNumber],["AND" => ["id" => $_SESSION["id"]]]);
		
        //add account_information	
		$database->update("account_information",
		["address" => $address, "city" => $city, "zipCode" => $zipCode, "phoneNumber" => $phoneNumber, "email" => $email],["AND" => ["id" => $_SESSION["id"]]]);
		*/
		//add image
		if (!empty($_FILES['image']['name'])){

			$image = $uploadImg->image($_SESSION["id"], $_FILES["image"]["name"], $_FILES["image"]["tmp_name"], "../uploads/account/");

			$database->update("account",
			["image" => $image],["AND" => ["id" => $_SESSION["id"]]]);

		}
				
		/*if ($myCheck->checkEmptySpace($password)){
			$securedCryptPassword = password_hash($password, PASSWORD_DEFAULT);
		
			$database->update("account",
			["password" => $securedCryptPassword],["AND" => ["id" => $_SESSION["id"]]]);
		}*/
		
		//send location
		header($headerMessage); ?>

		<div class="col-full noError">
			<div class="wrap-col">
				<?php echo $noErrorMessage; ?>
			</div>
		</div>
		
	<?php }else{ ?>

		<div class="col-full error">
			<div class="wrap-col">
				<h3><?php echo $errorMessage; ?></h3>
			</div>
		</div>

	<?php }
} ?>

<!-- Main -->
<div class="styleOverlay">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-setting-gear-glyph.svg" alt="">
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<h2>Inställningar</h2>
						</div>
					</div>

				</div>
			</div>
		</header>

		<!-- information -->
		<div class="col-4-12">
			<div class="wrap-col ">

				<div class="col-full">
					<div class="wrap-col">
						<h3>Konto</h3>
						<ul>
							<?php foreach ($linkArray as $output){ ?>
							<a href="/pages/<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>">
								<li>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/<?php echo $output["image"];?>">

									<p><?php echo $output["name"]; ?></p>

								</li>
							</a>
							<?php } ?>
						</ul>

					</div>
				</div>

			</div>
		</div>

		<!-- right side -->
		<div class="col-8-12">
			<div class="wrap-col ">
				
				<!-- 					-->
		<!-- payment			-->
		<!-- 					-->
		<div class="col-full">
			<div class="wrap-col">

				<?php foreach ($data as $output){ ?>

					<div class="col-3-12 col-3-12m removeSM txtCenter">
						<div class="wrap-col">
							<p class="overflowText"><?php echo $output; ?></p>
						</div>
					</div>

				<?php } ?>

				<!-- information -->
				<?php for($x = 0; $x < $account->number; $x++){ ?>

					<div class="col-full">
						<div class="wrap-col boxForum borderWhiteLeft">

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentNumber[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentDate[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentStatus[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentFee[$x]; ?></p>
								</div>
							</div>

						</div>
					</div>

				<?php } ?>

			</div>
		</div>

				<!-- view -->
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">

				<div class="col-full">
					<div class="wrap-col">

								<!-- profile picture -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Profilbild</p>

										<figure class="accountPicture">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $account->information["image"]; ?>" alt="">
												
											<figcaption>
												<input type="file" name="image" id="imageInput">
											</figcaption>
										</figure>

									</div>
								</div>

								<!-- address -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Adress</p>

										<input title="Adress" type="text" name="address" placeholder="Adress" <?php if($myCheck->checkEmptySpace($address)){ ?> value="<?php echo $address; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["address"]); ?>"<?php } ?>>

									</div>
								</div>

								<div class="col-8-12 col-4-12m">
									<div class="wrap-col">
	
										<input title="Stad" type="text" name="city" placeholder="Stad" <?php if($myCheck->checkEmptySpace($city)){ ?> value="<?php echo $city; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["city"]); ?>"<?php } ?>>

									</div>
								</div>

								<div class="col-4-12 col-4-12m">
									<div class="wrap-col">
													
										<input title="Postnummer" type="text" name="zipCode" placeholder="Postnummer" <?php if($myCheck->checkEmptySpace($zipCode)){ ?> value="<?php echo $zipCode; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["zipCode"]); ?>"<?php } ?>>

									</div>
								</div>

								<!-- phonenumber -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Telefonnummer</p>

										<input title="Telefonnummer" type="text" name="phoneNumber" placeholder="Telefonnummer" <?php if($myCheck->checkEmptySpace($phoneNumber)){ ?> value="<?php echo $phoneNumber; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["phoneNumber"]); ?>"<?php } ?>>

									</div>
								</div>

								<!-- email -->
								<div class="col-full">
									<div class="wrap-col">
										<p>E-postadress</p>

										<input title="E-postadress" type="text" name="email" placeholder="E-postadress" <?php if($myCheck->checkEmptySpace($email)){ ?> value="<?php echo $email; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["email"]); ?>"<?php } ?>>

									</div>
								</div>

							</div>
						</div>

						<div class="col full">
							<div class="wrap-col">

								<div class="col-full">
									<div class="wrap-col">
										<p>Foruminställningar</p>

										<!-- show image -->
										<input type="checkbox" name="showImage" id="showImage" value="1" <?php if(($showImage == "1") || ($account->information["showImage"] == "1")){ ?> checked="checked" <?php } ?>>			
													
										<label id="imageShow" title="Visa bild" for="showImage"></label>Visa bild<br>

										<!-- show mail -->
										<input type="checkbox" name="showMail" id="showMail" value="1" <?php if(($showMail == "1") || ($account->information["showEmail"] == "1")){ ?> checked="checked" <?php } ?>>
													
										<label id="mailShow" title="Visa e-postadress" for="showMail"></label>Visa e-postadress<br>

										<!-- show phone number-->
										<input type="checkbox" name="showPhoneNumber" id="showPhoneNumber" value="1" <?php if(($showPhoneNumber == "1") || ($account->information["showPhoneNumber"] == "1")){ ?> checked="checked" <?php } ?>>
													
										<label id="phoneShow" title="Visa telefonnummer" for="showPhoneNumber"></label>Visa telefonnummer<br>

									</div>
								</div>

							</div>
						</div>

						<div class="col full">
							<div class="wrap-col">

								<div class="col-full">
									<div class="wrap-col">
										<p>Lösenord</p>
											
										<input title="Lösenord" type="password" name="password" placeholder="Nuvarande lösenord" <?php if($myCheck->checkEmptySpace($password)){ ?> value="<?php echo $password; ?>"<?php } ?>>
									</div>
								</div>

								<div class="col-full">
									<div class="wrap-col">
												
										<input title="Upprepa lösenord" type="password" name="repassword" placeholder="Upprepa lösenord" <?php if($myCheck->checkEmptySpace($repassword)){ ?> value="<?php echo $repassword; ?>"<?php } ?>>
									</div>
								</div>

							</div>
						</div>

					<!-- button -->		
					<div class="col-full">
						<div class="wrap-col">
							<button>Uppdatera</button>
						</div>
					</div>

				</form>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>