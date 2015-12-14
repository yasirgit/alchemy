<script type="text/javascript">	
function delRecipe(rid,divId)
{	
	var mainurl="<?php echo site_url("/recipefinder/delFromRecipeBox/");?>"+"/"+rid;	
	
	var confirm=window.confirm("Are you sure that you want to remove this recipe from your Recipe Box?");
	if(confirm)
	{
		jQuery.ajax({
		url : mainurl,	
		beforeSend: function (html)		
		{
			//alert(2);
		},
		success : function (html) 
		{
		   jQuery('#'+divId).slideUp();
		   //jQuery('#'+divId+"2").slideUp();
		   //jQuery('#'+divId+"3").slideUp();
		   window.location = "<?php echo site_url("/recipefinder/my_recipebox/list");?>"

		 }
		});
	}	
}
function showByMealType(mealId,divId)
{	
	var mainurl="<?php echo site_url("/recipefinder/recipemealtype/");?>"+"/"+mealId;		
	
	jQuery.ajax({
	url : mainurl,	
	beforeSend: function (html)		
	{
		jQuery('#'+divId).slideUp();
		//alert(2);
	},
	success : function (html) 
	{
	   document.getElementById(divId).innerHTML=html;
	   jQuery('#'+divId).slideDown();	   
	 }
	});
	
}
</script>
<script type="text/javascript">
	jQuery(function(){


		// Dialog			
		jQuery('#dialog').dialog({
			autoOpen: false,
			width: 600,
			buttons: {
				"Close": function() { 
					jQuery(this).dialog("close"); 
				} 
			}
		});

		// Dialog Link
		jQuery('.dialog_link').live("click", function(e){		
		e.preventDefault();
			var caur_val = $(this).attr('cur');
			////////////////////////////////////////ajax call///////////////////
			var mainurl="<?php echo site_url("/recipefinder/getrating/");?>"+"/"+caur_val;			
			jQuery.ajax({
			url : mainurl,	
			beforeSend: function (html)		
			{},
			success : function (html) 
			{
			   document.getElementById("dialog").innerHTML=html;
			   jQuery('#dialog').dialog('open');			   
			 }
			});
			////////////////////////////////////////////////////////////////////			
		});	
	});
	
function ratingSubmit()
{
///////
	var mainurl="<?php echo site_url("/recipefinder/saverating/");?>";	
	var rating=jQuery('input:radio[name=rating]:checked').val();
	var review=jQuery('#review_text').val();	
	var rbox_id=jQuery('#rbox_id').val();

	if(rating>0&&review.length>0)	
	{
		jQuery.ajax({
		url : mainurl,	
		type: "POST",
		data: "rating="+rating+"&review="+review+"&rbox_id="+rbox_id,		
		beforeSend: function (html)		
		{
			//jQuery('#'+divId).slideUp();
			//alert(2);
		},
		success : function (html) 
		{
		   document.getElementById("dialog_link"+rbox_id).innerHTML=html;
		   jQuery('#dialog').dialog('close');	   	   
		 }
		});
	}
	else
	{
		alert("Please select rating and review");
	}	
	
return false;
/////////
}	
</script>
<script type="text/javascript">
$(document).ready(function(){
    <?php if($_REQUEST['tracker']==1){?>
		    $('#linko').addClass('expandable').text('MINIMIZE OPTIONS');
            $('.expand-wrapper').show();
            $('.options-short-view').hide();
			$('#tracker').val(1);
	<?}?>
			
			/////////////////meal button			
			$('.meals_button').live('click',
			function()			
			{
				///////////////////////////////////
				var str="p="+$(this).attr('p');
				doAjax("recipefinder/recipeboxmeal",
				function(response)
				{
					if (response.error_code == 0)
					{						
						$('#mealcontent').html(response.display);						
						
						$('#recipecontent').slideUp('slow');			
						$('#mealcontent').slideDown('slow');						
					}
					else
					{}
				},str);				
			 //////////////////////////////////			
			 $(this).parent().attr('class',"active");
		     $(this).parent().prev().removeAttr('class');
		  });
	$('.recipe_button').click(function()
	{
			$('#recipecontent').slideDown('slow');
			$('#mealcontent').slideUp('slow');						
			$(this).parent().attr('class',"active");
			$(this).parent().next().removeAttr('class');
	});
	////////////////////end meal function
	//////////////////add to journal/////////////
	///////////////////////add to journal link///////////	
	jQuery('.user-access-link .add-eating').live('click',
		function()
		{									
			var ujID = $(this).attr('ujID');
			jQuery('#journalujid').html(ujID);
			
			///////////////////////////////////////
			jQuery('#addjournaleating').dialog(
			{
				modal:		true,
				title:		"Add meal to journal",
				width:		419,
				dialogClass: 'small-scale',										
				resizable: false,
				position:	"middle",				
			});
			jQuery('#addjournaleating').dialog('open');						
		});
	
		jQuery('#addrecipejournal').live('click',		
		function()
		{												
		///////////////////////////////////////////////////////	
			var str= $('#addmealjournal').serialize()+"&ujid="+jQuery('#journalujid').html();		
			doAjax("journal/addrecipeboxjournal",
			function(response)
			{
				if (response.error_code == 0)
				{
					alert("The meal is successfully added to your journal");
					$('#addjournaleating').dialog('close');					
				}				
			},str);		
		});
///////////////////////end journal link//////////////
	
	///////////////////end journal///////////////			
});

$(document).ready(function() {
	$(".paging-holder a:contains('<')").attr('class', 'link-prev');
	$(".paging-holder a:contains('>')").attr('class', 'link-next');
	//$(".paging-holder > ul > li span").attr('class', 'active');
});
</script>
<style>
.digitnone{
	display:none;
}

.lastlink{
	display:block;
}
</style>

<!-- ui-dialog -->
<div id="dialog" title="My Review And Rating">	
</div>

<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>
<div class="how-do-use"><a class="about-page" href="javascript:void(0);">How do I use this page</a><a href="recipefinder" class="return-to">&lt; Return to Recipe Finder</a></div>
<!--RF-2 Search-->
<div class="rf-search-area">
    <?php $this->load->view('recipefinder/recipe_finder_box'); ?> 
</div>
<div class="search-result-up">
	<h2>My Recipe Box <span>(<?php echo count($boxRecipe)+count($boxMeal);?>)</span></h2>
	
		<div class="paging-holder">
		<?php echo $this->pagination->create_links(); ?>
		</div>
</div>

	<!--<div class="recipe-list-area">
		<h2>My Recipe List (<?php //echo count($boxRecipe)+count($boxMeal);?>)</h2>
		<a href="recipefinder/">Return to Recipe Finder &gt;</a>
	</div> -->
	<div class="user-area">
		<ul>
			<li class="active"><a href="javascript:void(0);" class="recipe_button"><span>Recipes</span></a></li>
			<li><a href="javascript:void(0);" class="meals_button" p="1"><span>Meals</span></a></li>
		</ul>
		<a href="users/recipe_finder" class="add" style="float:right;">Add a Recipe</a>
		<!--<form action="#" class="user-signup">
			<fieldset>
				<label for="select02">Show me:</label>
				<select id="select02" onchange="showByMealType(this.value,'recipeinfobox')" >					
					<option value="All">All</option>
					<?php
					//foreach($mealtype as $key=>$value)					
					//{	
					?>
					<option value="<?php //echo $key;?>"><?php //echo $value;?></option>
					<?php
					//}
					?>
				</select>
			</fieldset>
		</form> -->
	</div>
<!--	
<div id="recipeinfobox">
	<table class="recipe-info-box">
		<tr>
			<th class="head-sort"><a href="#">Sort by:</a></th>
			<th class="head-title">Title</th>
			<th class="head-rating-review">My Rating/Review</th>
			<th class="head-rating">Overall Rating</th>
			<th class="head-date"><a href="#">Date Added</a></th>
			<th class="head-notes">My Notes</th>
		</tr>
		<tr class="recipe-info-box-indent">
			<td colspan="6"></td>
		</tr>
		<?php
/*		
echo "<pre>";
print_r($boxRecipe);
echo "</pre>";
*/		
		
		/*for($i=0;$i<count($boxRecipe);$i++)
		{
			$singleRecipe=$boxRecipe[$i]->recd['recipe'][0];
			$recipeOwner=$boxRecipe[$i]->recd['users'][0];
			$divId="delrecipe".$singleRecipe->rID;
			
			if(($i%2)==0)
			$class='class="odd"';
			else
			$class="";*/
		?>
		
		<tr <?php //echo $class?> id="delrecipe<?php //echo $singleRecipe->rID."1";?>">
			<td class="top-border" colspan="6"></td>
		</tr>
		<tr <?php //echo $class?> id="delrecipe<?php //echo $singleRecipe->rID."2";?>">
			<td><a href="recipefinder/recipe_info/<?php //echo $singleRecipe->rID;?>"><img src="<?php //echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="75" height="76" /></a></td>
			<td class="recipe-info-box-text">
				<h3><?php //echo $singleRecipe->title;?></h3>
				<strong>By: <a href="#"><?php //echo $recipeOwner->first_name." ".$recipeOwner->last_name?></a></strong>
				<ul>
					<li>
						<a href="#" class="sexybutton sexyorange"><span><span>Print</span></span></a>
					</li>
					<li>
						<a href="#" class="sexybutton sexyorange" onclick="delRecipe('<?php //echo $singleRecipe->rID;?>','<?php //echo $divId;?>'); return false;"><span><span>Delete</span></span></a> 
					</li>
				</ul>
			</td>
			<td><a href="#" class="dialog_link" cur="<?php  //echo $boxRecipe[$i]->id; ?>"><span id="dialog_link<?php //echo $boxRecipe[$i]->id;?>"><?php //if($boxRecipe[$i]->myrating>0){?><img src="htdocs/images/img-stars<?php //echo $boxRecipe[$i]->myrating;?>.gif" /><?php //} else {?>Rate/Review<?php //}?></span></a></td>
			<td>
				<?php
					/*$rat=round($boxRecipe[$i]->rating['rating'][0]->actualrat);
					if(!isset($rat))
					$rat=0;*/
				?>
				<div class="rating-block"><img src="htdocs/images/img-stars<?php //echo $rat;?>.gif" alt="" width="77" height="17" /></div>
			</td>
			<td><em class="date"><?php  //echo date('M d, Y', strtotime($boxRecipe[$i]->add_date));?></em></td>
			<td><a href="#" class="dialog_link" cur="<?php  //echo $boxRecipe[$i]->id; ?>">View Note</a></td>
		</tr>
		<tr <?php //echo $class?> id="delrecipe<?php //echo $singleRecipe->rID."3";?>">
			<td class="bottom-border" colspan="6"></td>
		</tr>
		<?php
		//}
		?>		
	</table>
	<?php
		//echo $this->pagination->create_links();
	?>
</div>
-->
<div id="mealcontent" style="display:none;">

</div>

<div id="recipecontent">
	<div class="schedule-block recipe-search-box schedule-block-update">
	<?php
	for($i=0;$i<count($boxRecipe);$i++)
	{

		$singleRecipe=$boxRecipe[$i]->recd['recipe'][0];
		$recipeOwner=$boxRecipe[$i]->recd['users'][0];
		$divId="delrecipe".$singleRecipe->rID;

		if(($i%2)==0)
		$class=' odd';
		else
		$class="";
	?>
		<div class="schedule-block-area" id="<?php echo $divId;?>">
			<div class="schedule-box<?php echo $class;?>">
				<div class="holder">
					<div class="image-box">
										<a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>">
											<?php if($boxRecipe[$i]->recd['images'][0]->thumb_img_name): ?>
													<img src="htdocs/images/recipes/thumb/<?php echo $boxRecipe[$i]->recd['images'][0]->thumb_img_name; ?>" alt="" width="62" height="62" />
											<?php else: ?>
												<img src="htdocs/images/62x62.jpg" alt="" width="62" height="62" />
											<?php endif; ?>
										</a>
					</div>
					<div class="info-box">
						<h3 class="heding-info-box heding-info-box-like">
                                                    <a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>"><?php echo stripslashes($singleRecipe->title);?></a>
						</h3>
						<div class="text-box">
                                                    <p><?php echo stripslashes($singleRecipe->desc);?></p>
							<strong class="title-recipe">by member: 
							<a href="#"><?php echo $recipeOwner->first_name." ".$recipeOwner->last_name?></a></strong>
						</div>
						<ul class="user-access-link">
							<li><a href="recipefinder/recipe_info/<?php echo $singleRecipe->rID;?>#rec-review-list" class="note-access">Note</a></li>
							<li><a href="#" class="del-access" onclick="delRecipe('<?php echo $singleRecipe->rID;?>','<?php echo $divId;?>'); return false;">Delete</a></li>
							<li><a href="javascript:void(0);" class="print-access">Print</a></li>
						</ul>
					</div>
					<div class="icon-holder">
						<ul>
							<?php
							//echo "<pre>";
							//print_r($boxRecipe[$i]->direction);
							//echo "</pre>";*/
							//echo "ISPROTEIN=". $boxRecipe[$i]->direction['isProtein'];
							//echo "Protein status=".$boxRecipe[$i]->direction['proteinStatus'];
							if($boxRecipe[$i]->direction['isProtein'] == 1) { ?>
							<li <?php if($boxRecipe[$i]->direction['proteinStatus'] == 'solid'){ ?> class="protien-solid" <?php } else { ?> class="protien" <?php } ?>  >
								<a class="betterTip" >PROTEIN</a>
							</li>
							<?php
							}
							if($boxRecipe[$i]->direction['isSlowcarb'] == 1) {
							?>
							<li <?php if($boxRecipe[$i]->direction['slowcarbStatus'] == 'solid'){ ?> class="slow-carb-solid" <?php } else { ?> class="slow-carb" <?php } ?> >
								<a>slow carb</a></li>
							<?php
							}
							if($boxRecipe[$i]->direction['isFirstcarb'] == 1) {
							?>
							<li <?php if($boxRecipe[$i]->direction['firstcarbStatus'] == 'solid'){ ?> class="fast-carb-solid" <?php } else { ?> class="fast-carb" <?php } ?> >
								<a>FAST carb</a></li>
							<?php
							}
							?>
						</ul>
					</div>
					
					<div class="icon-box-right">
						<?php
							$rat=round($boxRecipe[$i]->rating['rating'][0]->actualrat);
							if(!isset($rat))
							$rat=0;
						?>
						<img src="htdocs/images/img-stars<?php echo $rat;?>.gif" alt="<?php echo $rat; ?> Rating" width="77" height="17" />
						<br />
						<span>(<?php echo $boxRecipe[$i]->rating['rating'][0]->totusers; ?> people reviewed)</span>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>		
	</div>	
	<div class="container">
		<div class="paging-holder">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>
<div id="addjournaleating" style="display:none;">
	<?php
		$this->load->view('recipefinder/adjournalform');
	?>	
</div>
<span id="journalujid" style="display:none;"></span>	
<div class="footer-banner"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>