 
<script>
$(document).ready(function(){
    $('#fb1').click(function(){ 
	  // alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="1" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal1');
	  $("#fb1").hide("slow");
	  $('<span id="selectfb">Featured</span>').animate({ opacity: "show" }, "slow").appendTo('#featureVal1');;
	});
	
	$('#fb2').click(function(){ 
	  // alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="2" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal2');
	});
	
	$('#fb3').click(function(){ 
	   //alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="3" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal3');
	});
	
	$('#fb4').click(function(){ 
	  // alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="4" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal4');
	});
	
	$('#fb5').click(function(){ 
	  // alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="5" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal5');
	});
	
	$('#fb6').click(function(){ 
	   //alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="6" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal6');
	});
	
	$('#fb7').click(function(){ 
	  // alert("rima");
	  $('<input type="hidden" id="ft" name="fitem" value="7" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal7');
	});



});
	
</script>


<style>


.hide {visibility:hidden;}

  </style>

<div class="popup-bonus-goal" id="popup-bonus-goal">
<?php 
  if(count($bonusGoal)>0){
	foreach ($bonusGoal as $key => $bGlist)
	{   echo $bGlist['featured_id'];
	    foreach ($fetureid as $key => $fture){echo "fid=".$fture['id']; echo "--OPt".$fture['options']; }
?>      
<script>
	$(function() {
		$( "#popupBgoalbar" ).progressbar({
			value:20 
		});
	});
</script>
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <p class="heading"><?php echo $fture['options']; ?></p>
        	<div class="bonus-goal-graph">
			     <div id="popupBgoalbar"></div>
            </div>
			<form action="successjournal/bonus_entry" class="feature" method="post">
            <p class="graph-calc"><input type="hidden" name="cur_waist" value="<?php echo $bGlist['cur_val']; ?>" />
			<label>Current = <?php echo $bGlist['cur_val']; ?> in</label><span><label>Goal =</label><input type="text" name="gl_waist" value="<?php echo $bGlist['goal_val']; ?>" /></span>
		<!--	<input type="hidden" id="ft" name="fitem" value="8" />-->
			</p>
             <p class="heading">Other Options</p>
           
               <fieldset>
			      <input type="hidden" name="cur_hips" value="<?php echo $bGlist['cur_hips']; ?>" /></p>
                  <label class="current">Inches Lost - My Hips</label><p>Current = <?php echo $bGlist['cur_hips']; ?> in<br /><label class="bgoal">Goal</label><input type="text" name="gl_hips" class="goal" value="<?php echo $bGlist['goal_hips']; ?>"  /></p>
				  <img id="fb1" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />-->
				  <span id="featureVal1"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_thighs" value="<?php echo $bGlist['cur_thighs']; ?>" /></p>
                  <label class="current">Inches Lost - My Thighs</label><p>Current = <?php echo $bGlist['cur_thighs']; ?> in<br /><label class="bgoal">Goal</label><input type="text" name="gl_thighs" class="goal" value="<?php echo $bGlist['goal_thighs']; ?>"  /></p>
				  <img id="fb2" class="featureBtn" src="<?=$this->config->item('base_url')?> /htdocs/images/successjournal/btn-makeFeature.gif" />
				<!--  <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />-->
				  <span id="featureVal2"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_bodyfat" value="<?php echo $bGlist['cur_bodyfat']; ?>" /></p>
                  <label class="current">Reduce My Body Fat</label><p>Current = <?php echo $bGlist['cur_bodyfat']; ?> in<br /><label class="bgoal">Goal</label><input type="text" name="gl_bodyfat" class="goal" value="<?php echo $bGlist['goal_bodyfat']; ?>"  /></p><img id="fb3" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal3"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_weight" value="<?php echo $bGlist['cur_weight']; ?>" /></p>
                  <label class="current">Lose Weight</label><p>Current = <?php echo $bGlist['cur_weight']; ?> in<br /><label class="bgoal">Goal</label><input type="text" name="gl_weight" class="goal" value="<?php echo $bGlist['goal_weight']; ?>"  /></p><img id="fb4" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal4"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Clothing Size</label><p>Current  <input type="text" name="cur_size" class="goal" value="<?php echo $bGlist['cur_size']; ?>"  /><br /><label class="bgoal">Goal</label><input type="text" name="gl_size" class="goal" value="<?php echo $bGlist['goal_size']; ?>"  /></p><img id="fb5" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal5"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Blood Pressure</label><p>Current  <input type="text" name="cur_blood" class="goal" value="<?php echo $bGlist['cur_blood']; ?>"  /><br /><label class="bgoal">Goal</label><input type="text" name="gl_blood" class="goal" value="<?php echo $bGlist['goal_blood']; ?>"  /></p><img id="fb6" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal6"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Cholesterol</label><p>Current  <input type="text" name="cur_cholest" class="goal" value="<?php echo $bGlist['cur_cholest']; ?>"  /><br /><label class="bgoal">Goal</label><input type="text" name="gl_cholest" class="goal" value="<?php echo $bGlist['goal_cholest']; ?>"  /></p><img id="fb7" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal7"></span>
               </fieldset>
             <fieldset class="btn saveBtn">
                <input id="waistadd" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />         -->     <input type="submit" name="mm" id="featuresave" value="" /> 
           </fieldset>
             </form>
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
  
 <?php }
 } else{
 ?>
   		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <p class="heading">Inches Lost - My Waist</p>
        	<div class="bonus-goal-graph">
            </div>
			<form action="successjournal/bonus_entry" class="feature" method="post">
            <p class="graph-calc"><input type="hidden" name="cur_waist" value="1.2" />
			<label>Current = -1.8 in</label><span><label>Goal =</label><input type="text" name="gl_waist" /></span>
		<!--	<input type="hidden" id="ft" name="fitem" value="8" />-->
			</p>
             <p class="heading">Other Options</p>
           
               <fieldset>
			      <input type="hidden" name="cur_hips" value="1.2" /></p>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label class="bgoal">Goal</label><input type="text" name="gl_hips" class="goal" /></p>
				  <img id="fb1" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />-->
				  <span id="featureVal1"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_thighs" value="1.2" /></p>
                  <label class="current">Inches Lost - My Thighs</label><p>Current = 1.2 in<br /><label class="bgoal">Goal</label><input type="text" name="gl_thighs" class="goal" /></p>
				  <img id="fb2" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				<!--  <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />-->
				  <span id="featureVal2"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_bodyfat" value="1.2" /></p>
                  <label class="current">Reduce My Body Fat</label><p>Current = 1.2 in<br /><label class="bgoal">Goal</label><input type="text" name="gl_bodyfat" class="goal" /></p><img id="fb3" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal3"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_weight" value="1.2" /></p>
                  <label class="current">Lose Weight</label><p>Current = 1.2 in<br /><label class="bgoal">Goal</label><input type="text" name="gl_weight" class="goal" /></p><img id="fb4" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal4"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Clothing Size</label><p>Current  <input type="text" name="cur_size" class="goal" /><br /><label class="bgoal">Goal</label><input type="text" name="gl_size" class="goal" /></p><img id="fb5" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal5"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Blood Pressure</label><p>Current  <input type="text" name="cur_blood" class="goal" /><br /><label class="bgoal">Goal</label><input type="text" name="gl_blood" class="goal" /></p><img id="fb6" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal6"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Cholesterol</label><p>Current  <input type="text" name="cur_cholest" class="goal" /><br /><label class="bgoal">Goal</label><input type="text" name="gl_cholest" class="goal" /></p><img id="fb7" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif">
				  <span id="featureVal7"></span>
               </fieldset>
		
             <fieldset class="btn saveBtn">
                <input id="waistadd" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />         -->     <input type="submit" name="mm" id="featuresave" value="" /> 
           </fieldset>
             </form>
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
<?php
}
?>
   <div id="bgBonusPopup"></div>