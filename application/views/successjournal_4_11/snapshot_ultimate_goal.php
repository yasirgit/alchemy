
<script>
	
/*	$(function() {
		$( "#progressbar" ).progressbar({
			value: <?php //echo $loseweight; ?>
		});
	});*/
</script>


<?php if(count($ugoalset)>0){foreach ($ugoalset as $key => $list){  $lose= $list['pounds'];
		 foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
		 //Pounds lost comes from the user’s current measurements minus their original measurements
		     //echo $row['weight'];
		     $loseweight = $row['weight']-$curWeight;  
		   
			 $scalling = (float) (219/50)  ;
			 $diffWeight=$loseweight * $scalling;
			 if($diffWeight < 219)
			 {
			   $dynWidth = $diffWeight;
			 }
			 else
			 {
			    $dynWidth = 219;
			 }
?>

<div class="ultimate-goal"  >
    <div class="ultimate-bottom-round">
        <div class="ultimate-title" style="width:">
            <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
            <div class="loser-quantity"><span>Lose <?php echo $lose ;?> lbs</span></div>
            <div class="clear">&nbsp;</div>
        </div>
        <div class="ultimate-miter">
	<!--	    <div class="ppbar_set">
			    <div id="progressbar"></div>
		    </div>-->
			<div class="comm-progress not-full"  <?php echo "style='width:".$dynWidth."px;'"  ;?>>-<?php echo $loseweight; ?> lbs<div class="left-volume"></div></div>
		</div>
     </div>
</div>
<?php
}}else
{
?>
<div class="ultimate-goal">
    <div class="ultimate-bottom-round">
        <div class="ultimate-title">
            <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
            <div class="loser-quantity"><span>Lose 0 lbs</span></div>
            <div class="clear">&nbsp;</div>
        </div>
        <div class="ultimate-miter">
		
		</div>
     </div>
</div>
<?php
} 
?>
