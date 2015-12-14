<div class="links-block">
			<a class="about-page" href="#">How do I use this page</a>
			<a class="journal finder" href="#">Recipe Finder</a>
			<?php $this->load->view('recipefinder/recipe_finder_box'); ?>
</div>
<div class="recipe-list-area">
			<a href="#">Return to Recipe Finder &gt;</a>
</div>
<div class="container">
		<div class="block-in-blue block-in-blue-large">
			<div class="block-in-holder-blue">
					<?php //$this->load->view('recipefinder/recipe_findby_ingredients'); ?>		
			</div>
		</div>
</div>
<div class="search-result">
			<? $this->load->view('recipefinder/recipe_filter_box'); ?>
</div>

<div class="schedule-block recipe-search-box">
			<?php if(!empty($recipes_results))foreach($recipes_results as $ind=>$recipe){?>
								
                <div class="schedule-block-area">
									<div class="schedule-box odd">
										<div class="holder">
											<div class="image-box">
												<img src="<?php echo RECIPE_IMAGE_LOC;if(!empty($recipe->recipe_image)) echo $recipe->recipe_image; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="<?php echo $recipe->recipe_name;?>"   width="79" height="81"/>
											</div>
											<div class="info-box">
												<h3 class="heding-info-box heding-info-box-like">
													<a href="recipefinder/recipe_details/<?php echo $recipe->rID;?>"><?php echo $recipe->title;?></a>
												</h3>
												<div class="text-box">
													<p><?php echo $recipe->desc;?></p>
													<strong class="title-recipe">by member: <!--a href="#">francescabella10</a--></strong>
												</div>
											</div>
											<div class="image-box image-box-right">
												<a href="#"><img src="images/img32.png" alt="" width="48" height="48" /></a>
											</div>
											<img src="htdocs/images/img-stars<?php echo $recipe->ratings ;?>.gif" />
										</div>
									</div>
								</div>
								
								<!--div class="schedule-block-area">
									<div class="schedule-box">
										<div class="holder">
											<div class="image-box">
												<img src="images/img33.gif" alt="" width="74" height="75" />
											</div>
											<div class="info-box">
												<h3 class="heding-info-box">
													<a href="#">Pin-wheel Style Braciole &amp; Broccoli</a>
												</h3>
												<div class="text-box">
													<p>A lean beef braciole with a side of steamed broccoli.</p>
													<strong class="title-recipe">by member: <a href="#">francescabella10</a></strong>
												</div>
											</div>
											<div class="image-box image-box-right">
												<a href="#"><img src="images/img34.png" alt="" width="48" height="48" /></a>
											</div>
										</div>
									</div>
								</div-->
	           <?php }?>			
</div>
<div class="container">
								<div class="paging-holder">
									<a href="#" class="link-prev">&lt;</a>
									<ul>
										<li><a href="#" class="active">1</a></li>
										<li><strong>of</strong></li>
										<li><a href="#">9</a></li>
									</ul>
									<a href="#" class="link-next">&gt;</a>
								</div>
</div>
