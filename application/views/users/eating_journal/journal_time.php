<div class="display-oneline">
<div class="titme-title" <?php echo isset($cwidth)?'style="width:'.$cwidth.'"':''?>><?php echo $title; ?></div>
<div class="hoursall-box">
	<div class="choice-box">
	<a href="javascript:void(0);" class="up" time="<?php echo $timename; ?>">up</a>
	<span><input type="text" name="<?php echo $fieldname;?>" class="<?php echo $timename; ?>" onkeyup="timeCheck(this)" value="<?php echo date("g:i A",strtotime($currenttime)); ?>" size="8" /></span>
	<a href="javascript:void(0);" class="down" time="<?php echo $timename; ?>">down</a>
	</div>
</div>
</div>