<script type="text/javascript">
$(document).ready(function(){
    <?php if($_REQUEST['tracker']==1){?>
		    $('#linko').addClass('expandable').text('MINIMIZE OPTIONS');
            $('.expand-wrapper').show();
            $('.options-short-view').hide();
			$('#tracker').val(1);
	<?}?>
		
});
</script>
<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>
<div class="how-do-use"><a class="about-page" href="#">How do I use this page</a><a href="#" class="return-to">&lt; Return to Recipe Finder</a></div>
<!--RF-2 Search-->
<div class="rf-search-area">
    <?php $this->load->view('recipefinder/recipe_finder_box'); ?> 
</div>
<div class="search-result-up">
			<h2>Search Results <span>(<?php if(!empty($total_results)) echo $total_results; else echo "0"; ?> found)</span></h2>
		<?php
        if(isset($total_results) && $total_results>0){
        $total_pages=ceil($total_results/10);
        $current=$this->uri->segment(3);
        if(empty($current))
        $current=1;
        if($current==1)
            $prev="";
        else
            $prev=$current-1;
        if($current==$total_pages)    
        $next='';
        else
        $next=$current+1;
        
        ?>
            <div class="paging-holder">
                <?php if(!empty($prev)){?><a href="recipefinder/search/<?php echo $prev;?>" class="link-prev">&lt;</a><?}?>
                <ul>
                    <li><a href="#" class="active"><?php echo $current;?></a></li>
                    <li><strong>of</strong></li>
                    <li><a href="recipefinder/search/<?php echo $total_pages;?>"><?php echo $total_pages;?></a></li>
                </ul>
                <?php if(!empty($next)){?><a href="recipefinder/search/<?php echo $next;?>" class="link-next">&gt;</a><?}?>
            </div>
        <?}?>
            
</div>
<div class="schedule-block recipe-search-box schedule-block-update">
	<?php if(isset($recipes_results))foreach($recipes_results as $ind=>$recipe){
			
			?>
	<div class="schedule-block-area">
		<div class="schedule-box <?php if($ind%2!=0){?>odd<?}?>">
			<div class="holder">
				<div class="image-box">
					<img src="<?php if (!empty($recipe->recipe_image))
                echo "htdocs/images/recipes/thumb/" . $recipe->recipe_image; else
                echo "http://fatsecret.com/static/images/box/recipe_default.jpg"; ?>" alt="<?php echo $recipe->title; ?>"   width="62" height="62"/>

				</div>
				<div class="info-box">
					<h3 class="heding-info-box heding-info-box-like">
						<a href="recipefinder/recipe_info/<?php echo $recipe->rID;?>"><?php echo $recipe->title;?></a>
					</h3>
					<div class="text-box">
						<p><?php echo $recipe->desc;?></p>
						<?php if(!empty($recipe->uname)){ ?><strong class="title-recipe">by member: <a href="#"><?php echo $recipe->uname; ?></a></strong><?php } ?>
					</div>
				</div>
				<div class="icon-holder">
					<ul>
					<?php
					$fatloss=array();
					$total_carb=0;
					$total_protein=0;
					$total_fat=0;
					$total_calories=0;
					$dietary_fiber=0;
					$sugar=0;
					$alldirection = array();
					
					#recipe servings by SHAIFUL
					$query = "SELECT rs.* FROM recipe_servings rs,recipes r where r.rID='".$recipe->rID."' and r.rID=rs.rID";
					$recipe_servings= $this->db->query($query)->result();
					if(count($recipe_servings)>0){
						foreach($recipe_servings as $label=>$ing)
						{
							//echo $ing->food_id."<br>";
							$temp=$this->journal_model->getFoodInformation($ing->food_id);

							for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
							{
									$tempservice=$temp['servings'][0]['serving'][$k];
									if($tempservice['measurement_description']==$ing->serving)
									{
										$fatloss = $tempservice;
										foreach($fatloss as $key => $value){
											if($key=='carbohydrate'){
													$total_carb+=$value;
											}
											if($key=='protein'){
													$total_protein+=$value;
											}
											if($key=='fat'){
													$total_fat+=$value;
											}
											if($key=='calories'){
													$total_calories+=$value;
											}
											if($key=='fiber'){
													$dietary_fiber+=$value;
											}
											if($key=='sugar'){
													$sugar+=$value;
											}
										}
									}
							}

							/*echo "<pre>";
							print_r($temp);
							echo "<pre>";*/
						}
						$getPerc = array('total_calories'=>$total_calories,'total_fat'=>$total_fat,'total_carb'=>$total_carb,'dietary_fiber'=>$dietary_fiber,'sugar'=>$sugar,'total_protein'=>$total_protein);
						$returnPerc=$this->journal_model->getfoodinfo($getPerc);
						/*echo "<pre>";
						print_r($returnPerc);
						echo "</pre>";
						exit;*/
						$alldirection = $returnPerc['directions'];
					}
                    ?>
					<?php if($alldirection['isProtein'] == 1) { ?> 
						<li <?php if($alldirection['proteinStatus'] == 'solid'){ ?> class="protien-solid" <?php } else { ?> class="protien" <?php } ?>>
							<a href="#" title="">PROTEIN</a>
						</li>
					<?php }
					if($alldirection['isSlowcarb'] == 1) {
					?>
						<li  <?php if($alldirection['slowcarbStatus'] == 'solid'){ ?> class="slow-carb-solid" <?php } else { ?> class="slow-carb" <?php } ?>>
							<a href="#">slow carb</a>
						</li>
					<?php }
					if($alldirection['isFirstcarb'] == 1) {
					?>
						<li <?php if($alldirection['firstcarbStatus'] == 'solid'){ ?> class="fast-carb-solid" <?php } else { ?> class="fast-carb" <?php } ?>>
							<a href="#">FAST carb</a>
						</li>
					<?php } ?>
					</ul>
				</div>
				
				<div class="icon-box-right">
                <?php
                $avg = 0;
                if($recipe->totusers > 0 && $recipe->totRat > 0){
                $avg = round($recipe->totRat/$recipe->totusers);
                }
                ?>
                    <img src="htdocs/images/img-stars<?php echo $avg; ?>.gif" alt="" /><br />
                    <span>(<?php if(!empty($recipe->totusers)){ echo $recipe->totusers; } else { echo 0; }?> people reviewed)</span>
                </div>
			</div>
		</div>
	</div>
	<?php }?>
	
</div>
<?php
    if(isset($total_results) && $total_results>0){
               
        ?>
        <div class="container">
                    <div class="paging-holder">
                        <?php if(!empty($prev)){?><a href="recipefinder/search/<?php echo $prev;?>" class="link-prev">&lt;</a><?}?>
                        <ul>
                            <li><a href="#" class="active"><?php echo $current;?></a></li>
                            <li><strong>of</strong></li>
                            <li><a href="recipefinder/search/<?php echo $total_pages;?>"><?php echo $total_pages;?></a></li>
                        </ul>
                        <?php if(!empty($next)){?><a href="recipefinder/search/<?php echo $next;?>" class="link-next">&gt;</a><?}?>
                    </div>
        </div>
<?}?>      

<div class="footer-banner"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>          