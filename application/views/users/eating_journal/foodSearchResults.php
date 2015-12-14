<div>
	<a href="javascript:void(0);" id="xxx" class="getQuantity" style="font-weight:bold;" title="add.." food_id="<?=$food_id?>" food_name="<?=$food_name?>" details="1"><img src="htdocs/images/myfs_tri.gif">&nbsp;<?=$food_name?></a>&nbsp;
	<?php
	if ($food_type == "Brand")
	{
		?><span style="font-size:11px;">(<?=$brand_name?>)</span><?php
	}
	?>
	<div>
		<div class="smallText"><?=$food_description?></div>
		<span class="smallText"><a href="javascript:void(0);" class="getQuantity" title="add..." food_id="<?=$food_id?>" details="0" food_name="<?=$food_name?>">add item</a></span>
		<hr />
	</div>
</div>
