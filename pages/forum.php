<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php");

/***************************/
/* privilegeID		       */
/***************************/
if (isset($_SESSION['id'])) {
	$privilegeID = $_SESSION['privilege'];
}else{
	$privilegeID = "1";
}

/***************************/
/* new class               */
/***************************/
$myCheck = new Check();

$forum = new DataAccess();
$forum->getForum($privilegeID);

?>

<!-- section 1 -->
<div class="styleLight">
	<div class="content">	

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">
					
					<!-- index -->
					<div class="col-full">
						<div class="wrap-col">
							<a href="/pages/forum.php">Forumindex</a>
						</div>
					</div>

					<!-- settings -->
					<?php if(isset($_SESSION["id"]) && ($privilegeID >= "4")){ ?>		
					<div class="col-full">
						<div class="wrap-col">
							<nav class="forumBarSetting">
								<ul>
									<li>
										<a href="/pages/addForum.php">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Skapa forumdel
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

				<?php for($x = 0; $x < $forum->number; $x++){ ?>
					
					<!-- rows -->
					<a href="/pages/forumTopic.php?id=<?php echo $forum->id[$x]?>" title="<?php echo $forum->title[$x]; ?><?php echo $forum->content[$x]; ?>">

						<div class="col-full">
							<div class="wrap-col boxForum border<?php echo $forum->color[$x] ?>Left">

								<!-- box 1 -->
								<div class="col-11-12">
									<div class="wrap-col">
										<h2 class="overflowText"><?php echo $forum->title[$x]; ?></h2>
										<p class="overflowText"><?php echo $forum->content[$x]; ?></p>

										<?php if(isset($_SESSION["id"]) && ($privilegeID >= "4")){ ?>
											
											<!-- hidden settings -->
											<div class="forumBarSetting forumBoxHidden">
												<ul>
													<li>
														<a href="/pages/editForum.php?id=<?php echo $forum->id[$x]; ?>">
															<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Ändra
														</a>
													</li>
													<li>
														<a href="/pages/deleteForum.php?id=<?php echo $forum->id[$id]; ?>">
															<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-trash-delete-recycle-bin-glyph.svg" alt="">Radera
														</a>
													</li>
												</ul>
											</div>
										<?php } ?>

									</div>
								</div>

								<!-- box 2 -->
								<div class="col-1-12 removeM removeSM">
									<div class="wrap-col">
										<h4><?php echo $forum->count[$x]; ?></h4>
										<p class="txtCenter">Trådar</p>
									</div>
								</div>

							</div>
						</div>

					</a>
				<?php } ?>

			</div>
		</div>

	</div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>