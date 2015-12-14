<h3>Favorite <?=$type?>(s)<br />(click to add)</h3>
<?php
if (@$favoriteMeals)
{
	foreach ($favoriteMeals AS $favoriteMeal)
	{
		?>
		<div class="row favorites">
			<input type="radio" class="radio" name="favoriteMeals" id="favoriteMeals<?=$favoriteMeal->ujID?>" ujID="<?=$favoriteMeal->ujID?>" />
			<label for="favoriteMeals<?=$favoriteMeal->ujID?>"><?php echo stripslashes($favoriteMeal->name);?></label>
		</div>
		<?php
	}
}
?>
