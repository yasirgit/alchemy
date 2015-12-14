<?php
$result='';
$fatlossplate=array();
foreach($data->plate as $key=>$value)
{
	if(in_array($value->value, array(5,6,7)))
	$result.='<div class="big-fat-units big-fat-unit-'.$value->value.'">&nbsp;</div>';
	else
	$result.='<div class="big-fat-units big-fat-units-storing big-fat-unit-'.$value->value.'">&nbsp;</div>';
	
	if(isset($value->isfatlossplate))
	$fatlossplate[$key]=$value->isfatlossplate;
}

/*echo "<pre>";
	print_r($fatlossplate);
echo "</pre>";
exit();
*/
?>
<div id="big-fat-unit-holder1" class="big-fat-unit-holder">
	<?php echo $result;?>
</div>
<div class="big-fat-scale">
	<ul class="big-chart-unit">
	<?php
	$dc_count=0;
	$hours1="";
	
	$isfatlossplate1="";
	$isfatlossplate2="";
	$isfatlossplate3="";
	
	$hours2="";
	$hours3="";
	
	foreach($data->plate as $key=>$value)
	{
		if($dc_count%3==0)
		{		 
			$hours1=$key;		 
			if(isset($value->isfatlossplate))
			$isfatlossplate1=$value->isfatlossplate;
			
			
			$currentTime = date("Y-m-d")." ".$key.":00:00"; //Change date into time
			
			
			$timeAfterOneHour = strtotime($currentTime)+(60*60);									
			$hours2=date("H",$timeAfterOneHour);//next hour 
						
			if(isset($fatlossplate[$hours2]))
			$isfatlossplate2=$fatlossplate[$hours2];
			
			
			$timeAfterTwoHour = $timeAfterOneHour+60*60;			
			$hours3=date("H",$timeAfterTwoHour);//next next hour			
			
			if(isset($fatlossplate[$hours3]))
			$isfatlossplate3=$fatlossplate[$hours3];
		}		
		
		if($dc_count%3==0)
		{
	?>
		<li>
		<div>
			<?php			 
			 if(strlen($isfatlossplate1)>0&&$isfatlossplate1==0)
			 {			 
			?>
			  <img src="htdocs/images/coach/big-fat-red-circle.png" class="hurs1" alt="" />
			<?php
			 $isfatlossplate1="";
			 }
			 else if(strlen($isfatlossplate1)>0&&$isfatlossplate1==1)
			 {
			?>
			 <img src="htdocs/images/coach/big-fat-effect-circle.png" class="hurs1" alt="" />	
			<?php
			$isfatlossplate1="";
			 }			 
			?>
			
			<?php
			 if(strlen($isfatlossplate2)>0&&$isfatlossplate2==0)
			 {			 
			?>
			  <img src="htdocs/images/coach/big-fat-red-circle.png" class="hurs2" alt="" />
			<?php
			$isfatlossplate2="";
			 }
			 else if(strlen($isfatlossplate2)>0&&$isfatlossplate2==1)
			 {
			?>
			 <img src="htdocs/images/coach/big-fat-effect-circle.png" class="hurs2" alt="" />	
			<?php
			$isfatlossplate2="";
			 }
			?>
			<?php
			 if(strlen($isfatlossplate3)>0&&$isfatlossplate3==0)
			 {			 
			?>
			  <img src="htdocs/images/coach/big-fat-red-circle.png" class="hurs3" alt="" />
			<?php
				$isfatlossplate3="";
			 }
			 else if(strlen($isfatlossplate3)>0&&$isfatlossplate3==1)
			 {
			?>
			 <img src="htdocs/images/coach/big-fat-effect-circle.png" class="hurs3" alt="" />	
			<?php
				$isfatlossplate3="";
			 }
			?>
		</div>
		<span><?php echo date("ga",strtotime(date("Y-m-d")." ".$key.":00:00"));?></span>
		</li>
	<?php
		}
		$dc_count++;
	}
	?>		
	</ul>
</div>
<?php
if($dc_count<=16)  //scrol hide before or equal 16 hour//
{
?>
<script type="text/javascript">
$(function() 
{
	$('.jScrollPaneTrack').css("display","none");
	$('.jScrollArrowLeft').css("display","none");
	$('.jScrollArrowRight').css("display","none");
	$('.jScrollPaneContainer').css("height","216px");
	
});
</script>
<?php
}
else
{                                                          
?>
<script type="text/javascript">
$(function() 
{
	$('.jScrollPaneTrack').css("display","block");
	$('.jScrollArrowLeft').css("display","block");
	$('.jScrollArrowRight').css("display","block");
	$('.jScrollPaneContainer').css("height","240px");	
});
</script>
<?php
}
?>