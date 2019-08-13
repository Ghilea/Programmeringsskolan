<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php");

/***************************/
/* class	               */
/***************************/
$myDate = new Date();
$myBBCode = new BBCode();
$edu = new DataAccess();
$edu->getEducation();

$taskCount = new DataAccess();

$dynRow = new DataAccess($edu->number);
$dynRow->dynamicRow();

$news = new DataAccess(4);
$news->getNews();

?>

<header class="styleMain">
	<div class="content">	
		<div class="centerBox">
			<div class="w1 slide-right">Problemlösning</div>
			<div class="w2 slide-left">Felsökning</div>
			<div class="w3 slide-right">logiskt tänkande</div>
			<p class="fade-in">Vi hjälper dig med grunderna</p>
		</div>
	</div>
</header>


<!-- language -->
<div class="styleSquare">

	<!-- header -->
	<header>
		<div class="col-full squareTitleBox">
			<div class="bgBox">
				<h2>Vad väljer du?</h2>
				<p>Vill du skapa en app till mobilen, en hemsida eller ett spel på datorn? Vilket språket du än väljer kommer du kunna vara kreativ med ditt skapande.</p>
			</div>
		</div>
	</header>

	<div class="col-full">
		<div id="education" class="flex-container">

			<?php $y = 1; $i = 1; for($x = 0; $x < $edu->number; $x++){ ?>

				<?php $taskCount->count("education_task", "education_id", $edu->id[$x]); ?>

				<div class="<?php echo $dynRow->row3Width[$x].' '.$dynRow->row2Width[$x]; ?> boxColor<?php echo $i; if($i == 5){$i = 1;}else{ $i++; } ?> <?php if ($taskCount->number <= 0) { echo "hide"; } ?>">

					<?php if ($taskCount->number >= 1){ ?>
					<a class="link" href="/pages/education.php?id=<?php echo $edu->id[$x]; ?>">
					<?php } ?>

						<div class="difficultyPos"><?php echo $edu->difficulty[$x]; ?></div>

						<!-- Section - image -->
						<div class="col-full">
							<div class="wrap-col">
								<figure class="circleImg">
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $edu->image[$x]; ?>" title="<?php echo $edu->title[$x]; ?>" alt="<?php echo $edu->title[$x]; ?>">
								</figure>
							</div>
						</div>

						<!-- Section - title and text -->
						<div class="col-full">
							<div class="wrap-col">
								<h3 class="wordSplit"><?php echo $edu->title[$x]; ?></h3>
								<p><?php echo $myBBCode->ellipsis($edu->content[$x], 300); ?></p>
							</div>
						</div>

					<?php if ($taskCount->number >= 1){ ?>
						</a>
					<?php } ?>

					<?php if(isset($_SESSION["privilege"]) >= "4"){ ?>
						<!-- hidden settings -->
						<div class="forumBarSetting forumBoxHidden">
							<a href="/pages/editEducation.php?id=<?php echo $edu->id[$x]; ?>">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Ändra
							</a>
						</div>
					<?php } ?>

				</div>

			<?php $y++; } ?>

		</div>
	</div>

</div>	
<!-- End section -->

<!-- News -->
<div class="styleNews">
	
	<!-- header -->
	<header>
		<div class="col-full squareTitleBox">
			<div class="bgBox">
				<h2>Det är gratis!</h2>
				<p>Kurser, aktiviteter, lärarledda kvällslektioner. Vi vill att fler ska få lära sig programmering i sitt eget tempo. En god programmerare kan inte stressas fram. Därför försöker vi också lägga grunden där de som är helt nybörjare inom programmering kan följa med enkelhet.</p>
			</div>
		</div>
	</header>
		
	<!-- information -->
	<div class="col-full">
		<div class="flex-container">

			<?php $i = 1; for($x = 0; $x < $news->number; $x++) { ?>
					
				<div class="<?php if($i == 4 ){ echo "col-full"; }else{ echo "col-4-12"; }?> col-6-12m boxColor<?php echo $i; ?>">
					<div class="wrap-col">

						<a href="#<?php echo $news->id[$x]; ?>">

							<!-- Section - image -->
							<div class="col-full">
								<div class="wrap-col">
		
									<figure class="img">
										<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/shop.svg" title="<?php echo $news->title[$x]; ?>" alt="<?php echo $news->title[$x]?>">
									</figure>
			
								</div>
							</div>

							<!-- Section - title and text -->
							<div class="col-full">
								<div class="wrap-col">
			
									<h3 title="<?php echo $news->title[$x]; ?>"><?php echo $news->title[$x]; ?></h3>
									<p class="<?php if($i == 4 ){ echo "maxWidth"; } ?>"><?php echo $myBBCode->ellipsis($news->content[$x], 300); ?></p>
									

								</div>
							</div>
						</a>

					</div>
				</div>
					
			<?php $i++; } ?>

		</div>
	</div>

</div>
<!-- End section -->

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>