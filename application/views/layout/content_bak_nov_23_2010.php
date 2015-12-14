<?php $CI =& get_instance();?>
<div id="twocolumns">
	<?php $css = getContentFrameBorderCssClass($CI);?>
	<?php if(($this->CI->router->class=="recipefinder")||($this->CI->router->method=="recipe_finder" && $this->CI->router->class=="users"))	
	{
	?>
	<div id="content">
		<div class="content-holder">
			<div class="content-frame">
				<?=$__content?>
			</div>
		</div>
	</div>
	<?php }else{?>
	<div id="content" class=<?=$css['content']?>>
		<div class="<?=$css['content_holder']?>">
			<div class="content-frame <?=$css['content_frame']?>">
				<?=$__content?>
			</div>
		</div>
	</div>
	<?php }?>
	<?php if($CI->auth->isLoggedIn()) getRightNavbar($CI) ?>
</div>