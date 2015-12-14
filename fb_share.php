<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta name="description" content="<?php echo $_GET['description'];?>" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta property="og:url" content="http://bglobal.ripemedia.com/recipefinder/recipe_info/<?php echo $_GET['rid']; ?>"/>
	<title><?php echo $_GET['title'];?></title>
	
	<script type="text/javascript">
		top.location.href = 'http://bglobal.ripemedia.com/recipefinder/recipe_info/<?php echo $_GET['rid']; ?>'; 
	</script>
</head>

<body>
	<?php echo $_GET['description'];?>
</body>

</html>