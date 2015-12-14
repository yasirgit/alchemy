<?php
if(strlen($this->config->item('flagtime'))==0)
{
$hours=0;
}
else
{
$start_time=substr(date("H:i:s",strtotime($this->config->item('flagtime'))),0,2).":00:00";
$endtime=substr(date("H:i:s",strtotime($currenttime)),0,2).":00:00";

//echo $start_time."==".$endtime."<br />";

$n2time=substr($start_time,0,2);
$n1time=substr($endtime,0,2);
$hours=abs($n2time-$n1time)-1;

if($n2time>12&&$n1time<12)
$hours=0;

}
if($hours<=0)
{
?>
<div class="schedule-box">
	<div class="holder" style="height:26px;">
		<div class="hours-box"><span></span></div>
		<div class="problem-box" style="height:26px;">
		   <?php
			if(isset($flagw)&&$flagw==0&&isset($type)&&$type=="Breakfast")
			{
		   ?>	
			<div class="block">											
			   <img height="22" width="22"  style=""  alt="Too much time before Breakfast. Try to eat within 60 minutes of waking." title="Too much time before Breakfast. Try to eat within 60 minutes of waking." src="htdocs/images/ico-warning.gif">
			</div>
			<?php
			}
			else
			{
			?>
			<div class="block">											
			   <img height="22" width="22"  style=""  alt="Too much time has passed since you last ate. Try to eat a meal/snack every 2-3 hours" title="Too much time has passed since you last ate. Try to eat a meal/snack every 2-3 hours" src="htdocs/images/ico-warning.gif">
			</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
<?php
}
else
{
?>
<div class="schedule-box" style="margin:0;padding:0;">
	<div class="problem-box" style="top:-<?php echo $hours*27;?>px;height:<?php echo $hours*24;?>px;">
		<?php
		 if(isset($flagw)&&$flagw==0&&isset($type)&&$type=="Breakfast")
		 {
		?>
		<div class="block" title="Too much time before Breakfast. Try to eat within 60 minutes of waking." style="height:100%; background:url(htdocs/images/ico-warning.gif) no-repeat center; text-indent:-9999em;">									   
		</div>
		<?php
		 }
		 else
		 {
		?>
		<div class="block" title="Too much time has passed since you last ate. Try to eat a meal/snack every 2-3 hours" style="height:100%; background:url(htdocs/images/ico-warning.gif) no-repeat center; text-indent:-9999em;">									   
		</div>
		<?php
		}
		?>
	</div>
</div>
<?php
}
?>