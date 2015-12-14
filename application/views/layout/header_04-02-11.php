<?php $this->CI = & get_instance(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>OnlineTrackingJournal</title>

	<base href="<?=$this->config->item('base_url')?>/" />	
	<?php 	  
	if(($this->CI->router->class=="recipefinder")||($this->CI->router->class=="eatingout"))	
	{
	?>
	<link media="all" rel="stylesheet" href="htdocs/recipefinder/all.css" type="text/css" />
	<link media="all" rel="stylesheet" href="htdocs/recipefinder/sexybuttons.css" type="text/css" />
	<link media="all" rel="stylesheet" href="application/views/_assets/css/ui-lightness/jquery-ui-1.8.2.custom.css" type="text/css" />
	<link media="all" rel="stylesheet" href="htdocs/css/jScrollHorizontalPane.css" type="text/css" />
	<script type="text/javascript" src="htdocs/recipefinder/vscrollarea.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/ie-hover-ns-pack.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/inputs.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/menu.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/tabs.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/jquery.galleryScroll.1.5.2.js"></script>
	<script type="text/javascript" src="htdocs/recipefinder/jquery.main.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/jquery.form.js"></script>
	<link media="all" rel="stylesheet" href="application/views/_assets/css/recipeBuilder.css" type="text/css" />
	<script type="text/javascript" src="application/views/_assets/js/recipeBuilder.js"></script>
	<?php if($this->CI->router->class=="recipefinder"){?>
	<script type="text/javascript" src="htdocs/recipefinder/dom.manipulation.js"></script>
	<?php }?>
	<script type="text/javascript" src="htdocs/js/jScrollHorizontalPane.min.js"></script>    
	<script type="text/javascript">
		$(function(){
			$('.micro-chart-bars').jScrollHorizontalPane({showArrows:true,arrowSize:14,scrollbarHeight:8,scrollbarMargin:0});			
		});
	</script>    
	<?php
	}
	elseif(($this->CI->router->method=="recipe_finder" && $this->CI->router->class=="users")||($this->CI->router->class=="access"&&$this->CI->router->method=="signup_step2")||($this->CI->router->class=="users"&&$this->CI->router->method=="myAccount"))
	{
	?>
	<link media="all" rel="stylesheet" href="htdocs/recipefinder/all.css" type="text/css" />
	<link media="all" rel="stylesheet" href="htdocs/css/sexybuttons.css" type="text/css" />
	<link media="all" rel="stylesheet" href="application/views/_assets/css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" />
	<script type="text/javascript" src="application/views/_assets/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/jquery.form.js"></script>
	<!--<script type="text/javascript" src="application/views/_assets/js/jquery.impromptu-3.1.min.js"></script>-->
	<script type="text/javascript" src="application/views/_assets/js/functions.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/sidebar.js"></script>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="application/views/_assets/css/ie.css" media="screen"/><![endif]-->
	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
	<script type="text/javascript" src="htdocs/js/vscrollarea.js"></script>
	<script type="text/javascript" src="htdocs/js/ie-hover-ns-pack.js"></script>
	<!--<script type="text/javascript" src="htdocs/js/inputs.js"></script>
	--><script type="text/javascript" src="htdocs/js/menu.js"></script>
	<script type="text/javascript" src="htdocs/js/tabs.js"></script>
	<link media="all" rel="stylesheet" href="application/views/_assets/css/recipeBuilder.css" type="text/css" />
	<script type="text/javascript" src="application/views/_assets/js/recipeBuilder.js"></script>
	
	<script type="text/javascript" src="htdocs/js/jScrollHorizontalPane.min.js"></script>    
	<script type="text/javascript">
		$(function(){
			$('.micro-chart-bars').jScrollHorizontalPane({showArrows:true,arrowSize:14,scrollbarHeight:8,scrollbarMargin:0});			
		});
	</script> 
	<?php
	}else
	{
	?>
	<link media="all" rel="stylesheet" href="htdocs/css/all.css" type="text/css" />
	<link media="all" rel="stylesheet" href="htdocs/css/sexybuttons.css" type="text/css" />
	<link media="all" rel="stylesheet" href="application/views/_assets/css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" />
	<link media="all" rel="stylesheet" href="htdocs/css/jScrollHorizontalPane.css" type="text/css" />
	<script type="text/javascript" src="application/views/_assets/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/jquery.form.js"></script>
	<!--<script type="text/javascript" src="application/views/_assets/js/jquery.impromptu-3.1.min.js"></script>-->
	<script type="text/javascript" src="application/views/_assets/js/functions.js"></script>
	<script type="text/javascript" src="application/views/_assets/js/sidebar.js"></script>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="application/views/_assets/css/ie.css" media="screen"/><![endif]-->
	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
	<script type="text/javascript" src="htdocs/js/vscrollarea.js"></script>
	<script type="text/javascript" src="htdocs/js/ie-hover-ns-pack.js"></script>
	<script type="text/javascript" src="htdocs/js/inputs.js"></script>
	<script type="text/javascript" src="htdocs/js/menu.js"></script>
	<script type="text/javascript" src="htdocs/js/tabs.js"></script>	
	<script type="text/javascript" src="htdocs/js/jScrollHorizontalPane.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.micro-chart-bars').jScrollHorizontalPane({showArrows:true,arrowSize:14,scrollbarHeight:8,scrollbarMargin:0});			
		});
	</script>    
	<!--
	<script type="text/javascript" src="htdocs/js/jquery.galleryScroll.1.5.2.js"></script>
	<script type="text/javascript" src="htdocs/js/jquery.main.js"></script>-->
	<?php
	}
	if(!empty($css))
	{
		foreach($css as $css_src)
		{
			?><link rel='stylesheet' type='text/css' href='htdocs/css/<?=$css_src?>' /><?
		}
	}
	if(!empty($_assets_css))
	{
		foreach($_assets_css as $css_src)
		{
			?><link rel='stylesheet' type='text/css' href='application/views/_assets/css/<?=$css_src?>' /><?
		}
	}
	if(!empty($js))
	{
		foreach($js as $js_src)
		{
			?><script type='text/javascript' src='htdocs/js/<?=$js_src?>'></script><?php
		}
	}
	if(!empty($_assets_js))
	{
		foreach($_assets_js as $js_src)
		{
			?><script type='text/javascript' src='application/views/_assets/js/<?=$js_src?>'></script><?php
		}
	}
	?>
</head>
<body>
	<div id="wrapper" <?php if($this->CI->router->class=="recipefinder" || $this->CI->router->method=="recipe_finder"){?>class="sub-page-yellow"<?}?>>
