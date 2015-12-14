<div class="rht-box">
		<div class="rht-box-top">
		    <h2 class="meter-title">8 Week Goal</h2>
		    <div class="box-holder-title"><a id="return-weekedit">edit</a></div>
		</div>
		<?php if(count($weekGoal)>0){foreach ($weekGoal as $key => $wlist){ 
		  $enddate = $wlist['endingDate'];
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
		
		?>
		<div class="rht-box-mid">
		    <div class="weight-lose-box">
            <div class="lose">Lose </div>
            <div class="lose-amount"><?php  echo $wlist['clothingSize'];?> in</div>
        </div>
		<div class="weight-lose-graph"></div>
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
		<ul class="snapshot-time-count">
			<li><?php echo $days; ?><small>Days</small></li>
			<li><?php echo $hours; ?><small>Hours</small></li>
			<li><?php echo $minutes; ?><small>Minutes</small></li>
			<li><?php echo $seconds; ?><small>Second</small></li>
		</ul>
		</div>
		 <?php 
		    } }
          ?>
		<div class="rht-box-bottom"></div>
</div>