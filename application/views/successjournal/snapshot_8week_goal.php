<?php
if(count($weekGoal)>0){   
 foreach ($weekGoal as $key => $wlist){ 
   $lose = $wlist['pounds']; 
   $startRange=$row['weight'];
   $endRange=$row['weight']- $lose;
   $midRange=(($lose/2)+$endRange);
   ///remaining date count
   $enddate =  $wlist['endingDate']; 
   
   $todate = date('Y-m-d h:i:s');


/*   $dt=explode('-',$enddate); $x=1;
   $s=$dt[1]-$x;
   $edate=$dt[0].",".$s.",".$dt[2];*/
   
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
?>



<script type="text/javascript">
   $(document).ready(function() {
            $('#defaultCountdown').countdown({until:'+<? echo $days; ?>d +<? echo $hours; ?>h +<? echo $minutes; ?>m +<? echo $seconds; ?>s'});
   });
</script>
<?php
	 foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
	 
	         if($curWeight=='' || $curWeight==0){ $curWeight=$row['weight'];}
			 
		 //Pounds lost comes from the user’s current measurements minus their original measurements
		 
		    
		    $loseweight = $curWeight - $row['weight'];  
			 
			 if($loseweight < 0)
			 {    
			   
			    if(abs($loseweight) >= $lose)  
			    {       
			          
			  ?>
                    
                         <div class="ultimate-bottom-round">
                               <div class="ultimate-title">
                                    <h2 class="meter-title">8 Week Goal</h2>
                                    <div class="loser-quantity"><span>Lose <? echo $lose; ?> lbs</span></div>
                                    <div class="clear">&nbsp;</div>
                                </div>
                                <div class="time-label">Time Remaining</div>
								<?php
									if($enddate>=$todate)
									 {
								?>																	
								        <div id="defaultCountdown" class="snapshot-time-count"></div>
							    <? 
								     }
									 else{
								?>
                                        <ul class="snapshot-time-count">
                                            <li>-<small>Days</small></li>
                                            <li>-<small>Hours</small></li>
                                            <li>-<small>Minutes</small></li>
                                            <li>-<small>Second</small></li>
                                        </ul>
								<? } ?>
                                        <div class="congrats-weekgoal">
                                            <h2 class="bold-01">
                                                  Congratulations!
                                            </h2>
                                            <h3 class="bold-02">You&#39;ve hit your goal!</h3>                                                                       
                                            <em>Don&#39;t forget to claim your reward,</em>
                                         </div>
                           </div>
                       
			     <?php
			        }
			        else{   
		   
			            $scalling = (float) (219/$lose)  ;
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
                   
                           <div class="ultimate-bottom-round">
                              <div class="ultimate-title">
                                   <h2 class="meter-title">8 Week Goal</h2>
                                   <div class="loser-quantity"><span>Lose <?php echo $lose;  ?> lbs</span></div>
                                   <div class="clear">&nbsp;</div>
                              </div>
                              <div class="time-label">Time Remaining</div>
				             <?php   if($todate >= $enddate){  ?>
							  <div style="margin:auto;text-align:center; width:235px;color:#C3161C;font-weight:bold;font-size:20px; ">                                   Your time is over!
					          </div>  
					          <ul class="snapshot-time-count">
			                          <li>-<small>Days</small></li>
			                          <li>-<small>Hours</small></li>
			                          <li>-<small>Minutes</small></li>
			                          <li>-<small>Second</small></li>
		                      </ul>
					       <? } else {?>
				              <div id="defaultCountdown" class="snapshot-time-count"></div>
							  <? } ?>

                              <div class="ultimate-miter">
				   
					              <div class="comm-progress week-bar not-full" <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php echo abs($loseweight); ?> lbs <div class="left-volume"></div>
						          </div>
								  <div class="lost-snapshot">
                                      <span><? echo $startRange; ?> lbs</span>
                                      <span class="middle"><? echo $midRange; ?> lbs</span>
                                      <span class="right"><? echo $endRange; ?> lbs</span>
                                  </div>
				              </div>
                          </div>
                      
             <?php 
			          } 
			}else{  
			?>
			       
                           <div class="ultimate-bottom-round">
                              <div class="ultimate-title">
                                   <h2 class="meter-title">8 Week Goal</h2>
                                   <div class="loser-quantity"><span>Lose <?php echo $lose;  ?> lbs</span></div>
                                   <div class="clear">&nbsp;</div>
                              </div>
                              <div class="time-label">Time Remaining</div>
							   <?php   if($todate >= $enddate){  ?>
							  <div style="margin:auto;text-align:center; width:235px;color:#C3161C;font-weight:bold;font-size:20px; ">                                   Your time is over!
					          </div>  
					          <ul class="snapshot-time-count">
			                          <li>-<small>Days</small></li>
			                          <li>-<small>Hours</small></li>
			                          <li>-<small>Minutes</small></li>
			                          <li>-<small>Second</small></li>
		                      </ul>
					       <? } else {?>
				 
				              <div id="defaultCountdown" class="snapshot-time-count"></div>
							  
							  <? } ?>

                              <div class="ultimate-miter">
				   
					              <div class="comm-progress week-bar not-full" <?php echo "style='width:8px;'"  ;?>>                                       <div class="left-volume"></div>
						          </div>
								  <div class="lost-snapshot">
                                         <span><? echo $startRange; ?> lbs</span>
                                         <span class="middle"><? echo $midRange; ?> lbs</span>
                                         <span class="right"><? echo $endRange; ?> lbs</span>
                                  </div>
				              </div>
                          </div>
                   
			
			
<?			
			}
         
	}
	
}else{       
?>

                                                                <div class="ultimate-bottom-round">
                                                                    <div class="ultimate-title">
                                                                        <h2 class="meter-title">8 Week Goal</h2>
                                                                        <div class="loser-quantity"><span>Lose 50 lbs</span></div>
                                                                        <div class="clear">&nbsp;</div>
                                                                    </div>
                                                                    <div class="time-label">Time Remaining</div>
                                                                    <ul class="snapshot-time-count">
                                                                        <li>-<small>Days</small></li>
                                                                        <li>-<small>Hours</small></li>
                                                                        <li>-<small>Minutes</small></li>
                                                                        <li>-<small>Second</small></li>
                                                                    </ul>
                                                                    <div class="congrats-module-text">                                                                      
                                                                     <p>By the time you reach the end of these 8 weeks, you will have made dramatic changes to your body and gained all the tools you need to live healthier for the rest of your life. Set your goal in whatever terms you like - pounds lost, clothing sizes, or a reduction in body fat.  And don't forget to add your Reward so you can celebrate your success!
</p>
                                                                     <p class="btn-center"><a id="return-weekedit" class="sexybutton sexyorange"><span><span>+Set 8 Week Goal</span></span></a></p>
                                                                    </div>
                                                                </div>
                                                       
<?php
}
?>