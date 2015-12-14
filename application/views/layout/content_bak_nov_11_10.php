<?php $CI =& get_instance();?>
<div id="twocolumns">
	<?php $css = getContentFrameBorderCssClass($CI);?>
	<div id="content" class=<?=$css['content']?>>
		<div class="<?=$css['content_holder']?>">
			<div class="content-frame <?=$css['content_frame']?>">
				<?=$__content?>
			</div>
		</div>
	</div>
	<?php
	if ($CI->auth->isLoggedIn() && $CI->auth->isSetup())
	{
		getRightNavbar($CI);
	}
	?>
</div>