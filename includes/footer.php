<?php 

	$tableArray = [
		["title" => "Aktivitet- & lärorum", "name" => "fActivity"],
		["title" => "Samarbetspartner", "name" => "fPartners"],
		["title" => "Undervisning i skola", "name" => "fShool"],
		["title" => "Om programmeringsskolan", "name" => "fAbout"],
	];

	/***************************/
	/* link footer			   */
	/***************************/
	$fActivity = [
		["name" => "Prova på dag", "link" => "#"],
		["name" => "Mina sida", "link" => "#"],
		["name" => "Kontakta oss", "link" => "/pages/contact.php"]
	];

	$fPartners = [
		["name" => "Företagsnamn", "link" => "#"],
		["name" => "Företagsnamn", "link" => "#"],
		["name" => "Företagsnamn", "link" => "#"]
	];

	$fShool = [
		["name" => "Förskolan", "link" => "#"],
		["name" => "Förskoleklass", "link" => "#"],
		["name" => "Grundskolan", "link" => "#"],
		["name" => "Gymnasiet", "link" => "#"]
	];

	$fAbout = [
		["name" => "Historia", "link" => "/pages/about.php"],
		["name" => "FAQ - Vanligt ställda frågor", "link" => "/pages/faq.php"],
		["name" => "Teknisk support", "link" => "#"],
		["name" => "Vi som jobbar här", "link" => "#"],
		["name" => "Jobba hos oss", "link" => "#"]
	];
?>

<!-- content container -->
</div>
	
	<!-- footer -->
	<div class="styleFooter">
		<div class="content">

			<div class="col-full">
				<div class=wrap-col>
				
					<!-- loop table by section -->
					<?php foreach ($tableArray as $section) { ?>
						<div class="col-3-12 col-6-12m">
							<div class="wrap-col">
								
								<h3><?php echo $section["title"] ?></h3>
								
								<ul>
									<?php foreach (${$section["name"]} as $output) { ?>

										<li><a href="<?php echo $output["link"]; ?>"><?php echo $output["name"]; ?></a></li>
									
									<?php } ?>
								</ul>

							</div>
						</div>
					<?php } ?>

				</div>
			</div>

		</div>
	</div>

	<div class="copyright">
		<p>Copyright &copy; 2019 Programmeringsskolan</p>
	</div>

</div> <!-- wrapContainer -->

		<!-- show video embed -->
		<div class="overlay-video">
			<div class="videoWrapperExt">
				<div class="videoWrapper">
					<iframe id="player" src="" allowfullscreen></iframe>
				</div>
			</div>
		</div>

		<!-- JQUERY -->
		<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<!-- Deferring Images -->
		<script defer src="/javaScript/DeferringImages.js"></script>

		<!-- overlay video -->
		<script defer src="/javaScript/overlayVideo.js"></script>

	</body>
</html>