<?php
error_reporting(0);
$this->load->model('fatloss_model'); 

$optimizer=array();
$jDate=date("Y-m-d");
////////////////////////////////////////////
$cardioe=0;
$resistancee=0;
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

$final_array[0]['time']=$mwaketime;
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
		}
	}
	else if($advice[$i]['type']=="Exercise")	
	{
		if($advice[$i]['entryname']=="Cardio")
		$cardioe++;
		else if($advice[$i]['entryname']=="Resistance")
		$resistancee++;
		
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


////////////////////////////
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
	///////////////////////////////////////
	if(isset($value['sex']))
	$optimizer[$key]['isfatlossplate']=fatloss_model::isfatlossplate($value);
	////////////////////////////////////////
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
if(!isset($istoday))
{
	$end=date("H",strtotime($bedtime));
}
else if(isset($istoday)&&$istoday==1)
{
	$time_dif_with_end=fatloss_model::getHourDiff($end.":00",$bedtime);
	$currenttime=date("H:i");
	$time_dif_with_cur=fatloss_model::getHourDiff($currenttime,$bedtime);

	if($time_dif_with_end>$time_dif_with_cur)
	$end=date("H");

	$currenttimed=fatloss_model::getHourDiff($waketime,$end.":00");

	if($currenttimed>=(24-$tsleep))
	$end=date("H",strtotime($bedtime));
}
///-----------------------


////////////////////////////
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

while(1)
{		
	if($temp==$end)
	$flag=1;
	
	///////////////////////////////rest calculate after first hour////
	if(strlen($firstmealeaten)>0&&strlen($firstmealtime)>0)
	{		
		
		$hourdiff=fatloss_model::getHourDiff($firstmealtime,$temp.":00");
		
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
$totalwakeup=0;
$totalfatburning=0; 
foreach($finalArray as $key=>$value)
{
	$totalwakeup++;		
	$finalArray[$key]['value']=$finalArray[$key]['value']>11?11:$finalArray[$key]['value'];
	$finalArray[$key]['value']=$finalArray[$key]['value']<1?1:$finalArray[$key]['value'];	
	if(in_array($finalArray[$key]['value'], array(5,6,7)))
	$totalfatburning++;	
	
	if(isset($optimizer[$key]['isfatlossplate']))
	$finalArray[$key]['isfatlossplate']=$optimizer[$key]['isfatlossplate'];
	
	unset($finalArray[$key]['message']);
}
///////////////////calculate grade fat burning percentage///////////
$total_score=0;
$returndata=array();

if($totalwakeup>0)
$returndata['fat_burning_mode']=($totalfatburning/$totalwakeup)*100;
else
$returndata['fat_burning_mode']=0;

$total_score+=($returndata['fat_burning_mode']/2);
////////////////////////////////////////get calories score//////
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

$returndata['plate']=$finalArray;
$returndata['total_score']=$total_score;

/////////////////////////get feedback for fatloss coach/////////
$areaofimprovement=array();
$youdidwell=array();
$ydi=0;
$aimpi=0;


	/////////Priority # 1///
	$iswakeflag=0;
	$countfatlossplate=0;
	$countnotfatlossplate=0;
	$lmealeaten="";
	$noslowcarb=0;
	foreach($optimizer as $key=>$value)
	{
		if(isset($value['ismeal']))
		{			
		    if(isset($value['waketime'])&&$iswakeflag==0)
			{
				if($value['total_sleep']>=7&&$value['total_sleep']<=8)
				$youdidwell[$ydi++]="Between 7-8 hrs sleep";			
				else if($value['total_sleep']>=5&&$value['total_sleep']<=6)
				$areaofimprovement[$aimpi++]="Between 5-6 hrs sleep";
				else if($value['total_sleep']<5)
				$areaofimprovement[$aimpi++]="Less than 5 hours sleep";
				else if($value['total_sleep']>9)
				$areaofimprovement[$aimpi++]="More than 9 hrs sleep";
		 	}
			
			if($iswakeflag==0)
			{
				$timeD=fatloss_model::getHourDiff($waketime,$value['time']);
				if($timeD<=0.5)
				$youdidwell[$ydi++]="Ate w/in 30 min of rising";
				else
				$areaofimprovement[$aimpi++]="Did not eat w/in 30 min of rising";
				$iswakeflag=1;			
			}
			//////////////////////get meal realted message/////////
			if($value['isfatlossplate']==1)
			$countfatlossplate++;
			else
			$countnotfatlossplate++;
			
			if($value['type']=="Snack")	//snack feedback
			{
				if($value['isfatlossplate']==1)
				$youdidwell[$ydi++]="Snacks correct size";
				else
				{
					if($this->session->userdata('sex')=="Female"&&$value['total_calories']<150)
					$areaofimprovement[$aimpi++]="Snack too small";
					else if($this->session->userdata('sex')=="Female"&&$value['total_calories']>250)
					$areaofimprovement[$aimpi++]="Snack too large";
					else if($this->session->userdata('sex')=="Male"&&$value['total_calories']>250)
					$areaofimprovement[$aimpi++]="Snack too large";
					else if($this->session->userdata('sex')=="Male"&&$value['total_calories']<150)
					$areaofimprovement[$aimpi++]="Snack too small";					
				}
			}
			else
			{
				if($value['isfatlossplate']==0)
				{
					if($this->session->userdata('sex')=="Male"&&$value['total_protein']<15&&$value['total_protein']>0)
					$areaofimprovement[$aimpi++]="meal had too little protein";
					else if($this->session->userdata('sex')=="Female"&&$value['total_protein']<12&&$value['total_protein']>0)
					$areaofimprovement[$aimpi++]="meal had too little protein";
					else if($value['total_protein']==0)
					$areaofimprovement[$aimpi++]="meal had no protein";
					
					if($this->session->userdata('sex')=="Male"&&$value['total_carb']>=50.01)
					$areaofimprovement[$aimpi++]="meal had too much fast carb";
					
					if($this->session->userdata('sex')=="Female"&&$value['total_carb']>=45.01)
					$areaofimprovement[$aimpi++]="meal had too much fast carb";					
					
					if($this->session->userdata('sex')=="Male"&&$value['total_fat']>=21.41)
					$areaofimprovement[$aimpi++]="meal had too big fat portion";
					
					if($this->session->userdata('sex')=="Female"&&$value['total_fat']>=17.51)
					$areaofimprovement[$aimpi++]="meal had too big fat portion";
				}			
				
				
				if($value['total_sodium']>2301)
			    $areaofimprovement[$aimpi++]="Too much sodium";
				else 
				$youdidwell[$ydi++]="Good amount of sodium";
			}

			if(strlen($lmealeaten)>0) ///meal time difference feedback
			{
				$timeD=fatloss_model::getHourDiff($waketime,$value['time']);
				if($timeD<2)
				$areaofimprovement[$aimpi++]="Ate more than every 2-3 hr";
				else if($timeD>3)
				$areaofimprovement[$aimpi++]="Did not eat every 2-3 hours";
				else 
				$youdidwell[$ydi++]="Ate every 2-3 hours";
			}
			$temp=fatloss_model::getfoodinfo($value);
			if($temp['directions']['isSlowcarb']==0)
			$noslowcarb++;
		}
		else if(isset($value['waketime'])&&!isset($value['ismeal']))
		{
				if($value['total_sleep']>=7&&$value['total_sleep']<=8)
				$youdidwell[$ydi++]="Between 7-8 hrs sleep";			
				else if($value['total_sleep']>=5&&$value['total_sleep']<=6)
				$areaofimprovement[$aimpi++]="Between 5-6 hrs sleep";
				else if($value['total_sleep']<5)
				$areaofimprovement[$aimpi++]="Less than 5 hours sleep";
				else if($value['total_sleep']>9)
				$areaofimprovement[$aimpi++]="More than 9 hrs sleep";		
		}
		if(isset($value['ismeal']))	
		$lmealeaten=$value['time'];
	}
	
	if(strlen($lmealeaten)>0) ///meal time difference feedback
	{
		$timeD=fatloss_model::getHourDiff($end.":00",$value['time']);
		if($timeD<2)
		$areaofimprovement[$aimpi++]="Ate more than every 2-3 hr";
		else if($timeD>3)
		$areaofimprovement[$aimpi++]="Did not eat every 2-3 hours";
		else 
		$youdidwell[$ydi++]="Ate every 2-3 hours";
	}
	else
	{				
		$timeD=fatloss_model::getHourDiff($waketime,$end.":00");
		if($timeD>0.5)
		$areaofimprovement[$aimpi++]="Did not eat w/in 30 min of rising";				
	}
	
     
	if($countfatlossplate>0&&$countnotfatlossplate==0)	
	$youdidwell[$ydi++]="All Meals were Fat Loss Plates";
	
	if($countfatlossplate>0&&$countnotfatlossplate==0&&$this->session->userdata('sex')=="Male"&&$burning_total['all_calories']>=2025&&$burning_total['all_calories']<=2450)
	$areaofimprovement[$aimpi++]="Too many calories";

	if($countfatlossplate>0&&$countnotfatlossplate==0&&$this->session->userdata('sex')=="Female"&&$burning_total['all_calories']>=1575&&$burning_total['all_calories']<=1950)
	$areaofimprovement[$aimpi++]="Too many calories";	
	
	if($this->session->userdata('sex')=="Male"&&$burning_total['all_saturatedfat']>27)
	$areaofimprovement[$aimpi++]="Too much saturated fat";
	else if($this->session->userdata('sex')=="Male"&&$burning_total['all_saturatedfat']>0&&$burning_total['all_saturatedfat']<=27)
	$youdidwell[$ydi++]="Good amount of saturated fat";

	if($this->session->userdata('sex')=="Female"&&$burning_total['all_saturatedfat']>21)
	$areaofimprovement[$aimpi++]="Too much saturated fat";	
	else if($this->session->userdata('sex')=="Female"&&$burning_total['all_saturatedfat']>0&&$burning_total['all_saturatedfat']<=21)
	$youdidwell[$ydi++]="Good amount of saturated fat";
	
	if($this->session->userdata('sex')=="Male"&&$burning_total['all_fiber']<38)
	$areaofimprovement[$aimpi++]="Too little Fiber";
	else if($this->session->userdata('sex')=="Male"&&$burning_total['all_fiber']>=38)
	$youdidwell[$ydi++]="Good amount of Fiber";

	if($this->session->userdata('sex')=="Female"&&$burning_total['all_fiber']<25)
	$areaofimprovement[$aimpi++]="Too little Fiber";	
	else if($this->session->userdata('sex')=="Female"&&$burning_total['all_fiber']>=25)
	$youdidwell[$ydi++]="Good amount of Fiber";
	
	if($noslowcarb>=3)
	$areaofimprovement[$aimpi++]="Too many meals w/o Slow Carb";		
	else if(strlen($lmealeaten)>0)
	$youdidwell[$ydi++]="Good # of meals with Slow Carb";
	
	if($burning_total['all_cholesterol']>300)
	$areaofimprovement[$aimpi++]="Too much cholesterol";	
	else if($burning_total['all_cholesterol']>0&&$burning_total['all_cholesterol']<=300)
	$youdidwell[$ydi++]="Good amount of cholesterol";
	
	
	
	
	if($water<=7)
	$areaofimprovement[$aimpi++]="7 or less glasses of water";
	else if($water>7&&$water<=11)
	$areaofimprovement[$aimpi++]="Between 8-11 glasses water";
	else
	$youdidwell[$ydi++]="Correct amount of water";
	
	if($daily->vitamins==1)
	$youdidwell[$ydi++]="Took multi";
	else
	$areaofimprovement[$aimpi++]="Did not take multi";
	
$returndata['areaofimprovement']=$areaofimprovement;
$returndata['youdidwell']=$youdidwell;
$returndata['cardio_exercise']=$cardioe;
$returndata['resistance_exercise']=$resistancee;

///////////////end fat loss coach feedback

///////////////////////////
echo json_encode($returndata);
?>
