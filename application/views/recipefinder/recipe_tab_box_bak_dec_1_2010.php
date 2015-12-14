<!-- tabs-->
								<ul id="tabset" class="tabset">
									<li class="active"><a href="#tab-1" class="tab"><span>Top Recipes</span></a></li>
									<li><a href="#tab-2" class="tab"><span>New Recipes</span></a></li>
									<li><a href="#tab-3" class="tab"><span>Quick &amp; Easy</span></a></li>
									<li><a href="#tab-4" class="tab"><span>Fat Loss Solos</span></a></li>
								</ul>
								<div class="tab-content-holder tab-content-holder-indent">
									<div class="tab-content" id="tab-1">
										<div class="holder">
											<!-- gallary -->
											<div class="gallery G1">
												<a href="#" class="link-prev">&lt;</a>
												<div>
													<div class="g-holder">
														<ul>
															<?
                              foreach($recipes['top_recipes'] as $ind=>$rval)
                              {
                                ?>
                                <li>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" ><img src="<?echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" class="tab-link"><?echo $rval->title;?></a>
															  </li>
															   
                              <?}?>
                              
														</ul>
													</div>
												</div>
												<a href="#" class="link-next">&gt;</a>
											</div>
										</div>
									</div>
									<div class="tab-content" id="tab-2">
										<div class="holder">
											<!-- gallary -->
											<div class="gallery G1">
												<a href="#" class="link-prev">&lt;</a>
												<div>
													<div class="g-holder">
														<ul>
															<?
                              foreach($recipes['new_recipes'] as $ind=>$rval)
                              {
                                ?>
                                <li>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>"><img src="<?echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" class="tab-link"><?echo $rval->title;?></a>
															  </li>
															   
                              <?}?>
                              
														</ul>
													</div>
												</div>
												<a href="#" class="link-next">&gt;</a>
											</div>
										</div>
									</div>
									<div class="tab-content" id="tab-3">
										<div class="holder">
											<!-- gallary -->
											<div class="gallery G1">
												<a href="#" class="link-prev">&lt;</a>
												<div>
													<div class="g-holder">
														<ul>
															<?
                              foreach($recipes['quick_and_easy'] as $ind=>$rval)
                              {
                                ?>
                                <li>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" ><img src="<?echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" class="tab-link"><?echo $rval->title;?></a>
															  </li>
															   
                              <?}?>
														</ul>
													</div>
												</div>
												<a href="#" class="link-next">&gt;</a>
											</div>
										</div>
									</div>
									<div class="tab-content" id="tab-4">
										<div class="holder">
											<!-- gallary -->
											<div class="gallery G1">
												<a href="#" class="link-prev">&lt;</a>
												<div>
													<div class="g-holder">
														<ul>
															<?
                              foreach($recipes['fat_loss'] as $ind=>$rval)
                              {
                                ?>
                                <li>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" ><img src="<?echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
																<a href="recipefinder/recipe_info/<?echo $rval->rID;?>" class="tab-link"><?echo $rval->title;?></a>
															  </li>
															   
                              <?}?>
														</ul>
													</div>
												</div>
												<a href="#" class="link-next">&gt;</a>
											</div>
										</div>
									</div>
								</div>
