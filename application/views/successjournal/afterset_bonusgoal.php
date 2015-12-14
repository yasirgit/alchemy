<?php
		
 if(count($bonusGoal)>0){
	foreach ($bonusGoal as  $bGlist)
    {
	               foreach ($fetureid as $fture){
		                  $options= $fture['options'];
					      $fid= $fture['id'];
						  $st_val_name= $fture['start_val_name'];
		                  $cur_val_name= $fture['cur_val_name'];
			              $goal_val_name= $fture['goal_val_name'];
					      $unit= $fture['ms_unit'];
				  }
	$dynWidth='';
	//$lose = $bGlist[$cur_val_name]-$bGlist[$st_val_name];
	$lose = $bGlist[$st_val_name] - $bGlist[$goal_val_name];
	$startRange = $bGlist[$st_val_name];
	$endRange = $bGlist[$goal_val_name];
	$midRange = (($startRange+$endRange)/2);
	$curlose = $bGlist[$cur_val_name]- $bGlist[$st_val_name];
			
	if($curlose < 0){
	 if(abs($curlose) >= $lose)
	 {
	   $dynWidth=315;
	   
	 }
	 else{
	     $scalling = (float) (315/$lose)  ;
			       $diffWeight = abs($curlose) * $scalling;
			        if($diffWeight < 315)
			        {
			            $dynWidth = $diffWeight;
			        }
			        else
			        {
			            $dynWidth = 315;
			        }
	 }
	}else{
	  $dynWidth=5;
	}
	
	}
	}
?>	

					                  <div class="bonus-box-top">
					                    <div class="meter-title">Bonus Goal</div>
					                    <div class="box-holder-title"><a id="return-bonus-edit">edit</a></div>
				                      </div>
					                  <div class="bonus-box-mid">
					                    <div class="bonus-left">
					                      <div class="lose">Lose</div>
					                      <div class="lose-amount">
										  <? if($fid==5) { echo $unit." ".$lose;
										     }else{ 
										      echo $lose." ".$unit ; 
										     } 
										  ?>  
										   
										  </div>
				                        </div>
					                    <div class="bonus-right">
                                          <h2><?php echo $options ?></h2>
                                          <div class="lose-graph">
										    <? if($fid==5) {
			                                ?>
			                                    <div class="comm-progress bobus-bar "  <?php echo "style='width:".$dynWidth."px;'";?>><?php  echo $unit." ".abs($curlose); ?> </div>
			                               <?
			                                   }
			                                   else{?>
			                                     <div class="comm-progress bobus-bar "  <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php  echo abs($curlose)." ".$unit;?> </div>
			                                   <? } ?>
		                                    
                                          </div>
										   <div class="bonus-lost-unit">
                                            <? if($fid==5) 
			                                  {
			                                ?>
			                                   <span><? echo $unit; ?> <? echo $startRange; ?> </span>
                                               <span class="middle"><? echo $unit; ?> <? echo $midRange; ?> </span>
                                               <span class="right"> <? echo $unit; ?> <? echo $endRange; ?></span>
			                                <?
			                                  }else{
			                                ?>
			   
                                               <span><? echo $startRange; ?> <? echo $unit; ?></span>
                                               <span class="middle"><? echo $midRange; ?> <? echo $unit; ?></span>
                                               <span class="right"><? echo $endRange; ?> <? echo $unit; ?></span>
				                            <? } ?>
                                           </div>
                                         <!-- <ul>
                                          		<li>-<? //echo $startRange." ".$unit; ?> </li>
                                                <li>-<? //echo $midRange." ".$unit; ?> </li>
                                                <li class="last">-<? //echo $endRange." ".$unit; ?> </li>
                                          </ul>-->
                                        </div>
				                      </div>
					                  <div class="bonus-box-bottom"></div>
