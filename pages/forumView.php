<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php");

/***************************/
/* get data                */
/***************************/
if (isset($_GET["id"])){ $id = intval($_GET["id"]); }else{ $id = null; };

/***************************/
/* new class               */
/***************************/
$myDate = new Date();
$myBBCode = new BBCode();
$myCheck = new Check();
$myPaging = new Paging();
$post = new DataAccess();

/***************************/
/* check data			   */
/***************************/
$myCheck->checkURL("forum_thread", "id", $id);

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

$myPaging->setPaging("forumView", "forum_post", "forum_thread_id", $id, $perPage, $page);

$post->getForumPost($start, $perPage, $id);

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
							<a href="/pages/forumTopic.php?id=<?php echo $post->information["forum_id"]; ?>"><?php  echo $post->information["title"]; ?></a> &gt;
							<?php  echo $post->information["threadTitle"]; ?>
						</div>
					</div>

					<!-- settings -->
					<!-- fixa så det inte visas när tråden är låst -->
					<?php if(isset($_SESSION["id"])){ ?>		
					<div class="col-full">
						<div class="wrap-col">
							<nav class="forumBarSetting">
								<ul>
									<li>
										<a href="/pages/addPost.php?id=<?php echo $id; ?>">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Skriv inlägg
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
		
		<!-- information -->
		<div class="col-full">
			<div class="wrap-col">
				
				<!-- paging -->
				<div class="col-full">
					<div class="wrap-col">
						<?php echo $myPaging->getPaging(); ?>
					</div>
				</div>
				<!-- paging end -->

				<?php for($x = 0; $x < $post->number; $x++){ ?>

                    <!-- box -->
					<div class="col-full">
						<div class="wrap-col boxForum borderWhiteLeft">

							<div class="col-3-12 removeM removeSM">
								<div class="wrap-col">

									<figure class="circleImg">
										<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $post->image[$x]; ?>" alt="">
									</figure>

									<p class="txtCenter">
										<?php echo $post->firstname[$x]." ".$post->lastname[$x]; ?>
									</p>
								</div>
							</div>

							<div class="col-9-12">
								<div class="wrap-col">

									<p class="boxForumText">
                                        <?php echo $myBBCode->useBBCode($post->content[$x]); ?>
                                    </p>
									
									<div class="boxForumSettings">

										<!-- settings -->
										<?php if(isset($_SESSION["id"])){ ?>		
										<div class="col-full">
											<div class="wrap-col">
										
												<ul class="forumBoxHidden">
													<?php if(($_SESSION["id"] == $post->account_id[$x]) || ($_SESSION['privilege'] >= "4")){ ?>
														<li>
															<a href="/pages/editPost.php?id=<?php echo $post->post_id[$x]; ?>&forum_id=<?php echo $post->forum_id[$x]; ?>">
																<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Ändra
															</a>
														</li>
													<?php } ?>
												</ul>
												
											</div>
										</div>
										<?php } ?>

                                        <div class="boxForumDate">
											<?php echo $myDate->rewriteDate('%d %b %Y', $post->created[$x]); ?>
										</div>
								
									</div>

								</div>
							</div>

						</div>
					</div>
		
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