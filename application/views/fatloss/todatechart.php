<?php
for($i=0;$i<count($result);$i++)
{
?>
<div class="weekly-chart-unitbar">
	<div class="percent-indicator" style="height:<?php echo $result[$i]['fatburning']?>%;">&nbsp;</div>
	<label class="weelydya-in-grade"><?php echo $result[$i]['grade']?></label>
</div>
<?php
}
?>