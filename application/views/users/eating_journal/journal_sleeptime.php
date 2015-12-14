<?php
$data=array();
$data['time']=$sleep;

$lmeal=$this->config->item('flagmealtime');

$timedata['currenttime']=$sleep->from_time;
if(strlen($lmeal)>0)
{
	///////////////////////////////////////////////////////
				$dtime=substr($lmeal,0,5);
				$atime=substr($sleep->from_time,0,5);						
				$nextDay=$dtime>$atime?1:0;
				$dep=EXPLODE(':',$dtime);
				$arr=EXPLODE(':',$atime);
				$diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
				$hours=FLOOR($diff/(60*60));
				$mins=FLOOR(($diff-($hours*60*60))/(60));
				$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
				IF(STRLEN($hours)<2){$hours="0".$hours;}
				IF(STRLEN($mins)<2){$mins="0".$mins;}
				$hours+=$mins/60;
				///////////////////////////////////////////
				if($hours>3)
				{
				?>
				<?php $this->load->view('users/eating_journal/journal_error',$timedata);?>
				<?php
				}
}
else
{?>
<?php $this->load->view('users/eating_journal/journal_error',$timedata);?>
<?php
}	


$this->config->set_item('flagtime',$sleep->from_time);
?>
<div class="schedule-box">
	<div class="edit-box"><?php echo $this->load->view('users/eating_journal/journal_meal',$data);?></div>
	<div class="holder">
		<div class="hours-box">
		<span><span><?php echo date("h:i A",strtotime($sleep->from_time));?><span style="text-align:center; display:block; clear:both; width: 53px;">To</span><?php echo date("h:i A",strtotime($sleep->to_time));?></span></span>
		</div>
		<div class="image-box" style="vertical-align:middle;">
			<img src="htdocs/images/img5.gif" width="33" height="32" alt="" />
		</div>
		<div class="info-box sub4">
			<strong>Sleep</strong>
		</div>
	</div>
</div>