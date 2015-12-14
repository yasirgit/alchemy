<script>
	$(function() {
		$( "#eightweekGoal" ).progressbar({
			value:20 <?php // echo $value; ?>
		});
	});
</script>
<?php
if(count($weekGoal)>0){
 foreach ($weekGoal as $key => $wlist){ 
   $lose= $wlist['pounds']; 
  ///remaining date count
  $enddate=  $wlist['endingDate']; 
  $waittime=date("y-m-d h:i:s");
  $diff=strtotime($enddate)-strtotime($waittime);
     $temp=$diff/86400; 
  $days=floor($temp);
     $temp=24*($temp-$days);
  $hours=floor($temp);
     $temp=60*($temp-$hours);
  $minutes=floor($temp);
     $temp=60*($temp-$minutes);
  $seconds=floor($temp);
 //  echo "Result: {$days}d {$hours}h {$minutes}m {$seconds}s<br/>\n";
}}
?>
<div class="ultimate-goal week-goal">
        <div class="ultimate-bottom-round">
                <div class="ultimate-title">
                       <h2 class="meter-title">8 Week Goal</h2>
                       <div class="loser-quantity"><span>Lose <?php echo $lose;  ?> lbs</span></div>
                        <div class="clear">&nbsp;</div>
                 </div>
                 <div class="time-label">Time Remaining</div>
                       <ul class="snapshot-time-count">
                             <li><?php echo $days; ?><small>Days</small></li>
                             <li><?php echo $hours; ?><small>Hours</small></li>
                             <li><?php echo $minutes; ?><small>Minutes</small></li>
                             <li><?php echo $seconds; ?><small>Second</small></li>
                       </ul>
                 <div class="ultimate-miter">
				     <div class="ppbar_set">
			                   <div id="eightweekGoal"></div>
		             </div>
				 </div>
        </div>
</div>