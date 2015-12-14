<?php
		foreach ($fetureid as $fture){
		      $options= $fture['options'];
			  $fid= $fture['id'];
		      $cur_val= $fture['cur_val'];
			  $goal_val= $fture['goal_val'];
		 }
		       
		?>
<?php
foreach ($last_dayMsr as $lday){
 $lwaist=$lday['um_waist'];
}
$lossWaist=''; $dynWidth=212;
 if($fid==8)
 {  //$first_dayMsr->um_waist;
   $lossWaist = ($first_dayMsr->um_waist)-$lwaist;
   $scalling = (float) (316/4)  ;
			 $diffWeight=$lossWaist * $scalling;
			 if($diffWeight < 316)
			 {
			   $dynWidth = $diffWeight;
			 }
			 else
			 {
			    $dynWidth = 316;
			 }
 }
	
?>	
<div class="bonus-box">
					                  <div class="bonus-box-top">
					                    <div class="meter-title">Bonus Goal</div>
					                    <div class="box-holder-title"><a id="return-bonus-edit">edit</a></div>
				                      </div>
					                  <div class="bonus-box-mid">
					                    <div class="bonus-left">
					                      <div class="lose">Lose</div>
					                      <div class="lose-amount"><?php echo $goal_val; ?> in</div>
				                        </div>
					                    <div class="bonus-right">
                                          <h2><?php echo $options ?></h2>
                                          <div class="lose-graph">
										      <div class="comm-progress"  <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php //echo $lossWaist ;?></div>
		                                    
                                          </div>
                                          <ul>
                                          		<li>0</li>
                                                <li>-2 in</li>
                                                <li class="last">-4 in</li>
                                          </ul>
                                        </div>
				                      </div>
					                  <div class="bonus-box-bottom"></div>
</div>