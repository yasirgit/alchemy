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
	   
	  //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 
	      $fatWeight =  $weight *  $bodyfat;   
	 //Lean Body Mass = (My Body Weight)  –  (My Fat Weight)
	      $leanBodyMass = $weight - $fatWeight;
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
	  $fatWeight =  $weight *  $bodyfat; 
	  $leanBodyMass = $weight - $fatWeight;
   }
}
}else
{
   $bodyfat = 0;
   $fatWeight = 0;
   $leanBodyMass = 0;
}
?>


<div class="lost-box-rptr">
    <h3>You lost <br />
	<span><?php echo $fatWeight; ?> lbs.</span>
	<br />To Date</h3>
</div>

 <div class="lost-box-rptr length-bg">
     <h3>You lost <br /><span><?php echo $leanBodyMass ?> in.</span>
	 <br />To Date
	 </h3>
</div>
<div class="lost-box-rptr weight-in-percent-bg">
   <h3>You lost <br /><span><?php echo $bodyfat; ?>%</span>
   <br />body fat<br />To Date
   </h3>
</div>

<div class="view-all-measure"><a href="#"></a></div>