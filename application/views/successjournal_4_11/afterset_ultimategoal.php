<?php 
         if(count($ugoalset)>0){foreach ($ugoalset as $key => $list){ 
		 
		 foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
		 //Pounds lost comes from the user’s current measurements minus their original measurements
		     //echo $row['weight'];
		     $loseweight = $row['weight']-$curWeight;  
		   
			 $scalling = (float) (210/50)  ;
			 $diffWeight=$loseweight * $scalling;
			 if($diffWeight < 210)
			 {
			   $dynWidth = $diffWeight;
			 }
			 else
			 {
			    $dynWidth = 210;
			 }
?>
<div class="lft-box">
		<div class="lft-box-top">
				<h2 class="meter-title">Ultimate Goal</h2>
				<div class="box-holder-title"><a id="return-uedit">edit</a></div>
		</div>
		<div class="lft-box-mid">
				<div class="lft-box-inner">
					<div class="weight-lose-box">
					    <div class="lose">Lose </div>
					       <div class="lose-amount"><?php echo $list['clothingSize'];?> in
                           </div>
				         </div>
					   
					  <div class="weight-lose-graph">
					      <div class="comm-progress not-full" <?php echo "style='width:".$dynWidth."px;'"  ;?>>-<?php echo $loseweight; ?> lbs<div class="left-volume"></div></div>
					  </div>
					
					  <div class="ticket">
					 
					  <?php
					  if($list['daySpa']==1)
					  {
					  ?>
					  <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward1.gif" height="" width="" alt="reward1" align="middle">
					  <?php } 
					  elseif($list['weekendTrip']==1) { 
					  ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward2.gif" height="" width="" alt="reward2" align="middle">
					  <?php }
					   elseif($list['concertTickets']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward3.gif" height="" width="" alt="reward3" align="middle">
					    <?php }
					   elseif($list['nightOuts']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward.gif" height="" width="" alt="reward4" align="middle">
					    <?php }
					   elseif($list['newOutfit']==1) {
					   ?>
					   <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward5.gif" height="" width="" alt="reward5" align="middle">
					    <?php }
					   elseif($list['myOwnreward']==1) {
					   ?>
					    <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward6.gif" height="" width="" alt="reward6" align="middle">
						<?php } ?>
						
					  </div>
				 </div>
		</div>
			<div class="lft-box-bottom"></div>
 </div>
		<?php }} 
		else{
		?>
		<div class="lft-box">
		<div class="lft-box-top">
				<h2 class="meter-title">Ultimate Goal</h2>
				<div class="box-holder-title"><a id="return-uedit">Add</a></div>
		</div>
				<div class="lft-box-mid">
				<div class="lft-box-inner">
					<div class="weight-lose-box">
					    <div class="lose">Lose </div>
					       <div class="lose-amount">0 in
                           </div>
				         </div>
					   
					  <div class="weight-lose-graph"></div>
					
					  <div class="ticket">

						
					  </div>
				 </div>
		</div>
				<div class="lft-box-bottom"></div>
 </div>
<?php 
	}
?>

