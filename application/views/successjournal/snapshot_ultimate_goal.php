
<script>
	
/*	$(function() {
		$( "#progressbar" ).progressbar({
			value: <?php //echo $loseweight; ?>
		});
	});*/
</script>

<?php
    if(count($ugoalset)>0)
    {
        foreach ($ugoalset as $key => $list)
        { 
            $lose= $list['pounds'];
		    $startRange=$row['weight'];
            $endRange=$row['weight']- $lose;
            $midRange=(($lose/2)+$endRange);
   
		 foreach($last_dayMsr as $ulist){ $curWeight = $ulist['um_bweight']; }
		 
		    if($curWeight=='' || $curWeight==0){ $curWeight=$row['weight'];}

			 $loseweight = $curWeight - $row['weight']; 
			 if($loseweight < 0)
			 {    
			    if(abs($loseweight) >= $lose)
			    {
			 ?>
                  
                        <div class="ultimate-bottom-round congrats-round">
                            <div class="ultimate-title congrats-title">
                                <h2 class="meter-title">Ultimate Goal</h2>
                                <div class="loser-quantity"><span>Lose <? echo $lose ?> lbs</span></div>
                                <div class="clear">&nbsp;</div>
                            </div>
                            <div class="congrats-module">
                                <h2 class="bold-01">
                                  Congratulations!
                                </h2>
                                <h3 class="bold-02">You&#39;ve hit your goal!</h3>                                                                       
                                <em>Don&#39;t forget to claim your reward,</em>
                            </div>
                        </div>
                    
			<?php
			    }
				else
				{
			 
                    $scalling = (float) (219/$lose)  ;
			        $diffWeight= abs($loseweight) * $scalling;
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
                            <div class="ultimate-title" style="width:">
                                <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
                                <div class="loser-quantity"><span>Lose <?php echo $lose ;?> lbs</span></div>
                                <div class="clear">&nbsp;</div>
                            </div>
                            <div class="ultimate-miter">
			                     <div <? if($dynWidth >=219){ echo "class='comm-progress full'";} else {echo "class='comm-progress not-full'";}?> <? echo "style='width:".$dynWidth."px;'"  ;?> > 
			                         <?php echo abs($loseweight); ?> lbs
			                         <div class="left-volume"></div>
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
			else{  
?> 

                   
                        <div class="ultimate-bottom-round">
                            <div class="ultimate-title" style="width:">
                                <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
                                <div class="loser-quantity"><span>Lose <?php echo $lose ;?> lbs</span></div>
                                <div class="clear">&nbsp;</div>
                            </div>
                            <div class="ultimate-miter">
			                    <div class="comm-progress not-full" <?php echo "style='width:8px;'"  ;?> > 
			    
			                        <div class="left-volume"></div>
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
			
?>

<?
        }   
	}else
    {
?>

    <div class="ultimate-bottom-round congrats-round">
            <div class="ultimate-title congrats-title">
                <h2 class="meter-title">Ultimate Goal</h2>
                <div class="loser-quantity"><span>Lose 0 lbs</span></div>
                <div class="clear">&nbsp;</div>
            </div>
                                                                 
            <div class="congrats-module-text">                                                                      
               <p>You will have made dramatic changes to your body and gained all the tools you need to live healthier for the rest of your life. Set your goal in whatever terms you like - pounds lost, clothing sizes, or a reduction in body fat.  And don't forget to add your Reward so you can celebrate your success!</p>
               <p class="btn-center" ><a id="return-uedit" class="sexybutton sexyorange"><span><span>+Set New Goal</span></span></a></p>
            </div>
    </div>

<?php
    } 
?>
