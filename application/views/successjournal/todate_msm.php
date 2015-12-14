<?php

if($last_dayMsr)
{  //echo "hhh";
foreach($last_dayMsr as $toallum)
{
      $thigh = $toallum['um_thighs'];
	  $hip = $toallum['um_hips'];
	  $calf = $toallum['um_calves'];
	  $wrist = $toallum['um_wrist'];
	  $waist = $toallum['um_waist'];
	  $forearms = $toallum['um_forearms'];
	  $weight = $toallum['um_bweight'];
      $weight = $toallum['um_bweight'];
}

//echo "ST=" .$st_bodyfat;
if(($toallum['um_waist']!=0) && ($first_dayMsr->um_waist!=0))  {
$df_um_waist = $first_dayMsr->um_waist - $toallum['um_waist'];
}
if(($toallum['um_bweight']!=0) && ($first_dayMsr->um_bweight!=0))
{
$df_um_bweight = $first_dayMsr->um_bweight - $toallum['um_bweight'];
}
$df_bodyfat = $first_dayMsr->um_bodyfat - $toallum['um_bodyfat'];;
}
else{
$df_um_waist=0;
$df_um_bweight=0;
$df_bodyfat =0; 
}

///////////////////////////////////////////


?>


<div class="lost-box-rptr">
   <? if($df_um_bweight>0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
	<span><?php echo abs($df_um_bweight); ?> lbs.</span>
	<br />To Date</h3>
</div>

 <div class="lost-box-rptr length-bg">
    <? if($df_um_waist>0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
	 <span><?php echo abs($df_um_waist); ?> in.</span>
	 <br />To Date
	 </h3>
</div>
<div class="lost-box-rptr weight-in-percent-bg">
    <? if($df_bodyfat>0){?>
    <h3>You lost <br />
	<? } else {?>
	 <h3>You lost <br />
	 <? } ?>
   <span><?php echo abs($df_bodyfat); ?> %</span>
   <br />body fat<br />To Date
   </h3>
</div>

<div class="view-all-measure"><a href="#"></a></div>