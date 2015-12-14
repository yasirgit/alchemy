<div class="look-control look-control-bed"> 
<div class="text-styler"><b>What time did you go to bed?</b></div>
<?php
if(isset($custometime[0]->bed_time)&&$custometime[0]->bed_time!="00:00:00")
$bed_time=$custometime[0]->bed_time;
else
$bed_time=$time;
?>
<form id="editBedForm">
	<div>
		<?php
			$uTime['title']="Bed Time: ";
			$uTime['currenttime']=$bed_time;
			$uTime['fieldname']="bedtime"; 
			$uTime['timename']="beddailytime";
			echo $this->load->view('users/eating_journal/journal_time',$uTime);
		?>			
	</div>
<div class="right-align-button">
		<a href="javascript:void(0);" id="editBedFormSubmit"	class="sexybutton sexyorange"><span><span class="editWakeFormSubmit">Submit</span></span></a>
</div>
</form>
</div>
<div class="b b2">
<div class="add-popup-bottomleft">
  <div>&nbsp;</div>
</div>
</div>
