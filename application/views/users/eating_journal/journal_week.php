<div style="float:left;width:270px;height:auto; border:1px solid gray;padding:5px;margin:7px;">
	<div style="padding-left:5px;height:30px;color:#FFFFFF;font:weight:bold;font-size:14px;background:#74DF00"><a class="week_every_day" activedate="<?php 	
	echo date("m/d/Y",strtotime($times[0]->today));
	 ?>" style="color:#FFFFFF;font:weight:bold;text-decoration:none;cursor:pointer;"><?=$times[0]->dayofweek?> <?=$times[0]->today?></a></div>
	<?php	
	$flag=array();	
	foreach($times AS $time)
	{
		if (@$bgColor == "#FFF")
		{
			$bgColor = "#CEF6CE";
		}
		else
		{
			$bgColor = "#FFF";
		}		
		?>
		<?php

			/////////////////////sleep time/////////////						
				if(!empty($times['sleep_time']))
				{
					////////////
											
					for($i=0;$i<count($times['sleep_time']);$i++)
					{
						$temp1=$time->time;
						$temp2=$times['sleep_time'][$i]->from_time;						
						 										
						if($temp1>=$temp2&&$flag[$i]!=2)
						{
						 $flag[$i]=2;							
						?> 
						 <div style="float:left;padding:5px;width:260px;min-height:20px;background:<?=$bgColor?>;">
						 	<?php echo date("h:i A",strtotime($times['sleep_time'][$i]->from_time))." To ".date("h:i A",strtotime($times['sleep_time'][$i]->to_time))." (sleep)"; ?>
						 	<span class="schedule-box" style="background:none;text-align:right;">
						 		<a ujsid="<?php echo $times['sleep_time'][$i]->id; ?>" class="editSleeptime" href="javascript:void(0);"><img src="htdocs/images/ico-edit.gif" border="0" /></a>
						 	</span>
						 </div>						 
						 <?php 
						 $bgColor=$bgColor == "#FFF"?"#CEF6CE":"#FFF";
						} 
						
					}
					////////////
				}
				
				/////////////////////////
		
		?>
		<div style="float:left;padding:5px;width:260px;min-height:30px;background:<?=$bgColor?>;">		
			<?php
			if (@$time->journal)
			{												
				$journal_id=$time->journal[0]->ujID;
				?>
				<form id="journalForm_<?=$time->utID?>_<?php echo $journal_id;?>_<?=$times[0]->today?>">
				<div style="width:55px;float:left;">
					<?=@$time->type?><br />
					<?php //date("h:i A",strtotime(@$time->ujTime)); ?>
					<?=date("h:i A",strtotime($time->time))?>
				</div>
				<div style="width:189px;float:left;">
					<?php					
					foreach ($time->journal AS $journal)
					{
						?><input type="hidden" name="ujID[]" value="<?=$journal->ujID?>" /><?php
						if ($journal->name)
						{
							?><div style="float:left;height:auto;"><b><?php echo stripslashes($journal->name);?></b></div><?php
							$inset = " &nbsp - ";
						}
						else
						{
							$inset = "";
						}
						foreach ($journal->items AS $item)
						{
							?><div style="clear:both;height:auto;"><?=$inset.$item->qty?> <?php echo stripslashes($item->serving);?> <?=$item->entryname?></div><?php
						}
					}
					?>
				</div>
				<div style="width:16px;float:left;">
					<?php
					if (@$time->journal)
					{
						?><a href="javascript:void(0);" class="editJournal" utID="<?=$time->utID?>" ujID="<?php echo $journal_id;?>" date="<?=$times[0]->today?>" time="<?=strtotime($time->time)?>"><img src="htdocs/images/ico-edit.gif" border="0" /></a><?php
					}
					?>
				</div>
				</form>
				<?php				
			}
			else
			{
				if(@$time->utID)
				{
				?>
				<div style="width:260px;float:left;">
					<?=@$time->type?><br />
					<?=date("h:i A",strtotime(@$time->time))?>
				</div>
				<?php
				}
			}
			?>
		</div>		
		<?php
	}
?>	
</div>
