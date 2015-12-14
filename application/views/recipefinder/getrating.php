<?php
$rate=$boxRecipe[0]->myrating;
?>
<h3>Review this recipe</h3>
<div id="myreview_submit">
	<form id="myreview_frm" method="post" onsubmit="return ratingSubmit();">
		<input type="radio" name="rating" <?php echo $rate==1?" checked":"";?>  value="1" />1
		&nbsp;<input type="radio" name="rating" <?php echo $rate==2?" checked":"";?> value="2" />2
		&nbsp;<input type="radio" name="rating" <?php echo $rate==3?" checked":"";?> value="3" />3
		&nbsp;<input type="radio" name="rating" <?php echo $rate==4?" checked":"";?> value="4" />4
		&nbsp;<input type="radio" name="rating" <?php echo $rate==5?" checked":"";?> value="5" />5
		<br /><br />
		<textarea name="review_text" id="review_text" rows="6" style="width:400px;"><?php echo $boxRecipe[0]->note;?></textarea>
		<br /><br />
		<input type="hidden" name="rbox_id" id="rbox_id" value="<?php echo $boxRecipe[0]->id;?>" />
		<input type="submit" value="submit" />
	</form>
</div>