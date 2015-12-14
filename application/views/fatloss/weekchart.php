<?php
foreach($fat_burning_mode as $key=>$value)
{
?>
<div class="weekly-chart-unitbar">
	<div class="percent-indicator" style="height:<?php echo round($value);?>%;">&nbsp;</div>
	<label class="weelydya-in-grade"><?php echo $grade[$key];?></label>
</div>
<?php
}
?>