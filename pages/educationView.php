<?php 
/***************************/
/* include				   */
/***************************/
include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php");

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* new class               */
/***************************/
$myCheck = new Check();
$myCheck->checkURL("education", "id", $id);

$myBBCode = new BBCode();

$task = new DataAccess();
$task->getEducationTaskView($id);

?>

<!-- section1 -->
<div class="styleLight">

	<!-- header -->
		<div class="col-full headerBox">
			<div class="bgBox">
				
				<div class="content">
					<div class="col-full">
						<div class="wrap-col">
							<figure class="circleImg">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $task->information["image"]; ?>" title="<?php echo $task->information["title"]; ?>" alt="<?php echo $task->information["title"]; ?>">
							</figure>
							<h2><?php echo $task->information["title"]; ?></h2>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- header -->
		<header>
			<!-- index -->
			<div class="col-full">
				<div class="wrap-col">
					<div class="eduMenu">
						<a href="/index.php#education">Kurser</a> &gt;
						<a href="/pages/education.php?id=<?php echo $task->information["id"]; ?>"><?php echo $task->information["education_title"]; ?></a> &gt;
						<?php echo $task->information["title"]; ?>
					</div>
				</div>
			</div>
		</header>

		<div class="col-full">
			<div class="wrap-col">
				<div class="content">

					<div class="col-3-12 col-4-12m">
						<div class="wrap-col">

							<div class="task">
								<h3>Video</h3>
								<ul>
									<?php for($x = 0; $x < $task->information["video"]; $x++){ ?>
										<div class="js-overlay-start" data-url="<?php echo $task->content[$x]; ?>?rel=0&amp;showinfo=0&amp;autoplay=1">
											<li class="boxForum borderBlueLeft"><?php echo $task->title[$x]; ?></li>
										</div>
									<?php } ?>
								</ul>

								<h3>Övningar</h3>
								<ul>
									<?php for($x = 0; $x < $task->information["training"]; $x++){ ?>
										<a href="#">
											<li class="boxForum borderGreenLeft"><?php echo $task->title2[$x]; ?></li>
										</a>
									<?php } ?>
								</ul>
							</div>

						</div>
					</div>
		
					<div class="col-9-12 col-8-12m">
						<div class="wrap-col">
							
							<div class="flex-container">
									
								<!-- information -->
								<div class="col-full">
									<div class="wrap-col">
										<p><?php echo $myBBCode->useBBCode($task->information["content"]); ?></p>
									</div>
								</div>

							</div>

						</div>
					</div>

			</div>
		</div>
	</div>

</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>