<script>
$(document).ready(function(){

     $('.featureBtn').click(function(){
	     var id = $(this).attr("id");  valid = true;
		 if ( $("#ft").val()==null )
		 { 
		 $("#b"+id).hide('slow');
		 $('<input type="hidden" id="ft" name="fitem" value="'+id+'" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal'+id);
	     $('<span id="selectfb">Featured</span>').animate({ opacity: "show" }, "slow").appendTo('#featureVal'+id);
		 }
		 else{
		    alert("You have already selected one feature item!");
	         valid = false;
		 }
		 return valid;
	 });

});
	
</script>
<?php
if($to_umval)
{  //echo "hhh";
foreach($to_umval as $toallum)
{
      $thigh = $toallum['um_thighs'];
	  $hip = $toallum['um_hips'];
	  $calf = $toallum['um_calves'];
	  $wrist = $toallum['um_wrist'];
	  $waist = $toallum['um_waist'];
	  $forearms = $toallum['um_forearms'];
	  $weight = $toallum['um_bweight'];
}

foreach($uacDate as $ures)
{
   
   $birthDay=strtotime($ures['birthdate']);
   $toDate = date('y-m-d'); 
   $countAge = strtotime($toDate)-strtotime($birthDay);
   $age = floor(($countAge/(60*60*24))/365);
   

   
   if($ures['sex']=='Male')
   {
       if($age <= 30)
	   {  
	        // Male 30 years old or less= waist + (hips x 0.5) - (forearms x 3.0) - wrist = % body fat
	      $bodyfat = $waist + ($hip * 0.5) - ($forearms * 3.0) - $wrist ;  
		                  
	   }else{
	       //Male 31 years old or more= waist + (hips x 0.5) - (forearms x 2.7) - wrist = % body fat
		  $bodyfat = $waist + ($hip * 0.5) - ($forearms * 2.7) - $wrist;   
	   }

   }
   else if($ures['sex']=='Female')
   {
       if($age <= 30)
	   {
	      //Female 30 years old or less= hips + (thigh x 0.8) - (calf x 2.0) - wrist = % body fat
		  $bodyfat = $hip + ($thigh * 0.8) - ($calf * 2.0) - $wrist ; 
		   
	   }else{
	       //Female 31 years old or more= hips + thigh - (calf x 2.0) - wrist = % body fat
		  $bodyfat = $hip + $thigh - ($calf * 2.0) - $wrist ; 
	   }
	   //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 

   }
}
}else
{
   $bodyfat =0;

}
?>

<style>

.hide {visibility:hidden;}
 </style>
<?php 
		if($last_dayMsr){ 
		 foreach($last_dayMsr as $curerntres)
		 {
		    $uwaist = $curerntres['um_waist'];
			$uthighs = $curerntres['um_thighs'];
			$uweight = $curerntres['um_bweight'];
			$uhip = $curerntres['um_hips'];
			
		 }
	   }
	   else
	   { 
	      $uwaist=0;
		  $uthighs=0;
		  $uweight=0;
		  $uhip=0;
		  
	   }
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
			<form action="successjournal/bonus_entry" class="feature" method="post" name="bonus_entry">
			
            <p class="graph-calc"><input type="hidden" name="cur_waist" value="<?php echo $uwaist ;?>" />
			   <label>Current = -<?php echo $uwaist ;?>  in</label>
			   <span><label>Goal =</label><input type="text" name="gl_waist" value="" /></span>
		
			</p>
             <p class="heading">Other Options</p>

               <fieldset>
			      <input type="hidden" name="cur_hips" value="<?php echo $uhip ;?>" />
                  <label class="current">Inches Lost - My Hips</label><p>Current = <?php echo $uhip ;?> in<br /><label class="bgoal">Goal</label><input type="text" name="gl_hips" class="goal" /></p>
				<div id="b1">  <img id="1" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
							 
				  <span id="featureVal1"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_thighs" value="<?php echo $uthighs ;?>" /></p>
                  <label class="current">Inches Lost - My Thighs</label><p>Current = <?php echo $uthighs ;?>  in<br /><label class="bgoal">Goal</label><input type="text" name="gl_thighs" class="goal" /></p>
				  <div id="b2"><img id="2" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
				
				  <span id="featureVal2"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_bodyfat" value="<?php echo $bodyfat; ?>" /></p>
                  <label class="current">Reduce My Body Fat</label><p>Current = <?php echo $bodyfat; ?>%<br /><label class="bgoal">Goal</label><input type="text" name="gl_bodyfat" class="goal" /></p>
				  <div id="b3"><img id="3" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" onclick="return check_feature()" ></div>
				  <span id="featureVal3"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_weight" value="<?php echo $uweight ;?>" /></p>
                  <label class="current">Lose Weight</label><p>Current = <?php echo $uweight ;?> lbs<br /><label class="bgoal">Goal</label><input type="text" name="gl_weight" class="goal" /></p>
				  <div id="b4"><img id="4" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
				  <span id="featureVal4"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Clothing Size</label><p>Current  <input type="text" name="cur_size" class="goal" value="" />in<br /><label class="bgoal">Goal</label><input type="text" name="gl_size" class="goal" value="" /></p>
				  <div id="b5"><img id="5" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" ></div>
				  <span id="featureVal5"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Blood Pressure</label><p>Current  <input type="text" name="cur_blood" class="goal" /><br /><label class="bgoal">Goal</label><input type="text" name="gl_blood" class="goal" /></p>
				  <div id="b6"><img id="6" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" onclick="return check_feature()" ></div>
				  <span id="featureVal6"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Cholesterol</label><p>Current  <input type="text" name="cur_cholest" class="goal" /><br /><label class="bgoal">Goal</label><input type="text" name="gl_cholest" class="goal" /></p>
				 <div id="b7" <img id="7" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
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