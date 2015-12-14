<div style="float:left;width:72px;height:100px;border:1px solid gray;padding:5px;">
	<div style="float:right;"><?=$times[0]->dayofmonth?></div>
	<?php
	if ($times)
	{
		?>
		<div style="clear:both;margin:0 auto;">
			<?php
			/*
			echo "<pre>";
				print_r($times['sleep_time']);
			echo "</pre>";*/	
			foreach($times AS $time)
			{
				?>
				<div>
					<?php
					if (@$time->journal)
					{
						$journal_id=$time->journal[0]->ujID;
						?>
						<form id="journalForm_<?=$time->utID?>_<?php echo $journal_id;?>_<?=$times[0]->today?>" action="javascript:void(0);">
	 					<a class="sexybutton sexyorange editJournal" utID="<?=$time->utID?>" ujID="<?php echo $journal_id;?>" date="<?=$times[0]->today?>" time="<?=strtotime($time->time)?>" style="width:70px;padding:0px;">
							<span><span style="font-size:11px;"><?=$time->type?></span></span>
						</a>
	 					<?php
						foreach ($time->journal AS $journal)
						{
							?><input type="hidden" name="ujID[]" value="<?=$journal->ujID?>" /><?php
						}
						?>
						</form>
						<?php
	 				}
				?>
				</div>
				<?php
			}
			if ($times[0]->dayofweek == "__Saturday")
			{
				?>
				<div class="weekly" style="position:relative;top:0px;left:65px;z-index:32000;width:15px;height:100px;">
					<div>X</div>
				</div>
				<?php
			}
			?>
			<?php
			for($i=0;$i<count($times['sleep_time']);$i++)
			{
			?>				
				<span class="schedule-box" style="background:none;text-align:right;">
						 		<a ujsid="<?php echo $times['sleep_time'][$i]->id; ?>" class="editSleeptime" href="javascript:void(0);"><img src="htdocs/images/ico-edit.gif" border="0" />Sleep</a>
				</span>	
			<?php 	
			} 			
			?>
		</div>
		<?php		
	}	
	?>
</div>
