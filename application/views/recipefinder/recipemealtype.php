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
	
	for($i=0;$i<count($boxRecipe);$i++)
	{
		$singleRecipe=$boxRecipe[$i]->recd['recipe'][0];
		$recipeOwner=$boxRecipe[$i]->recd['users'][0];
		$divId="delrecipe".$singleRecipe->rID;
		
		if(($i%2)==0)
		$class='class="odd"';
		else
		$class="";
	?>
	
	<tr <?php echo $class?> id="delrecipe<?php echo $singleRecipe->rID."1";?>">
		<td class="top-border" colspan="6"></td>
	</tr>
	<tr <?php echo $class?> id="delrecipe<?php echo $singleRecipe->rID."2";?>">
		<td><a href="#"><img src="<?php echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="75" height="76" /></a></td>
		<td class="recipe-info-box-text">
			<h3><?php echo $singleRecipe->title;?></h3>
			<strong>By: <a href="#"><?php echo $recipeOwner->first_name." ".$recipeOwner->last_name?></a></strong>
			<ul>
				<li>
					<a href="#" class="sexybutton sexyorange"><span><span>Print</span></span></a>
				</li>
				<li>
					<a href="#" class="sexybutton sexyorange" onclick="delRecipe('<?php echo $singleRecipe->rID;?>','<?php echo $divId;?>'); return false;"><span><span>Delete</span></span></a>
				</li>
			</ul>
		</td>
		<td><a href="#"  class="dialog_link" cur="<?php  echo $boxRecipe[$i]->id; ?>" ><span id="dialog_link<?php echo $boxRecipe[$i]->id;?>"><?php if($boxRecipe[$i]->myrating>0){?><img src="htdocs/images/img-stars<?php echo $boxRecipe[$i]->myrating;?>.gif" /><?php } else {?>Rate/Review<?php }?></span></a></td>
		<td>
			<div class="rating-block"><img src="htdocs/images/img-star4.gif" alt="" width="77" height="17" /></div>
		</td>
		<td><em class="date"><?php  echo date('M d, Y', strtotime($boxRecipe[$i]->add_date));?></em></td>
		<td><a href="#" class="dialog_link" cur="<?php  echo $boxRecipe[$i]->id; ?>">View Note</a></td>
	</tr>
	<tr <?php echo $class?> id="delrecipe<?php echo $singleRecipe->rID."3";?>">
		<td class="bottom-border" colspan="6"></td>
	</tr>
	<?php
	}
	?>		
</table>