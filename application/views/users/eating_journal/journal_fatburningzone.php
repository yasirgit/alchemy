<?php
$this->load->model('fatloss_model');
error_reporting(0);
$optimizer=array();
$fatlossplate=array();

$jDate=date("Y-m-d");
//////////////////////////////////////////////
if(isset($advice[count($advice)-1]['type'])&&$advice[count($advice)-1]['type']=="Bed")
$bedtime=$advice[count($advice)-1]['time'];
if(isset($advice[0]['type'])&&$advice[0]['type']=="Wakeup")
{
	$waketime=$advice[0]['time'];
	$jDate=$advice[0]['jDate'];
}
$tsleep=$advice[0]['total_sleep'];
//////////////////////////////////////////////////////

$final_array[0]['time']=$advice[0]['time'];
$final_array[0]['type']="Wakeup";

for($i=0;$i<count($advice);$i++)
{
	if($advice[$i]['type']!="Exercise"&&(isset($advice[$i]['food_description']['isSkip'])&&$advice[$i]['food_description']['isSkip']==0))	
	{
		if(empty($optimizer[date('H',strtotime($advice[$i]['time']))])&&!empty($advice[$i]['food_description']))
		{
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_calories']=$advice[$i]['food_description']['total_calories'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_fat']=$advice[$i]['food_description']['total_fat'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_carb']=$advice[$i]['food_description']['total_carb'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['dietary_fiber']=$advice[$i]['food_description']['dietary_fiber'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['sugar']=$advice[$i]['food_description']['sugar'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_protein']=$advice[$i]['food_description']['total_protein'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_sodium']=$advice[$i]['food_description']['total_sodium'];
			
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_saturated_fat']=$advice[$i]['food_description']['total_saturated_fat'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_cholesterol']=$advice[$i]['food_description']['total_cholesterol'];

			$optimizer[date('H',strtotime($advice[$i]['time']))]['ismeal']=1;
			$optimizer[date('H',strtotime($advice[$i]['time']))]['type']=$advice[$i]['type'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['sex']=$advice[$i]['sex'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['time']=$advice[$i]['time'];
			
			$fatlossplate[date('H',strtotime($advice[$i]['time']))]['isfatlosplate']=$advice[$i]['food_description']['isfatlosplate'];
		}
		else if(!empty($advice[$i]['food_description']))
		{
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_calories']+=$advice[$i]['food_description']['total_calories'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_fat']+=$advice[$i]['food_description']['total_fat'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_carb']+=$advice[$i]['food_description']['total_carb'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['dietary_fiber']+=$advice[$i]['food_description']['dietary_fiber'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['sugar']+=$advice[$i]['food_description']['sugar'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_protein']+=$advice[$i]['food_description']['total_protein'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_sodium']+=$advice[$i]['food_description']['total_sodium'];
			
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_saturated_fat']+=$advice[$i]['food_description']['total_saturated_fat'];
			$optimizer[date('H',strtotime($advice[$i]['time']))]['total_cholesterol']+=$advice[$i]['food_description']['total_cholesterol'];
			
			$optimizer[date('H',strtotime($advice[$i]['time']))]['time']=$advice[$i]['time'];
			$fatlossplate[date('H',strtotime($advice[$i]['time']))]['isfatlosplate']=$advice[$i]['food_description']['isfatlosplate'];
		}
	}	
}
if(!empty($optimizer[date("H",strtotime($advice[0]['time']))]))
{
  $optimizer[date("H",strtotime($advice[0]['time']))]['total_sleep']=$advice[0]['total_sleep'];
  $optimizer[date("H",strtotime($advice[0]['time']))]['waketime']=$advice[0]['time'];
}
else
{
 $optimizer[date("H",strtotime($advice[0]['time']))]['total_sleep']=$advice[0]['total_sleep'];
 $optimizer[date("H",strtotime($advice[0]['time']))]['waketime']=$advice[0]['time'];
}

ksort($optimizer);

$finalArray=array();
$mid=0;
$vid=0;

$burning_total=array();
$burning_total['all_calories']=0;
$burning_total['all_fiber']=0;
$burning_total['all_sodium']=0;
$burning_total['all_fat']=0;
$burning_total['all_cholesterol']=0;
$burning_total['all_saturatedfat']=0;
$optimizer_flag="";
$end="";
$beforeflag=0;

foreach($optimizer as $key=>$value)
{		
	
	$burning_total['all_calories']+=$value['total_calories'];
	$burning_total['all_fiber']+=$value['dietary_fiber'];
	$burning_total['all_sodium']+=$value['total_sodium'];
	$burning_total['all_fat']+=$value['total_fat'];
	$burning_total['all_cholesterol']+=$value['total_cholesterol'];
	$burning_total['all_saturatedfat']+=$value['total_saturated_fat'];	
	
	if(isset($value['total_sleep'])&&strlen($optimizer_flag)>0)
	{
		$beforeflag=1;
		$end=$optimizer_flag;
				
	}
	
	if($beforeflag==0)
	$end=$key;
	
	$optimizer_flag=$key;
}
//-----------------------get end time--
$time_dif_with_end=fatloss_model::getHourDiff($end.":00",$bedtime);
$currenttime=date("H:i");
$time_dif_with_cur=fatloss_model::getHourDiff($currenttime,$bedtime);

if($time_dif_with_end>$time_dif_with_cur)
$end=date("H");

$currenttimed=fatloss_model::getHourDiff($waketime,$end.":00");

if($currenttimed>=(24-$tsleep))
$end=date("H",strtotime($bedtime));
///-----------------------

$start=date("H",strtotime($advice[0]['time']));
$temp=$start;
$flag=0;
$burningvalue=0;
$lastmealeaten="";
$lastmealtime="";

$firstmealeaten="";
$firstmealtime="";

$sleepvalue=0;
$sleep_message=array();
$isFirst=0;
$isHourOne=0;

$feedbackscore=array();
$feedbackmealtime="";

while(1)
{		
	
	if($temp==$end)
	$flag=1;
	///////////////////////////////rest calculate after first hour////
	if(strlen($firstmealeaten)>0&&strlen($firstmealtime)>0)
	{		
		
		$hourdiff=fatloss_model::getHourDiff($firstmealtime,$temp.":00");
		$feedbackmealtime=$lastmealtime;
		
		$hourdiff+=$isHourOne;				
		if($hourdiff>=0&&$hourdiff<1)//hour 1 condition
		{
			if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1&&$isHourOne==0)
			{			
			//////////////////////////////////////
				$mealburningvalue=6;
				if($optimizer[$temp]['type']=='Snack')
				$gettempvalue=fatloss_model::snack_criteria($optimizer[$temp]);
				else
				$gettempvalue=fatloss_model::meal_criteria($optimizer[$temp]);
				
				$mealburningvalue+=$gettempvalue['fatburning'];
				///////////////////////
				$finalArray[$temp]['message']=$gettempvalue['message'];
				////////////////////////////////////////
				if($mealburningvalue>6)
				$mealburningvalue+=$sleepvalue;
				else
				$mealburningvalue-=$sleepvalue;			
				
				$finalArray[$temp]['value']=$mealburningvalue;	
				$lastmealeaten=$temp;
				$lastmealtime=$optimizer[$temp]['time'];
				$isHourOne=1;	
			//////////////////
			}
			else
			{
				$finalArray[$temp]['message']=array();
				$finalArray[$temp]['value']=1;				
			}			
		}
		else if($hourdiff>=1&&$hourdiff<2)//hour 2 condition
		{
			if(empty($optimizer[$temp])&&$isHourOne==0)
			{
			 $finalArray[$temp]['message']=array();
			 $finalArray[$temp]['value']=1;
			}
			else if(empty($optimizer[$temp])&&$isHourOne==1)
			{
			  $finalArray[$temp]['message']=array();
			  $finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value'];
			}
			else if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1)
			{								
				if($isHourOne==0)
				{
					//////////////////////////////////////
						$mealburningvalue=6;
						if($optimizer[$temp]['type']=='Snack')
						$gettempvalue=fatloss_model::snack_criteria($optimizer[$temp]);
						else
						$gettempvalue=fatloss_model::meal_criteria($optimizer[$temp]);

						$mealburningvalue+=$gettempvalue['fatburning'];
						///////////////////////
						$finalArray[$temp]['message']=$gettempvalue['message'];
						////////////////////////////////////////
						if($mealburningvalue>6)
						$mealburningvalue+=$sleepvalue;
						else
						$mealburningvalue-=$sleepvalue;			
						$finalArray[$temp]['value']=$mealburningvalue;	
						$lastmealeaten=$temp;	
						$isHourOne=1;
						$lastmealtime=$optimizer[$temp]['time'];
					//////////////////				
				}
				else
				{
					$tempeaten=fatloss_model::getSomethingOrLot($optimizer[$temp]);					
					$finalArray[$temp]['message']=$tempeaten['message'];
					$finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value']+$tempeaten['value'];
					$lastmealeaten=$temp;	
					$lastmealtime=$optimizer[$temp]['time'];					
				}
			}					
		}
		else if($hourdiff>=2&&$hourdiff<3)//hour 3 condition
		{						
			if(empty($optimizer[$temp])&&$isHourOne==0)
			{
			 $finalArray[$temp]['message']=array();
			 $finalArray[$temp]['value']=1;
			}
			else if(empty($optimizer[$temp])&&$isHourOne==1)
			{
			  $finalArray[$temp]['message']=array();
			  $finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value'];
			}
			else if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1)
			{																
										
				$temphourdifference=fatloss_model::getHourDiff($lastmealtime,$optimizer[$temp]['time']);				
				if(($isHourOne==0)||$temphourdifference>=2&&$temphourdifference<=3)
				{
					//////////////////////////////////////
						$mealburningvalue=6;
						if($optimizer[$temp]['type']=='Snack')
						$gettempvalue=fatloss_model::snack_criteria($optimizer[$temp]);
						else
						$gettempvalue=fatloss_model::meal_criteria($optimizer[$temp]);

						$mealburningvalue+=$gettempvalue['fatburning'];
						///////////////////////
						$finalArray[$temp]['message']=$gettempvalue['message'];
						////////////////////////////////////////
						if($mealburningvalue>6)
						$mealburningvalue+=$sleepvalue;
						else
						$mealburningvalue-=$sleepvalue;			
						$finalArray[$temp]['value']=$mealburningvalue;	
						$lastmealeaten=$temp;	
						$isHourOne=1;
						$lastmealtime=$optimizer[$temp]['time'];
					//////////////////				
				}				
				else
				{
					$tempeaten=fatloss_model::getSomethingOrLot($optimizer[$temp]);					
					$finalArray[$temp]['message']=$tempeaten['message'];
					$finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value']+$tempeaten['value'];
					$lastmealeaten=$temp;	
					$lastmealtime=$optimizer[$temp]['time'];					
				}
			}					
		}
		else if($hourdiff>=3)//hour 4 condition
		{						
										
			if(empty($optimizer[$temp])&&$isHourOne==0)
			{
			 $finalArray[$temp]['message']=array();
			 $finalArray[$temp]['value']=1;
			}
			else if(empty($optimizer[$temp])&&$isHourOne==1)
			{
			  
			  $temphourdifference=fatloss_model::getHourDiff($lastmealtime,$temp.":00");			  
			  if($temphourdifference<3)
			  {		
			   $finalArray[$temp]['message']=array();
			   $finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value'];
			  }
			  else if($temphourdifference>=3&&$temphourdifference<4)
			  {
				$finalArray[$temp]['message']=array();
			    $finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value']-4;
			  }
			  else if($temphourdifference>=4)
			  {
			    $finalArray[$temp]['message']=array();
			    $finalArray[$temp]['value']=1;			  
			  }
			}
			else if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1)
			{																
										
				$temphourdifference=fatloss_model::getHourDiff($lastmealtime,$optimizer[$temp]['time']);				
				if(($isHourOne==0)||$temphourdifference>=2)
				{
					//////////////////////////////////////
						$mealburningvalue=6;
						if($optimizer[$temp]['type']=='Snack')
						$gettempvalue=fatloss_model::snack_criteria($optimizer[$temp]);
						else
						$gettempvalue=fatloss_model::meal_criteria($optimizer[$temp]);

						$mealburningvalue+=$gettempvalue['fatburning'];
						///////////////////////
						$finalArray[$temp]['message']=$gettempvalue['message'];
						////////////////////////////////////////
						if($mealburningvalue>6)
						$mealburningvalue+=$sleepvalue;
						else
						$mealburningvalue-=$sleepvalue;			
						$finalArray[$temp]['value']=$mealburningvalue;	
						$lastmealeaten=$temp;	
						$isHourOne=1;
						$lastmealtime=$optimizer[$temp]['time'];
					//////////////////				
				}				
				else
				{
					$tempeaten=fatloss_model::getSomethingOrLot($optimizer[$temp]);					
					$finalArray[$temp]['message']=$tempeaten['message'];
					$finalArray[$temp]['value']=$finalArray[$lastmealeaten]['value']+$tempeaten['value'];
					$lastmealeaten=$temp;	
					$lastmealtime=$optimizer[$temp]['time'];					
				}
			}					
		}
////////////////////////////////////////////for feedback message//////
		if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1)
		{				
				$tempfeedbackh=fatloss_model::getHourDiff($feedbackmealtime,$optimizer[$temp]['time']);
				
				
				if($tempfeedbackh==2.5)
				$feedbackscore[$temp]['isRight']=1;			
				else if($tempfeedbackh<2.5)
				$feedbackscore[$temp]['isTooOften']=1;
				else if($tempfeedbackh>2.5)
				$feedbackscore[$temp]['isNotOften']=1;						
				
				
				if(in_array($finalArray[$temp]['value'],array(5,6,7)))
				$feedbackscore[$temp]['isRightAmount']=1;
				else if($finalArray[$temp]['value']<5)
				$feedbackscore[$temp]['isTooLittle']=1;
				else if($finalArray[$temp]['value']>7)
				$feedbackscore[$temp]['isTooMuch']=1;
				
				$feedbackscore[$temp]['isMeal']=1;
				
		}
		else
		{				
				$tempfeedbackh=fatloss_model::getHourDiff($feedbackmealtime,$temp.":00:00");								
				if($tempfeedbackh==2.5)
				$feedbackscore[$temp]['isRight']=1;			
				else if($tempfeedbackh<2.5)
				$feedbackscore[$temp]['isTooOften']=1;
				else if($tempfeedbackh>2.5)
				$feedbackscore[$temp]['isNotOften']=1;						
				
				$feedbackscore[$temp]['isMeal']=0;
		}	
/////////////////////////////////////////////////////////		
	}
	//////////////////////////////////////////////////////////	
	if(!empty($optimizer[$temp])&&strlen($firstmealeaten)==0&&strlen($firstmealtime)==0)
	{//
		if(isset($optimizer[$temp]['ismeal'])&&$optimizer[$temp]['ismeal']==1&&isset($optimizer[$temp]['total_sleep']))
		{	
			
			$tmessage=fatloss_model::getSleepInfo($optimizer[$temp]['total_sleep']);
			$sleep_message[$mid++]=$tmessage['message'];
			$sleepvalue=$tmessage['pvalue'];			
			//////////////////////////////////////			
				$mealburningvalue=6;
				if($optimizer[$temp]['type']=='Snack')
				$gettempvalue=fatloss_model::snack_criteria($optimizer[$temp]);
				else
				$gettempvalue=fatloss_model::meal_criteria($optimizer[$temp]);
												
				$mealburningvalue+=$gettempvalue['fatburning'];
			///////////////////////
			$finalArray[$temp]['message']=$gettempvalue['message'];
			////////////////////////////////////////
			if($mealburningvalue>6)
			$mealburningvalue+=$sleepvalue;
			else
			$mealburningvalue-=$sleepvalue;
			
			$finalArray[$temp]['value']=$mealburningvalue;
			$lastmealeaten=$temp;
			$firstmealeaten=$temp;
			$lastmealtime=$optimizer[$temp]['time'];
			$firstmealtime=$optimizer[$temp]['time'];
			$isFirst=1;
			$isHourOne=1; /////////check 1 hour hase passed
			
			////////////////////////////////////////////for feedback message//////
			$tempfeedbackh=fatloss_model::getHourDiff($optimizer[$temp]['waketime'],$optimizer[$temp]['time']);
			if($tempfeedbackh==0.5)
			$feedbackscore[$temp]['isRight']=1;			
			else if($tempfeedbackh<0.5)
			$feedbackscore[$temp]['isTooOften']=1;
			else if($tempfeedbackh>0.5)
			$feedbackscore[$temp]['isNotOften']=1;						
			
			if(in_array($mealburningvalue,array(5,6,7)))
			$feedbackscore[$temp]['isRightAmount']=1;
			else if($mealburningvalue<5)
			$feedbackscore[$temp]['isTooLittle']=1;
			else if($mealburningvalue>7)
			$feedbackscore[$temp]['isTooMuch']=1;
			
			$feedbackscore[$temp]['isMeal']=1;			
			///////////////////////////////////////////////
		}
		else if(!isset($optimizer[$temp]['ismeal'])&&isset($optimizer[$temp]['total_sleep']))
		{
			$tmessage=fatloss_model::getSleepInfo($optimizer[$temp]['total_sleep']);
			$sleep_message[$mid++]=$tmessage['message'];
			$sleepvalue=$tmessage['pvalue'];			
			$lastmealtime=$optimizer[$temp]['waketime'];
			$lastmealeaten=$temp;
			
			$firstmealeaten=$temp;			
			$firstmealtime=$optimizer[$temp]['waketime'];
			
			
			$hourdiff=fatloss_model::getHourDiff($optimizer[$temp]['waketime'],($temp+1).":00");
			
			if($hourdiff>=1)
			{	
				$finalArray[$temp]['value']=1;
				$finalArray[$temp]['message']=array();
			}										
		}					
	}//			
	///////////////////////////////////////////////////
	$temp=date("H",strtotime($temp.":00:00")+(60*60));	
	if($flag==1)	
	break;
}

///////////////////////////////////	
$result2='';


$default_chart_value='';
$default_chart_label='';
$dc_count=0;
foreach($finalArray as $key=>$value)
{
	$default_chart_value.='<div class="unit-0 hour'.$key.'">&nbsp;</div>';
		
	if($dc_count%3==0)
	$default_chart_label.='<li class="show-time">'.substr(date("ga",strtotime(date("Y-m-d")." ".$key.":00:00")),0,-1).'</li>';	
	else
	$default_chart_label.='<li>'.$key.'</li>';	
	
	$dc_count++;
}
if($dc_count<=16)  //scrol hide before or equal 16 hour//
{
?>
<script type="text/javascript">
$(function() 
{
	$('.jspHorizontalBar').css("display","none");
	$('.micro-chart-scale').css("top","-14px");
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
	$('.jspHorizontalBar').css("display","block");
	$('.micro-chart-scale').css("top","");
});
</script>
<?php
}
?>
<script type="text/javascript">
$(function() 
{
	//$('#eating_journal_main_chart').html('<div class="unit-0 hour06">&nbsp;</div><div class="unit-0 hour07">&nbsp;</div><div class="unit-0 hour08">&nbsp;</div><div class="unit-0 hour09">&nbsp;</div><div class="unit-0 hour10">&nbsp;</div><div class="unit-0 hour11">&nbsp;</div>	<div class="unit-0 hour12">&nbsp;</div><div class="unit-0 hour13">&nbsp;</div><div class="unit-0 hour14">&nbsp;</div><div class="unit-0 hour15">&nbsp;</div><div class="unit-0 hour16">&nbsp;</div><div class="unit-0 hour17">&nbsp;</div>	<div class="unit-0 hour18">&nbsp;</div><div class="unit-0 hour19">&nbsp;</div><div class="unit-0 hour20">&nbsp;</div><div class="unit-0 hour21">&nbsp;</div><div class="unit-0 hour22">&nbsp;</div><div class="unit-0 hour23">&nbsp;</div>	<div class="unit-0 hour00">&nbsp;</div><div class="unit-0 hour01">&nbsp;</div><div class="unit-0 hour02">&nbsp;</div><div class="unit-0 hour03">&nbsp;</div><div class="unit-0 hour04">&nbsp;</div><div class="unit-0 hour05">&nbsp;</div>');
	$('#eating_journal_main_chart').html('<?php echo $default_chart_value;?>');
	$('#micro_scale_unit_id').html('<?php echo $default_chart_label;?>');	
});
</script>
<?php
$totalwakeup=0;
$totalfatburning=0; 
foreach($finalArray as $key=>$value)
{
	$totalwakeup++;		
	$finalArray[$key]['value']=$finalArray[$key]['value']>11?11:$finalArray[$key]['value'];
	$finalArray[$key]['value']=$finalArray[$key]['value']<1?1:$finalArray[$key]['value'];
	
	if(in_array($finalArray[$key]['value'], array(5,6,7)))
	{
	$totalfatburning++;
	?>
		<script type="text/javascript">
			$(function() 
			{
				$('.<?php echo "hour".$key?>').addClass('micro-chart-unit');
				$('.<?php echo "hour".$key?>').addClass('unit-<?php echo $finalArray[$key]['value'];?>');				
				$('.<?php echo "hour".$key?>').removeClass('unit-0');								
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
				$('.<?php echo "hour".$key?>').addClass('micro-chart-storing');
				$('.<?php echo "hour".$key?>').addClass('unit-<?php echo $finalArray[$key]['value'];?>');				
				$('.<?php echo "hour".$key?>').removeClass('unit-0');
			});
	</script>			
	<?php
	}
}
///////////////////calculate grade fat burning percentage///////////
$total_score=0;

$tempfeedbackh=fatloss_model::getHourDiff($waketime,date("H:i:s"));  ///scenario 1
if($tempfeedbackh<=1.0)
$date['fat_burning_mode']=100;
else if($totalwakeup>0)
$date['fat_burning_mode']=($totalfatburning/$totalwakeup)*100;
else
$date['fat_burning_mode']=0;

$total_score+=($date['fat_burning_mode']/2);

//////////////
$daily=User_model::getDaily($jDate);
if($this->session->userdata('sex')=="Male")
{
	////////////////////////////////////////get calories score//////
	if($burning_total['all_calories']<=749||$burning_total['all_calories']>=3001)
	$total_score+=0;
	else if(($burning_total['all_calories']>=750&&$burning_total['all_calories']<=899)||($burning_total['all_calories']>=2851&&$burning_total['all_calories']<=3000))
	$total_score+=4;
	else if(($burning_total['all_calories']>=900&&$burning_total['all_calories']<=1049)||($burning_total['all_calories']>=2701&&$burning_total['all_calories']<=2850))
	$total_score+=8;
	else if(($burning_total['all_calories']>=1050&&$burning_total['all_calories']<=1199)||($burning_total['all_calories']>=2551&&$burning_total['all_calories']<=2700))
	$total_score+=12;
	else if(($burning_total['all_calories']>=1200&&$burning_total['all_calories']<=1349)||($burning_total['all_calories']>=2401&&$burning_total['all_calories']<=2500))
	$total_score+=16;
	else if(($burning_total['all_calories']>=1350&&$burning_total['all_calories']<=2400))
	$total_score+=20;
	////////////////////////////////////////get fiber score////////////
	if($burning_total['all_fiber']<=14)
	$total_score+=0;
	else if($burning_total['all_fiber']>=15&&$burning_total['all_fiber']<=19)
	$total_score+=2;
	else if($burning_total['all_fiber']>=20&&$burning_total['all_fiber']<=24)
	$total_score+=4;
	else if($burning_total['all_fiber']>=25&&$burning_total['all_fiber']<=29)
	$total_score+=6;
	else if($burning_total['all_fiber']>=30&&$burning_total['all_fiber']<=34)
	$total_score+=8;
	else if($burning_total['all_fiber']>=35)
	$total_score+=10;
	
	/////////////water score////////////
	$water=$daily->cups;
	if($water<=3)	
	$total_score+=0;
	else if($water>=4&&$water<=5)
	$total_score+=1;
	else if($water>=6&&$water<=7)
	$total_score+=2;
	else if($water>=8&&$water<=9)
	$total_score+=3;	
	else if($water>=10&&$water<=11)
	$total_score+=4;		
	else if($water>=12)
	$total_score+=5;			

	///////////////////////////////////////get Cholesterol socore/////////
	if($burning_total['all_cholesterol']>=501)
	$total_score+=0;
	else if($burning_total['all_cholesterol']>=451&&$burning_total['all_cholesterol']<=500)
	$total_score+=1;
	else if($burning_total['all_cholesterol']>=401&&$burning_total['all_cholesterol']<=450)
	$total_score+=2;
	else if($burning_total['all_cholesterol']>=351&&$burning_total['all_cholesterol']<=400)
	$total_score+=3;
	else if($burning_total['all_cholesterol']>=301&&$burning_total['all_cholesterol']<=350)
	$total_score+=4;
	else if($burning_total['all_cholesterol']<=300)
	$total_score+=5;


	////////////////////////////////////////get saturated fat score////////////
	if($burning_total['all_saturatedfat']>=0&&$burning_total['all_saturatedfat']<=27)
	$total_score+=5;
	else if($burning_total['all_saturatedfat']>=28&&$burning_total['all_saturatedfat']<=33)
	$total_score+=4;
	else if($burning_total['all_saturatedfat']>=34&&$burning_total['all_saturatedfat']<=39)
	$total_score+=3;
	else if($burning_total['all_saturatedfat']>=40&&$burning_total['all_saturatedfat']<=45)
	$total_score+=2;
	else if($burning_total['all_saturatedfat']>=46&&$burning_total['all_saturatedfat']<=51)
	$total_score+=1;
	else if($burning_total['all_saturatedfat']>=52)
	$total_score+=0;

	////////////////////////////////////////get sodium score////////////
	if($burning_total['all_sodium']>=0&&$burning_total['all_sodium']<=1100)
	$total_score+=5;
	else if($burning_total['all_sodium']>=1101&&$burning_total['all_sodium']<=1400)
	$total_score+=4;
	else if($burning_total['all_sodium']>=1401&&$burning_total['all_sodium']<=1700)
	$total_score+=3;
	else if($burning_total['all_sodium']>=1701&&$burning_total['all_sodium']<=2000)
	$total_score+=2;
	else if($burning_total['all_sodium']>=2001&&$burning_total['all_sodium']<=2300)
	$total_score+=1;
	else if($burning_total['all_sodium']>=2301)
	$total_score+=0;		
}
else if($this->session->userdata('sex')=="Female")
{
	////////////////////////////////////////get calories score//////
	if($burning_total['all_calories']<=599||$burning_total['all_calories']>=2701)
	$total_score+=0;
	else if(($burning_total['all_calories']>=600&&$burning_total['all_calories']<=749)||($burning_total['all_calories']>=2551&&$burning_total['all_calories']<=2700))
	$total_score+=4;
	else if(($burning_total['all_calories']>=750&&$burning_total['all_calories']<=899)||($burning_total['all_calories']>=2401&&$burning_total['all_calories']<=2550))
	$total_score+=8;
	else if(($burning_total['all_calories']>=900&&$burning_total['all_calories']<=1049)||($burning_total['all_calories']>=2251&&$burning_total['all_calories']<=2400))
	$total_score+=12;
	else if(($burning_total['all_calories']>=1050&&$burning_total['all_calories']<=1199)||($burning_total['all_calories']>=2101&&$burning_total['all_calories']<=2250))
	$total_score+=16;
	else if(($burning_total['all_calories']>=1200&&$burning_total['all_calories']<=2100))
	$total_score+=20;
	////////////////////////////////////////get fiber score////////////
	if($burning_total['all_fiber']<=8)
	$total_score+=0;
	else if($burning_total['all_fiber']>=9&&$burning_total['all_fiber']<=12)
	$total_score+=2;
	else if($burning_total['all_fiber']>=13&&$burning_total['all_fiber']<=16)
	$total_score+=4;
	else if($burning_total['all_fiber']>=17&&$burning_total['all_fiber']<=20)
	$total_score+=6;
	else if($burning_total['all_fiber']>=21&&$burning_total['all_fiber']<=24)
	$total_score+=8;
	else if($burning_total['all_fiber']>=25)
	$total_score+=10;
	
	/////////////water score////////////
	$water=$daily->cups;
	if($water<=3)	
	$total_score+=0;
	else if($water>=4&&$water<=5)
	$total_score+=1;
	else if($water>=6&&$water<=7)
	$total_score+=2;
	else if($water>=8&&$water<=9)
	$total_score+=3;	
	else if($water>=10&&$water<=11)
	$total_score+=4;		
	else if($water>=12)
	$total_score+=5;			

	///////////////////////////////////////get Cholesterol socore/////////
	if($burning_total['all_cholesterol']>=501)
	$total_score+=0;
	else if($burning_total['all_cholesterol']>=451&&$burning_total['all_cholesterol']<=500)
	$total_score+=1;
	else if($burning_total['all_cholesterol']>=401&&$burning_total['all_cholesterol']<=450)
	$total_score+=2;
	else if($burning_total['all_cholesterol']>=351&&$burning_total['all_cholesterol']<=400)
	$total_score+=3;
	else if($burning_total['all_cholesterol']>=301&&$burning_total['all_cholesterol']<=350)
	$total_score+=4;
	else if($burning_total['all_cholesterol']<=300)
	$total_score+=5;


	////////////////////////////////////////get saturated fat score////////////
	if($burning_total['all_saturatedfat']>=0&&$burning_total['all_saturatedfat']<=23)
	$total_score+=5;
	else if($burning_total['all_saturatedfat']>=24&&$burning_total['all_saturatedfat']<=29)
	$total_score+=4;
	else if($burning_total['all_saturatedfat']>=30&&$burning_total['all_saturatedfat']<=35)
	$total_score+=3;
	else if($burning_total['all_saturatedfat']>=36&&$burning_total['all_saturatedfat']<=39)
	$total_score+=2;	
	else if($burning_total['all_saturatedfat']>=40&&$burning_total['all_saturatedfat']<=45)
	$total_score+=1;	
	else if($burning_total['all_saturatedfat']>=46)
	$total_score+=0;

	////////////////////////////////////////get sodium score////////////
	if($burning_total['all_sodium']>=0&&$burning_total['all_sodium']<=1100)
	$total_score+=5;
	else if($burning_total['all_sodium']>=1101&&$burning_total['all_sodium']<=1400)
	$total_score+=4;
	else if($burning_total['all_sodium']>=1401&&$burning_total['all_sodium']<=1700)
	$total_score+=3;
	else if($burning_total['all_sodium']>=1701&&$burning_total['all_sodium']<=2000)
	$total_score+=2;
	else if($burning_total['all_sodium']>=2001&&$burning_total['all_sodium']<=2300)
	$total_score+=1;
	else if($burning_total['all_sodium']>=2301)
	$total_score+=0;		
}
?>
<?php

$feedbackmessage=array();
$feedbackfatburning=round($date['fat_burning_mode']);

if($feedbackfatburning==100)
{
$feedbackmessage['perc']=array("Congratulations! You've been in fat burning mode 100% of the day!",
							   "Wow! You're doing a fantastic job!",	
							   "Amazing work! You've been flawless so far!");
}							   
else if($feedbackfatburning>=90&&$feedbackfatburning<=99)
{
$feedbackmessage['perc']=array("Great stuff - you've been in fat burning mode almost all day!",
							   "Excellent - you're almost perfect today!",	
							   "Super job! Keep up the great work!");
}						
else if($feedbackfatburning>=80&&$feedbackfatburning<=89)
{
$feedbackmessage['perc']=array("Good job - you've been in fat burning mode most of the day.",
							   "Fine work - you're just a few tweaks from perfection.",	
							   "Nicely done - you're doing pretty well so far.");
}
else if($feedbackfatburning>=50&&$feedbackfatburning<=79)
{
$feedbackmessage['perc']=array("Ok, but there's room for improvement so that you can stay in fat burning mode.",
							   "Good effort, now let's make some tweaks to be even better.",	
							   "Not bad - you need just a few adjustments to stay in fat-burning mode.");
}
else if($feedbackfatburning<50)
{
$feedbackmessage['perc']=array("There's room for improvement here, with some important tweaks.",
							   "Your can get right into fat-burning mode with a few changes.",	
							   "You can move into fat-burning mode with a few important adjustments.");
}

$finalfeedbackmessage="";
$lastmealinfo=array();
$timingm=array();
$amountm=array();
$isfeedbackmeal=0;

ksort($fatlossplate);
$snackmealflp=end($fatlossplate);

$isRight="";
if(!empty($feedbackscore))
{	
	foreach($feedbackscore as $key=>$value)
	{
		if($value['isMeal']==1)
		{
			$lastmealinfo['meal']=$value;
			$isfeedbackmeal=1;
		}
		
		$lastmealinfo['nonmeal']=$value;
	}
}	

	/////////////////////last meal info for timing
	if((isset($lastmealinfo['meal']['isRight'])&&!isset($lastmealinfo['nonmeal']['isNotOften']))&&$isfeedbackmeal==1)
	{
	$timingm=array("You're eating meals or snacks every 2-3 hours which is just right.",
								   "You're eating schedule is right on target - keep eating meals/snacks every 2-3 hours.",	
								   "You're optimizing your fat-burning by always eating every 2-3 hours.");
	}
	else if(isset($lastmealinfo['meal']['isTooOften'])&&$isfeedbackmeal==1)
	{
	$timingm=array("You're eating a bit too often; try to space out meals/snacks every 2-3 hours.",
								   "It's important to eat every 2-3 hours, so try not to have meals/snacks more often than that.",	
								   "Eating many small meals/snacks throughout the day is great, but try to only eat once every 2-3 hours.");
	}
	else if((isset($lastmealinfo['nonmeal']['isNotOften'])||isset($lastmealinfo['meal']['isNotOften']))&&$isfeedbackmeal==1)
	{
	$timingm=array("Try to eat more often (every 2-3 hours) to actually speed up your metabolism.",
								   "It's important to add some snacks into your schedule so that you're eating every 2-3 hours.",	
								   "Adding snacks between meals so you're eating every 2-3 hours is key for speeding up your metabolism.");
	}
	/////////////////////last meal info for meal amount
	if(isset($snackmealflp['isfatlosplate'])&&$snackmealflp['isfatlosplate']==1&&$isfeedbackmeal==1)
	{
	$amountm=array("Finally, the portion sizes of your meals/snacks are right on the mark!",
								   "Also, you've been eating perfect Fat Loss plates & snacks...keep it up!",	
								   "Lastly, your Fat Loss plates & snacks have been ideal - that's how it's done!");
	}
	else if(isset($lastmealinfo['meal']['isTooLittle'])&&$isfeedbackmeal==1)
	{
	$amountm=array("Finally, increase the portion sizes of your meals/snacks to make sure that your body is getting enough fuel.",
								   "Also, you actually need slightly larger Fat Loss plates and/or snacks to keep your metabolism burning.",	
								   "Lastly, your Fat Loss plates and/or snacks need to be bigger to give your metabolism the proper fuel it needs.");
	}
	else if(isset($lastmealinfo['meal']['isTooMuch'])&&$isfeedbackmeal==1)
	{
	$amountm=array("Finally, the portion sizes of your meals/snacks are a bit too large…try to reduce them a bit.",
								   "Also,  your Fat Loss plates and/or snacks are a bit large for maximum fat-burning.",	
								   "Lastly, pay close attention to portion size, for your Fat Loss plates and/or snacks are a bit large.");
	}
		
	$rendomvalue=rand(1,1000);	
	if(!empty($feedbackmessage['perc']))
	$finalfeedbackmessage=$feedbackmessage['perc'][$rendomvalue%3];
	
	$rendomvalue=rand(1,1000);
	if(isset($timingm[$rendomvalue%3]))
	$finalfeedbackmessage.=" ".$timingm[$rendomvalue%3];
	
	$rendomvalue=rand(1,1000);
	if(isset($amountm[$rendomvalue%3]))
	$finalfeedbackmessage.=" ".$amountm[$rendomvalue%3];
	
	
	
	if($tempfeedbackh<=1.0&&empty($timingm)&&empty($amountm))//scenario 1
	{
		$finalfeedbackmessage.=" Make sure to eat your next meal or snack within 60 minutes of waking up so that you can fire up your metabolism for the day ahead!";	
	}
	else if($tempfeedbackh>1.0&&empty($timingm)&&empty($amountm))//scenario 2
	{
		$finalfeedbackmessage.=" It's important to eat within 60 minutes of waking up so that you can fire up your metabolism for the day ahead. Make sure to eat your next meal or snack as soon as possible!";
	}
?>
<script type="text/javascript">	
	$(function() 
	{						
		<?php
		if($eDate==$jDate)
		{
		?>
		$('#feedback_message').html('<?php echo mysql_escape_string($finalfeedbackmessage);?>');
		<?php
		}
		?>
		
		$('#sidebar_fat_percent').html('<?php echo round($date['fat_burning_mode'])."%";?>');		
		<?php
		if(round($date['fat_burning_mode'])<50)
		{
		?>
		 $('#sidebar_fat_percent').removeClass();		
		 $('#sidebar_fat_percent').addClass('sidebar-fat-percent-red');		
		<?php
		}
		else if(round($date['fat_burning_mode'])>=50&&round($date['fat_burning_mode'])<=79)
		{
		?>
		 $('#sidebar_fat_percent').removeClass();		
		 $('#sidebar_fat_percent').addClass('sidebar-fat-percent-yellow');		
		<?php
		}
		else
		{
		?>
		 $('#sidebar_fat_percent').removeClass();		
		 $('#sidebar_fat_percent').addClass('sidebar-fat-percent');				
		<?php
		}
		?>
		
		//$('#doctormessage').html('<?php echo $result;?>');						
	});
</script>