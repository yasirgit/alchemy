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
<div class="popup-bonus-goal" id="popup-bonus-goal">
<?php 
  if(count($bonusGoal)>0){
	foreach ($bonusGoal as  $bGlist)
	{
	    $fid = $bGlist['fid'];
		$fcur= $bGlist['cur_val'];
		$fgoal = $bGlist['goal_val'];

		
	}
	
?>      

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
<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
 </div>
        <div class="popup-middle">
		<?php
			   foreach ($fetureid as $fture){
		                  $options= $fture['options'];
					      $fid= $fture['id'];
		                  $cur_val_name= $fture['cur_val_name'];
			              $goal_val_name= $fture['goal_val_name'];
					      $unit= $fture['ms_unit'];
		       
			?>
            <p class="heading"><?php echo $options ?></p>
        	<div class="bonus-goal-graph">
			    <div class="comm-progress bobus-bar not-full"  <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php //echo $lossWaist ;?></div>
            </div>
			<form action="successjournal/bonus_update" class="feature" method="post" name="bonus_entry">
          <p class="graph-calc"> <input type="hidden" name="feature" value="<?php echo $fture['id']; ?>" />
			   <label>Current = -
			   <?php 
			      if($fture['id']==1)
					 {echo $uhip;
					  echo "<input type='hidden' value='".$uhip."' name=".$fture['cur_val_name']." />";
					 }
					 elseif($fture['id']==2)
					 {
					  echo $uthighs;
					   echo "<input type='hidden' value='".$uthighs."' name=".$fture['cur_val_name']." />";
					 }
					 elseif($fture['id']==3)
					 {
					   echo $bodyfat;
					    echo "<input type='hidden' value='".$bodyfat."' name=".$fture['cur_val_name']." />";
					 }
					 elseif($fture['id']==4)
					 {
					   echo $uweight;
					    echo "<input type='hidden' value='".$uweight."' name=".$fture['cur_val_name']." />";
					 }
					 elseif($fture['id']==8)
					 {
					   echo $uwaist;
					    echo "<input type='hidden' value='".$uwaist."' name=".$fture['cur_val_name']." />";
					 }
					 else {
				   ?>
				  <input type="text" class="goal" name="<?php echo $fture['cur_val_name']; ?>" value="<?php echo $fture['cur_val']; ?>" />
				  <?php
				  }
				  }
				echo $unit;
			   ?>
			     </label>
			   <span><label>Goal =</label><input type="text" name="<?php echo $fture['goal_val_name']; ?>" value="<?php echo $fture['goal_val'];?>" /></span>
		
			</p>
             <p class="heading">Other Options</p>
  <?php 
              
			   foreach ($nonfetured as $key => $nonfture){
			     
			?>   
             
           
               <fieldset>
			     
                  <label class="current"><?php echo $nonfture['options']; ?></label>
				  
				  <p>Current = -
				  <?php
				     if($nonfture['id']==1)
					 {echo $uhip;
					  
					 }
					 elseif($nonfture['id']==2)
					 {
					  echo $uthighs;
					   echo "<input type='hidden' value='".$uthighs."' name=".$nonfture['cur_val_name']." />";
					 }
					 elseif($nonfture['id']==3)
					 {
					   echo $bodyfat;
					    echo "<input type='hidden' value='".$bodyfat."' name=".$nonfture['cur_val_name']." />";
					 }
					 elseif($nonfture['id']==4)
					 {
					   echo $uweight;
					    echo "<input type='hidden' value='".$uweight."' name=".$nonfture['cur_val_name']." />";
					 }
					 elseif($nonfture['id']==8)
					 {
					   echo $uwaist;
					    echo "<input type='hidden' value='".$uwaist."' name=".$nonfture['cur_val_name']." />";
					 }
					 else {
				   ?>
				  <input type="text" class="goal" name="<?php echo $nonfture['cur_val_name']; ?>" value="" />
				  <?php
				  }
				 echo $nonfture['ms_unit'];
				  ?>
				 <br />
				  <label class="bgoal">Goal</label><input type="text" name="<?php echo $nonfture['goal_val_name']; ?>" class="goal" value=""  /><?php echo $nonfture['ms_unit']; ?>
				  </p>
				  <div id="b<?php echo $nonfture['id']; ?>"> <img id="<?php echo $nonfture['id']; ?>" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
				 
				  <span id="featureVal<?php echo $nonfture['id']; ?>"></span>
               </fieldset>
             <?php } ?>
		
             <fieldset class="btn saveBtn">
                <input id="waistadd" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<input type="image" name="upbonus" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="submit"/>           <!--   <input type="submit" name="upbonus" id="" value="" /> -->
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
  
 <?php //}
 }else{
 
    $this->load->view("successjournal/entry_bonus");

}
?>
   <div id="bgBonusPopup"></div>