<h3>Recent <?=$type?> Item(s)<br />(click to add)</h3>
<?php
if (@$recentItems)
{
	foreach ($recentItems AS $recentItem)
	{
		?>
		<div class="row recentItems">
			<input type="radio" class="radio" name="recentItems" id="recentItems<?=$recentItem->ujiID?>" ujiID="<?=$recentItem->ujiID?>" />
			<label for="recentItems<?=$recentItem->ujiID?>"><?php echo stripslashes($recentItem->entryname);?></label>
		</div>
		<?php
	}
}
?>
