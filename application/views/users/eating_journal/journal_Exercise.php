<?php
if ($time->journal)
{
	// NOTE: there is only one journal entry per utID for Exercise entries
	/*echo "<pre>";
		print_r($time);
	echo "</pre>";*/
	?>
	<div class="schedule-box sub3">
		<div class="edit-box"><?=$this->load->view('users/eating_journal/journal_meal',$time->journal);?></div>
		<div class="holder">
			<div class="hours-box"><span><?=date("h:i A",strtotime($time->journal[0]->time));?></span></div>
			<form id="journalForm_<?=$time->utID?>_<?=$time->journal[0]->ujID?>_<?=$time->date?>">
			<input type="hidden" name="ujID[]" value="<?=$time->journal[0]->ujID?>" />
			<div class="info-box">				
				<div style="float:left;padding-left:20px;">
					<?php
					if(isset($time->journal[0]->items[0]->entryname))
					if ($time->journal[0]->items[0]->entryname == "Cardio")
					{
						?><img src="htdocs/images/img16.png" class="png" alt="" /><?php
					}
					else
					{
						?><img src="htdocs/images/img17.png" class="png" alt="" /><?php
					}
					?>
					<?php
					if (@$time->journal[0]->skipped == 1)
					{
					?><u>SKIPPED THIS EXERCISE</u><?php
					}?>					
				</div>
				
				<div style="float:left;padding-left:10px;font-weight:normal;">
				 <?php
					if(isset($time->journal[0]->items[0]->entryname))
					{
				 ?>	
					<?=@$time->journal[0]->name?> <?=$time->journal[0]->items[0]->qty?> <?=$time->journal[0]->items[0]->serving?> <?=$time->journal[0]->items[0]->entryname?> workout
				 <?php
					}
				 ?>	
				</div>
			</div>
			</form>
		</div>
	</div>
	<?php
	$this->config->set_item('flagtime',$time->journal[0]->time);
}
else
{
	?>
	<div class="schedule-box sub5">
		<div class="edit-box"><?=$this->load->view('users/eating_journal/journal_meal',$time->journal);?></div>
		<div class="holder">
			<div class="hours-box"><span><?=date("h:i A",strtotime($time->time));?></span></div>
			<div class="image-box"><span id="mealType"><?=$time->type?></span></div>
			<div class="block"><div><span>Enter your exercise</span></div></div>
		</div>
	</div>
	<?php
	}
?>