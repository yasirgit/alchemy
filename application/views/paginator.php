<?php
if ($paginator)
{
	?>
	<div class="paging" style='float:left; display:inline; line-height:35px; font-weight:bold; font-size:11px;'>
		<?php if ($paginator['current'] != 0) { ?>
			<a href="javascript:void(0);" url="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['prevPage']?>">PREV</a>&nbsp;
		<?php } else { ?>
			<a>PREV</a>&nbsp;
		<?php } ?>
		|
		<?php foreach ($paginator['pages'] AS $k => $i) { ?>
			<?php if ($i == $paginator['current']) { ?>
				<span style='text-decoration:underline; background:#999999;padding:0px 5px; color:#005da4;'><?=$k?></span>
			<?php } else { ?>
				&nbsp;<a href="javascript:void(0);" url=<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$i?>" style='text-decoration:none;'><?=$k?></a>&nbsp;
			<?php } ?>
		<?php } ?>
		|
		<?php if ($paginator['nextPage'] != 0) { ?>
			&nbsp;<a href="javascript:void(0);" url=<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['nextPage']?>">NEXT</a>
		<?php } else { ?>
			&nbsp;<a>NEXT</a>
		<?php } ?>
	</div>
	<div style='display:inline; padding-left:30px; line-height:35px; font-weight:bold; font-size:11px; color:#005da4;'>
		<?php if ($paginator['nextPage'] > 0) { ?>
			Showing <?=$paginator['current']+1?>-<?=$paginator['nextPage']?> of <?=$paginator['cntr']?>
		<?php } else { ?>
			Showing <?=$paginator['current']+1?>-<?=$paginator['cntr']?> of <?=$paginator['cntr']?>
		<?php } ?>
	</div>
	<?php
}
?>
