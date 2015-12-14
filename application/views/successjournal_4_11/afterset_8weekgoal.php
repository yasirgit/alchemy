<?php if(count($weekGoal)>0)
        {foreach ($weekGoal as $key => $wlist){   
		          $enddate = $wlist['endingDate'];
				  //date remaining
                  $dt=explode('-',$enddate); $x=1;
                  $s=$dt[1]-$x;
                  $edate=$dt[0].",".$s.",".$dt[2];
		
		?>
<?php
 foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
		 //Pounds lost comes from the user’s current measurements minus their original measurements
		     //echo $row['weight'];
		    $loseweight = $row['weight']-$curWeight;  
		   
			 $scalling = (float) (219/25);
			 $diffWeight = $loseweight * $scalling;
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
          var austDay = new Date(<?php echo $edate; ?>); 
          $('#week8Countdown').countdown({until:austDay});
    
   });
</script>
<div class="rht-box">
		<div class="rht-box-top">
		    <h2 class="meter-title">8 Week Goal</h2>
		    <div class="box-holder-title"><a id="return-weekedit">edit</a></div>
		</div>
		<div class="rht-box-mid">
		    <div class="weight-lose-box">
            <div class="lose">Lose </div>
            <div class="lose-amount"><?php  echo $wlist['clothingSize'];?> in</div>
        </div>
		<div class="weight-lose-graph">
		     <div class="comm-progress week-bar not-full" <?php echo "style='width:".$dynWidth."px;'"  ;?>>-<?php echo $loseweight; ?> lbs<div class="left-volume"></div></div>
		</div>
		<div class="ticket">
		      <?php
					  if($wlist['daySpa']==1)
					  {
					  ?>
					  <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward1.gif" height="" width="" alt="reward1" align="middle">
					  <?php } 
					  elseif($wlist['weekendTrip']==1) { 
					  ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward2.gif" height="" width="" alt="reward2" align="middle">
					  <?php }
					   elseif($wlist['concertTickets']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward3.gif" height="" width="" alt="reward3" align="middle">
					    <?php }
					   elseif($wlist['nightOuts']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-right.gif" height="" width="" alt="reward4" align="middle">
					    <?php }
					   elseif($wlist['newOutfit']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-right.gif" height="" width="" alt="reward5" align="middle">
					    <?php }
					   elseif($wlist['myOwnreward']==1) {
					   ?>
					    <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward6.gif" height="" width="" alt="reward6" align="middle">
						<?php } ?>
		</div>
		<div class="time-label">Time Remaining</div>
		<div id="week8Countdown" class="snapshot-time-count"></div>

		</div>
	<div class="rht-box-bottom"></div>
</div>
		 <?php 
		    } }
			?>
			