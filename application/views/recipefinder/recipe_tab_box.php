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
				<a href="javascript:void(0);" class="link-prev">&lt;</a>
				<div>
					<div class="g-holder">
						<ul>
							<?php foreach($recipes['top_recipes'] as $ind=>$rval)
                            {
							$img = $rval->imgages;
                            ?>
							<li>
								<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" >
								<img src="<?php if(!empty($img->thumb_img_name)) echo 'htdocs/images/recipes/thumb/'.$img->thumb_img_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
								<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" class="tab-link"><?php echo $rval->title;?></a>
							</li>
							<?php }?>
						</ul>
					</div>
				</div>
				<a href="javascript:void(0);" class="link-next">&gt;</a>
			</div>
			<div class="view-mor-link"><a href="#"></a></div>
		</div>
	</div>
	<div class="tab-content" id="tab-2">
		<div class="holder">
			<!-- gallary -->
			<div class="gallery G1">
				<a href="javascript:void(0);" class="link-prev">&lt;</a>
				<div>
					<div class="g-holder">
						<ul>
							<?php foreach($recipes['new_recipes'] as $ind=>$rval)
                            {
							$img = $rval->imgages;
                            ?>
                            <li>
								<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>">
								<img src="<?php if(!empty($img->thumb_img_name)) echo 'htdocs/images/recipes/thumb/'.$img->thumb_img_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
								<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" class="tab-link"><?php echo $rval->title;?></a>
							</li>
															   
                            <?php }?>
						</ul>
					</div>
				</div>
				<a href="javascript:void(0);" class="link-next">&gt;</a>
			</div>
			<div class="view-mor-link"><a href="#"></a></div>
		</div>		
	</div>
	<div class="tab-content" id="tab-3">
		<div class="holder">
			<!-- gallary -->
			<div class="gallery G1">
				<a href="javascript:void(0);" class="link-prev">&lt;</a>
				<div>
					<div class="g-holder">
						<ul>
							<?php foreach($recipes['quick_and_easy'] as $ind=>$rval)
                             {
							 $img = $rval->imgages;
                            ?>
                                <li>
										<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" >
										<img src="<?php if(!empty($img->thumb_img_name)) echo 'htdocs/images/recipes/thumb/'.$img->thumb_img_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
										<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" class="tab-link"><?php echo $rval->title;?></a>
								</li>
															   
                            <?php }?>
						</ul>
					</div>
				</div>
				<a href="javascript:void(0);" class="link-next">&gt;</a>
			</div>
			<div class="view-mor-link"><a href="#"></a></div>
		</div>
	</div>
	<div class="tab-content" id="tab-4">
		<div class="holder">
			<!-- gallary -->
			<div class="gallery G1">
				<a href="javascript:void(0);" class="link-prev">&lt;</a>
				<div>
					<div class="g-holder">
						<ul>
							<?php foreach($recipes['fat_loss'] as $ind=>$rval)
							{
							$img = $rval->imgages;
							?>
								<li>
									<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" >
									<img src="<?php if(!empty($img->thumb_img_name)) echo 'htdocs/images/recipes/thumb/'.$img->thumb_img_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="#" width="80" height="81" /></a>
									<a href="recipefinder/recipe_info/<?php echo $rval->rID;?>" class="tab-link"><?php echo $rval->title;?></a>
							   </li>
							<?php }?>
						</ul>
					</div>
				</div>
				<a href="javascript:void(0);" class="link-next">&gt;</a>
			</div>
			<div class="view-mor-link"><a href="#"></a></div>
		</div>
	</div>
	
</div>