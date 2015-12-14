<link media="all" rel="stylesheet" href="htdocs/recipefinder/rating.css" type="text/css" />
<script type="text/javascript">	
function addreview(updateDiv)  
{	
	var mainurl="<?php echo site_url("/recipefinder/addreview/");?>";	
	/* var rating=jQuery('input:radio[name=rating]:checked').val(); */
	var rating = jQuery('#rating').val();
	var review = jQuery.trim(jQuery('#review_text').val());
        var recipe_id = jQuery('#rrecipe_id').val();
	
	if(rating > 0 && review.length > 0)
	{   //alert(1);
		var updatediv=document.getElementById('updatedivid').innerHTML;		  
		
		jQuery.ajax({
		url : mainurl,
		type: "POST",
		data: "rating="+rating+"&review="+review+"&recipe_id="+recipe_id+"&updateid="+(parseInt(updatediv)+1),		
		beforeSend: function (html)		
		{
			//alert(2);
			//jQuery('#loading-div').css('');
		},
		success : function (html) 
		{			
		    if(html == 1)
			{
				//alert(html);
				jQuery('#addedmsg').removeClass('showdiv').addClass('dontshowdiv');
			} else {
				jQuery("#recipereview"+updatediv).html(html);
				document.getElementById('updatedivid').innerHTML=parseInt(updatediv)+1;
				$("#rec-review-listid").show("slow");
				
			}
			//document.getElementById('review_text').innerHTML="";
		    jQuery('#review_text').val('');
		    jQuery('#r1unit').removeClass('r1-unit_selected sel').addClass('r1-unit');
		    jQuery('#r2unit').removeClass('r2-unit_selected sel').addClass('r2-unit');
		    jQuery('#r3unit').removeClass('r3-unit_selected sel').addClass('r3-unit');
		    jQuery('#r4unit').removeClass('r4-unit_selected sel').addClass('r4-unit');
		    jQuery('#r5unit').removeClass('r5-unit_selected sel').addClass('r5-unit');
		 }
		});
	}
        else{
            alert('You must select rating star and also need to write a review');
        }
}
</script>

<script type="text/javascript">	
$(document).ready(function(){


///////////////////////add to journal link///////////
	jQuery('.add-eating').click(
		function()
		{									
			///////////////////////////////////////
			jQuery('#addjournaleating').dialog(
			{
				modal:		true,
				title:		"Add recipe to journal",
				width:		419,
				dialogClass: 'small-scale',										
				resizable: false,
				position:	"middle",				
			});
			jQuery('#addjournaleating').dialog('open');						
		});
	
		jQuery('#addrecipejournal').click(
		function()
		{												
		///////////////////////////////////////////////////////	
			var str = $('#addmealjournal').serialize();
			doAjax("journal/addrecipejournal",
			function(response)
			{
				if (response.error_code == 0)
				{
					alert("This recipe is successfully added to your journal");
					$('#addjournaleating').dialog('close');					
				}
				else
				{
					
				}
			},str);
		////////////////////////////////////////////////////////	
		});	

///////////////////////end journal link//////////////

	var arr = [1, 2, 3, 4, 5];
    var samearr = [1, 2, 3, 4, 5];

    jQuery.each(arr, function(index, value) {
       jQuery(".r" + value + "-unit").click(function() {
		//alert(value);
		document.getElementById('rating').value=value;
		jQuery('#r' + value + 'unit').removeClass('r' + value + '-unit').addClass("r" + value + "-unit_selected sel");

                jQuery.each(samearr, function(index, val){
                    if(value!=val){
						if(jQuery('#r'+val+'unit').hasClass('r'+val+'-unit_selected sel'))
                        {
  							//alert(val);
                            jQuery('#r'+val+'unit').removeClass('r'+val+'-unit_selected sel').addClass("r"+val+"-unit");
                        } 
                    }
                });
		});
    });
	
});

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

<style>
.showdiv{
	display:none;
}

.dontshowdiv{
	display:block;
}

#addedmsg{
	color:#9F3D05;
	background:#EBF5FA;
	border:1px solid #929292;
	padding:5px;
}
</style>
<?php $x=count($findrecipe); ?>

<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>

<div class="how-do-use"><a class="about-page" href="javascript:void(0);">How do I use this page</a>
<a href="recipefinder/" class="return-to">&lt; Return to Recipe Finder</a></div>
<div class="recipy-details-wrapper">
	<!--Recipy Top Box-->
	<div class="recipy-top-holder">
		<div class="recipy-top-inner">
			<div class="recipy-gray-box">
			
				<!--Recipy Box Left-->
				<div class="recipy-box-left">
					<div class="recipy-left-top">&nbsp;</div>
					<div class="recipy-left-content">
						<ul class="recipy-add-list">
		                   <?php  if($x>0) { ?>
						      <li>Already in My Recipe Box</li>
							 <? } else{?>
							<li><a href="recipefinder/my_recipebox/<?php echo $recipe_id; ?>" class="add-to-box">Add to my Recipe Box</a></li>
							<? } ?>
							<li><a href="javascript:void(0);" class="add-eating">Add to Eating Journal</a></li>
							<li><a href="javascript:void(0);" class="print-option">Print</a></li>
						</ul>
						<ul class="recipy-text-list">
							<li><strong>Servings:</strong> <? if(!empty($recipe_details['no_serving']))echo $recipe_details['no_serving'];?></li>
							<li><strong>Active Prep:</strong> <? if(!empty($recipe_details['act_time']))echo $recipe_details['act_time'];?> min</li>
							<li><strong>Inactive Prep:</strong> <? if(!empty($recipe_details['inact_time']))echo $recipe_details['inact_time'];?> min</li>
							<li><strong>Cooking Time:</strong> <? if(!empty($recipe_details['cooking_time_min']))echo $recipe_details['cooking_time_min'];?> min</li>
							<li><strong>Total Time:</strong> <?php echo $tot_time = ($recipe_details['act_time'] + $recipe_details['inact_time'] + $recipe_details['cooking_time_min'])?> min</li>
							<li><strong>Difficulty:</strong> <!--Easy --></li>
						</ul>
						<ul class="recipy-text-list">
							<li><strong>Meal Types</strong></li>
							<?php
							//print_r($recipe_mlType_slc);
							for($i=0;$i<count($recipe_mlType_slc);$i++)	
							{
							?>
								<li><?php echo $recipe_mlType_slc[$i]->name; ?></li>
							<?php
							}
							?>
						</ul>
						<ul class="recipy-text-list">
							<li><strong>Dietary Restrictions</strong></li>
							<?php
							for($i=0;$i<count($dietary_sel);$i++)	
							{
							?>
							<li><?php echo $dietary_sel[$i]->name; ?></li>
							<?php
							}
							?>
						</ul>
						<ul class="vit-option">
						<?php
						//$recipe_details['direction'];
						//echo "ISPROTEIN=". $recipe_details['direction']['isProtein'];
						//echo "Protein status=".$recipe_details['direction']['proteinStatus'];
						?>
							<?php if($recipe_details['direction']['isProtein'] == 1) { ?>
							<li class="protien"><a  <?php if($recipe_details['direction']['proteinStatus'] != 'solid'){ ?> class="prot_stripe" <?php }?>>PROTEIN</a></li>
							<?php
							} 
							if($recipe_details['direction']['isSlowcarb'] == 1) {
							?>
							<li class="slow-carb"><a <?php if($recipe_details['direction']['slowcarbStatus'] == 'solid'){ ?> class="slow-carb" <?php } else { ?> class="slow-carb-stripe" <?php } ?>>slow carb</a></li>
							<?php 
							}
							if($recipe_details['direction']['isFirstcarb'] == 1) {
							?>
							<li class="fast-carb"><a  <?php if($recipe_details['direction']['firstcarbStatus'] == 'solid'){ ?> class="fast-carb" <?php } else { ?> class="fast-carb-stripe" <?php } ?> >FAST carb</a></li>
							<?php
							}
							?>
						</ul>
					</div>
				</div>
				<!--/Recipy Box Left-->
				
				<!--Recipy Box Right-->
				<div class="recipy-box-right">
					<div class="recipy-box-right-top">&nbsp;</div>
					<div class="recipy-box-right-content">
						<div class="clear-both-side">
							<div class="recipy-thumb-site">
								<div class="recipy-thumb">
									<a href="javascript:void()">
									<img src="<? if(!empty($recipe_img[0]->image_name)) echo 'htdocs/images/recipes/'.$recipe_img[0]->image_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="<?echo $recipe_details['recipe_name'];?>" width="169" height="156"/>
									</a>
									<span class="view-photoss"></span>
								</div>
								<div class="racipy-item-review">
									<strong>Rating</strong><br />
										<?php
										for($i=0;$i<count($reviews);$i++)	
										{
											$avg = 0;
											if($reviews[$i]->totusers > 0){
											$avg = round($reviews[$i]->totRat/$reviews[$i]->totusers);
											}
											?>
											<img src="htdocs/images/img-stars<?php echo $avg;?>.gif" />
											<br />
											<small>(<?php echo $reviews[$i]->totusers; ?> people reviewed)</small>		
										<?php
										}
										?>	
								</div>
							</div>
							<div class="ingredients-site">
								<h2 class="suace-heading"><?if(!empty($recipe_details['recipe_name']))echo $recipe_details['recipe_name'];?></h2>
								<div class="re-user-icon">
									<span class="rec-user-link">by <a href="javascript:void(0);"><?php echo $recipe_details['user_name']; ?></a></span>
									<span class="rec-user-link"><img src="images/recipy-alge.gif" alt="" /></span>
									<?php
                                    $fburl = urlencode("http://bglobal.ripemedia.com/fb_share.php?rid=".$recipe_id."&title=".$recipe_details['recipe_name']."&description=".$recipe_details['recipe_description']);
									$burl = "http://bglobal.ripemedia.com/recipefinder/recipe_info/".$recipe_id;
									$rec_url = '&original_referer='.$burl.'&url='.$burl;
									?>
									<a href="#" class="share-this-link">SHARE THIS RECIPE</a>
									
									<div class="share-tooltip hidediv" id="trackid" style="left: 474px;top: 107px;">
										<div class="share-tooltip-in">
											<div class="share-tol-content">
												<div class="share-pic-option">SHARE THIS RECIPE </div>
												<p>Share this meal with family and friends:</p>
												<div class="share-icon-links">
													<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $fburl; ?>" title="Share this recipe on Facebook" class="share-facebook">Facebook</a>
													<a target="_blank" href="http://twitter.com/share?text=Check out this recipe on Alchemy!<?php echo $rec_url; ?>" title="Share this recipe on Twitter" class="share-twitter">Twitter</a>
												</div>
											</div>
										</div>
									</div>
									
									<br class="clear" />
								</div><br/><br/>
								<p><? if(!empty($recipe_details['recipe_description']))echo $recipe_details['recipe_description'];?></p>
								<h4 class="red-sub-heading">Ingredients</h4>
								<ul class="re-text-lists">
									<?php 
									  if(!empty($recipe_details['serving_sizes'][0]['serving'][0]))
									  foreach($recipe_details['serving_sizes'][0]['serving'][0] as $ind=>$sval)
									  {
										echo "<li>".$sval['value']."</li>";
										
									  }?>
								</ul>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
						<h4 class="red-sub-heading sub-heading-left">Directions</h4>
						<ol start="1" type="1" class="rec-ol-list">
							<?php 
							  if(!empty($recipe_details['directions'][0]['direction']))
							  foreach($recipe_details['directions'][0]['direction'] as $ind=>$sval)
							  {
								echo "<li>".$sval['direction_description']."</li>";
												  
							  }?>
						</ol>
					</div>
					<div class="recipy-box-right-bottom">&nbsp;</div>
				</div>
				<!--/Recipy Box Right-->
				<div class="clear">&nbsp;</div>
			</div>
		</div>
	</div>
	<!--/Recipy Top Box-->
	
	<div class="review-recent-holder">
		<div class="reviews-side">
			
			<!--Servings note-->
			<? if(!empty($recipe_details['recipe_servNote']))
			{ ?>
			<div class="rec-review-list" id="rec-review-list">
				<h2 class="reviews-heading">Notes or serving suggestions</h2>
				<div class="review-content">
					<div class="review-content-rptr review-rptr-even">
						<p><?php echo $recipe_details['recipe_servNote']; ?></p>
					</div>
				</div>
				<div class="rec-review-bottom">&nbsp;</div>
			</div>
			<?php
			}
			?>
			<!--Servings note-->
			
			<!--Review List-->
			<div class="rec-review-list" id="rec-review-listid" <?php  if(count($rat_details)<1) { ?> style="display:none;" <?php } ?>>
				<h2 class="reviews-heading">Review</h2>
				<div class="review-content">
					<?php
					//print_r($rat_details);
					for($i=0;$i<count($rat_details);$i++)	
					{
					?>
					<div class="review-content-rptr review-rptr-even">
						<p><?php echo $rat_details[$i]->reviews; ?></p>
						<p>
							<span class="reviwer-user">
							<?php
							echo date('M d, Y', strtotime($rat_details[$i]->created))." by member: <a>".$rat_details[$i]->username."</a>";
							?>
							</span>
							<span class="reviews-rating">
							<a>
							<img src="htdocs/images/img-stars<?php echo $rat_details[$i]->ratings;?>.gif" alt="Rating"/>
							</a></span>
							<br class="clear" />
						</p>
					</div>
					<?php
					}
					?>
					<div class="review-content-rptr" id="recipereview1">
					
					</div>
					
				</div>
				
				<span id="updatedivid" style="display:none;">1</span>
				
				<div class="rec-review-bottom">&nbsp;</div>
			</div>
			<!--Review List-->
			
			<!--Give the recipy review-->
			<div class="rec-review-list">
				<h2 class="reviews-heading reviews-put">Review this recipe</h2>
				<div class="review-put-area">
					<div class="re-own-diet">Do you think this recipe is good for Ripemedia's own diet?</div>
					<div class="re-give-review"><div id="avgReview">
						 <?php
							for($i=0; $i<count($reviews); $i++)	
							{
						    ?>
							
								<?php 
									//echo $reviews[$i]->reviews;			
									//$divId=$reviews[$i]->rrid;
									$avg = 0;
									if($reviews[$i]->totusers > 0){
									   $avg = round($reviews[$i]->totRat/$reviews[$i]->totusers);
									}
								?>
								<!-- <br /> -->
								<?php 
									//echo date('d M, Y', strtotime($reviews[$i]->created))." By ".$reviews[$i]->username;			
								?>
								<!-- <br /> -->
								<a ><img src="htdocs/images/img-stars<?php echo $avg;?>.gif" /></a>
						    <?php
							}
						 ?></div>
						<h4>Review Now </h4>
						<div id="addedmsg" class="showdiv">
							You have already reviewed this recipe!!
						</div>
						<ul style="width: 80px;" class="unit-rating" id="unit_ul179">
							<li><a id="r1unit" rel="nofollow" class="r1-unit rater" title="1 out of 5" >1</a></li>
							<li><a id="r2unit" rel="nofollow" class="r2-unit rater" title="2 out of 5" >2</a></li>
							<li><a id="r3unit" rel="nofollow" class="r3-unit rater" title="3 out of 5" >3</a></li>
							<li><a id="r4unit" rel="nofollow" class="r4-unit rater" title="4 out of 5" >4</a></li>
							<li><a id="r5unit" rel="nofollow" class="r5-unit rater" title="5 out of 5" >5</a></li>
						</ul>
					</div>
					<div class="put-rev-form-area">
						<form id="newreview_frm" method="post">
							<input type="hidden" name="rating" id="rating" value="" />
							<label>Please enter additional comments on this recipe if you wish</label>
							<textarea name="review_text" id="review_text" rows="6" style="width:350px;"></textarea>
							
							<input type="hidden" name="rrecipe_id" id="rrecipe_id" value="<?php echo $recipe_id;?>" />
							<!--<input type="button" value="submit" onclick="addreview()" /> -->
							<a class="sexybutton sexyorange sexybtn" onclick="addreview()">
							<span><span>Submit</span></span>
							</a>
							
							<div class="clear">&nbsp;</div>
						</form>
					</div>
				</div>
				<div class="put-review-bottom">&nbsp;</div>
			</div>
			<!--/Give the recipy review-->
			
		</div>
		<div class="related-recipy-site">
		
			<!--Other related recipes-->
			<!--<div class="related-recipy-boundary">
				<h2 class="related-heading">Review</h2>
				<div class="related-content">
					<div class="related-content-rptr">
						<p class="related-title-link"><a href="#">Spicy Chicken</a></p>
						<p>A delicious spicy chicken breast skillet recipe.</p>
						<p><strong>by:</strong> <a href="#">cbella</a></p>
					</div>
					<div class="related-content-rptr related-even">
						<p class="related-title-link"><a href="#">Chopped Chicken Salad</a></p>
						<p>Chicken and salad greens in a light dressing.</p>
						<p><strong>by:</strong> <a href="#">330poundwoman</a></p>
					</div>
					<div class="related-view-all-option"><a href="#">View more recipes &rsaquo;</a></div>
				</div>
				<div class="related-bottom">&nbsp;</div>
			</div> -->
			<!--/Other related recipes-->
			
			<!--Circle Chart Area-->
			<div class="circle-chart-area">
				<div class="circle-chart-content">
					<div class="nutrition-facts">
						<h4 class="nutrition-head">Nutrition Facts</h4>
						<!--<p>Serving Size 1 serving</p> -->
						<div class="nutrition-divider-bar">&nbsp;</div>
						<p><small>Amount Per Serving</small></p>
						<p><span class="black-label">Calories</span> <?php if(!empty($recipe_details['totCal'])){ echo $recipe_details['totCal']; } ?>  <span class="black-label">Calories from Fat</span> <?php if(!empty($recipe_details['totFat'])){ echo ($recipe_details['totFat']*9); } ?><!-- 159 --></p>
						<div class="nutrition-divider-bar divider-gap">&nbsp;</div>
						<p><span class="black-label">Total Fat</span> <?php if(!empty($recipe_details['totFat'])){ echo $recipe_details['totFat']; } ?>g</p>
						<p>&nbsp;&nbsp;Saturated Fat <?php if(!empty($recipe_details['saturated_fat'])){ echo $recipe_details['saturated_fat']; } ?>g</p>
						<p>&nbsp;&nbsp;Polyunsaturated Fat <?php if(!empty($recipe_details['polyunsat_fat'])){ echo $recipe_details['polyunsat_fat']; } ?>g </p>
						<p>&nbsp;&nbsp;Monounsaturated Fat <?php if(!empty($recipe_details['monounsat_fat'])){ echo $recipe_details['monounsat_fat']; } ?>g</p>
						<p><span class="black-label">Cholesterol</span> <?php if(!empty($recipe_details['cholesterol'])){ echo $recipe_details['cholesterol']; } ?>mg</p>
						<p><span class="black-label">Sodium</span> <?php if(!empty($recipe_details['sodium'])){ echo $recipe_details['sodium']; } ?>mg</p>
						<p><span class="black-label">Potassium</span>  <?php if(!empty($recipe_details['potassium'])){ echo $recipe_details['potassium']; } ?>mg</p>
						<p><span class="black-label">Total Carbohydrates</span>  <?php if(!empty($recipe_details['totCarb'])){ echo $recipe_details['totCarb']; } ?>g</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dietary Fiber <?php if(!empty($recipe_details['dietary_fiber'])){ echo $recipe_details['dietary_fiber']; } ?>g</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sugars <?php if(!empty($recipe_details['sugar'])){ echo $recipe_details['sugar']; } ?>g</p> 
						<p><span class="black-label">Protein</span> <?php if(!empty($recipe_details['totProt'])){ echo $recipe_details['totProt']; } ?>g</p>
						<div class="nutrition-divider-bar">&nbsp;</div>
						<div class="vitamin-fifty-wrap"><span class="vitamin-fifty">Vitamin A <?php if(!empty($recipe_details['vitamin_a'])){ echo $recipe_details['vitamin_a']; } ?>%</span><span class="vitamin-fifty">* Vitamin C <?php if(!empty($recipe_details['vitamin_c'])){ echo $recipe_details['vitamin_c']; } ?>%</span></div>
						<div class="vitamin-fifty-wrap"><span class="vitamin-fifty">Calcium <?php if(!empty($recipe_details['calcium'])){ echo $recipe_details['calcium']; } ?>%</span><span class="vitamin-fifty">* Iron <?php if(!empty($recipe_details['iron'])){ echo $recipe_details['iron']; } ?>%</span></div>
					</div>
					<div class="nutrition-facts chart-content-bottom">
						<div class="circle-chart-indicator">
						<h4>Calorie Breakdown:</h4>
						<ul class="circle-char-indlist">
							<li class="carbohydred-ind">Carbohydrate (<?php if(!empty($recipe_details['percCarb'])){ echo $recipe_details['percCarb']; } ?>%)</li>
							<li class="fat-ind">Fat (<?php if(!empty($recipe_details['percFat'])){ echo $recipe_details['percFat']; } ?>%)</li>
							<li class="protien-ind">Protein (<?php if(!empty($recipe_details['percProt'])){ echo $recipe_details['percProt']; } ?>%)</li>
						</ul>
					</div>
						<div class="circle-chart-place">
						<!-- <img src="images/recipy-calonic-breakdown.gif" alt="Circle chart" /> -->
						<?php if(!empty($recipe_details['pieimg'])){ echo $recipe_details['pieimg']; } ?>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
				</div>
				<div class="circle-chart-bottom">&nbsp;</div>
			</div>
			<!--/Circle Chart Area-->
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</div>
<div id="addjournaleating" style="display:none;">
	<?php
		$this->load->view('recipefinder/adjournalform');
	?>
</div>
<div class="footer-banner"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>
