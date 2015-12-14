<link media="all" rel="stylesheet" href="<?=$this->config->item('base_url')?>/htdocs/recipefinder/slide.css" type="text/css" />
<script type="text/javascript" src="<?=$this->config->item('base_url')?>/htdocs/recipefinder/slide.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
	$(".share-this-link").hover(function() {
		$(this).next().show();
	});
	
	$(".share-tooltip").hover(function() {
		$(this).show();
	},
	function() {
		$(this).hide();
	}	
	);
});
</script>
<?php
//print_r($latRecipe); exit;
?>
<style>
.sub-page-yellow .content-frame {
    padding-bottom: 5px;
}
</style>

<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>
<div class="how-do-use"><a class="about-page" href="#">How do I use this page</a></div>

<div class="container">
    <div class="block-wrap">
        <?php $this->load->view('recipefinder/recipe_finder_box_home'); ?> 
    
        <div class="block-in">
            <div class="block-in-holder">
                <div class="block-in-frame">
                    <div class="block-in-title">
                        <!--<form action="#" class="select-area">
                        <fieldset>
                            <select>
                            <option value="Dinner">Dinner</option>
                            <option value="Dinner">Dinner</option>
                            <option value="Dinner">Dinner</option>
                            </select>
                        </fieldset>
                        </form> -->
                        <h2>Featured Fat Loss Recipes</h2>
                    </div>
                    <?php $this->load->view('recipefinder/recipe_featured_box',$recipes); ?>  
                    
                </div>
            </div>
            <div class="clear">&nbsp;</div>
        </div>
        <!-- tabs-->
        <?php $this->load->view('recipefinder/recipe_tab_box',$recipes); ?>
        <!--tabs-->
    </div>    

    <div class="block-in-small white">
        <div class="block-in-holder-small">
            <div class="block-in-frame-small">
                <div class="heading-block-in-small">
                    <h2>My Recipe Box</h2>
                </div>
                <h3>Recently Added:</h3>
                <ul>
                  <?php

                                for($i=0; $i< count($boxRecipe); $i++)
				  {													
					  $singleRecipe=$boxRecipe[$i]->recd['recipe'][0];
										  
					  if($i%2==0)
					  $class='class="grey"';	
					  else
					  $class="";
				  ?>
				  <li <?php echo $class;?>>
                                      <a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>">
                                      <?php if($boxRecipe[$i]->recd[images][$i]->thumb_img_name): ?>
                                          <img src="htdocs/images/recipes/thumb/<?php echo $boxRecipe[$i]->recd[images][$i]->thumb_img_name; ?>" alt="" width="50" height="47" />
                                      <?php else: ?>
					  <img src="<?php echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="50" height="47" />
                                      <?php endif; ?>
                                      </a>
					  <div class="block-in-small-text">
						  <a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>"><?php echo $singleRecipe->title;?></a>
						  <em class="date"><?php  echo date('M d, Y', strtotime($boxRecipe[$i]->add_date));?></em>
					  </div>
				  </li>
				  <?php
				  }
				  ?>	
                </ul>
                <div class="links-box">
                    <span class="all"><a href="recipefinder/my_recipebox">View All &gt;&gt;</a></span>
                    <a class="sexybutton sexyorange" href="users/recipe_finder"><span><span>Add a recipe</span></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="block-in-small white recipe-all" style="position: relative; top: 10px;">
        <div class="block-in-holder-small">
            <div class="block-in-frame-small">
                <div class="heading-block-in-small">
                    <h2>My Recipe</h2>
                </div>
                <h3>Latest Recipe:</h3>
                <ul>
                  <?php
                             // print_r($latRecps);
                               	  for($k=0; $k< count($latRecipe); $k++)
				  {
					  if($k%2==0)
					  $class='class="grey"';
					  else
					  $class="";
				  ?>
				  <li <?php echo $class;?>>
                                      <a href="recipefinder/recipe_info/<?php echo $latRecipe[$k]->rID;?>">
                                      <?php if($latRecipe[$k]->imgages->thumb_img_name): ?>
                                          <img src="htdocs/images/recipes/thumb/<?php echo $latRecipe[$k]->imgages->thumb_img_name; ?>" alt="" width="50" height="47" />
                                      <?php else: ?>
                                          <img src="http://fatsecret.com/static/images/box/recipe_default.jpg" alt="recipe_default.jpg" width="50" height="47" />
                                      <?php endif; ?>
                                      </a>
					  <div class="block-in-small-text">
						  <a href="recipefinder/recipe_info/<?php echo $latRecipe[$k]->rID;?>"><?php echo $latRecipe[$k]->title;?></a>
						  <em class="date"><?php  echo date('M d, Y', strtotime($latRecipe[$k]->createdOn));?></em>
					  </div>
				  </li>
				  <?php
				  }
				  ?>
                </ul>
                <div class="links-box">
                    <span class="recipe-view"><a href="recipes/listAll">View All &gt;&gt;</a></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container"></div>
</div>
<div class="footer-banner"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>


<? /*?>
<div class="container">
    <div class="block-in">
	  <div class="block-in-holder">
		  <div class="block-in-frame">
			  <div class="block-in-title">
				  <form action="#" class="select-area">
					  <fieldset>
						  <select>
							  <option value="Dinner">Dinner</option>
							  <option value="Dinner">Dinner</option>
							  <option value="Dinner">Dinner</option>
						  </select>
					  </fieldset>
				  </form>
				  <h2>Featured Fat Loss Recipes</h2>
			  </div>
			  
				  <? $this->load->view('recipefinder/recipe_featured_box',$recipes); ?>  
			  
			  
		  </div>
	  </div>
  </div>
  <div class="block-in-small">
	  <div class="block-in-holder-small">
		  <div class="block-in-frame-small">
			  <div class="heading-block-in-small">
				  <div class="decor-right">&nbsp;</div>
				  <h2>Million Meals Menu Planner</h2>
			  </div>
			  <form action="#" class="select-list">
				  <fieldset>
					  <div class="block-in-white">
						  <div class="block-in-holder-white">
							  <div class="block-in-frame-white">
								  <div class="heading-block-in-white">
									  <label for="select1"><span>1</span> Choose a protein</label>
								  </div>
								  <div class="row">
									  <select id="select1">
										  <option value="">&nbsp;</option>
									  </select>
								  </div>
								  <div class="heading-block-in-white heading-yellow">
									  <label for="select2"><span>2</span> Choose a fast carb</label>
								  </div>
								  <div class="row">
									  <select id="select2">
										  <option value="">&nbsp;</option>
									  </select>
								  </div>
								  <div class="heading-block-in-white heading-green">
									  <label for="select3"><span>3</span> Choose a slow carb</label>
								  </div>
								  <div class="row">
									  <select id="select3">
										  <option value="">&nbsp;</option>
									  </select>
								  </div>
							  </div>
						  </div>
					  </div>
					  <a href="#" class="sexybutton sexyorange sexybtn"><span><span>Find</span></span></a>
				  </fieldset>
			  </form>
		  </div>
	  </div>
  </div>
</div>
<div class="container">
  <div class="block-in-small white">
	  <div class="block-in-holder-small">
		  <div class="block-in-frame-small">
			  <div class="heading-block-in-small">
				  <h2>My Recipe Box</h2>
			  </div>
			  <h3>Recently Added:</h3>
			  <ul>
				  <?php
				  for($i=0;$i<count($boxRecipe);$i++)
				  {													
					  $singleRecipe=$boxRecipe[$i]->recd['recipe'][0];
					  $recipeOwner=$boxRecipe[$i]->recd['users'][0];
					  
					  if($i%2==0)
					  $class='class="grey"';	
					  else
					  $class="";
				  ?>
				  <li <?php echo $class;?>>
					  <img src="<?php echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="50" height="47" />
					  <div class="block-in-small-text">
						  <a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>"><?php echo $singleRecipe->title;?></a>
						  <em class="date"><?php  echo date('M d, Y', strtotime($boxRecipe[$i]->add_date));?></em>
					  </div>
				  </li>
				  <?php
				  }
				  ?>												
			  </ul>
			  <div class="links-box">
				  <span class="all"><a href="recipefinder/my_recipebox">View All &gt;&gt;</a></span>
				  <a class="sexybutton sexyorange" href="users/recipe_finder"><span><span>Add a recipe</span></span></a>
			  </div>
		  </div>
	  </div>
  </div>
  <div class="block-in-blue">
	  <div class="block-in-holder-blue">
      <? $this->load->view('recipefinder/recipe_findby_ingredients'); ?>
    </div>
  </div>  
  <? $this->load->view('recipefinder/recipe_tab_box',$recipes); ?>
</div>
<?*/?>