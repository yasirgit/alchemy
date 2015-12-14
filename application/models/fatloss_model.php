<?php
class fatloss_model extends Model
{
	private $CI;
	
	function __construct()
	{
		parent::Model();
		$this->CI =& get_instance();		
		////////////////////////////////////////////						
		if(strlen($this->session->userdata('timezone'))>0)
		date_default_timezone_set($this->session->userdata('timezone'));		   				   	
		/////////////////////////////////////////////		   						
		
	}	
	function meal_criteria($allvalue)
	{
		$fatburning=0;
		$return=array();
		$message=array();
		$mIndex=0;
			
		if($allvalue['sex']=="Male")
		{
		///////////////////
			if($allvalue['total_calories']>=250&&$allvalue['total_calories']<=299)//If Total Calories too small
			{
			 $fatburning+=-1;
			 $message[$mIndex++]="Your Breakfast was a little small. Improve results and keep hunger and cravings in check by enjoying full portions.";
			}
			else if($allvalue['total_calories']<250)//If Meal WAY too Small
			{
			 $fatburning+=-2;
			 $message[$mIndex++]="Your not eating enough! Improve results and keep hunger and cravings in check by enjoying full portions.";
			}
			else if($allvalue['total_calories']>=551&&$allvalue['total_calories']<=700)//If Meal too Large
			{
			 $fatburning+=2;
			 $message[$mIndex++]="That meal was a bit big.";
			}
			else if($allvalue['total_calories']>700)//If Meal WAY too Large
			{
			 $fatburning+=4;
			 $message[$mIndex++]="Uh Oh!  Really big meal.  Check your portion sizes and added fat to avoid slowing fat loss.";
			}
					
			//////////////////////carb
			if($allvalue['total_carb']>50&&$allvalue['total_carb']<=150)//If too Much Fast Carb
			$fatburning+=2;	 		
			else if($allvalue['total_carb']>150&&$allvalue['total_carb']<=300)//If WAY too Much Fast Carb
			$fatburning+=3;	
			
			/*due thing//If mostly Fast Carb// If Fat Loss Plate Version C (no Slow Carb)*/
			////////////fat/////////////		
			if($allvalue['total_fat']>100)//If too Much Fat
			$fatburning+=0;				
		////////////////////
		}
		else if($allvalue['sex']=="Female")	
		{
		//////////////////////
		///////////////////
			if($allvalue['total_calories']>=200&&$allvalue['total_calories']<=249)//If Total Calories too small
			{
			 $fatburning+=-1;
			 $message[$mIndex++]="Your Breakfast was a little small. Improve results and keep hunger and cravings in check by enjoying full portions.";
			}
			else if($allvalue['total_calories']<200)//If Meal WAY too Small
			{
			 $fatburning+=-2;
			 $message[$mIndex++]="Your not eating enough! Improve results and keep hunger and cravings in check by enjoying full portions.";
			}
			else if($allvalue['total_calories']>=451&&$allvalue['total_calories']<=600)//If Meal too Large
			{
			 $fatburning+=2;
			 $message[$mIndex++]="That meal was a bit big.";
			}
			else if($allvalue['total_calories']>600)//If Meal WAY too Large
			{
			 $fatburning+=4;
			 $message[$mIndex++]="Uh Oh!  Really big meal.  Check your portion sizes and added fat to avoid slowing fat loss.";
			}
					
			//////////////////////carb
			if($allvalue['total_carb']>45&&$allvalue['total_carb']<=125)//If too Much Fast Carb
			$fatburning+=2;	 		
			else if($allvalue['total_carb']>125&&$allvalue['total_carb']<=250)//If WAY too Much Fast Carb
			$fatburning+=3;
			
			/*due thing//If mostly Fast Carb// If Fat Loss Plate Version C (no Slow Carb)*/
			////////////fat/////////////		
			if($allvalue['total_fat']>75)//If too Much Fat
			$fatburning+=0;				
		////////////////////		
		///////////////////
		}	
		//if($allvalue['total_calories'])	
		$return['fatburning']=$fatburning;
		$return['message']=$message;
		
	return $return;	
	}
	function getSomethingOrLot($allvalue)
	{
		$selot=0;
		$selotm=array();	
		$tIndex=0;
		if($allvalue['sex']=="Male")
		{
		///////////////////
			if($allvalue['total_calories']>=100&&$allvalue['total_calories']<=200)
			{
				$selot=2;
				$selotm[$tIndex++]="Try to hold out or If you are hungry between meals";
			}
			else if($allvalue['total_calories']>200)
			{
				$selot=3;
				$selotm[$tIndex++]="";
			}		
		////////////////////
		}
		else if($allvalue['sex']=="Female")
		{
		///////////////////
			if($allvalue['total_calories']>=75&&$allvalue['total_calories']<=150)
			{
				$selot=2;
				$selotm[$tIndex++]="Try to hold out or If you are hungry between meals";
			}
			else if($allvalue['total_calories']>150)
			{
				$selot=3;
				$selotm[$tIndex++]="";
			}
		////////////////////	
		}
		 $return=array();
		 $return['value']=$selot;
		 $return['message']=$selotm;	
		 return $return;
	}
	function snack_criteria($allvalue)
	{//////
		$fatburning=0;
		$return=array();
		$message=array();
		$mIndex=0;
		
		if($allvalue['sex']=="Male")
		{
		///////////////////
			if($allvalue['total_calories']>=400)//If way too big…
			{
			 $fatburning+=3;
			 $message[$mIndex++]="";
			}
			else if($allvalue['total_calories']>250&&$allvalue['total_calories']<400)//If Meal WAY too Small
			{
			 $fatburning+=2;
			 $message[$mIndex++]="";
			}
			else if($allvalue['total_calories']<150)//If too small…
			{
			 $fatburning+=-2;
			 $message[$mIndex++]="";
			}			
		////////////////////
		}
		else if($allvalue['sex']=="Female")	
		{
		//////////////////////			
			if($allvalue['total_calories']>=300)//If way too big…
			{
			 $fatburning+=3;
			 $message[$mIndex++]="";
			}
			else if($allvalue['total_calories']>250&&$allvalue['total_calories']<300)//If Meal WAY too Small
			{
			 $fatburning+=2;
			 $message[$mIndex++]="";
			}
			else if($allvalue['total_calories']<150)//If too small…
			{
			 $fatburning+=-2;
			 $message[$mIndex++]="";
			}				
		///////////////////
		}	
		//if($allvalue['total_calories'])	
		$return['fatburning']=$fatburning;
		$return['message']=$message;
		
	return $return;
	}///////
	function getHourDiff($firstHour,$secondHour)
	{
			$dtime=substr($firstHour,0,5);
			$atime=substr($secondHour,0,5);		
			
			$nextDay=$dtime>$atime?1:0;
			$dep=EXPLODE(':',$dtime);
			$arr=EXPLODE(':',$atime);
			$diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
			$hours=FLOOR($diff/(60*60));
			$mins=FLOOR(($diff-($hours*60*60))/(60));
			$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
			IF(STRLEN($hours)<2){$hours="0".$hours;}
			IF(STRLEN($mins)<2){$mins="0".$mins;}
			IF(STRLEN($secs)<2){$secs="0".$secs;}
			
			$temp=floatval($mins/60);
			$temp+=$hours;			
			return $temp;	
	}
	function getSleepInfo($total_sleep)
	{
		if($total_sleep<5)
		{
			$return['message']="You need to get more sleep!  Studies show that people who only got 5 hours of sleep where 50% more likely to be obese than those who got 7-8.";
			$return['pvalue']=3;
		}
		else if($total_sleep<6)
		{
			$return['message']="You need to get more sleep!  Studies show that people who only got 6 hours of sleep where 23% more likely to be obese than those who got 7-8.";
			$return['pvalue']=2;
		}
		else if($total_sleep<7||$total_sleep>9)
		{
			$return['message']='Sleep - Try to get a full 7-8 hours of sleep tonight.  It will help speed weight loss and minimize cravings during the day.';
			$return['pvalue']=1;
		}
		else 
		{
			$return['message']='';
			$return['pvalue']=0;
		}
		return $return;
	}
	///////////////////////////
	function isfatlossplate($data)
	{		
		$iscalorieOk=0;
		$isproteingOk=0;
		$iscarbsOk=0;
		$isfatOK=0;
			///////////////////////
		if(isset($data['sex']))	
		{
			if($data['sex']=="Male")
			{			
					if($data['type']=="Snack"&&$data['total_calories']>=150&&$data['total_calories']<=250)
					$iscalorieOk=1;
					else if($data['total_calories']>=300&&$data['total_calories']<=550&&$data['type']!="Snack")
					$iscalorieOk=1;

					if($data['total_fat']>=0&&$data['total_fat']<=21.4)
					$isfatOK=1;

					if($data['total_carb']>=3&&$data['total_carb']<=50)
					$iscarbsOk=1;

					if($data['total_protein']>=15)
					$isproteingOk=1;						
			}
			else if($data['sex']=="Female")
			{
					if($data['type']=="Snack"&&$data['total_calories']>=150&&$data['total_calories']<=250)
					$iscalorieOk=1;
					else if($data['total_calories']>=250&&$data['total_calories']<=450&&$data['type']!="Snack")
					$iscalorieOk=1;

					if($data['total_fat']>=0&&$data['total_fat']<=17.5)
					$isfatOK=1;

					if($data['total_carb']>=3&&$data['total_carb']<=45)
					$iscarbsOk=1;

					if($data['total_protein']>=12)
					$isproteingOk=1;						
			}
		}	
				
			$isfatlosplate=0;	
			if($iscalorieOk==1&&$isfatOK==1&&$iscarbsOk==1&&$isproteingOk==1&&$data['type']!="Snack")
			$isfatlosplate=1;
			else if($iscalorieOk==1&&$data['type']=="Snack")
			$isfatlosplate=1;
			else
			$isfatlosplate=0;
				
			return $isfatlosplate;
		///////////////////////////////	
	}
	function getfoodinfo($fatlosplate)
	{	
		$return= array();
		/*	
			[total_calories] => 272
			[total_fat] => 9.77
			[total_carb] => 34.25
			[dietary_fiber] => 2.3
			[sugar] => 6.7
			[total_protein] => 12.32			
		*/
		/////////////////////////////////////////get percent Percent_Fiber				
		$Percent_Fiber=0;
		$Percent_Carbs = 0;
		$Percent_Sugar = 0;
		$Percent_Carbs_from_Fiber = 0;
		$Percent_Carbs_from_Sugars = 0;
		$Fiber_Grams=$fatlosplate['dietary_fiber'];
		$Carb_Grams=$fatlosplate['total_carb'];
		
		if($Carb_Grams>0)
		$Percent_Carbs_from_Fiber=$Fiber_Grams/$Carb_Grams;
		
		$Carb_Calories=$Carb_Grams*4;		
		$Fiber_Calories=$Percent_Carbs_from_Fiber*$Carb_Calories;		
		
		if($fatlosplate['total_calories']>0)
		$Percent_Fiber=($Fiber_Calories/$fatlosplate['total_calories'])*100;				
		$return['Percent_Fiber']=$Percent_Fiber;
		///////////////////////////////////get Percent_Carbs
		$Carb_Grams=$fatlosplate['total_carb'];
		$Carb_Calories=$Carb_Grams*4;
		if($fatlosplate['total_calories']>0)
		$Percent_Carbs=($Carb_Calories/$fatlosplate['total_calories'])*100;
		$return['Percent_Carbs']=$Percent_Carbs;
		/////////////////////////////////////////////get sugar percents
		$Sugar_Grams=$fatlosplate['sugar'];
		if($Carb_Grams>0)
		$Percent_Carbs_from_Sugars=$Sugar_Grams/$Carb_Grams;
		
		$Carb_Calories=$Carb_Calories;
		$Sugar_Calories=$Carb_Calories*$Percent_Carbs_from_Sugars;
		if($fatlosplate['total_calories']>0)
		$Percent_Sugar=($Sugar_Calories/$fatlosplate['total_calories'])*100;
		$return['Percent_Sugar']=$Percent_Sugar;
		/////////////////////////////////////////////////////////////		
		$decision=array();
		if($this->session->userdata('sex')=="Male")
		{
			if($fatlosplate['total_fat']>=8)
			$decision['isFat']=1;
			else
			$decision['isFat']=0;
		}
		else if($this->session->userdata('sex')=="Female")
		{
			if($fatlosplate['total_fat']>=6.5)
			$decision['isFat']=1;
			else
			$decision['isFat']=0;
		}
		else
		$decision['isFat']=0;
						
		if(($fatlosplate['total_protein']>=6)&&$return['Percent_Fiber']<10&&$return['Percent_Carbs']<55)
		$decision['isProtein']=1;
		else
		$decision['isProtein']=0;
		
		if(($return['Percent_Carbs']>=67)&&$return['Percent_Fiber']<10&&$return['Percent_Carbs']<55&&$return['Percent_Fiber']<15)
		$decision['isFirstcarb']=1;
		else
		$decision['isFirstcarb']=0;
		
		if($decision['isFat']==0&&$decision['isProtein']==0&&$decision['isFirstcarb']==0)
		$decision['isSlowcarb']=1;
		else
		$decision['isSlowcarb']=0;
		
		if($decision['isFirstcarb']==1&&$decision['isFat']==1)
		$decision['fattyfastcarb']=1;
		else
		$decision['fattyfastcarb']=0;
		
		if($decision['isProtein']==1&&$decision['isFat']==1)
		$decision['fattyprotein']=1;
		else
		$decision['fattyprotein']=0;
		/////////////////////////////////////////////////////////////derection fo alcohol//
		$calculated_calories=($fatlosplate['total_fat']*9)+($fatlosplate['total_carb']*4)+($fatlosplate['total_protein']*4);
		
		if($calculated_calories<($fatlosplate['total_calories']/2))
		$decision['isAlcohol']=1;
		else
		$decision['isAlcohol']=0;
		/////////////////////////////////////////////get percent fat////
		if($fatlosplate['total_calories']>0)
		{
		 $Percent_Fat=(($fatlosplate['total_fat']*9)/$fatlosplate['total_calories'])*100;		
		 $Percent_Protein=(($fatlosplate['total_protein']*4)/$fatlosplate['total_calories'])*100;
		 $return['Percent_Fat']=$Percent_Fat;
		 $return['Percent_Protein']=$Percent_Protein;
		}
		////////////////////////get isSolid or stripe////////////////
		if($this->session->userdata('sex')=="Male")
		{
				if($decision['isFat']==1)
				{
					if($fatlosplate['total_fat']>0)
					$decision['fatStatus']="solid";
					else
					$decision['fatStatus']="stripe";
				}
				if($decision['isProtein']==1)
				{
					if($fatlosplate['total_protein']>15)
					$decision['proteinStatus']="solid";
					else
					$decision['proteinStatus']="stripe";
				}				
				if($decision['isFirstcarb']==1)
				{
					if($fatlosplate['total_carb']>0)
					$decision['firstcarbStatus']="solid";
					else
					$decision['firstcarbStatus']="stripe";
				}
				if($decision['isSlowcarb']==1)
				{
					if($fatlosplate['total_carb']>0)
					$decision['slowcarbStatus']="solid";
					else
					$decision['slowcarbStatus']="stripe";
				}
				
		}
		else if($this->session->userdata('sex')=="Female")
		{
				if($decision['isFat']==1)
				{
					if($fatlosplate['total_fat']>0)
					$decision['fatStatus']="solid";
					else
					$decision['fatStatus']="stripe";
				}
				if($decision['isProtein']==1)
				{
					if($fatlosplate['total_protein']>12)
					$decision['proteinStatus']="solid";
					else
					$decision['proteinStatus']="stripe";
				}
				if($decision['isFirstcarb']==1)
				{
					if($fatlosplate['total_carb']>0)
					$decision['firstcarbStatus']="solid";
					else
					$decision['firstcarbStatus']="stripe";
				}
				if($decision['isSlowcarb']==1)
				{
					if($fatlosplate['total_carb']>0)
					$decision['slowcarbStatus']="solid";
					else
					$decision['slowcarbStatus']="stripe";
				}
		}
		/////////////////////////////////////////////////////////////
		$return['directions']=$decision;		
		return $return;
	}
}
?>