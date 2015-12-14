<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');
class journal_model extends Model
{

	private $CI;
	private $days = array(	'Sun' => 'weekends',
							'Mon' => 'weekdays',
							'Tue' => 'weekdays',
							'Wed' => 'weekdays',
							'Thu' => 'weekdays',
							'Fri' => 'weekdays',
							'Sat' => 'weekends');
							
	public static $lastmealtaken = "";						

	function __construct()
	{
		parent::Model();
		$this->fatsecret = new FatSecretAPI(API_KEY, API_SECRET);
		$this->CI =& get_instance();
		
		error_reporting(0);					
		////////////////////////////////////////////						
		if(strlen($this->session->userdata('timezone'))>0)
		date_default_timezone_set($this->session->userdata('timezone'));		   				   	
		/////////////////////////////////////////////		   						
		
	}
	function getFoodInformation($food_id)
	{
		$url = BASE_URL . 'method=food.get&food_id='.$food_id;
		$temp=$this->fatsecret->requestapi($url,$this->session->userdata('auth_token'),$this->session->userdata('auth_secret'));				
		return $temp; 
	}
	function getFatlossSystem($journalItem,$type)
	{						
		$fatloss=array();
		$fattag=0;
		for($i=0;$i<count($journalItem);$i++)
		{
			if(!empty($journalItem[$i]->items))
			for($j=0;$j<count($journalItem[$i]->items);$j++)
			{				
				if($journalItem[$i]->items[$j]->food_id)
				{					
				/////////////////////////////////////////////////////////												
					try 
					{												
						$sql="select * from food_description where food_id='".$journalItem[$i]->items[$j]->food_id."' and measurement_description='".stripslashes($journalItem[$i]->items[$j]->serving)."'";	
						$tempfod=$this->db->query($sql)->row_array();
						
						if(!empty($tempfod)) //if found in database
						{
							$fatloss[$fattag] = $tempfod;
							$fatloss[$fattag]['qty']=$journalItem[$i]->items[$j]->qty;						
							$fattag++;
						}
						else  //call api for information if it not stored in database
						{
							$temp=$this->getFoodInformation($journalItem[$i]->items[$j]->food_id);																								
							if(!empty($temp['servings'][0]['serving']))
							{
								for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
								{
									$tempservice=$temp['servings'][0]['serving'][$k];
									if($tempservice['measurement_description']==stripslashes($journalItem[$i]->items[$j]->serving))
									{
										$fatloss[$fattag] = $tempservice;
										$fatloss[$fattag]['qty']=$journalItem[$i]->items[$j]->qty;
										$fattag++;
									}
								}
							}
						}											
					} 
					catch (Exception $ex) 
					{
						$result['error'] = $ex->getMessage();
					}	
				/////////////////////////////////////////////////////////	
				}					
			}
		}		
		
///###########################################applying formula###################################//		
		$total_calories=0;		
		$total_fat=0;				
		$total_carb=0;
		$dietary_fiber=0;
		$sugar=0;		
		$total_protein=0;
		$total_sodium=0;
		
		$saturated_fat=0;	
		$polyunsaturated_fat=0;	
		$monounsaturated_fat=0;	
		$trans_fat=0;	
		$cholesterol=0;	
		$potassium=0;	
		$calcium=0;	
		$iron=0;
		
		foreach($fatloss as $key=>$value)
		{			
			$total_calories+=($value['calories']/$value['number_of_units'])*$value['qty'];
			$total_fat+=($value['fat']/$value['number_of_units'])*$value['qty'];						
			$total_carb+=($value['carbohydrate']/$value['number_of_units'])*$value['qty'];
			
			if(isset($value['fiber']))
			$dietary_fiber+=($value['fiber']/$value['number_of_units'])*$value['qty'];			
			if(isset($value['sugar']))
			$sugar+=($value['sugar']/$value['number_of_units'])*$value['qty'];
			
			$total_protein+=($value['protein']/$value['number_of_units'])*$value['qty'];						
			$total_sodium+=($value['sodium']/$value['number_of_units'])*$value['qty'];
			
			$saturated_fat+=($value['saturated_fat']/$value['number_of_units'])*$value['qty'];
			$polyunsaturated_fat+=($value['polyunsaturated_fat']/$value['number_of_units'])*$value['qty'];
			$monounsaturated_fat+=($value['monounsaturated_fat']/$value['number_of_units'])*$value['qty'];
			$trans_fat+=($value['trans_fat']/$value['number_of_units'])*$value['qty'];
			$cholesterol+=($value['cholesterol']/$value['number_of_units'])*$value['qty'];
			$potassium+=($value['potassium']/$value['number_of_units'])*$value['qty'];
			$calcium+=($value['calcium']/$value['number_of_units'])*$value['qty'];
			$iron+=($value['iron']/$value['number_of_units'])*$value['qty'];
		}						
			
		$fatlossystem['total_calories']=$total_calories;
		$fatlossystem['total_fat']=$total_fat;
		$fatlossystem['total_carb']=$total_carb;
		$fatlossystem['dietary_fiber']=$dietary_fiber;		
		$fatlossystem['sugar']=$sugar;
		$fatlossystem['total_protein']=$total_protein;
		$fatlossystem['total_sodium']=$total_sodium;
		
		$fatlossystem['total_saturated_fat']=$saturated_fat;
		$fatlossystem['total_polyunsaturated_fat']=$polyunsaturated_fat;
		$fatlossystem['total_monounsaturated_fat']=$monounsaturated_fat;
		$fatlossystem['total_trans_fat']=$trans_fat;
		$fatlossystem['total_cholesterol']=$cholesterol;
		$fatlossystem['total_potassium']=$potassium;
		$fatlossystem['total_calcium']=$calcium;
		$fatlossystem['total_iron']=$iron;
		
		if(isset($journalItem[0]->skipped)&&$journalItem[0]->skipped==1)
		$fatlossystem['isSkip']=1;
		else if($type!="Exercise")		
		{												
			$fatlossystem['lastmealtaken']=$this->lastmealtaken;
			$this->lastmealtaken=$journalItem[0]->time;
			$fatlossystem['isSkip']=0;	
		}

		//
		////////////////////////detect fat loss plate//////////////////
		$errormessage=array();
		$iscalorieOk=0;
		$isproteingOk=0;
		$iscarbsOk=0;
		$isfatOK=0;
				
		if($this->session->userdata('sex')=="Male")
		{
			
			if($type=="Snack"&&$total_calories>=150&&$total_calories<=250)
			$iscalorieOk=1;
			else if($total_calories>=300&&$total_calories<=550&&$type!="Snack")
			$iscalorieOk=1;

			if($total_fat>=0&&$total_fat<=21.4)
			$isfatOK=1;

			if($total_carb>=3&&$total_carb<=50)
			$iscarbsOk=1;

			if($total_protein>=15)
			$isproteingOk=1;

			if($type=="Snack")
			{
			 $fatlossystem['calories1']=150;
			 $fatlossystem['calories2']=250;				
			}
			else
			{
			 $fatlossystem['calories1']=300;
			 $fatlossystem['calories2']=550;
			}
			
			$fatlossystem['fat1']=0;			
			$fatlossystem['fat2']=21.4;
			$fatlossystem['carb1']=0;
			$fatlossystem['carb2']=50;
			$fatlossystem['protein']=15;			
		}
		else if($this->session->userdata('sex')=="Female")
		{
			if($type=="Snack"&&$total_calories>=150&&$total_calories<=250)
			$iscalorieOk=1;
			else if($total_calories>=250&&$total_calories<=450&&$type!="Snack")
			$iscalorieOk=1;

			if($total_fat>=0&&$total_fat<=17.5)
			$isfatOK=1;

			if($total_carb>=3&&$total_carb<=45)
			$iscarbsOk=1;

			if($total_protein>=12)
			$isproteingOk=1;
			
			if($type=="Snack")
			{
			 $fatlossystem['calories1']=150;
			 $fatlossystem['calories2']=250;				
			}
			else
			{
			 $fatlossystem['calories1']=250;
			 $fatlossystem['calories2']=450;
			}
			
			$fatlossystem['fat1']=0;			
			$fatlossystem['fat2']=17.4;
			$fatlossystem['carb1']=0;
			$fatlossystem['carb2']=45;
			$fatlossystem['protein']=12;
		}
		
		$fatlossystem['iscalorieOk']=$iscalorieOk;
		$fatlossystem['isfatOK']=$isfatOK;
		$fatlossystem['iscarbsOk']=$iscarbsOk;
		$fatlossystem['isproteingOk']=$isproteingOk;		
		
		$isfatlosplate=0;	
		if($iscalorieOk==1&&$isfatOK==1&&$iscarbsOk==1&&$isproteingOk==1&&$type!="Snack")
		$isfatlosplate=1;
		else if($iscalorieOk==1&&$type=="Snack")
		$isfatlosplate=1;
		else
		$isfatlosplate=0;		
		
		$fatlossystem['isfatlosplate']=$isfatlosplate;
		$fatlossystem['type']=$type;		
///###########################################applying formula###################################//		
		return $fatlossystem;
	}
	private function maintainExercise($uid)
	{				
		$today= date('Y-m-d');				
		$day = date("D",strtotime($today));
		
		$sql="select * from user_times where user_id='".$uid."' and type='Exercise' and week_period='".$this->dayType($day)."'";
		$etime=	$this->db->query($sql)->result();
		$utId=$etime[0]->utID;
		
		////////////////////////////////////////////////////////////////////
		$sql="select * from daily_exercise where uid='".$uid."' and week_day='".$day."'";
		$daily_exercise=$this->db->query($sql)->result();

		$sql="select * from maintain_exercise where uid='".$uid."' and date='".$today."' and exercise_name='cardio_time' and isinsert='1'";
		$allexercise= $this->db->query($sql)->result();
		if(empty($allexercise))
		{			
			
			if(isset($daily_exercise[0]->cardio_time)&&strlen($daily_exercise[0]->cardio_time)>0)
			{
				$sql="insert into maintain_exercise set 
					exercise_name='cardio_time',
					isinsert='1',
					uid='".$uid."',
					date='".$today."'";
				$this->db->query($sql);
				
				$sql="insert into user_journal set
				utID='".$utId."',
				name='36 minutes', 
				date='".$today."',
				time='".$daily_exercise[0]->cardio_time."',
				createdBy='".$uid."',  
				createdOn='".date("Y-m-d H:i:s",strtotime($today))."'";
				
				$this->db->query($sql);
				$cardioid = $this->db->insert_id();
				
				$sql="insert into user_journal_items set
				ujID='".$cardioid."',
				entryname='Cardio', 				
				createdBy='".$uid."',  
				createdOn='".date("Y-m-d H:i:s",strtotime($today))."'";				
				$this->db->query($sql);
								
			}
		}
		
		$sql="select * from maintain_exercise where uid='".$uid."' and date='".$today."' and exercise_name='resistance_time' and isinsert='1'";
		$resisexercise= $this->db->query($sql)->result();
		if(empty($resisexercise))
		{			
			if(isset($daily_exercise[0]->resistance_time)&&strlen($daily_exercise[0]->resistance_time)>0)
			{
				$sql="insert into maintain_exercise set 
					exercise_name='resistance_time',
					isinsert='1',
					uid='".$uid."',
					date='".$today."'";
				$this->db->query($sql);
				
				$sql="insert into user_journal set
				utID='".$utId."',
				name='24 minutes', 
				date='".$today."',
				time='".$daily_exercise[0]->resistance_time."',
				createdBy='".$uid."',  
				createdOn='".date("Y-m-d H:i:s",strtotime($today))."'";
				
				$this->db->query($sql);
				$resistanceid = $this->db->insert_id();
				
				$sql="insert into user_journal_items set
				ujID='".$resistanceid."',
				entryname='Resistance', 				
				createdBy='".$uid."',  
				createdOn='".date("Y-m-d H:i:s",strtotime($today))."'";				
				$this->db->query($sql);
			}
		}
		////////////////////////////////										
	}	
	public function setSleepLayout($active)
	{
		$sql = "SELECT * FROM user_journel_sleep WHERE user_id='".$this->session->userdata('id')."' and date=$active";
		$sleeptime=$this->db->query($sql)->result();									
		$slpTime=array();
		for($i=0;$i<count($sleeptime);$i++)
		{									
			$slpTime[$i]=new stdClass;
			$slpTime[$i]->type="sleeptime";
			$slpTime[$i]->time=$sleeptime[$i]->from_time;
			
			$slpTime[$i]->id=$sleeptime[$i]->id;
			$slpTime[$i]->user_id=$sleeptime[$i]->user_id;
			$slpTime[$i]->from_time=$sleeptime[$i]->from_time;
			$slpTime[$i]->to_time=$sleeptime[$i]->to_time;
			$slpTime[$i]->date=$sleeptime[$i]->date;
		}
	  return $slpTime;		
	}
	private function _getJournalEnties($mDate,$date,$day,$wflag=0)
	{										
		/////////////////////////////////////////////////////////////////////		
		$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes,".
				"			".$mDate." AS date ". " FROM	user_custom_times" .
				" WHERE 	week_period='".$this->days[$day]."' AND user_id=".$this->session->userdata('id') .
				" AND date=$date ORDER BY outId";		 
						
		$custome_user_time=	$this->db->query($query)->result();
		
		$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes," .
				"			".$mDate." AS date" .
				" FROM		user_times" .
				" WHERE		week_period='".$this->days[$day]."' AND user_id=".$this->session->userdata('id') .
				" AND isdisable=0 ORDER BY time";
		
		$this->user_times = $this->db->query($query)->result();						
		
		$testUserTime=array();				
		if(!empty($custome_user_time))
		{
			$flagwd=1;
			for($i=0;$i<count($custome_user_time);$i++)
			{
			 	if($custome_user_time[$i]->type=="Snack")
			 	{
					$testUserTime[$custome_user_time[$i]->type.($flagwd)]['time']=$custome_user_time[$i]->time;
				 	$testUserTime[$custome_user_time[$i]->type.($flagwd)]['hour']=$custome_user_time[$i]->hour;
				 	$testUserTime[$custome_user_time[$i]->type.($flagwd)]['minutes']=$custome_user_time[$i]->minutes;
				 	$testUserTime[$custome_user_time[$i]->type.($flagwd)]['date']=$custome_user_time[$i]->date;
			 		$flagwd++;				 	
			 	}			 	
			 	else
			 	{				
					$testUserTime[$custome_user_time[$i]->type]['time']=$custome_user_time[$i]->time;
				 	$testUserTime[$custome_user_time[$i]->type]['hour']=$custome_user_time[$i]->hour;
				 	$testUserTime[$custome_user_time[$i]->type]['minutes']=$custome_user_time[$i]->minutes;
				 	$testUserTime[$custome_user_time[$i]->type]['date']=$custome_user_time[$i]->date;
			 	}
		    }
		    		   
		    $temp="";	
		    $flagwd=1;	    
			for($i=0;$i<count($this->user_times);$i++)
			{				
				$temp=$this->user_times[$i]->type;
				if($this->user_times[$i]->type=="Snack")
				$temp=($this->user_times[$i]->type).($flagwd++);				
												
				if(isset($testUserTime[$temp])&&($this->user_times[$i]->week_period==$this->days[$day]))
				{
					$this->user_times[$i]->time=$testUserTime[$temp]['time'];
					$this->user_times[$i]->hour=$testUserTime[$temp]['hour'];
					$this->user_times[$i]->minutes=$testUserTime[$temp]['minutes'];
					$this->user_times[$i]->date=$testUserTime[$temp]['date'];
				}										 
					
			}											  	
		}		
		
		//////////////////adjust exercise time////////commented it for client feedback
		if(str_replace("'", "", $date)==date('Y-m-d'))
		$this->maintainExercise($this->session->userdata('id'));	
		////////////////////////////////////////////////////////////////////////////////////////
		$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
				" FROM		user_journal" .
				" WHERE		`date`=".$date." AND createdBy=".$this->session->userdata('id') .
				" ORDER BY	time";
				
		if ($this->journal = $this->db->query($query)->result())
		{
			for ($y=0; $y < count ($this->journal); $y++)
			{
				$query = "SELECT	*" .
						" FROM		user_journal_items" .
						" WHERE		ujID=".$this->journal[$y]->ujID;
				$this->journal[$y]->items = $this->db->query($query)->result();
			}
		}	
				
		$JOURNALENTRIES[] = array();
		for ($y=0, $yy=0; $y < count ($this->user_times); $y++, $yy++)
		{
			$JOURNALENTRIES[$yy]			= $this->user_times[$y];
			$JOURNALENTRIES[$yy]->journal	= false;			
			for ($x=0; $x < count ($this->journal); $x++)
			{
				if ($JOURNALENTRIES[$yy]->utID == $this->journal[$x]->utID)
				{
					if ($JOURNALENTRIES[$yy]->time == $this->journal[$x]->time)
					{						
						
						//$JOURNALENTRIES[$yy]->journal[] = $this->journal[$x];																		
						$JOURNALENTRIES[$yy]->journal[] = $this->journal[$x];
						
					}
					else
					{											
						$yy++;
						$JOURNALENTRIES[$yy]->utID		= $this->user_times[$y]->utID;
						$JOURNALENTRIES[$yy]->type		= $this->user_times[$y]->type;
						$JOURNALENTRIES[$yy]->date		= $this->user_times[$y]->date;
						$JOURNALENTRIES[$yy]->time		= $this->journal[$x]->time;
						$JOURNALENTRIES[$yy]->journal[]	= $this->journal[$x];
					}
				}
			}
		}		
		// // get any image for these journal entries
		if (!empty($JOURNALENTRIES))
		{
			for ($x=0; $x < count($JOURNALENTRIES); $x++)
			{				
				$query = "SELECT	*" .
						" FROM 		user_journal_images" .
						" WHERE		utID=".$JOURNALENTRIES[$x]->utID." AND ".
						"			date='".$JOURNALENTRIES[$x]->date."' AND ".
						"			time='".$JOURNALENTRIES[$x]->time."'";
				$JOURNALENTRIES[$x]->image = $this->db->query($query)->result();
			}
		}
		
		//////////////////get sleep layout//////////////
		if($wflag!=1)
		{
			$slpTime=array();
			$slpFlag=count($JOURNALENTRIES);
			$slpTime=$this->setSleepLayout($date);
			for($i=0;$i<count($slpTime);$i++)
			$JOURNALENTRIES[$slpFlag++]=$slpTime[$i];
		}
		////////////////////////////////////////activate fat loss plate////////		
		usort($JOURNALENTRIES, array("journal_model", "cmpjtime"));
		$tempjournal=array();
		$mainarray=array();
		$tjc=0;
		for($i=0;$i<count($JOURNALENTRIES);$i++)
		{		
			if(!empty($JOURNALENTRIES[$i]->journal))
			$tempjournal[$tjc++]=$JOURNALENTRIES[$i]->utID;
		}
		
		$tjc=0;				
		for($i=0;$i<count($JOURNALENTRIES);$i++)
		{									
			if (in_array($JOURNALENTRIES[$i]->utID, $tempjournal)) 
			{
				if(!empty($JOURNALENTRIES[$i]->journal))
				{
				 $mainarray[$tjc]=$JOURNALENTRIES[$i];
				 $mainarray[$tjc++]->food_description=$this->getFatlossSystem($JOURNALENTRIES[$i]->journal,$JOURNALENTRIES[$i]->type);
				}
			}
			else
			$mainarray[$tjc++]=$JOURNALENTRIES[$i];			
		}			
		/////////////////////////////////////////		
		return $mainarray;
	}

	public function get($when,$nextDay="")
	{		
		switch ($when)
		{			
			case 'yesterday':
			$day	= date("D",strtotime("-1 day"));
			$date	= "'".date("Y-m-d",strtotime("-1 day"))."'";
			$mDate	= "DATE_ADD(DATE('".date("Y-m-d")."'),INTERVAL -1 DAY)";
			$times = $this->_getJournalEnties($mDate,$date,$day);
			break;

			case 'today':
			$day	= date("D");
			$date	= "'".date("Y-m-d")."'";
			$mDate	= "DATE(".$date.")";
			$times = $this->_getJournalEnties($mDate,$date,$day);			
			break;

			case 'tomorrow':
			$day	= date("D",strtotime("+1 day"));
			$date	= "'".date("Y-m-d",strtotime("+1 day"))."'";
			/*$tDate	= "select DATE_ADD(CURDATE(),INTERVAL +1 DAY) as tomor";
			$dayofweek	= $this->db->query($tDate)->result();			
			$date="'".$dayofweek[0]->tomor."'";						
			*/
			$mDate	= "DATE_ADD(DATE('".date("Y-m-d")."'),INTERVAL +1 DAY)";
			$times = $this->_getJournalEnties($mDate,$date,$day);
			break;

			case "week":
			$times = array();
			$todate	= "'".date("Y-m-d")."'";
			
			if(strlen($nextDay)>0)
			{
				$omsql="SELECT DAYOFWEEK(DATE('".$nextDay."')) as today";
				$dayofweek	= $this->db->query($omsql)->result();			
				$dayindex=intval($dayofweek[0]->today);
			}
			else
			{	
				$omsql="SELECT DAYOFWEEK(DATE(".$todate.")) as today";
				$dayofweek	= $this->db->query($omsql)->result();			
				$dayindex=intval($dayofweek[0]->today);
			}
			
			/*
			if(($dayindex-1)<1)
			$dayindex=7;
			else
			$dayindex=$dayindex-1;
			*/		
			
			$j=0;
			$fullweek=array();
			for ($i=-(($dayindex-1));; $i++)
			{
				if($j==7)	
				break;
					if(strlen($nextDay)>0)
					{
						$query	= "SELECT	DATE_ADD(DATE('".$nextDay."'),INTERVAL ".$i." DAY) AS today," .
							"			DAYNAME(DATE_ADD(DATE('".$nextDay."'),INTERVAL ".$i." DAY)) AS dayofweek";
					}
					else
					{
					$query	= "SELECT	DATE_ADD(DATE(".$todate."),INTERVAL ".$i." DAY) AS today," .
							"			DAYNAME(DATE_ADD(DATE(".$todate."),INTERVAL ".$i." DAY)) AS dayofweek";				
					}		
				
				$date	= $this->db->query($query)->result();								

				$fullweek[$j]=$date[0]->today;
				
				$day	= substr($date[0]->dayofweek,0,3);
				
				//////////////////////////////for weekly calander//
				if(strlen($nextDay)>0)
				{	
					$xDate	= "DATE_ADD(DATE('".$nextDay."'),INTERVAL ".$i." DAY)";
					$mDate	= "DATE('".$nextDay."')";
				}
				else
				{
					$xDate	= "DATE_ADD(DATE(".$todate."),INTERVAL ".$i." DAY)";
					$mDate	= "DATE(".$todate.")";
				}
				
				if ($times[$j] = $this->_getJournalEnties($mDate,$xDate,$day,1));
				{
					$times[$j][0]->today		= $date[0]->today;
					$times[$j][0]->dayofweek	= $date[0]->dayofweek;
				}
			 $j++;
			}
			$times['week']=$fullweek;				
			break;

			case "month":
			$times = array();
			$todate	= "'".date("Y-m-d")."'";	
			
			if(strlen($nextDay)>0)
			$firstDay=substr($nextDay,0,8)."01";						
			else
			$firstDay	= date('y').'-'.date('m').'-01';			
			
			$dayOfWeek	= date("N",strtotime($firstDay));
			$dayOfMonth	= date("j",strtotime($firstDay));
			$numDays	= date("t",strtotime($firstDay));
			
			$fullmonth=array();
			$jt=0;
			for ($i=-$dayOfWeek; $i < $numDays; $i++)
			{
				$query = "SELECT	DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY) AS today," .
						"			DAYNAME(DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY)) AS dayofweek," .
						"			DAYOFMONTH(DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY)) AS dayofmonth";
				$date	= $this->db->query($query)->result();

				$day	= substr($date[0]->dayofweek,0,3);
				$xDate	= "DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY)";
				if(strlen($nextDay)>0)
				$mDate	= "DATE('".$nextDay."')";
				else
				$mDate	= "DATE(".$todate.")";
				if ($times[$i] = $this->_getJournalEnties($mDate,$xDate,$day,1));
				{
					$times[$i][0]->today		= $date[0]->today;
					$times[$i][0]->dayofweek	= $date[0]->dayofweek;
					$times[$i][0]->dayofmonth	= $date[0]->dayofmonth;					
					$fullmonth[$jt++]=$date[0]->today;
				}
			}
			$times['month']=$fullmonth;
			break;
			default:			
			$day	= date("D",strtotime($when));
			$date	= "'".date("Y-m-d",strtotime($when))."'";
			$mDate	= "DATE('".date("Y-m-d",strtotime($when))."')";			
			$times = $this->_getJournalEnties($mDate,$date,$day);
			break;
		}
		return $times;
	}

	public function __get($when)
	{
		$times = false;
		switch ($when)
		{
			default:
			break;
			
			case "yesterday":
			$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes," .
					"			DATE_ADD(CURDATE(),INTERVAL -1 DAY) AS date" .
					" FROM		user_times" .
					" WHERE		week_period='".$this->days[date("D",strtotime("-1 day"))]."' AND user_id=".$this->session->userdata('id').
					" ORDER BY	time";
			if (($times = $this->db->query($query)->result()) !== false)
			{
				for ($x=0; $x < count ($times); $x++)
				{
					$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
							" FROM		user_journal" .
							" WHERE		utID=".$times[$x]->utID." AND `date`='".date("Y-m-d",strtotime("-1 day"))."' AND createdBy=".$this->session->userdata('id');
					if (($times[$x]->journal = $this->db->query($query)->result()) !== false)
					{
						for ($y=0; $y < count ($times[$x]->journal); $y++)
						{
							$query = "SELECT	*" .
									" FROM		user_journal_items" .
									" WHERE		ujID=".$times[$x]->journal[$y]->ujID;
							$times[$x]->journal[$y]->items = $this->db->query($query)->result();

							if ($y == 0)
							{
								// get any image for this journal entry
								$query = "SELECT	*" .
										" FROM 		user_journal_images" .
										" WHERE		utID=".$times[$x]->journal[0]->utID." AND ".
										"			date='".$times[$x]->journal[0]->date."' AND ".
										"			time='".$times[$x]->journal[0]->time."'";
								$times[$x]->image = $this->db->query($query)->result();
							}
						}
					}
				}
			}
			break;

			case "today":
			return $this->_getJournalEnties($when);
			$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes," .
					"			CURDATE() AS date" .
					" FROM		user_times" .
					" WHERE		week_period='".$this->days[date("D")]."' AND" .
					"			user_id=".$this->session->userdata('id').
					" ORDER BY	time";
			if (($times = $this->db->query($query)->result()) !== false)
			{
				for ($x=0; $x < count ($times); $x++)
				{
					$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
							" FROM		user_journal" .
							" WHERE		utID=".$times[$x]->utID." AND" .
							"			`date`='".date("Y-m-d")."' AND" .
							"			createdBy=".$this->session->userdata('id');
					if (($times[$x]->journal = $this->db->query($query)->result()) !== false)
					{
						for ($y=0; $y < count ($times[$x]->journal); $y++)
						{
							$query = "SELECT	*" .
									" FROM		user_journal_items" .
									" WHERE		ujID=".$times[$x]->journal[$y]->ujID;
							$times[$x]->journal[$y]->items = $this->db->query($query)->result();

							if ($y == 0)
							{
								// get any image for this meal
								$query = "SELECT	*" .
										" FROM 		user_journal_images" .
										" WHERE		utID=".$times[$x]->journal[0]->utID." AND ".
										"			date='".$times[$x]->journal[0]->date."' AND ".
										"			time='".$times[$x]->journal[0]->time."'";
								$times[$x]->image = $this->db->query($query)->result();
							}
						}
					}
				}
			}
			break;

			case "tomorrow":
			$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes," .
					"			DATE_ADD(CURDATE(),INTERVAL +1 DAY) AS date" .
					" FROM		user_times" .
					" WHERE		week_period='".$this->days[date("D",strtotime("+1 day"))]."' AND user_id=".$this->session->userdata('id') .
					" ORDER BY	time";
			if (($times = $this->db->query($query)->result()) !== false)
			{
				for ($x=0; $x < count ($times); $x++)
				{
					$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
							" FROM		user_journal" .
							" WHERE		utID=".$times[$x]->utID." AND `date`='".date("Y-m-d",strtotime("+1 day"))."' AND createdBy=".$this->session->userdata('id');
					if (($times[$x]->journal = $this->db->query($query)->result()) !== false)
					{
						for ($y=0; $y < count ($times[$x]->journal); $y++)
						{
							$query = "SELECT	*" .
									" FROM		user_journal_items" .
									" WHERE		ujID=".$times[$x]->journal[$y]->ujID;
							$times[$x]->journal[$y]->items = $this->db->query($query)->result();

							if ($y == 0)
							{
								// get any image for this meal
								$query = "SELECT	*" .
										" FROM 		user_journal_images" .
										" WHERE		utID=".$times[$x]->journal[0]->utID." AND ".
										"			date='".$times[$x]->journal[0]->date."' AND ".
										"			time='".$times[$x]->journal[0]->time."'";
								$times[$x]->image = $this->db->query($query)->result();
							}
						}
					}
				}
			}
			break;

			case "week":
			$times = array();
			for ($i=0; $i < 7; $i++)
			{
				$query	= "SELECT	DATE_ADD(CURDATE(),INTERVAL ".$i." DAY) AS today," .
						"			DAYNAME(DATE_ADD(CURDATE(),INTERVAL ".$i." DAY)) AS dayofweek";
				$date	= $this->db->query($query)->result();
				$query	= "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
						" FROM		user_times" .
						" WHERE		week_period='".$this->days[substr($date[0]->dayofweek,0,3)]."' AND user_id=".$this->session->userdata('id') .
						" ORDER BY	time";
				if (($times[$i]	= $this->db->query($query)->result()) !== false)
				{
					for ($x=0; $x < count ($times[$i]); $x++)
					{
						$query	= "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
								" FROM		user_journal" .
								" WHERE		utID=".$times[$i][$x]->utID." AND `date`=DATE_ADD(CURDATE(),INTERVAL ".$i." DAY) AND createdBy=".$this->session->userdata('id');
						if (($times[$i][$x]->journal = $this->db->query($query)->result()) !== false)
						{
							for ($y=0; $y < count ($times[$i][$x]->journal); $y++)
							{
								$query = "SELECT	*" .
										" FROM		user_journal_items" .
										" WHERE		ujID=".$times[$i][$x]->journal[$y]->ujID;
								$times[$i][$x]->journal[$y]->items = $this->db->query($query)->result();
							}
						}
					}
				}

				$times[$i][0]->today		= $date[0]->today;
				$times[$i][0]->dayofweek	= $date[0]->dayofweek;
			}
			break;

			case "month":
			$times = array();
			$firstDay	= date('y').'-'.date('m').'-01';
			$dayOfWeek	= date("N");
			$dayOfMonth	= date("j");
			$numDays	= date("t");
			for ($i=-$dayOfWeek; $i < $numDays; $i++)
			{
				$query = "SELECT	DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY) AS today," .
						"			DAYNAME(DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY)) AS dayofweek," .
						"			DAYOFMONTH(DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY)) AS dayofmonth";
				$date	= $this->db->query($query)->result();

				$query	= "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
						" FROM		user_times" .
						" WHERE		week_period='".$this->days[substr($date[0]->dayofweek,0,3)]."' AND user_id=".$this->session->userdata('id') .
						" ORDER BY	time";
				if (($times[$i]	= $this->db->query($query)->result()) !== false)
				{
					for ($x=0; $x < count ($times[$i]); $x++)
					{
						$query	= "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
								" FROM		user_journal" .
								" WHERE		utID=".$times[$i][$x]->utID." AND `date`=DATE_ADD('".$firstDay."',INTERVAL ".$i." DAY) AND createdBy=".$this->session->userdata('id');
						if (($times[$i][$x]->journal = $this->db->query($query)->result()) !== false)
						{
							for ($y=0; $y < count ($times[$i][$x]->journal); $y++)
							{
								$query = "SELECT	*" .
										" FROM		user_journal_items" .
										" WHERE		ujID=".$times[$i][$x]->journal[$y]->ujID;
								$times[$i][$x]->journal[$y]->items = $this->db->query($query)->result();
							}
						}
					}
				}
				
				$times[$i][0]->today		= $date[0]->today;
				$times[$i][0]->dayofweek	= $date[0]->dayofweek;
				$times[$i][0]->dayofmonth	= $date[0]->dayofmonth;
			}
			break;
		}

		return $times;
	}

	public function getJournalEntry($where,$limit=1)
	{
		$where[] = "uj.createdBy=".$this->session->userdata('id');
		$query = "SELECT	*" .
				" FROM		user_journal uj, user_times ut" .
				" WHERE		ut.utID=uj.utID AND ".implode(" AND ",$where) .
				" group by uj.name LIMIT	" . $limit;		
		return $this->db->query($query)->result();
	}

	public function getJournalItems($where,$limit=1)
	{
		$where[] = "uji.createdBy=".$this->session->userdata('id');
		$query = "SELECT	*" .
				" FROM		user_journal uj, user_times ut, user_journal_items uji" .
				" WHERE		uj.utID=ut.utID AND uj.ujID=uji.ujID AND " . implode(" AND ",$where) .
				" GROUP BY	uji.food_id" .
				" ORDER BY uj.ujID DESC LIMIT " . $limit;		
		return $this->db->query($query)->result();
	}

	public function getJournal($utID,$where)
	{
		$query = "SELECT	*" .
				" FROM		user_times" .
				" WHERE		utID=$utID" .
				" ORDER BY	time";
		if (($times = $this->db->query($query)->result()) !== false)
		{
			$where[] = array("key" => "utID",		"op" => "=", "value" => $times[0]->utID,				"text" => false);
			$where[] = array("key" => "createdBy",	"op" => "=", "value" => $this->session->userdata('id'),	"text" => false);
			$query = "SELECT	*, HOUR(time) AS hour, MINUTE(time) AS minutes" .
					" FROM		user_journal" .
					" WHERE		".implode(" AND ",$this->buildQuery($where));			
			if (($times[0]->journal = $this->db->query($query)->result()) !== false)
			{
				$times[0]->time = $times[0]->journal[0]->time;
				for ($y=0; $y < count ($times[0]->journal); $y++)
				{
					$query = "SELECT	*" .
							" FROM		user_journal_items" .
							" WHERE		ujID=".$times[0]->journal[$y]->ujID;
					$times[0]->journal[$y]->items = $this->db->query($query)->result();

					if ($y == 0)
					{
						// get any image for this meal
						$query = "SELECT	*" .
								" FROM 		user_journal_images" .
								" WHERE		utID=".$times[0]->journal[0]->utID." AND ".
								"			date='".$times[0]->journal[0]->date."' AND ".
								"			time='".$times[0]->journal[0]->time."'";
						$times[0]->image = $this->db->query($query)->result();
					}
				}
			}
		}
		else
		{
			return false;
		}

		return $times;
	}

	/*
	 * date				2010-09-09
	 * entryname[0][]	{new item}
	 * entryname[144][]	Boiled Egg
	 * entryname[144][]	Toasted Whole Wheat Bread
	 * food_id[0][]		{9999}
	 * food_id[144][]	3094
	 * food_id[144][]	3591
	 * original_ujID[]	144
	 * qty[0][]			{9}
	 * qty[144][]		2
	 * qty[144][]		1
	 * serving[0][]		{serving}
	 * serving[144][]	jumbo
	 * serving[144][]	thin slice
	 * time				07:30 AM
	 * type				Breakfast
	 * utID				5
	*/
	public function copy($data)
	{
		$this->db->delete("user_journal", array(	'skipped'	=> 1, // delete any 'skipped' journal entry
													'utID'		=> $data['utID'],
													'date'		=> $data['date'],
													'time'		=> date("H:i",strtotime($data['time'])),
													'createdBy'	=> $this->session->userdata('id')));

		$dataU				= array();
		$dataU['date']		= $data['date'];
		if (strtotime($data['date']) > strtotime(date("Y-m-d")))
		{	// if copying to future date then set as.....
			$dataU['planned'] = 1;	// .....planned meal
		}
		$dataU['time']		= date("H:i",@strtotime($data['time']));
		$dataU['utID']		= $data['utID'];
		$dataU['createdBy']	= $this->session->userdata('id');
		$dataU['createdOn']	= date("Y-m-d H:i:s");
		foreach ($data['entryname'] AS $ujID => $entry)
		{
			$id[$ujID] = true;
		}
		$insert_ujID	= array();
		$image			= false;
		foreach ($id AS $ujID => $entry)
		{
			if ($ujID != 0)
			{
				$query = "SELECT	*" .
						" FROM		user_journal" .
						" WHERE		ujID=".$ujID;
				if (!($journal = $this->db->query($query)->result()))
				{
					show_error("journal_model.php - Invalid journal entry - ".$ujID);
				}
				$dataU['name'] = $journal[0]->name;
				
				// get any image for this journal entry
				if (!$image)
				{
					$image = true;
					$query = "SELECT	*" .
							" FROM		user_journal_images" .
							" WHERE		utID=".$journal[0]->utID." AND ".
							"			date='".$journal[0]->date."' AND ".
							"			time='".$journal[0]->time."'";
					if ($image = $this->db->query($query)->result_array())
					{
						unset($image[0]['ujmID']);
						unset($image[0]['modifiedBy']);
						$image[0]['date']		= $dataU['date'];
						$image[0]['time']		= $dataU['time'];
						$this->addImage($image[0]);
					}
				}
			}

			$this->db->insert("user_journal", $dataU);
			$insert_ujID[$ujID] = $this->db->insert_id();
		}

		foreach ($data['entryname'] AS $ujID => $entry)
		{
			for ($x=0; $x < count($data['entryname'][$ujID]); $x++)
			{
				$dataI				= array();
				$dataI['entryname']	= @$data['entryname'][$ujID][$x];
				$dataI['food_id']	= @$data['food_id'][$ujID][$x];
				$dataI['qty']		= @$data['qty'][$ujID][$x];
				$dataI['serving']	= @$data['serving'][$ujID][$x];
				$dataI['ujID']		= $insert_ujID[$ujID];
				$dataI['createdBy']	= $this->session->userdata('id');
				$dataI['createdOn']	= $dataU['createdOn'];
				$this->db->insert("user_journal_items",$dataI);
			}
		}
	}
	
	function storefoodinformation($food_id)
	{////////////		
		  		  		 
		 $sql="select * from food_list where food_id='".$food_id."'"; 
		 $fd_list = $this->db->query($sql)->result();
		 if(empty($fd_list))
		 {			  			  			  
			  try 
			  {
				$url = BASE_URL . 'method=food.get&food_id='.$food_id;
				$temp=$this->fatsecret->requestapi($url,$this->session->userdata('auth_token'),$this->session->userdata('auth_secret'));		
				
					$sql="insert into food_list set food_id='".$food_id."',food_name='".$temp['food_name']."'";
					$this->db->query($sql);
				
					$sql="select * from food_description where food_id='".$food_id."'"; 
					$fd_des = $this->db->query($sql)->result();				
					if(empty($fd_des))
					{
						if(!empty($temp['servings'][0]['serving']))
						{
							for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
							{
								$tempservice=$temp['servings'][0]['serving'][$k];							
								///////////////////////////////////////////////////////////	
								 $sql="insert into food_description set 
								 food_id='".$food_id."',
								 number_of_units='".$tempservice['number_of_units']."',
								 measurement_description='".mysql_escape_string($tempservice['measurement_description'])."',
								 calories='".$tempservice['calories']."',
								 carbohydrate='".$tempservice['carbohydrate']."',
								 protein='".$tempservice['protein']."',
								 fat='".$tempservice['fat']."',
								 saturated_fat='".$tempservice['saturated_fat']."',
								 polyunsaturated_fat='".$tempservice['polyunsaturated_fat']."',
								 monounsaturated_fat='".$tempservice['monounsaturated_fat']."',
								 trans_fat='".$tempservice['trans_fat']."',
								 cholesterol='".$tempservice['cholesterol']."',
								 sodium='".$tempservice['sodium']."',
								 potassium='".$tempservice['potassium']."',
								 fiber='".$tempservice['fiber']."',
								 sugar='".$tempservice['sugar']."',
								 vitamin_a='".$tempservice['vitamin_a']."',
								 vitamin_c='".$tempservice['vitamin_c']."',					
								 calcium='".$tempservice['calcium']."',
								 iron='".$tempservice['iron']."'";	
								$this->db->query($sql);
								///////////////////////////////////////////////////////////														
							}
						}
					}	
										
				} 
				catch (Exception $ex) 
				{
					$result['error'] = $ex->getMessage();
				}
		}		
	}///////////
	/*
	 * date				YYYY-MM-DD
	 * entryname[0]		array of serving names
	 * food_id[0]		array of food_id's
	 * qty[0]			array of quantities
	 * serving[0]		array of serving sizes
	 * time				HH:ii:ss
	 * type				Breakfast
	 * utID				(int)
	*/
	public function insert($data, $name='')
	{
		
		$this->db->delete("user_journal", array('skipped'	=> 1,	// delete any 'skipped' journal entry
												'utID'		=> $data['utID'],
												'date'		=> $data['date'],
												'time'		=> date("H:i",strtotime($data['time'])),
												'createdBy'	=> $this->session->userdata('id')));
		if (@$data['clear'] == 1)
		{
			$query = "SELECT	*" .
					" FROM		user_journal" .
					" WHERE		utID=".$data['utID']." AND" .
					"			date='".$data['date']."' AND" .
					"			time='".date("H:i",strtotime($data['time']))."' AND" .
					"			createdBy=".$this->session->userdata('id');
//$tmp['trace'] = $query;
//$tmp['error_code'] = 1;
//$tmp['error_msg'] = 'xxxx';
//echo json_encode($tmp);
//exit;
			if ($journalEntry = $this->db->query($query)->result())
			{
				foreach ($journalEntry AS $je)
				{
					$this->db->delete("user_journal",		array('ujID' => $je->ujID));
					$this->db->delete("user_journal_items",	array('ujID' => $je->ujID));
				}
			}

			$this->db->delete("user_journal_images", array(	'utID'		=> $data['utID'], // clear any current images
															'date'		=> $data['date'],
															'time'		=> date("H:i",strtotime($data['time'])),
															'createdBy'	=> $this->session->userdata('id')));
		}

		if (@$_FILES["upload"]["name"])
		{
			if ($_FILES["upload"]['error'] == UPLOAD_ERR_OK) 
			{
				$tmp_name = $_FILES["upload"]["tmp_name"];
				$fileName = $_FILES["upload"]["name"];
				if (!@move_uploaded_file($tmp_name, _UPLOAD_PATH_."/$fileName"))
				{
					$this->error_msg = "Uploaded file failed to save - file (".$_FILES["upload"]["name"].") => "._UPLOAD_PATH_."/$fileName";
					return false;
				}

				$dataM				= array();
				$dataM['name']		= $_FILES["upload"]["name"];
				$dataM['date']		= $data['date'];
				$dataM['time']		= date("H:i",@strtotime($data['time']));
				$dataM['utID']		= $data['utID'];
				$this->addImage($dataM);
			}
			else
			{
				$this->error_msg = "Uploaded error - ".$_FILES["upload"]['error'];
				return false;
			}
		}

		$dataU					= array();
		$dataU['date']			= $data['date'];
		$dataU['time']			= date("H:i",@strtotime($data['time']));
		$dataU['utID']			= $data['utID'];
		$dataU['skipped']		= @$data['skipped'];
		$dataU['createdBy']		= $this->session->userdata('id');
		$dataU['createdOn']		= date("Y-m-d H:i:s");
		$dataU['description']	= mysql_escape_string($data['journalmealdescription']);
		
/*		for ($first = true, $x = 0; $x < count ($data['entryname'][0]); $x++)
		{
			// insert as named meal or seperate journal entries
			if ($name == '' || $first)
			{
				$this->db->insert("user_journal",$dataU);
				$insert_ujID	= $this->db->insert_id();
				$first			= false;
			}
			$dataI				= array();
			$dataI['entryname']	= @$data['entryname'][0][$x];
			$dataI['food_id']	= @$data['food_id'][0][$x];
			$dataI['qty']		= @$data['qty'][0][$x];
			$dataI['serving']	= @$data['serving'][0][$x];
			$dataI['ujID']		= $insert_ujID;
			$dataI['createdBy']	= $this->session->userdata('id');
			$dataI['createdOn']	= $dataU['createdOn'];
			$this->db->insert("user_journal_items",$dataI);
		}
*/
		if ($name == '')
		{
			if (@$data['entryname'])
			{
				foreach ($data['entryname'] AS $ujID => $entry)
				{
					// first create the journal entry
					if ($ujID > 0)
					{	// must be added meal, lets get its name (if any)
						$query	="SELECT	name" .
								" FROM		user_journal" .
								" WHERE		ujID=".$ujID;
						$je = $this->db->query($query)->result();
						$dataU['name'] = $je[0]->name;		// keep same name in new journal entry
					}
					else
					{
						unset($dataU['name']);
					}
					$this->db->insert("user_journal",$dataU);
					$insert_ujID = $this->db->insert_id();
					// now lets create the journal items
					for ($x = 0; $x < count ($data['entryname'][$ujID]); $x++)
					{
						$dataI				= array();
						$dataI['entryname']	= mysql_escape_string(@$data['entryname'][$ujID][$x]);
						$dataI['food_id']	= @$data['food_id'][$ujID][$x];
						$dataI['qty']		= @$data['qty'][$ujID][$x];
						$dataI['serving']	= mysql_escape_string(@$data['serving'][$ujID][$x]);
						$dataI['ujID']		= $insert_ujID;
						$dataI['createdBy']	= $this->session->userdata('id');
						$dataI['createdOn']	= date("Y-m-d H:i:s");
						$this->db->insert("user_journal_items",$dataI);
						$this->storefoodinformation($dataI['food_id']);//store api data in server
					}
				}
			}
			else
			{
				$this->db->insert("user_journal",$dataU);
			}
		}
		else
		{	// combining into one meal
			if (@$data['entryname'])
			{
				$dataU['name'] = $name;
				$this->db->insert("user_journal",$dataU);
				$insert_ujID = $this->db->insert_id();
				foreach ($data['entryname'] AS $ujID => $entry)
				{
					for ($x = 0; $x < count ($data['entryname'][$ujID]); $x++)
					{
						$dataI				= array();
						$dataI['entryname']	= mysql_escape_string(@$data['entryname'][$ujID][$x]);
						$dataI['food_id']	= @$data['food_id'][$ujID][$x];
						$dataI['qty']		= @$data['qty'][$ujID][$x];
						$dataI['serving']	= mysql_escape_string(@$data['serving'][$ujID][$x]);
						$dataI['ujID']		= $insert_ujID;
						$dataI['createdBy']	= $this->session->userdata('id');
						$dataI['createdOn']	= date("Y-m-d H:i:s");
						$this->db->insert("user_journal_items",$dataI);
						$this->storefoodinformation($dataI['food_id']);//store api data in server
					}
				}
			}
			else
			{
				$this->db->insert("user_journal",$dataU);
			}
		}

		return true;
	}

	/*
	 * date				YYYY-MM-DD
	 * function			edit
	 * entryname[0]		array of serving names
	 * food_id[0]		array of food_id's
	 * qty[0]			array of quantities
	 * serving[0]		array of serving sizes
	 * time				HH:ii:ss
	 * type				Breakfast
	 * utID				(int)
	*/
	public function update($data, $name='')
	{
		if (@$_FILES["upload"]["name"])
		{
			if ($_FILES["upload"]['error'] == UPLOAD_ERR_OK) 
			{
				$tmp_name = $_FILES["upload"]["tmp_name"];
				$fileName = $_FILES["upload"]["name"];
				if (!@move_uploaded_file($tmp_name, _UPLOAD_PATH_."/$fileName"))
				{
					$this->error_msg = "Uploaded file failed to save - file (".$_FILES["upload"]["name"].") => "._UPLOAD_PATH_."/$fileName";
					return false;
				}

				$dataM				= array();
				$dataM['name']		= $_FILES["upload"]["name"];
				$dataM['date']		= $data['date'];
				$dataM['time']		= date("H:i",@strtotime($data['time']));
				$dataM['utID']		= $data['utID'];
				$this->addImage($dataM);
			}
			else
			{
				$this->error_msg = "Uploaded error - ".$_FILES["upload"]['error'];
				return false;
			}
		}

		if ($name == '')
		{
			$dataU					= array();
			$dataU['date']			= $data['date'];
			$dataU['time']			= date("H:i",@strtotime($data['time']));
			$dataU['utID']			= $data['utID'];
			if (@$data['entryname'])
			{
				$updated_ujID = array();
				foreach ($data['entryname'] AS $ujID => $entry)
				{
					if ($ujID == 0)
					{	// new entry added
						$dataU['createdBy']		= $this->session->userdata('id');
						$dataU['createdOn']		= date("Y-m-d H:i:s");
						$this->db->insert("user_journal",$dataU);
						$insert_ujID			= $this->db->insert_id();
					}
					else
					{	// update existing entry
						$dataU['modifiedBy']	= $this->session->userdata('id');
						$this->db->update("user_journal",$dataU, array("ujID" => $ujID));
						$this->db->delete("user_journal_items", array("ujID" => $ujID));
						$insert_ujID			= $ujID;
					}
					$updated_ujID[] = $insert_ujID;
					for ($x = 0; $x < count ($data['entryname'][$ujID]); $x++)
					{
						$dataI				= array();
						$dataI['entryname']	= mysql_escape_string(@$data['entryname'][$ujID][$x]);
						$dataI['food_id']	= @$data['food_id'][$ujID][$x];
						$dataI['qty']		= @$data['qty'][$ujID][$x];
						$dataI['serving']	= mysql_escape_string(@$data['serving'][$ujID][$x]);
						$dataI['ujID']		= $insert_ujID;
						$dataI['createdBy']	= $this->session->userdata('id');
						$dataI['createdOn']	= date("Y-m-d H:i:s");
						$this->db->insert("user_journal_items",$dataI);
						$this->storefoodinformation($dataI['food_id']);//store api data in server
					}
				}

				if (@$data['original_ujID'])
				{
					foreach ($data['original_ujID'] AS $ujID)
					{
						if (!in_array($ujID,$updated_ujID))
						{
							$this->db->delete("user_journal", array("ujID" => $ujID));	// deleted journal entries
						}
					}
				}
			}
			else
			{	// if not item entries then ujID is in passed data array
				$this->db->update("user_journal",$data,array("ujID" => $data['ujID']));
			}
		}
		else
		{	// combining into one meal
			$dataU					= array();
			$dataU['date']			= $data['date'];
			$dataU['time']			= date("H:i",@strtotime($data['time']));
			$dataU['name']			= $name;
			$dataU['utID']			= $data['utID'];
			$dataU['createdBy']		= $this->session->userdata('id');
			$dataU['createdOn']		= date("Y-m-d H:i:s");
			$dataU['description']	= mysql_escape_string($data['journalmealdescription']);
			$this->db->insert("user_journal",$dataU);
			$insert_ujID			= $this->db->insert_id();
			if (@$data['entryname'])
			{
				foreach ($data['entryname'] AS $ujID => $entry)
				{
					$this->db->delete("user_journal", array("ujID" => $ujID));			// delete old journal entry
					$this->db->delete("user_journal_items", array("ujID" => $ujID));	// delete old journal items
	
					for ($x = 0; $x < count ($data['entryname'][$ujID]); $x++)
					{
						$dataI				= array();
						$dataI['entryname']	= mysql_escape_string(@$data['entryname'][$ujID][$x]);
						$dataI['food_id']	= @$data['food_id'][$ujID][$x];
						$dataI['qty']		= @$data['qty'][$ujID][$x];
						$dataI['serving']	= mysql_escape_string(@$data['serving'][$ujID][$x]);
						$dataI['ujID']		= $insert_ujID;
						$dataI['createdBy']	= $this->session->userdata('id');
						$dataI['createdOn']	= date("Y-m-d H:i:s");
						$this->db->insert("user_journal_items",$dataI);
						$this->storefoodinformation($dataI['food_id']); //store api data in server
					}
				}
			}
		}

		return true;
	}

	public function delete($ujID)
	{
		$query = "SELECT	*" .
				" FROM		user_journal" .
				" WHERE		ujID=".$ujID[0];
		if ($journal = $this->db->query($query)->result())
		{
			$where = array(	"utID" => $journal[0]->utID,
							"date" => $journal[0]->date,
							"time" => $journal[0]->time);
			$this->db->delete("user_journal_images", $where);		// delete any images
			foreach ($ujID AS $id)
			{
				$this->db->delete("user_journal",		array("ujID" => $id));
				$this->db->delete("user_journal_items",	array("ujID" => $id));
			}
		}
	}

	private function addImage($data)
	{
//		$where = array(	"utID"		=> $data['utID'],
//						"date"		=> $data['date'],
//						"time"		=> $data['time'],
//						"createdBy"	=> $this->session->userdata('id'));
		$this->db->delete("user_journal_images", array(	"utID"		=> $data['utID'],	// delete any current image
														"date"		=> $data['date'],
														"time"		=> $data['time'],
														"createdBy"	=> $this->session->userdata('id')));

		$data['createdBy']	= $this->session->userdata('id');
		$data['createdOn']	= date("Y-m-d H:i:s");
		$this->db->insert("user_journal_images", $data);		// insert new image
		}

	public function dayType($day)
	{
		return $this->days[$day];
	}

	public function getTime($where=array())
	{
		$where[] = array("key" => "user_id", "op" => "=", "value" => $this->session->userdata('id'), "text" => false);
		$query = "SELECT	*" .
				" FROM		user_times" .
				" WHERE		".implode(" AND ",$this->buildQuery($where)).
				" ORDER BY	time ASC";		
		return $this->db->query($query)->result();
	}

	public function putTime($data)
	{
		$set[] = "`user_id`=".$this->session->userdata('id');
		foreach ($data AS $field => $value)
		{
			$set[] = "`".$field."`='".$value."'";
		}
		$sql = "REPLACE" .
				" INTO	user_times" .
				" SET	".implode(",",$set);
		$this->db->query($sql);
	}

	private function buildQuery($where)
	{
		$query = array();
		foreach ($where AS $param)
		{
			$kk	= array();
			$k	= explode(".",$param['key']);
			foreach ($k AS $x) { $kk[] = "`".$x."`"; }
			$key = implode(".",$kk);
			if (strcasecmp($param['op'],"IN") == 0)
			{
				$query[] = ($param['text']) ? $key." ".$param['op']." ('".implode("','",$param['value'])."')" : $key." ".$param['op']." (".implode(",",$param['value']).")" ;
			}
			else
			{
				$query[] = ($param['text']) ? $key." ".$param['op']." '".$param['value']."'" : $key." ".$param['op']." ".$param['value'] ;
			}
		}
		return $query;
	}
	
	///////////////////////////for fat loss burning zone/////////////////	
	function cmp($a, $b) 
	{			  
	 $a=key($a);
	 $b=key($b);	 
	  if ($a==$b) 
	  {
		   return 0;
	  }
	  return ($a < $b) ? -1 : 1;
	}
	function cmpjtime($a, $b) 
	{			  
	 $c=$a->time;
	 $d=$b->time;	 
	 if ($c==$d) 
	 {
		   return 0;
	 }
	 return ($c < $d) ? -1 : 1;
	}
	
	function getTimeDiff($dtime,$atime)
	{
		$dtime=substr($dtime,0,5);
		$atime=substr($atime,0,5);		
		
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
		
		$return=array();
		$return['hours']=$hours;
		$return['mins']=$mins;
		$return['secs']=$secs;
		RETURN $return;
	}
	
	function getTotalDif($ftime,$stime)
	{
		$timediff=$this->getTimeDiff(substr($ftime,0,5),substr($stime,0,5));
		$temp=floatval($timediff['mins']/60);
		$temp+=$timediff['hours'];			
		return $temp;
	}
	/////////////////////////
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
		
		$return['directions']=$decision;		
		return $return;
	}
	////////////////////
	public function getfatlossadvice($date="")
	{		     	
		$date=strlen($date)>0?$date:date("Y-m-d");					
		//$journel=$this->get("today");
		$journel=$this->get($date);
		
		//$date = date("Y-m-d");
		$sql="select * from user_customwakebed where date='".$date."' and user_id='".$this->session->userdata('id')."'";
		$wake_bed_time=$this->db->query($sql)->result();
				
		if(isset($wake_bed_time[0]->wake_time)&&strlen($wake_bed_time[0]->wake_time)>0)
		$wake_time=$wake_bed_time[0]->wake_time;
		
		if(isset($wake_bed_time[0]->bed_time)&&strlen($wake_bed_time[0]->bed_time)>0)
		$bed_time=$wake_bed_time[0]->bed_time;
				
		
		$sql="select * from user_journel_sleep where date='".$date."' and user_id='".$this->session->userdata('id')."'";
		$sleep_time=$this->db->query($sql)->result();				
		////////arranging hour ///////		
		$jourK=0;
		$mwaketime="";
		$mbedtime="";
		$flag=0;
		$allfoodinfo=array();		
		$final_array=array();
		$fn=1;
		
		for($i=0;$i<count($journel);$i++)
		{
			if($journel[$i]->type=="Wakeup"||$journel[$i]->type=="Bed")
			{				
				if(isset($wake_time)&&strlen($wake_time)>0&&$journel[$i]->type=="Wakeup")
				$mwaketime=$wake_time;				
				else if($journel[$i]->type=="Wakeup")
				$mwaketime=$journel[$i]->time;

				if(isset($bed_time)&&strlen($bed_time)>0)
				$mbedtime=$bed_time;								
				else if($journel[$i]->type=="Bed")
				$mbedtime=$journel[$i]->time;					
				$flag++;
			}			
			else
			{
				if(!empty($journel[$i]->journal))
				{
					if($journel[$i]->type=="Exercise")
					$final_array[$fn]['entryname']=$journel[$i]->journal[0]->items[0]->entryname;									
					$final_array[$fn]['time']=$journel[$i]->time;
					$final_array[$fn]['type']=$journel[$i]->type;
					$final_array[$fn]['sex']=$this->session->userdata('sex');
					$final_array[$fn]['food_description']=$journel[$i]->food_description;															
					//$final_array[$fn]['allfoodinfo']=$allfoodinfo;
					$fn++;					
				}
			}			
		}
		
		$jourK=0;
		$jArray=array();
		for($i=0;$i<count($sleep_time);$i++)
		{
			$jArray[$jourK][$sleep_time[$i]->from_time]['from_time']=$sleep_time[$i]->from_time;
			$jArray[$jourK][$sleep_time[$i]->from_time]['to_time']=$sleep_time[$i]->to_time;
			$jArray[$jourK]['type']="Sleep";			
			$jourK++;
		}		
		usort($jArray, array("journal_model", "cmp"));						
		
		////////////////////////////////get total sleep time //////////////
		$total_sleep=0;
		$total_minute=0;		
		$timediff=$this->getTimeDiff(substr($mbedtime,0,5),substr($mwaketime,0,5));							
		$total_sleep=$timediff['hours'];
		$total_minute=$timediff['mins'];
		for($i=0;$i<count($jArray);$i++)
		{
			foreach($jArray[$i] as $key=>$value)
			{
				if($jArray[$i]['type']=="Sleep")
				{
					$timediff=$this->getTimeDiff(substr($value['from_time'],0,5),substr($value['to_time'],0,5));					
					$total_sleep+=intval($timediff['hours']);
					$total_minute+=$timediff['mins'];					
				}
			}
		}
		
		/////////////////////////////////////////////////////////
		$total_sleep+=floatval($total_minute/60);		
		$final_array[0]['time']=$mwaketime;
		$final_array[0]['type']="Wakeup";
		$final_array[0]['total_sleep']=$total_sleep;
		$final_array[0]['jDate']=$date;		
		//--------------------------------	
		$final_array[$fn]['time']=$mbedtime;
		$final_array[$fn]['type']="Bed";			
		////////////////////////////////				
		return $final_array;
	}
	function getMeasurement()
	{
		$this->db->order_by("um_date", "desc");
		$this->db->limit(1);
		$query = $this->db->get_where('users_measurements', array('uid' => $this->session->userdata('id')));
        if ($query->num_rows() > 0)
        {
            return $query->result_array(); 
        }
	}
	function getLastlogin()
	{
		$sql="select last_login from users where id='".$this->session->userdata('id')."'";	
		$temp=$this->db->query($sql)->row_array();		
		return $temp['last_login'];
	}
    ////////////////////start plan goals/////
	function gradeCalculate($total_score)
	{
		if($total_score>=0&&$total_score<=59.99)		
		$grade="F";
		else if($total_score>=60&&$total_score<=63.99)		
		$grade="D-";
		else if($total_score>=64&&$total_score<=66.99)		
		$grade="D";
		else if($total_score>=67&&$total_score<=69.99)		
		$grade="D+";
		else if($total_score>=70&&$total_score<=73.99)		
		$grade="C-";
		else if($total_score>=74&&$total_score<=76.99)		
		$grade="C";
		else if($total_score>=77&&$total_score<=79.99)		
		$grade="C+";
		else if($total_score>=80&&$total_score<=83.99)		
		$grade="B-";
		else if($total_score>=84&&$total_score<=86.99)		
		$grade="B";
		else if($total_score>=87&&$total_score<=89.99)		
		$grade="B+";
		else if($total_score>=90&&$total_score<=93.99)		
		$grade="A-";
		else if($total_score>=94&&$total_score<=96.99)		
		$grade="A";
		else if($total_score>=97&&$total_score<=100)		
		$grade="A+";
		return $grade;
	}
	function getPlangoalScore($startdate,$enddate,$plangoal)
	{						
		$enddate=date("Y-m-d",strtotime("+1 day",strtotime($enddate)));
		$perfect_sleep=0;
		$perfect_sleep_count=0;
		
		$perfect_water=0;
		$perfect_water_count=0;
		
		$perfect_nsup=0;
		$perfect_nsup_count=0;
		
		$perfect_cardio=0;
		$perfect_cardio_count=0;
		
		$perfect_resistance=0;
		$perfect_resistance_count=0;
		
		$perfect_plate=0;
		$perfect_plate_count=0;
		
		$perfect_snacks=0;
		$perfect_snacks_count=0;
		
		$perfect_breakfastiming=0;
		$perfect_breakfastiming_count=0;
		
		$perfect_schedule=0;
		$perfect_schedule_count=0;
		
		$perfect_bedeat=0;
		$perfect_bedeat_count=0;
		
		$perfect_on_plan=0;
		$perfect_on_plan_count=0;
		
		$avoid_alcohol=0;
		$avoid_alcohol_count=0;
		
		$ps_count=0;
		$mealcount=0;
		$mealfatlossplate=0;
		$snackcount=0;
		$snackfatlossplate=0;
		
		$waketime=0;
		$isCardio=0;
		$isResistance=0;
		$jsondata="";
		$advcdata=array();
		$dayname="";
	while($startdate!=$enddate)
	{
		$dayname=strtolower(date("D",strtotime($startdate)));		
		///////////////////
			$advice=$this->getfatlossadvice($startdate);
		//////////////////////////////////////////perfect_on_plan			
		if(isset($plangoal['perfect_on_plan']))
		{
			$goalday=explode(",",$plangoal['perfect_on_plan']);
			if(in_array($dayname, $goalday))
			{
				$advcdata['advice']=$advice;
				$jsondata=$this->load->view('fatloss/fatloss_today', $advcdata, true);						
				$result['data']=json_decode($jsondata);						
				if($this->gradeCalculate($result['data']->total_score)=="A+")			
				$perfect_on_plan+=100;

				$perfect_on_plan_count++;	
			}	
		}	
		////////////////////////////////////
			
		///////////perfect sleep/////			
		if(isset($plangoal['perfect_sleep']))
		{
			$goalday=explode(",",$plangoal['perfect_sleep']);						
			if(in_array($dayname, $goalday))	
			{
				if($advice[0]['total_sleep']>=7&&$advice[0]['total_sleep']<=12)
				$perfect_sleep+=100;					
				
				$perfect_sleep_count++;
			}
		}	
		/////////////end perfect sleep///////////
		
			//////////////end perfect slow///////////////
			/////////////////////////////
			$dailyData = $this->user_model->getDaily($startdate);
			
			//////////////////perfect water////////////////
			if(isset($plangoal['perfect_water']))
			{
			  $goalday=explode(",",$plangoal['perfect_water']);						
			  if(in_array($dayname, $goalday))	
			  {	
				if($dailyData->cups>=12)
				$perfect_water+=100;
				
				$perfect_water_count++;
			  }	
			}	
			////////////////////////////Take my nutritional supplements
			if(isset($plangoal['perfect_nsup']))
			{
				$goalday=explode(",",$plangoal['perfect_nsup']);
				if(in_array($dayname, $goalday))	
			    {
				 if($dailyData->vitamins==1&&$dailyData->pills==1&&$dailyData->supplements==1&&$dailyData->fatBurning==1&&$dailyData->nutrition==1&&$dailyData->sleep==1&&$dailyData->choose==1)
				 $perfect_nsup+=100;
				 
				 $perfect_nsup_count++;
				}
			}
			
			$waketime=$advice[0]['time'];
			$ps_count++;
			
			$mealcount=0;
			$mealfatlossplate=0;
			$snackcount=0;
			$snackfatlossplate=0;
			$hdiff=0.0;
		
			$timingcount=0;			
			$isrighttime=0;
			$lastmealtime=$waketime;
			$alcoholcount=0;
			$isCardio=0;
			$isResistance=0;
			
			//////////////////////////////////////////////
			$swakeFlag=0;
			for($i=0;$i<count($advice);$i++)
			{			  							  
				  if($advice[$i]['type']=="Breakfast")
				  {
						$hdiff=$this->getTotalDif($waketime,$advice[$i]['time']);
						if(isset($plangoal['perfect_breakfastiming']))
						{
								$goalday=explode(",",$plangoal['perfect_breakfastiming']);
								if(in_array($dayname, $goalday))	
								{
								 $swakeFlag=1;
								 $perfect_breakfastiming_count++;
								}
						}
						if($hdiff<=0.5)
						{
							if($swakeFlag==1)
							$perfect_breakfastiming+=100;					
							
							$isrighttime++;
						}
						
						$lastmealtime=$advice[$i]['time'];
						$timingcount++;
						
					$temp=$this->getfoodinfo($advice[$i]['food_description']);
					if($temp['directions']['isAlcohol']==0)
					$alcoholcount++;					
				  }
				  if($advice[$i]['type']=="Snack"||$advice[$i]['type']=="Lunch"||$advice[$i]['type']=="Dinner")
				  {
					$hdiff=$this->getTotalDif($lastmealtime,$advice[$i]['time']);
					if($hdiff>=2&&$hdiff<=3)
					$isrighttime++;
					
					$lastmealtime=$advice[$i]['time'];
					$timingcount++;
					
					$temp=$this->getfoodinfo($advice[$i]['food_description']);
					if($temp['directions']['isAlcohol']==0)
					$alcoholcount++;
					
				  }
										  
				  if($advice[$i]['type']=="Exercise")
				  {
					if($advice[$i]['entryname']=="Cardio")
					$isCardio=1;
					else if($advice[$i]['entryname']=="Resistance")
					$isResistance=1;					
				  }
				  
				 if($advice[$i]['type']=="Snack")
				 {
					$snackcount++;				
					if($advice[$i]['food_description']['isfatlosplate']==1)
					$snackfatlossplate++;				
				 }
				 else if($advice[$i]['type']=="Breakfast"||$advice[$i]['type']=="Lunch"||$advice[$i]['type']=="Dinner")
				 {
					$mealcount++;
					if($advice[$i]['food_description']['isfatlosplate']==1)
					$mealfatlossplate++;				
				 }
			}
			
			///////////avoid alcohol///////////
			if(isset($plangoal['avoid_alcohol']))
			{
				$goalday=explode(",",$plangoal['avoid_alcohol']);
				if(in_array($dayname, $goalday))	
			    {
					if($alcoholcount==($snackcount+$mealcount))
					$avoid_alcohol+=100;
					
					$avoid_alcohol_count++;
				}		
			}	
			/////////////////////////////
			if($advice[count($advice)-1]['type']=="Bed")
			{
				$hdiff=$this->getTotalDif($lastmealtime,$advice[count($advice)-1]['time']);
				/////////////////perfect bed eat/////
				if(isset($plangoal['perfect_bedeat']))
				{
					$goalday=explode(",",$plangoal['perfect_bedeat']);
					if(in_array($dayname, $goalday))	
					{	
						if($hdiff>1)
						$perfect_bedeat+=100;
						
						$perfect_bedeat_count++;
					}	
				}	
				
				if($hdiff>=2&&$hdiff<=3)
				$isrighttime++;
				
				$timingcount++;
			}			
			/////////////////////perfect schedule
			if(isset($plangoal['perfect_schedule']))
			{
				$goalday=explode(",",$plangoal['perfect_schedule']);
				if(in_array($dayname, $goalday))	
				{
					if($timingcount==$isrighttime)
					$perfect_schedule+=100;
					
					$perfect_schedule_count++;	
				}	
			}	
			/////////////////////Perfect Plates/////
			if(isset($plangoal['perfect_snacks']))
			{
				$goalday=explode(",",$plangoal['perfect_snacks']);
				if(in_array($dayname, $goalday))	
				{
					if($snackcount==$snackfatlossplate)
					$perfect_snacks+=100;
					
					$perfect_snacks_count++;	
				}	
			}	
			/////////////////////Perfect Plates/////
			if(isset($plangoal['perfect_plate']))
			{	
				$goalday=explode(",",$plangoal['perfect_plate']);
				if(in_array($dayname, $goalday))	
				{
					if($mealcount==$mealfatlossplate)
					$perfect_plate+=100;			
					
					$perfect_plate_count++;
				}	
			}	
			///////////////////////////perfect cardio////////
			if(isset($plangoal['perfect_cardio']))
			{
				$goalday=explode(",",$plangoal['perfect_cardio']);
				if(in_array($dayname, $goalday))	
				{
					if($isCardio==1)
					$perfect_cardio+=100;						
					
					$perfect_cardio_count++;
				}	
			}	
			/////////////////////////perfect resistance//////////
			if(isset($plangoal['perfect_resistance']))
			{
			    $goalday=explode(",",$plangoal['perfect_resistance']);
				if(in_array($dayname, $goalday))	
				{
					if($isResistance==1)
			     	$perfect_resistance+=100;			
					
					$perfect_resistance_count++;
				}	
			}	
		////////////////////////	
			$startdate=date("Y-m-d",strtotime("+1 day",strtotime($startdate)));;
	}
					
		$return=array();		
		foreach($plangoal as $key=>$value)
		{
			$cvalue="$key"."_count";		
			$return[$key]=round($$key/$$cvalue);		
		}	
	return $return;	
	}
	//////////////////////////////////////////
	function recipeaddjournal($data)
	{		
		$rdata=array();				
		$rdata['date']=date("Y-m-d",strtotime($data['jdate']));
		$rdata['time']=$data['jmealttime'];
		$rdata['user_id']=$this->session->userdata('id');
		$rdata['week_period']=$this->days[date("D",strtotime($rdata['date']))];
		
		$table_name="user_times";
		$sql="select * from user_custom_times where user_id='".$rdata['user_id']."' and date='".$rdata['date']."'";
		$result=$this->db->query($sql)->result();
		if(count($result)>0)
		{
			$table_name="user_custom_times";				
			$sql="select *,TIMEDIFF(time,'".$data['jmealttime']."') as  closetime from $table_name where week_period='".$rdata['week_period']."' and type='".$data['jmealtype']."' and user_id='".$rdata['user_id']."' and date='".$rdata['date']."' order by closetime asc";
			$result=$this->db->query($sql)->result();
			if(count($result)>0)
			$rdata['utID']=$result[0]->outId;
		}
		else
		{
			$sql="select *,TIMEDIFF(time,'".$data['jmealttime']."') as  closetime from $table_name where week_period='".$rdata['week_period']."' and type='".$data['jmealtype']."' and user_id='".$rdata['user_id']."' order by closetime asc";
			$result=$this->db->query($sql)->result();
			if(count($result)>0)
			$rdata['utID']=$result[0]->utID;
		
		}
		
		
		/////////////////get reipe info////
		$rid=$data['recipe_id'];
		$sql="select title from recipes where rID='".$rid."'";
		$result=$this->db->query($sql)->result();
		$rdata['title']=$result[0]->title;
		
		$serving=array();
		$sql="select * from recipe_servings where rID='".$rid."'";
		$result=$this->db->query($sql)->result();
		for($i=0;$i<count($result);$i++)
		{
			$serving[$i]['food_id']=$result[$i]->food_id;
			$serving[$i]['entryname']=$result[$i]->entryname;
			$serving[$i]['qty']=$result[$i]->qty;
			$serving[$i]['serving']=$result[$i]->serving;
		}
		$rdata['serving']=$serving;
		
		$sql="insert into user_journal set 
			  utID='".$rdata['utID']."',
			  date='".$rdata['date']."',
			  time='".$rdata['time']."',
			  name='".$rdata['title']."',
			  createdBy='".$rdata['user_id']."',
			  createdOn='".date("Y-m-d H:i:s")."'";	
		$isinsert=$this->db->query($sql);
		
		$ujid="";
		if($isinsert)
		$ujid=$this->db->insert_id();
		
		for($i=0;$i<count($rdata['serving']);$i++)
		{
			$sql="insert into user_journal_items set 
			  ujID='".$ujid."',
			  food_id='".$rdata['serving'][$i]['food_id']."',
			  qty='".$rdata['serving'][$i]['qty']."',
			  entryname='".$rdata['serving'][$i]['entryname']."',
			  serving='".$rdata['serving'][$i]['serving']."',
			  createdBy='".$rdata['user_id']."',
			  createdOn='".date("Y-m-d H:i:s")."'";
			$isinsert=$this->db->query($sql);	  
		}
		if($isinsert)
		return true;
		else 
		return false;
	}
	////////////////////////////////////
	function boxmealaddjournal($data)
	{
		
		$rdata=array();				
		$rdata['date']=date("Y-m-d",strtotime($data['jdate']));
		$rdata['time']=$data['jmealttime'];
		$rdata['user_id']=$this->session->userdata('id');
		$rdata['week_period']=$this->days[date("D",strtotime($rdata['date']))];
		
		$table_name="user_times";
		$sql="select * from user_custom_times where user_id='".$rdata['user_id']."' and date='".$rdata['date']."'";
		$result=$this->db->query($sql)->result();
		if(count($result)>0)
		{
			$table_name="user_custom_times";				
			$sql="select *,TIMEDIFF(time,'".$data['jmealttime']."') as  closetime from $table_name where week_period='".$rdata['week_period']."' and type='".$data['jmealtype']."' and user_id='".$rdata['user_id']."' and date='".$rdata['date']."' order by closetime asc";
			$result=$this->db->query($sql)->result();
			if(count($result)>0)
			$rdata['utID']=$result[0]->outId;
		}
		else
		{
			$sql="select *,TIMEDIFF(time,'".$data['jmealttime']."') as  closetime from $table_name where week_period='".$rdata['week_period']."' and type='".$data['jmealtype']."' and user_id='".$rdata['user_id']."' order by closetime asc";
			$result=$this->db->query($sql)->result();
			if(count($result)>0)
			$rdata['utID']=$result[0]->utID;		
		}
		
		$sql="select * from user_journal where ujID='".$data['ujid']."'";
		$result=$this->db->query($sql)->result();
		
		if(!empty($result))
		$rdata['title']=$result[0]->name;
		
		
		
		$sql="insert into user_journal set 
			  utID='".$rdata['utID']."',
			  date='".$rdata['date']."',
			  time='".$rdata['time']."',
			  name='".$rdata['title']."',
			  createdBy='".$rdata['user_id']."',
			  createdOn='".date("Y-m-d H:i:s")."'";	
		$isinsert=$this->db->query($sql);
		
		$ujid="";
		if($isinsert)
		$ujid=$this->db->insert_id();
		
		$sql="select * from user_journal_items where ujID='".$result[0]->ujID."'";
		$journal_item=$this->db->query($sql)->result();				
		for($i=0;$i<count($journal_item);$i++)
		{
			$sql="insert into user_journal_items set 
			  ujID='".$ujid."',
			  food_id='".$journal_item[$i]->food_id."',
			  qty='".$journal_item[$i]->qty."',
			  entryname='".$journal_item[$i]->entryname."',
			  serving='".$journal_item[$i]->serving."',
			  createdBy='".$rdata['user_id']."',
			  createdOn='".date("Y-m-d H:i:s")."',
			  modifiedBy='".$rdata['user_id']."',
			  modifiedOn='".date("Y-m-d H:i:s")."'";	
			  $isinsert=$this->db->query($sql);						
		}
		
		$sql="select * from user_journal_images where utID='".$result[0]->utID."' AND date='".$result[0]->date."' AND time='".$result[0]->time."'";
		$journal_image=$this->db->query($sql)->result();
		
		for($i=0;$i<count($journal_image);$i++)
		{			
			
			$sql="insert into user_journal_images set 
			  utID='".$rdata['utID']."',
			  date='".$rdata['date']."',
			  time='".$rdata['time']."',
			  name='".$journal_image[$i]->name."',			 
			  createdBy='".$rdata['user_id']."',
			  createdOn='".date("Y-m-d H:i:s")."',
			  modifiedBy='".$rdata['user_id']."',
			  modifiedOn='".date("Y-m-d H:i:s")."'";	
			  $isinsert=$this->db->query($sql);						
		}

		return true;	
	}
	/////////////////////////////////////
	function autoupdateflp($rdata)
	{		
		$fatlossystem=array();				
		$type=$rdata['type'];
		try
		{		
			if(!empty($rdata['food_id']))
			{
			//
				$fattag=0;				
				$fatloss=array();
				foreach($rdata['food_id'] as $key=>$value)
				{				
					for($i=0;$i<count($value);$i++)
					{
						$sql="select * from food_description where food_id='".$value[$i]."' and measurement_description='".stripslashes($rdata['serving'][$key][$i])."'";	
						$tempfod=$this->db->query($sql)->row_array();
						if(!empty($tempfod)) //if found in database
						{
							$fatloss[$fattag] = $tempfod;
							$fatloss[$fattag]['qty']=$rdata['qty'][$key][$i];						
							$fattag++;
						}
						else
						{
							$temp=$this->getFoodInformation($value[$i]);																								
							if(!empty($temp['servings'][0]['serving']))
							{
								for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
								{
									$tempservice=$temp['servings'][0]['serving'][$k];
									if($tempservice['measurement_description']==stripslashes($rdata['serving'][$key][$i]))
									{
										$fatloss[$fattag] = $tempservice;
										$fatloss[$fattag]['qty']=$rdata['qty'][$key][$i];
										$fattag++;
									}
								}
							}					
						}
					}				
				}							
			//	
			}
		}
		catch (Exception $ex) 
		{
			$result['error'] = $ex->getMessage();
		}
		
		$total_calories=0;		
		$total_fat=0;				
		$total_carb=0;
		$dietary_fiber=0;
		$sugar=0;		
		$total_protein=0;
		$total_sodium=0;
		
		$saturated_fat=0;	
		$polyunsaturated_fat=0;	
		$monounsaturated_fat=0;	
		$trans_fat=0;	
		$cholesterol=0;	
		$potassium=0;	
		$calcium=0;	
		$iron=0;
		
		foreach($fatloss as $key=>$value)
		{			
			$total_calories+=($value['calories']/$value['number_of_units'])*$value['qty'];
			$total_fat+=($value['fat']/$value['number_of_units'])*$value['qty'];						
			$total_carb+=($value['carbohydrate']/$value['number_of_units'])*$value['qty'];
			
			if(isset($value['fiber']))
			$dietary_fiber+=($value['fiber']/$value['number_of_units'])*$value['qty'];			
			if(isset($value['sugar']))
			$sugar+=($value['sugar']/$value['number_of_units'])*$value['qty'];
			
			$total_protein+=($value['protein']/$value['number_of_units'])*$value['qty'];						
			$total_sodium+=($value['sodium']/$value['number_of_units'])*$value['qty'];
			
			$saturated_fat+=($value['saturated_fat']/$value['number_of_units'])*$value['qty'];
			$polyunsaturated_fat+=($value['polyunsaturated_fat']/$value['number_of_units'])*$value['qty'];
			$monounsaturated_fat+=($value['monounsaturated_fat']/$value['number_of_units'])*$value['qty'];
			$trans_fat+=($value['trans_fat']/$value['number_of_units'])*$value['qty'];
			$cholesterol+=($value['cholesterol']/$value['number_of_units'])*$value['qty'];
			$potassium+=($value['potassium']/$value['number_of_units'])*$value['qty'];
			$calcium+=($value['calcium']/$value['number_of_units'])*$value['qty'];
			$iron+=($value['iron']/$value['number_of_units'])*$value['qty'];
		}						
			
		$fatlossystem['total_food']=count($fatloss);
		$fatlossystem['total_calories']=$total_calories;
		$fatlossystem['total_fat']=$total_fat;
		$fatlossystem['total_carb']=$total_carb;
		$fatlossystem['dietary_fiber']=$dietary_fiber;		
		$fatlossystem['sugar']=$sugar;
		$fatlossystem['total_protein']=$total_protein;
		$fatlossystem['total_sodium']=$total_sodium;
		
		$fatlossystem['total_saturated_fat']=$saturated_fat;
		$fatlossystem['total_polyunsaturated_fat']=$polyunsaturated_fat;
		$fatlossystem['total_monounsaturated_fat']=$monounsaturated_fat;
		$fatlossystem['total_trans_fat']=$trans_fat;
		$fatlossystem['total_cholesterol']=$cholesterol;
		$fatlossystem['total_potassium']=$potassium;
		$fatlossystem['total_calcium']=$calcium;
		$fatlossystem['total_iron']=$iron;				
		//
		////////////////////////detect fat loss plate//////////////////
		$errormessage=array();
		$iscalorieOk=0;
		$isproteingOk=0;
		$iscarbsOk=0;
		$isfatOK=0;
				
		if($this->session->userdata('sex')=="Male")
		{
			
			if($type=="Snack"&&$total_calories>=150&&$total_calories<=250)
			$iscalorieOk=1;
			else if($total_calories>=300&&$total_calories<=550&&$type!="Snack")
			$iscalorieOk=1;

			if($total_fat>=0&&$total_fat<=21.4)
			$isfatOK=1;

			if($total_carb>=3&&$total_carb<=50)
			$iscarbsOk=1;

			if($total_protein>=15)
			$isproteingOk=1;

			if($type=="Snack")
			{
			 $fatlossystem['calories1']=150;
			 $fatlossystem['calories2']=250;				
			}
			else
			{
			 $fatlossystem['calories1']=300;
			 $fatlossystem['calories2']=550;
			}
			
			$fatlossystem['fat1']=0;			
			$fatlossystem['fat2']=21.4;
			$fatlossystem['carb1']=3;
			$fatlossystem['carb2']=50;
			$fatlossystem['protein']=15;			
		}
		else if($this->session->userdata('sex')=="Female")
		{
			if($type=="Snack"&&$total_calories>=150&&$total_calories<=250)
			$iscalorieOk=1;
			else if($total_calories>=250&&$total_calories<=450&&$type!="Snack")
			$iscalorieOk=1;

			if($total_fat>=0&&$total_fat<=17.5)
			$isfatOK=1;

			if($total_carb>=3&&$total_carb<=45)
			$iscarbsOk=1;

			if($total_protein>=12)
			$isproteingOk=1;
			
			if($type=="Snack")
			{
			 $fatlossystem['calories1']=150;
			 $fatlossystem['calories2']=250;				
			}
			else
			{
			 $fatlossystem['calories1']=250;
			 $fatlossystem['calories2']=450;
			}
			
			$fatlossystem['fat1']=0;			
			$fatlossystem['fat2']=17.4;
			$fatlossystem['carb1']=3;
			$fatlossystem['carb2']=45;
			$fatlossystem['protein']=12;
		}
		
		$fatlossystem['iscalorieOk']=$iscalorieOk;
		$fatlossystem['isfatOK']=$isfatOK;
		$fatlossystem['iscarbsOk']=$iscarbsOk;
		$fatlossystem['isproteingOk']=$isproteingOk;		
		
		$isfatlosplate=0;	
		if($iscalorieOk==1&&$isfatOK==1&&$iscarbsOk==1&&$isproteingOk==1&&$type!="Snack")
		$isfatlosplate=1;
		else if($iscalorieOk==1&&$type=="Snack")
		$isfatlosplate=1;
		else
		$isfatlosplate=0;				
		$fatlossystem['isfatlosplate']=$isfatlosplate;		
		$fatlossystem['type']=$type;
		
		return $fatlossystem;
	}
	/////////////////////////////////////
}

?>