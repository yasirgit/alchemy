<?php

//$bodyfat=0;
//$fatWeight=0;
//$leanBodyMass=0;

if($year_umval){
foreach($year_umval as $year_val)
{
      $thigh = $year_val['um_thighs'];
	  $hip = $year_val['um_hips'];
	  $calf = $year_val['um_calves'];
	  $wrist = $year_val['um_wrist'];
	  $waist = $year_val['um_waist'];
	  $forearms = $year_val['um_forearms'];
	  $weight = $year_val['um_bweight'];

      foreach($uacDate as $ures)
      {
   
               $birthDay=strtotime($ures['birthdate']);
               $toDate=date('y-m-d'); 
               $countAge = strtotime($toDate)-strtotime($birthDay);
               $age = floor(($countAge/(60*60*24))/365);
   
              if($ures['sex']=='Male')
              {
                   if($age <= 30)
	               {  
	                   // Male 30 years old or less= waist + (hips x 0.5) - (forearms x 3.0) - wrist = % body fat
	                     $bodyfat = $waist + ($hip * 0.5) - ($forearms * 3.0) - $wrist;  
		                  
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
	  
                }
         }//end inner foreach

   }// end outer foreach
}// end if
if($year_startVal){ 
foreach($year_startVal as $year_stval)
{
     
	 
	  $st_thigh = $year_stval['um_thighs'];
	  $st_hip = $year_stval['um_hips'];
	  $st_calf = $year_stval['um_calves'];
	  $st_wrist = $year_stval['um_wrist'];
	  $st_waist = $year_stval['um_waist'];
	  $st_forearms = $year_stval['um_forearms'];
	  $st_weight = $year_stval['um_bweight'];

      foreach($uacDate as $ures)
      {
   
               $birthDay=strtotime($ures['birthdate']);
               $toDate=date('y-m-d'); 
               $countAge = strtotime($toDate)-strtotime($birthDay);
               $age = floor(($countAge/(60*60*24))/365);
   
              if($ures['sex']=='Male')
              {
                   if($age <= 30)
	               {  
	                   // Male 30 years old or less= waist + (hips x 0.5) - (forearms x 3.0) - wrist = % body fat
	                     $bodyfat = $st_waist + ($st_hip * 0.5) - ($st_forearms * 3.0) - $st_wrist;  
		                  
	               }else{
	                   //Male 31 years old or more= waist + (hips x 0.5) - (forearms x 2.7) - wrist = % body fat
		                $bodyfat = $st_waist + ($st_hip * 0.5) - ($st_forearms * 2.7) - $st_wrist;   
	               }
	   

              }
              else if($ures['sex']=='Female')
              {
                  if($age <= 30)
	              {
	                 //Female 30 years old or less= hips + (thigh x 0.8) - (calf x 2.0) - wrist = % body fat
		               $st_bodyfat = $st_hip + ($st_thigh * 0.8) - ($st_calf * 2.0) - $st_wrist ; 
		   
	              }else{
	                  //Female 31 years old or more= hips + thigh - (calf x 2.0) - wrist = % body fat
		               $st_bodyfat = $st_hip + $st_thigh - ($st_calf * 2.0) - $st_wrist ; 
	              }
	  
                }
         }//end inner foreach
		 
}// end outer foreach

if($weight!=0 && $st_weight!=0){
$res_weight = $st_weight - $weight;
}
if($waist!=0 && $st_waist!=0){
$res_waist = $st_waist - $waist;
}
$res_bodyfat = $st_bodyfat - $bodyfat;

}else
{
$res_weight = 0;
$res_waist = 0;
$res_bodyfat=0;
}


?>



<div class="lost-box-rptr">
   <? if($res_weight>0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
    <span><?php echo abs($res_weight); ?> lbs.</span>
    <br />To Date</h3>
</div>
                                                
<div class="lost-box-rptr length-bg">
    <? if($res_waist>0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
		<span><?php echo abs($res_waist); ?> in.</span>
		<br />To Date</h3>
</div>

<div class="lost-box-rptr weight-in-percent-bg">
    <? if($res_bodyfat > 0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
		  <span><?php echo abs($res_bodyfat); ?> %</span>
		  <br />body fat<br />To Date</h3>
</div>
<div class="view-all-measure"><a href="#"></a></div>