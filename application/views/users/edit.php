<h3>Edit Profile</h3>
<?php echo validation_errors(); ?>
<form id="edit" action="users/edit/<?=$user['username_clean']?>" method="post">
Current weight*:<br><input type="text" name="weight" id="weight"><br>
Goal weight:<br><input type="text" name="goal_weight" id="goal_weight"><br>
<?if(intval($fsdata['height_cm'] == 0)) {?>
	Height:<br><input type="text" name="height" id="height"><br>
<?}?>
<input type="submit" name="save" id="save" value="Save">
</form>