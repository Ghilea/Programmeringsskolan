<?php
/***************************/
/* include				   */
/***************************/
require($_SERVER["DOCUMENT_ROOT"].'/includes/autoloader_class.php'); 
require_once($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

/***************************/
/* new class               */
/***************************/
$newSession = new Session();

/***************************/
/* link menu			   */
/***************************/
$array_menu = [
	["name" => "Hem", "link" => "/index.php"],
	["name" => "Kurser", "link" => "/index.php#education"],
	//["name" => "Butik", "link" => "/pages/shop.php"],
	["name" => "Forum", "link" => "/pages/forum.php"]
];

?>

<!DOCTYPE html>
<html lang="sv">
	<head>

		<!-- TITLE -->
		<title>Programmeringsskolan</title>
		
		<!-- META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- ICON -->
		<link rel="shortcut icon" href="#">

		<!-- CSS -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans|Work+Sans&display=swap" rel="stylesheet">

		<link href="/style.css" rel="stylesheet" type='text/css'/>
	</head>
	<body>

		<div id="wrapContainer">
			<div id="contentWrapper">

				<!-- Header -->
				<header id="header">

					<div class="logo">
						<a href="/index.php" title="Programmeringsskolan"> 
					
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/logo.svg" title="" alt="">
							<p>Programmeringsskolan</p>

						</a>
					</div>

					<label for="toggle-1" class="navControl">
						<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-list-view-hambuger-menu-glyph.svg" title="" alt="">
					</label>

					<input type="checkbox" id="toggle-1">

					<nav class="nav">
						<ul>

							<?php foreach ($array_menu as $output) { ?>

								<li><a href="<?php echo $output["link"]; ?>"><?php echo $output["name"]; ?></a></li>
							
							<?php } if(isset($_SESSION["id"])){ ?>
							
								<li><a class="btnMenu" href="/pages/account.php">Mina sida</a></li>
					
							<?php } else { ?>

								<li><a class="btnMenu" href="/pages/login.php">Logga in</a></li>

							<?php } ?>
	
						</ul>
					</nav>

				</header>