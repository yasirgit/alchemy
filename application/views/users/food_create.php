<h3>Add Food</h3>
<?php echo validation_errors(); ?>
<form id="add_food_frm" method="post">
Brand Type*<br />
<select name="brand_type" id="brand_type">
<option value="manufacturer">Manufacturer</option>
<option value="restaurant">Restaurant</option>
<option value="supermarket">Supermarket</option>
</select><br />
Brand Name*<br />
<input type="text" name="brand" id="brand" /><br />
Food Name*<br />
<input type="text" name="name" id="name" /><br />
Serving Size* <br />
<input type="text" name="size" id="size" /><br />
Calories*<br />
<input type="text" name="calories" id="calories" /><br />
Fat*<br />
<input type="text" name="fat" id="fat" /><br />
Carbohydrate* <br />
<input type="text" name="carbohydrate" id="carbohydrate" /><br />
Protein* <br />
<input type="text" name="protein" id="protein" /><br />
<input type="submit" name="save_food" id="save_food" value="Add Food"/>
</form>

<h3>Created Foods</h3>
<?php if(!empty($foods)) {?>
<table bgcolor="#CCCCCC" cellspacing="1" cellpadding="5">
	<tr>
		<td bgcolor="#FFFFFF"><b>Food Id</b></td>
		<td bgcolor="#FFFFFF"><b>Food Name</b></td>
		<td bgcolor="#FFFFFF"><b>Brand Name</b></td>
		<td bgcolor="#FFFFFF"><b>Food Type</b></td>
		<td bgcolor="#FFFFFF"><b>Food Url</b></td>
		<td bgcolor="#FFFFFF"><b>Servings</b></td>
	</tr>
	<?php foreach($foods as $k => $v) {?>
		<tr>
			<td bgcolor="#FFFFFF">
				<?=$v['food_id']?>
			</td>
			<td bgcolor="#FFFFFF">
				<?=$v['food_name']?>
			</td>
			<td bgcolor="#FFFFFF">
				<?=$v['brand_name']?>
			</td>
			<td bgcolor="#FFFFFF">
				<?=$v['food_type']?>
			</td>
			<td bgcolor="#FFFFFF">
				<a href="<?=$v['food_url']?>" target="_blank">See this food on Fat Secret</a>
			</td>
			<td bgcolor="#FFFFFF">
				<?=$v['servings']?>
			</td>
		</tr>
	<?} ?>
</table>
<?}?>