<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php");

/***************************/
/* post data               */
/***************************/
$postData = ["email", "password", "error"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

/***************************/
/* new class               */
/***************************/
$login = new DataAccess();
$myCheck = new Check();

/***************************/
/* send form			   */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$login->login($email, $password);

	// no errorMessage
	if(empty($login->errorMessage)){

		//add sessions
		$newSession->setSessionData("id", $login->id["id"]);
		$newSession->setSessionData("privilege", $login->privilege);

		//send location
		header("Location: /index.php");
 	}
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
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/login-enter-signin-glyph.svg" alt="">
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<h2>Logga in</h2>
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($login->errorMessage["errorAll"])){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $login->errorImage;?>" alt=""><p><?php echo $login->errorMessage["errorAll"];?></p></div><?php } ?>
						</div>
					</div>

				</div>
			</div>
		</header>

		<!-- formulär -->
		<form id="loginForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">

			<!-- information -->
			<div class="col-full">
				<div class="wrap-col ">

						<div class="col-full">
							<div class="wrap-col">

								<?php if(isset($login->errorMessage["errorEmail"])){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $login->errorImage;?>" alt=""><p><?php echo $login->errorMessage["errorEmail"];?></p></div><?php } ?>

								<input <?php if(isset($emailError)){ ?> class="inputError"; <?php } ?> type="text" name="email" placeholder="E-postadress *" <?php if($myCheck->checkEmptySpace($email)){ ?> value="<?php echo $email; ?>"<?php } ?>>

							</div>
						</div>

						<div class="col-full">
							<div class="wrap-col">

								<?php if(isset($login->errorMessage["errorPassword"])){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $login->errorImage;?>" alt=""><p><?php echo $login->errorMessage["errorPassword"];?></p></div><?php } ?>

								<input <?php if(isset($passwordError)){ ?> class="inputError"; <?php } ?> type="password" name="password" placeholder="Lösenord *" <?php if($myCheck->checkEmptySpace($password)){ ?> value="<?php echo $password; ?>"<?php } ?>>

							</div>
						</div>

				</div>
			</div>

			<!-- Button -->
			<div class="col-full">
				<div class="wrap-col">
					<button>Logga in</button>
				</div>
			</div>

		</form>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>