<?php
$returndata=array();
if($fatlossdata['total_food']>0)
{		
	$message="";
	if($fatlossdata['type']=="Snack")
	{						
		if($fatlossdata['iscalorieOk']==0&&$this->session->userdata('sex')=="Male")
		{			
			if($fatlossdata['total_calories']<150)
			$message.="Snack portion size too small<br />";
			else if($fatlossdata['total_calories']>250)
			$message.="Snack portion size too large<br />";
			
		}
		else if($fatlossdata['iscalorieOk']==0&&$this->session->userdata('sex')=="Female")
		{
			if($fatlossdata['total_calories']<150)
			$message.="Snack portion size too small<br />";
			else if($fatlossdata['total_calories']>250)
			$message.="Snack portion size too large<br />";
		}
	}
	else
	{		
		/////////////////////////////calories///////////////////
		if($fatlossdata['iscalorieOk']==0&&$this->session->userdata('sex')=="Male")
		{			
			if($fatlossdata['total_calories']<300)
			$message.="Overall, portion sizes too small<br />";
			else if($fatlossdata['total_calories']>550)
			$message.="Overall, portion sizes too large<br />";
			
		}
		else if($fatlossdata['iscalorieOk']==0&&$this->session->userdata('sex')=="Female")
		{
			if($fatlossdata['total_calories']<250)
			$message.="Overall, portion sizes too small<br />";
			else if($fatlossdata['total_calories']>450)
			$message.="Overall, portion sizes too large<br />";
		}
		
		/////////////////////////////fat///////////////////
		if($fatlossdata['isfatOK']==0&&$this->session->userdata('sex')=="Male")
		{			
			if($fatlossdata['total_fat']>21.4)
			$message.="Fat portion too large<br />";						
		}
		else if($fatlossdata['isfatOK']==0&&$this->session->userdata('sex')=="Female")
		{
			if($fatlossdata['total_fat']>17.5)
			$message.="Fat portion too large<br />";
		}
		/////////////////////////////carb///////////////////
		if($fatlossdata['iscarbsOk']==0&&$this->session->userdata('sex')=="Male")
		{			
			if($fatlossdata['total_carb']>50)
			$message.="Carb portion size too large<br />";			
		}
		else if($fatlossdata['iscarbsOk']==0&&$this->session->userdata('sex')=="Female")
		{
			if($fatlossdata['total_carb']>45)
			$message.="Carb portion size too large<br />";
		}
		/////////////////////protein////////////////
		if($fatlossdata['isproteingOk']==0&&$this->session->userdata('sex')=="Male")
		{			
			if($fatlossdata['total_protein']<15)
			$message.="Protein portion size too small<br />";						
		}
		else if($fatlossdata['isproteingOk']==0&&$this->session->userdata('sex')=="Female")
		{
			if($fatlossdata['total_protein']<12)
			$message.="Protein portion size too small<br />";
		}
		/////////////////////end/////////////////////				
	}
	if($fatlossdata['total_carb']<3)
	$message.="Need a Fast Carb or Slow Carb<br />";
	
	$returndata['message']=base64_encode($message);	
}

if($fatlossdata['total_food']>0&&$fatlossdata['isfatlosplate']==1)
$returndata['flag']=1;//fatloss plage
else if($fatlossdata['total_food']>0&&$fatlossdata['isfatlosplate']==0)
$returndata['flag']=0;//not fatloss plage
else
$returndata['flag']=2;//default fatloss plage
echo json_encode($returndata);
?>