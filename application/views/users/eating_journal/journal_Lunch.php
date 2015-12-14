<?php
if ($time->journal)
{							
		$journal_id="";
	?>
	<?php
	if(isset($time->food_description))
	{
	 $mainfatlossdata=$time->food_description; 
		if($mainfatlossdata['isSkip']==0)
		$this->config->set_item('flagmealtime',$time->journal[0]->time);
	}
			
	if($mainfatlossdata['isSkip']==0)
	{			
				
		$flagw=0;		
		$positiontime=strtotime($activetime." ".$time->journal[0]->time);				
		$glb_time=strtotime($activetime." ".$globalwaketime);
													
		if((isset($mainfatlossdata['lastmealtaken'])&&strlen($mainfatlossdata['lastmealtaken'])>0))
		{			 
			$current_time=strtotime($activetime." ".$mainfatlossdata['lastmealtaken']);			
			 if(($current_time>=$glb_time&&$positiontime>=$glb_time)||($current_time<=$glb_time&&$positiontime<=$glb_time))
			 {
			  $dtime=substr($mainfatlossdata['lastmealtaken'],0,5);
			  $flagw=1;			 
			 }
			 else if($positiontime>=$glb_time&&$current_time<$glb_time)
			 {
				$dtime=substr($globalwaketime,0,5);											
				$flagtime=strtotime($activetime." ".$this->config->item('flagtime'));															
				if($flagtime<$glb_time)
				$this->config->set_item('flagtime',$globalwaketime);
			 }
		}		
		else if($positiontime>=$glb_time)		
		{
			$dtime=substr($globalwaketime,0,5);
			
			$flagtime=strtotime($activetime." ".$this->config->item('flagtime'));															
			if($flagtime<$glb_time)
			$this->config->set_item('flagtime',$globalwaketime);
		}
				
		if(isset($dtime))
		{								
				///////////////////////////////////////////////////////				
				$atime=substr($time->journal[0]->time,0,5);						
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
				if(($flagw==1&&$hours>3)||($flagw==0&&$hours>1))
				{								
				  $timedata['currenttime']=$time->journal[0]->time;
				?>
				<?php $this->load->view('users/eating_journal/journal_error',$timedata);?>
				<?php
				}				
		}		
	}
	$this->config->set_item('flagtime',$time->journal[0]->time);	
	?>
	<div class="schedule-box sub2 meal">
		<div class="edit-box"><?=$this->load->view('users/eating_journal/journal_meal',$time->journal);?></div>
		<div class="holder" <?php if (@$time->journal[0]->planned == 1) { ?>style="background:#E6E6E6;"<?php } ?>>
			<div class="hours-box"><span><?=date("h:i A",strtotime($time->journal[0]->time));?></span></div>
			<div class="image-box">
				<span id="mealType"><?=$time->type?></span>
				<?php
				if (@$time->image)
				{
					?><img src="<?=_UPLOAD_PATH_?>/<?=$time->image[0]->name?>" width="107" height="70" alt="" /><?php
				}
				else
				{
					?><img src="htdocs/images/img20.gif" width="107" height="70" alt="" /><?php
				}
				?>
			</div>
			<?php 			
				$journal_id=$time->journal[0]->ujID;			
			?>
			<form id="journalForm_<?=$time->utID?>_<?php echo $journal_id;?>_<?=$time->date?>">
			<div class="info-box">
				<?php
				if (@$time->journal[0]->skipped == 1)
				{
					?><u>SKIPPED THIS MEAL</u><?php
				}
				foreach ($time->journal AS $journal)
				{
					if (@$journal->name)
					{
						?><strong><?php echo stripslashes(@$journal->name); ?></strong><?php
						if(strlen(@$journal->description)>0)
						{?>
						<p style="font-weight:normal;"><?php echo stripslashes(@$journal->description); ?></p>
						<?php
						}
					}					
					?>
					<input type="hidden" name="ujID[]" value="<?=$journal->ujID?>" />
					<?php 
					if(!isset($journal->name))
					{
					?>
					<ul>
						<?php
						foreach ($journal->items as $item)
						{
							?>
							<li>
								<?php
								if (@$journal->name)
								{
									?> &nbsp; - <?php
								}
								?>
								<?=$item->entryname?> (<?=$item->qty?> <?php echo stripslashes($item->serving);?>)
							</li>
							<?php
						}
						?>
					</ul>
					<?php
					}
					?>
					<?php
				}
				?>
			</div>
			</form>
			<div class="status-box">
			
			<?php
				if($time->food_description['isfatlosplate']==1)
				{
				?>
				<img src="htdocs/images/img15.png" class="png" alt="" />
				<?php
				}
				else
				{
				?>
				 <img src="htdocs/images/img13.png" class="png" id="errorlaunchfat<?php echo $journal_id;?>" alt="" />
				<?php
				}
			?>
			</div>
		</div>
	</div>
<?php
if(isset($time->food_description))
$fatlossdata['fatlossdata']=$time->food_description; 
$fatlossdata['classType']="errorlaunchfat".$journal_id;
$this->load->view('users/eating_journal/fatlossplate',$fatlossdata);
?>	
	<?php
}
else
{
		
		//////////////////////////////
		$theExactTime=$activetime;	
		$activetime.=" ".$time->time;		
		$activetime=strtotime($activetime);		
		$current_time=strtotime(date("Y-m-d H:i:s"));
		$lmeal=$this->config->item('flagmealtime');
		
		if($activetime<=$current_time)
		{
		
		  $positiontime=$activetime;				
		  $glb_time=strtotime($theExactTime." ".$globalwaketime);
			
			$flagw=0;
			if((isset($lmeal)&&strlen($lmeal)>0))
			{			 
				 $previous_time=strtotime($theExactTime." ".$lmeal);
				 if(($previous_time>=$glb_time&&$positiontime>=$glb_time)||($previous_time<=$glb_time&&$positiontime<=$glb_time))
				 {
					$dtime=substr($lmeal,0,5);
					$flagw=1;
				 }
				 else if($positiontime>=$glb_time&&$previous_time<$glb_time)
				 {
					$dtime=substr($globalwaketime,0,5);											
					$flagtime=strtotime($theExactTime." ".$this->config->item('flagtime'));															
					if($flagtime<$glb_time)
					$this->config->set_item('flagtime',$globalwaketime);
				 }
			}			
			else if($positiontime>=$glb_time)
			{
				$dtime=substr($globalwaketime,0,5);			 
				
				$flagtime=strtotime($theExactTime." ".$this->config->item('flagtime'));															
				if($flagtime<$glb_time)
				$this->config->set_item('flagtime',$globalwaketime);
			}
			
			
			///////////////////////////////								
			
			if(isset($dtime))
			{
					///////////////////////////////////////////////////////				
					$atime=substr($time->time,0,5);						
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
					if(($flagw==1&&$hours>3)||($flagw==0&&$hours>=0.5))
					{								
					  $timedata['currenttime']=$time->time;
					?>
					<?php $this->load->view('users/eating_journal/journal_error',$timedata);?>
					<?php
					}				
			}
		}
	
	$this->config->set_item('flagtime',$time->time);
	?>
	<div class="schedule-box sub5 meal">
		<div class="edit-box"><?=$this->load->view('users/eating_journal/journal_meal',$time->journal);?></div>
		<div class="holder">
			<div class="hours-box"><span><?=date("h:i A",strtotime($time->time));?></span></div>
			<div class="image-box">
				<span id="mealType"><?=$time->type?></span>
				<img src="htdocs/images/img20.gif" alt="" />
			</div>
			<div class="block"><div><span>Enter your meal</span></div>
			<div class="status-box" style="float:right;">
				<img src="htdocs/images/img11.png" class="png" alt="" />
			</div>
			</div>			
		</div>
	</div>
	<?php
}
?>