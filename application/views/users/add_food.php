<h3>Add Food</h3>
<?php echo validation_errors(); ?>
<form id="add_food_frm" method="post">
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
<input type="submit" name="save_food" id="save_food" />
</form>