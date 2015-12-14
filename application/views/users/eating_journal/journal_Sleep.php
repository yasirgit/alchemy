<?php
$time=new stdClass;
$time->type=$type;
$time->week_period=$week_period;
$time->time=$slept_time['to_time'];
$time->utID=$utID;
$sendData=array();
$sendData['time']=$time;
$total_sleep=intval(substr($slept_time['duration'],0,2))+(intval(substr($slept_time['duration'],3,2))/60);
?>
<div class="schedule-box">
	<div class="edit-box">
		<?php
		if($total_sleep<7)
		{
		?>
		<div class="p" style="float:left;width:250px;margin:0 70px 0 0;padding:0 0 0 30px;background:url(htdocs/images/bg-edit-c.png) repeat-x;">You got less than 7 hours of sleep last night.</div>
		<?php
		}
		else if($total_sleep>9)
		{
		?>
		<div class="p" style="float:left;width:172px;margin:0 124px 0 0;padding:0 0 0 30px;background:url(htdocs/images/bg-edit-c.png) repeat-x;">You slept 9 hours or more.</div>
		<?php
		}
		?>
		<?php echo $this->load->view('users/eating_journal/journal_meal',$sendData);?>
	</div>
	<div class="holder">
		<div class="hours-box"><span><span><?=date("h:i A",strtotime($slept_time['from_time']));?><span style="text-align:center; display:block; clear:both; width: 53px;">To</span><?=date("h:i A",strtotime($slept_time['to_time']));?></span></span></div>
		<div class="image-box" style="vertical-align:middle;">
			<img src="htdocs/images/img5.gif" width="33" height="32" alt="" />
		</div>
		<div class="info-box sub4" <?php if($total_sleep>9||$total_sleep<7){ ?>style="color:red;"<?php }?>>
			<strong>Slept (<?php echo substr($slept_time['duration'],0,5)." hours";?>)</strong>
		</div>
	</div>
</div>