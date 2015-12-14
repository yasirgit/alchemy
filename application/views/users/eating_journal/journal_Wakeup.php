<?php
$data=array();

if(date('N')==6||date('N')==7)
$isweekend="weekends";
else
$isweekend="weekdays";
foreach($userwakebed as $key=>$value)
{	
	if($value->type=="Wakeup"&&$value->week_period==$isweekend)
	{
		$data['type']=$value->type;
		$data['week_period ']=$value->week_period;
		$data['time ']=$value->time;
		$data['utID']=$value->utID;		
	}
}
$this->config->set_item('flagtime',$hour);
/*echo "<pre>";
	print_r($data);
echo "</pre>";*/
?>
<div class="schedule-box">	
	<div class="edit-box"><?=$this->load->view('users/eating_journal/journal_meal',$data);?></div>
	<div class="holder">
		<div class="hours-box"><span><?=$hour?></span></div>
		<div class="image-box" style="vertical-align:middle;">
			<img src="htdocs/images/img6.gif" width="42" height="42" alt="" />
		</div>
		<div class="info-box sub4">
			<strong>Wake UP</strong>
		</div>
	</div>
</div>
