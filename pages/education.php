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

$language = new DataAccess();
$language->getEducation($id);

$task = new DataAccess();
$task->getEducationTask($id);

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
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $language->image[0]; ?>" title="<?php echo $language->title[0]; ?>" alt="<?php echo $language->title[0]; ?>">
						</figure>
						<p><?php echo $myBBCode->useBBCode($language->content[0]); ?></p>
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
						<?php echo $language->title[0]; ?>
					</div>
				</div>
			</div>

		</header>

	<div class="col-full">
		<div class="wrap-col">
			<div class="content">
				
				<div class="flex-container">

					<?php for($x = 0; $x < $task->number; $x++){ ?>

						<div class="col-6-12 col-6-12m">
							<div class="wrap-col boxForum borderWhiteLeft">

								<a href="/pages/educationView.php?id=<?php echo $task->id[$x]?>">
									<h2><?php echo $task->title[$x]; ?></h2>
									<p><?php echo $myBBCode->ellipsis($task->content[$x]); ?></p>
								</a>

							</div>
						</div>

					<?php } ?>

				</div>

			</div>
		</div>
	</div>
	
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>