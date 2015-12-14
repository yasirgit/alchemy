<div id="journalEntry">
	<div class="look-control">
	<div></div>
	<div>
    <div class="select-option">
	    <b>&nbsp;Please select one:</b>
			<div style="float:right;font-size:12px;">	
			<?php				
			$flag=1;			
			$meal = false;		
			foreach ($time AS $jt)
			{		  	
				switch ($jt->type)
				{
					default:
					break;
					case "Breakfast":
					case "Lunch":
					case "Dinner":
					if (!$meal)
					{
						?><input type="radio" name="journalType" value="Meal" utID="0" class="entryType" onclick="checkSleep(this.value)" checked="true" /> Meal<?php
						$meal = true;
					}
					break;
					case "Exercise":
					?><input type="radio" name="journalType" value="Exercise" utID="<?=$jt->utID?>" onclick="checkSleep(this.value)" class="entryType" /> Exercise<?php
					break;
					case "Snack":
					if($flag==1)
					{	
						?><input type="radio" name="journalType" value="Snack" utID="<?=$jt->utID?>" onclick="checkSleep(this.value)" class="entryType" /> Snack<?php
						$flag++;
					}
					break;
				}
			}		
			?>		  
			<input type="radio" name="journalType" value="Sleep" onclick="checkSleep(this.value)" id="journaltypesleep" class="entryType" /> Sleep
			</div>
        </div>	
	<div id="typecontenttimearea">
	<div class="select-option select-opt-bottom">		
	<?php
		$uTime['title']="&nbsp;At what time?: ";
		$uTime['currenttime']="12:00 AM";
		$uTime['fieldname']="journalTime"; 
		$uTime['timename']="bedjournalTime";
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
	?>
	</div>
	<div class="display-oneline display-titlee">	
	<?php
		 if($active=="week")
		 {	  
		  ?>
			<div class="titme-title"><b>Week Day</b></div>
			<div>&nbsp;
				<select id="dayname" name="dayname" onchange="utidchange();">
					<?
					 foreach($weekday as $key=>$value)
					 {
					?>
						<option value="<?php echo $key;?>"><?php echo $value;?></option>
					<?php
					 }
					?>			
				</select>
			</div>
		 <?php
		 }
		 else if($active=="month")
		 {	 
		  ?>		
		  <div class="titme-title"><b>Month Day</b></div>
			<div>&nbsp;
				<select id="dayname" name="dayname">
					<?
					 foreach($month as $key=>$value)
					 {
					?>
						<option value="<?php echo $key;?>"><?php echo $key."(".$value.")";?></option>
					<?php
					 }
					?>			
				</select>
			</div>
		 <?php
		 }
		 ?>
		</div>
		<div class="right-align-button">
			<a href="javascript:void(0);" id="saveItems" class="sexybutton sexyorange"><span><span class="submitjournel">Submit</span></span></a>
		</div>
	</div>
	
	<div id="contentsleeptime" style="display:none; padding:16px 0 0;">
	
	<div class="display-oneline display-titlee" <?php if($active!="week" && $active!="month") { echo 'style="display:none;"'; } ?>>
<?php
		 if($active=="week")
		 {	  
		  ?>
			<div class="titme-title"><b>Week Day</b></div>
			<div>&nbsp;
				<select id="daynameweek" name="daynameweek" onchange="utidchange();">
					<?
					 foreach($weekday as $key=>$value)
					 {
					?>
						<option value="<?php echo $key;?>"><?php echo $value;?></option>
					<?php
					 }
					?>			
				</select>
			</div>
		 <?php
		 }
		 else if($active=="month")
		 {	 
		  ?>		
		  <div class="titme-title"><b>Month Day</b></div>
			<div>&nbsp;
				<select id="daynameweek" name="daynameweek">
					<?
					 foreach($month as $key=>$value)
					 {
					?>
						<option value="<?php echo $key;?>"><?php echo $key."(".$value.")";?></option>
					<?php
					 }
					?>			
				</select>
			</div>
		 <?php
		 }
		 ?>
		 </div>
		 <div>
		<?php
		$uTime['title']="<b>From time?</b>: ";
		$uTime['currenttime']="12:00 AM";
		$uTime['fieldname']="journalfromTime"; 
		$uTime['timename']="bedjournalfromTime";
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
		?>
		</div>
		<div>
		<?php
		$uTime['title']="<b>End time?</b>: ";
		$uTime['currenttime']="12:00 AM";
		$uTime['fieldname']="journaltoTime"; 
		$uTime['timename']="bedjournaltoTime";
		echo $this->load->view('users/eating_journal/journal_time',$uTime);
		?>
		</div>					
		<div class="right-align-button">
			<a href="javascript:void(0);" id="saveItems" class="sexybutton sexyorange"><span><span class="submitsleepjournel">Submit</span></span></a>
		</div>	
	</div>
</div>
</div>
    <div class="b b2">
        <div class="add-popup-bottomleft">
          <div>&nbsp;</div>
        </div>
      </div>