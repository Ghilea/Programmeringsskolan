<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); 

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* new class               */
/***************************/
//$myCount = new myCount();
$myPaging = new Paging();
$topic = new DataAccess();

/***************************/
/* check data			   */
/***************************/
//$myCheck->checkURL("forum", "id", $_GET["id"]);

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

$myPaging->setPaging("forumTopic", "forum_thread", "forum_id", $id, $perPage, $page);

$topic->getTopic($start, $perPage, $id);
?>

<!-- section -->
<div class="styleLight">
	<div class="content">
		
		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<!-- index -->
					<div class="col-full">
						<div class="wrap-col">
							<a href="/pages/forum.php">Forumindex</a> &gt;

							<?php echo $topic->information["title"]; ?>
						
						</div>
					</div>

					<!-- settings -->
					<?php if(isset($_SESSION["id"])){ ?>		
					<div class="col-full">
						<div class="wrap-col">
							<nav class="forumBarSetting">
								<ul>
									<li>
										<a href="/pages/addTopic.php?id=<?php echo $id; ?>">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Skapa tråd
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<?php } ?>

				</div>
			</div>
		</header>
             
        <!-- Forum -->
		<div class="col-full">
			<div class="wrap-col">
				
				<!-- paging -->
				<div class="col-full">
					<div class="wrap-col">
						<?php echo $myPaging->getPaging(); ?>
					</div>
				</div>
				<!-- paging end -->
		
				<?php for($x = 0; $x < $topic->number; $x++){ ?>

					<a href="/pages/forumView.php?id=<?php echo $topic->thread_id[$x]?>" title="<?php echo $topic->title[$x]; ?>">

						<div class="col-full">
							<div class="wrap-col boxForum borderWhiteLeft">

								<div class="col-11-12">
									<div class="wrap-col">

										<h2 class="overflowText"><?php echo $topic->title[$x]; ?></h2>

                                        <?php if(isset($_SESSION["id"]) && ($_SESSION['privilege'] >= "4")){ ?>
										
										<!-- hidden settings -->
										<div class="forumBarSetting forumBoxHidden">
											<ul>
												<li>
													<a href="/pages/editPost.php?id=<?php echo $topic->post_id[$x]; ?>&forum_id=<?php echo $topic->forum_id[$x]?>">
														<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Ändra
													</a>
												</li>
												<li>
													<a href="/pages/deleteTopic.php?id=<?php echo $topic->thread_id[$x]; ?>&forum_id=<?php echo $topic->forum_id[$x]?>">
														<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-trash-delete-recycle-bin-glyph.svg" alt="">Radera
													</a>
												</li>
											</ul>
										</div>
                                        <?php } ?>
                                        
									</div>
								</div>

								<div class="col-1-12 removeM removeSM">
									<div class="wrap-col">
										<h4><?php echo $topic->count[$x]; ?></h4>
										<p class="txtCenter">Svar</p>
									</div>
								</div>
					
							</div>
						</div>
						
					</a>
				<?php } ?>

				<!-- paging -->
				<div class="col-full">
					<div class="wrap-col">
						<?php echo $myPaging->getPaging(); ?>
					</div>
				</div>
				<!-- paging end -->

			</div>
		</div>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>