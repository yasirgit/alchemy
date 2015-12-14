<?php 
         
	if(count($ugoalset)>0)
	{
		foreach ($ugoalset as $key => $list)
		{ 
		 
		    $lose= $list['pounds'];
			
			$startRange=$row['weight'];
			$endRange=$row['weight']- $lose;
			$midRange=(($lose/2)+$endRange);
			
			
		    foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
		    //Pounds lost comes from the user’s current measurements minus their original measurements
		    //echo $row['weight'];
		    if($curWeight=='' || $curWeight==0){ $curWeight=$row['weight'];}
		   
		    $loseweight = $curWeight - $row['weight'];
			if($loseweight < 0)
			{   
			    if(abs($loseweight) >= $lose)
			    {
			 ?>
					                 
					                    <div class="lft-box-top">
					                      <h2 class="meter-title">Ultimate Goal</h2>
					                      <div class="box-holder-title"><a id="return-uedit">edit</a></div>
				                        </div>
					                    <div class="lft-box-mid">
					                      <div class="lft-box-inner lft-box-inner-new">
					                          <div class="mygoal-congrats-1">
                                                 <h2 class="bold-01">Congratulations!</h2>
                                                 <em class="hit-goal">You&#39;ve hit your goal!</em>
                                                 <h3 class="bold-02">You Lost <br /> 
<? echo $lose; ?> lbs !</h3>	
											     <em class="claim-reward">Don&#39;t forget to claim your reward</em>
                                                 
                                                 <div class="ticket">
					  <?php
					  if($list['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($list['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($list['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($list['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($list['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($list['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						  <? echo $list['ownRewardText']; ?>
						<?php } ?>
					  </div>			
                                             
                                             <a  id="return-to" class="sexybutton sexyorange"><span><span>+Set new goal</span></span></a>
                                              </div>
					                       
				                          </div>
				                        </div>
					   <div class="lft-box-bottom"></div>      
					             
			 <? 
		        }else
			    {
			 
			        $scalling = (float) (219/$lose)  ;
			        $diffWeight=abs($loseweight) * $scalling;
			        if($diffWeight < 219)
			        {
			            $dynWidth = $diffWeight;
			        }
			        else
			        {
			            $dynWidth = 219;
			        }
?>

		<div class="lft-box-top">
				<h2 class="meter-title">Ultimate Goal</h2>
				<div class="box-holder-title"><a id="return-uedit">edit</a></div>
		</div>
		<div class="lft-box-mid">
				<div class="lft-box-inner">
					<div class="weight-lose-box">
					    <div class="lose">Lose </div>
					       <div class="lose-amount"><?php echo $list['pounds'];?> lbs
                           </div>
				    </div>
					   
					  <div class="weight-lose-graph">
					      <div <? if($dynWidth >=219){ echo "class='comm-progress full'";} else {echo "class='comm-progress not-full'";}?> <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php echo abs($loseweight); ?> lbs<div class="left-volume"></div>
					      </div>
					 
					  <div class="lost-unit">
                            <span><? echo $startRange; ?> lbs</span>
                            <span class="middle"><? echo $midRange; ?> lbs</span>
                            <span class="right"><? echo $endRange; ?> lbs</span>
                       </div>
					  </div>
					  <div class="ticket">
					  <?php
					  if($list['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($list['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($list['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($list['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($list['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($list['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						   <? echo $list['ownRewardText']; ?>
						<?php } ?>
					  </div>
					
					 
				 </div>
		</div>
		<div class="lft-box-bottom"></div>
			
		<?php   }
		    }else
		    {  
		?>
	
		<div class="lft-box-top">
				<h2 class="meter-title">Ultimate Goal</h2>
				<div class="box-holder-title"><a id="return-uedit">edit</a></div>
		</div>
		<div class="lft-box-mid">
				<div class="lft-box-inner">
					<div class="weight-lose-box">
					    <div class="lose">Lose </div>
					       <div class="lose-amount"><?php echo $list['pounds'];?> lbs
                           </div>
				         </div>
					   
					  <div class="weight-lose-graph">
					      <div class="comm-progress not-full" <?php echo "style='width:8px;'"  ;?>>
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
					  if($list['daySpa']==1)
					  {
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-spa.png" />
						 Day at the Spy
					  <?php } 
					  elseif($list['weekendTrip']==1) { 
					  ?>
					     <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-weekend.png" />
						 Weekend trip
					   <?php }
					   elseif($list['concertTickets']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-concert.png" />
						  Concert Tickets
					  <?php }
					   elseif($list['nightOuts']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-nighout.png" />
						  Night Out
					   <?php }
					   elseif($list['newOutfit']==1) {
					   ?>
					       <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-outfit.png" />
						  New Outfit
					   <?php }
					   elseif($list['myOwnreward']==1) {
					   ?>
					      <img alt="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/reward-custom.png" />
						  <? echo $list['ownRewardText']; ?>
						<?php } ?>
					  </div>
					
					 
				 </div>
		</div>
			
		<div class="lft-box-bottom"></div>
		<?
	        }
		} 
	}else{
		?>
	
		<div class="lft-box-top">
				<h2 class="meter-title">Ultimate Goal</h2>
				<div class="box-holder-title"><a id="return-uedit">Add</a></div>
		</div>
		<div class="lft-box-mid">
				<div class="white-inner-box">
					                        <div class="white-top"></div>
					                        <div class="white-mid">
                                             <div class="body-text">
					                          <p>You will have made dramatic changes to your body and gained all the tools you need to live healthier for the rest of your life. Set your goal in whatever terms you like - pounds lost, clothing sizes, or a reduction in body fat.  And don't forget to add your Reward so you can celebrate your success! </p>
					                        <!--  <form action="#">-->
					                           
					                             <div id="return-to"><a class="sexybutton sexyorange"><span><span>+Set New Goal</span></span></a></div>
				                               
				                           <!--   </form>-->
                                              </div>
				                            </div>
					                        <div class="white-bottom"></div>
				</div>
		</div>
		<div class="lft-box-bottom"></div>		
<?php 
	}
?>

