<?php $CI =& get_instance();?>
<div id="twocolumns">
	<?php $css = getContentFrameBorderCssClass($CI);?>
	<?php if(($this->CI->router->class=="recipefinder")||($this->CI->router->class=="successjournal")||($this->CI->router->class=="fatlosscoach")||($this->CI->router->method=="recipe_finder" && $this->CI->router->class=="users"))	
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
	<?php 	if(($CI->auth->isLoggedIn() && $this->uri->segment(2)!="setup")||($this->CI->router->class=="access"&&$this->CI->router->method=="signup_step2"))
			{	
				getRightNavbar($CI);
			} 
			?>	
</div>