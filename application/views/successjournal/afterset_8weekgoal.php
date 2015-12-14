
<?php if(count($weekGoal)>0)
        {
		  foreach ($weekGoal as $key => $wlist){   
		          $enddate = $wlist['endingDate'];
				  $curDate = date('Y-m-d h:i:s'); 
				  $remainDays = strtotime($enddate)-strtotime($curDate);
		          $temp=$remainDays/86400; 
		          $days=floor($temp); 
		          $temp=24*($temp-$days);
	              $hours=floor($temp);
		          $temp=60*($temp-$hours);
		          $minutes=floor($temp);
		          $temp=60*($temp-$minutes);
		          $seconds=floor($temp);
				  //date remaining
                /*  $dt=explode('-',$enddate); $x=1;
                  $s=$dt[1]-$x;
                  $edate=$dt[0].",".$s.",".$dt[2];
				  $todate=date('Y-m-d');*/
				  $todate=date('Y-m-d h:i:s');
				  $lose= $wlist['pounds'];
				  
				  $startRange=$row['weight'];
			      $endRange=$row['weight']- $lose;
			      $midRange=(($lose/2)+$endRange);
		
		?>
		<script type="text/javascript">
   $(document).ready(function() {

		  $('#defaultCountdown2').countdown({until:'+<? echo $days; ?>d +<? echo $hours; ?>h +<? echo $minutes; ?>m +<? echo $seconds; ?>s'});
    
   });
</script>
<?php
 foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
 
         if($curWeight=='' || $curWeight==0){ $curWeight=$row['weight'];}
		 //Pounds lost comes from the user’s current measurements minus their original measurements
		     //echo $row['weight'];
		 $loseweight = $curWeight - $row['weight'];  
	   if($loseweight < 0)
		{    
		  
		    if(abs($loseweight) >= $lose)
		    {  
                      //echo "Result: {$days}d {$hours}h {$minutes}m {$seconds}s<br/>\n";

		?>
		                
					                    <div class="rht-box-top">
					                      <h2 class="meter-title">8 Week Goal</h2>
					                      <div class="box-holder-title"><a id="return-weekedit">edit</a></div>
				                        </div>
					                    <div class="rht-box-mid">
					                          <div class="mygoal-congrats-2">
                                                  <h2 class="bold-01">Congratulations!</h2>
                                                 <em class="hit-goal">You&#39;ve hit your goal!</em>
                                                 <h3 class="bold-02">You Lost <br /> 
<? echo $lose; ?> lbs !</h3>	
											     <em class="claim-reward">Don&#39;t forget to claim your reward</em>
                                                 <div class="ticket">
					  <?php
					  if($wlist['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($wlist['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($wlist['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($wlist['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($wlist['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($wlist['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						  <? echo $wlist['ownRewardText']; ?>
						<?php } ?>
					  </div>
                                                 <div class="time-label">Time Remaining</div>
                                                <?php
													if($enddate>=$todate)
													{
												?>																	
												 <div id="defaultCountdown2" class="snapshot-time-count"></div>
												<? }
												    else{
												?>
                                                    <ul class="snapshot-time-count">
                                                        <li>-<small>Days</small></li>
                                                        <li>-<small>Hours</small></li>
                                                        <li>-<small>Minutes</small></li>
                                                        <li>-<small>Second</small></li>
                                                     </ul>
												<? } ?>
                                              </div>
				                        </div>
					                    <div class="rht-box-bottom"></div>
				                     
		
           <?		  
		    }else{
		
		   
			 $scalling = (float) (219/$lose);
			  $diffWeight = abs($loseweight)* $scalling;
			 if($diffWeight < 219)
			 {
			    $dynWidth = $diffWeight;
			 }
			 else
			 {
			    $dynWidth = 219;
			 }
?>
<script type="text/javascript">
   $(document).ready(function() {
		  $('#week8Countdown').countdown({until:'+<? echo $days; ?>d +<? echo $hours; ?>h +<? echo $minutes; ?>m +<? echo $seconds; ?>s'});
    
   });
</script>

		<div class="rht-box-top">
		    <h2 class="meter-title">8 Week Goal</h2>
		    <div class="box-holder-title"><a id="return-weekedit">edit</a></div>
		</div>
		<div class="rht-box-mid">
		 <div class="weight-lose-box">
            <div class="lose">Lose </div>
            <div class="lose-amount"><?php  echo $wlist['pounds'];?> lbs</div>
        </div>
		<div class="weight-lose-graph">
		     <div class="comm-progress week-bar not-full" <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php echo abs($loseweight); ?> lbs<div class="left-volume"></div>
			 </div>
			   <div class="lost-unit">
                            <span><? echo $startRange; ?> lbs</span>
                            <span class="middle"><? echo $midRange; ?> lbs</span>
                            <span class="right"><? echo $endRange; ?> lbs</span>
               </div>
		</div>
							
		<div class="ticket">
					  <?php
					  if($wlist['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($wlist['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($wlist['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($wlist['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($wlist['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($wlist['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						   <? echo $wlist['ownRewardText']; ?>
						<?php } ?>
					  </div>
		<div class="time-label">Time Remaining</div>
		<?php   if($todate >= $enddate){  ?>
		         <p style="margin:auto;text-align:center; width:235px;color:#C3161C;font-weight:bold;font-size:20px;"> Time is over!</p>
		 <ul class="snapshot-time-count">
			                   <li>-<small>Days</small></li>
			                   <li>-<small>Hours</small></li>
			                   <li>-<small>Minutes</small></li>
			                   <li>-<small>Second</small></li>
		                 </ul>
		
		<?php 
		  } else{
		?>
		
		<div id="week8Countdown" class="snapshot-time-count"></div>
        <?php } ?>
		</div>
	<div class="rht-box-bottom"></div>

		 <?php 
		    }
		?>
			
			
		<?	
			
	 }else{
	 ?>

		<div class="rht-box-top">
		    <h2 class="meter-title">8 Week Goal</h2>
		    <div class="box-holder-title"><a id="return-weekedit">edit</a></div>
		</div>
		<div class="rht-box-mid">
		 <div class="weight-lose-box">
            <div class="lose">Lose </div>
            <div class="lose-amount"><?php  echo $wlist['pounds'];?> lbs</div>
        </div>
		<div class="weight-lose-graph">
		     <div class="comm-progress week-bar not-full" <?php echo "style='width:8px;'"  ;?>>
			    <div class="left-volume"></div>
			</div>
			<div class="lost-unit">
                            <span><? echo $startRange; ?> lbs</span>
                            <span class="middle"><? echo $midRange; ?> lbs</span>
                            <span class="right"><? echo $endRange; ?> lbs</span>
               </div>
		</div>
		<div class="ticket">
					  <?php
					  if($wlist['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($wlist['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($wlist['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($wlist['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($wlist['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($wlist['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						  <? echo $wlist['ownRewardText']; ?>
						<?php } ?>
					  </div>
		<div class="time-label">Time Remaining</div>
		<?php   if($todate >= $enddate){  ?>
		         <p style="margin:auto;text-align:center; width:235px;color:#C3161C;font-weight:bold;font-size:20px;"> Time is over!</p>
		 <ul class="snapshot-time-count">
			                   <li>-<small>Days</small></li>
			                   <li>-<small>Hours</small></li>
			                   <li>-<small>Minutes</small></li>
			                   <li>-<small>Second</small></li>
		                 </ul>
		
		<?php 
		  } else{
		?>
		<script type="text/javascript">
   $(document).ready(function() {
          var austDay = new Date(<?php echo $edate; ?>); 
          $('#week8Countdown').countdown({until:austDay});
    
   });
</script>
		<div id="week8Countdown" class="snapshot-time-count"></div>
        <?php } ?>
		</div>
	<div class="rht-box-bottom"></div>

	 
	 <?
	 }
   }
 }
			
?>
			