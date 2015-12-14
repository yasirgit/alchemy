<ul><?php
	if(count($negative)==0)
	{
	 ?>
	 <li><font style="color:red;">There is no negative feedback</font></li>
	 <?php	
	}
	for($i=0;$i<count($negative);$i++)
	{
	?>
	<li><span><?php echo $negative[$i]; ?></span></li>
	<?php
	}
	?>
</ul>