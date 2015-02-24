<?php 

if ($guestbook) :
							
							foreach ($guestbook as $value) :

								$post = $value["message"];
								$username = $value["username"];

						?>
								
						<div id="toggle">

							<div class="postinfo"><h1><?= find_at_tag_profile($username).  " " .$value["dateofpost"]; ?></h1></div> 

							<div class="usermessage"><p><?= find_hashtags($post); ?></p></div>
							
							<?php if ($value["picpath"]) : ?>

							<div class="postpic"><img src="<?= $value["picpath"]; ?>"></div>

							<?php endif; endforeach; ?>

						</div>

						<div class="toggle">

							<div class="commentfield">

								<form action="profile.php" method="POST">
								<input type="text" name="comment" class="commentinput">
								<input type="hidden" name="id" value="<?= $value["id"]; ?>">
								<button type="submit" class="commentbutton">comment</button>

								</form>

							</div>


							<?php	$getcomments = getComments($value["id"]);

									if ($getcomments) :

										foreach ($getcomments as $value) :
											
											$post = $value["message"];
											$username = $value["username"];
											$userpath = ltrim ($username, '@');
											$userpath = getUserpath($userpath);

							?>

							<div class="commentinfo">

								<?php foreach ($userpath as $path) : ?>
													
								<h1><?= find_at_tag_viewuser($username, $path["userpath"]). " " .$value["dateofpost"]; ?></h1>

								<?php endforeach; ?>

							</div>

							<div class="comment">

								<p><?= find_hashtags($post); ?></p>

							</div>

							<?php endforeach; endif; ?>

							<hr>

						</div>

						<?php else : ?>

						<h1 class="emptyresult"><?= "Write your first post here!"?></h1>

						<?php endif ?>


<?php if ($guestbookpost) :
									
									foreach ($guestbookpost as $value) :

										$post = $value["message"];
										$username = $value["username"];
										$userpath = ltrim ($username, '@');
										$userpath = getUserpath($userpath); ?>

										<div id="toggle">
											<div class="postinfo">
								
											<?php foreach ($userpath as $path) : ?>
													
												<h1><?= find_at_tag_viewuser($username, $path["userpath"]). " " .$value["dateofpost"]; ?></h1>

											<?php endforeach; ?>
										
											</div> 
											<div class="usermessage">
												<p><?= find_hashtags($post); ?></p>
											</div>
												
											<div class="postpic">
												<img src="<?php if($value["picpath"]) { print $value["picpath"]; } ?>">
											</div>
												
										</div> 
										
										<div class="toggle">
											<div class="commentfield">
												<form action="savecommentview.php" method="POST">
											
													<input type="text" name="comment" class="commentinput">
													<input type="hidden" name="id" value="<?= $value["id"]; ?>">
													<button type="submit" class="commentbutton">comment</button>

												</form>
											</div>

										<?php endforeach; 

											$getcomments = getComments($value["id"]);

											if ($getcomments) :

												foreach ($getcomments as $value) :

													$post = $value["message"];
													$username = $value["username"];
													$usernameat = ltrim ($username, '@');
													$userpath = getUserpath($usernameat);

										?>

										<div class="commentinfo">

											<?php if ($usernameat == $profilename) : ?>

												<h2><?= find_at_tag_profile($username); ?><h2>

											<?php 

												else :

													foreach ($userpath as $path) : 

											?>
														
												<h2><?= find_at_tag_viewuser($username, $path["userpath"]). " " .$value["dateofpost"]; ?></h2>

											<?php 

												endforeach;

												endif;

											?>
												
										</div>

										<div class="comment">

											<p><?= find_hashtags($post); ?></p>

										</div>

										<?php endforeach; endif; ?>

										<hr>

										</div>

								<?php else : ?>

								<h1 class="emptyresult"><?= $userinfo["username"]. " hasn't written any posts so far!"; ?></h1>

								<?php endif; ?>