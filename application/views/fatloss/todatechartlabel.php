<?php
if(isset($ismonth)&&$ismonth==1)
{
	for($i=0;$i<count($result);$i++)
	{
	?>
	<li><?php echo date("M",strtotime($result[$i]['start']));?></li>
	<?php
	}
}
else if(isset($isweek)&&$isweek==1)
{
	for($i=0;$i<count($result);$i++)
	{
	?>
	<li><?php echo date("m/d",strtotime($result[$i]['start']));?>-<br /><?php echo date("m/d",strtotime($result[$i]['end']));?></li>
	<?php
	}
}
?>