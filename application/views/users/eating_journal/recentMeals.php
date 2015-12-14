<h3>Recent <?=$type?>(s)<br />(click to add)</h3>
<p class="recentMeals">
	<strong>Yesterday: </strong>
	<?php
	if (@$yestedaysMeal)
	{
		?><a href="javascript:void(0);" ujID=<?=$yestedaysMeal[0]->ujID?>><?php echo stripslashes($yestedaysMeal[0]->name);?></a><?php
	}
	?>
</p>
<p class="recentMeals">
	<strong>Last Week: </strong>
	<?php
	if (@$weekagoMeal)
	{
		?><a href="javascript:void(0);" ujID=<?=$weekagoMeal[0]->ujID?>><?php echo stripslashes($weekagoMeal[0]->name);?></a><?php
	}
	?>
</p>
