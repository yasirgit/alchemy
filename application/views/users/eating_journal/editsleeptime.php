<div class="look-control look-control-bed">
<div id="contentsleeptime">
	<?php
		$uTime['title']="<b>From time?</b>";
		$uTime['currenttime']=$sleeptime[0]->from_time;
		$uTime['fieldname']="journalfromTime"; 
		$uTime['timename']="bedjournalfromTime";
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
	?>
	<?php
		$uTime['title']="<b>End time?</b>";
		$uTime['currenttime']=$sleeptime[0]->to_time;
		$uTime['fieldname']="journaltoTime"; 
		$uTime['timename']="bedjournaltoTime";
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
	?>	
	<input type="hidden" name="editsleepid" id="editsleepid" value="<?php echo $sleeptime[0]->id;?>" />		
	<div class="right-align-button">
		<a href="javascript:void(0);" id="saveItems"	class="sexybutton sexyorange"><span><span id="submiteditsleepjournel">Submit</span></span></a>
	</div>
</div>
</div>
<div class="b b2">
	<div class="add-popup-bottomleft">
	  <div>&nbsp;</div>
	</div>
</div>	