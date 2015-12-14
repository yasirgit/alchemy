<ul>
	<?php
	if(count($positive)==0)
	{
	 ?>
	 <li><font style="color:red;">There is no positive feedback</font></li>
	 <?php	
	}
	for($i=0;$i<count($positive);$i++)
	{
	?>
	<li><span><?php echo $positive[$i]; ?></span></li>
	<?php
	}
	?>  
</ul>