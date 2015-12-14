<?php
foreach($fat_burning_mode as $key=>$value)
{
?>
<li date="<?php echo date("Y-m-d",strtotime($key));?>"><div style="cursor:pointer;"><?php echo date("D",strtotime($key));?></div><div style="font-size:11px;cursor:pointer;"><?php echo date("m/d/y",strtotime($key));?></div></li>
<?php
}
?>