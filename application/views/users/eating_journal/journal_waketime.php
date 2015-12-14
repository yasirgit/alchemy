<div class="look-control look-control-bed" style="padding: 20px 37px 15px;"> 
<div class="text-styler"><b>At what time?</b></div>
<?php

if(isset($custometime[0]->wake_time))
$waketime=$custometime[0]->wake_time;
else
$waketime=$time;

if(isset($custometime[0]->bed_time))
$bed_time=$custometime[0]->bed_time;
else
$bed_time=$timeBed;

$today=date("M jS",strtotime($today));  
$yesterday=date("M jS",strtotime("-1 day",strtotime($today)));

?>
<style>
.display-oneline .titme-title{line-height:18px;}
.look-control-bed .display-oneline .titme-title {padding:10px 0 0 0;text-align: left;}
</style>
<form id="editWakeForm">
	<?php
		$uTime['title']="Your Bedtime Last Night<div>($yesterday)</div>";
		$uTime['currenttime']=$bed_time;
		$uTime['fieldname']="bedtime"; 
		$uTime['timename']="beddailytime";
		$uTime['cwidth']="210px";
		$uTime['isW']=1;
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
	?>
	<?php
		$uTime['title']="Your Wake Time This Morning<div>($today)</div>";
		$uTime['currenttime']=$waketime;
		$uTime['fieldname']="waketime"; 
		$uTime['timename']="wakedailytime";
		$uTime['cwidth']="210px";
		$uTime['isW']=1;
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
	?>			
	<?php 
	if(isset($isFirstTime)&&$isFirstTime==1)
	{
	?>
	<div class="text-styler text-styler2">
		<input type="checkbox" name="autoadjust" value="1" checked />Adjust my meal times automatically based on my wake time		
	</div>
	<?php 
	}?>
<div class="right-align-button">
	<a href="javascript:void(0);" id="editWakeFormSubmit"	class="sexybutton sexyorange"><span><span class="editWakeFormSubmit">Submit</span></span></a>
</div>
</form>
</div>
<div class="b b2">
<div class="add-popup-bottomleft">
  <div>&nbsp;</div>
</div>
</div>