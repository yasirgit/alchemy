<?php

/*
 * journal
 *
 * default model for journal
 *
 * @package ripe media
 * @version 1
 * @author Brian Markham
 */
class journal extends Controller
{
	private $methods = array(	"food.get"		=> array(	"template"	=> "users/eating_journal/foodGet",
															"callBack"	=> ""),
								"foods.search"	=> array(	"template"	=> "users/eating_journal/foodSearch",
															"callBack"	=> "")
							);

	private $journal_output = array();

	 function __construct()
	 {
		parent::Controller();
		$this->pageVars['isajax'] = true;
		
		error_reporting(0);

		$this->load->model(array('fatsecret/fsprofile_food', 'user_model'));
//		$this->load->model('twitter/twitter');
		$this->load->model('journal_model','journal');		
		$this->load->library('paginator');
		$this->load->library('Auth');
		if (!$this->auth->isLoggedIn())
		{
			$tmp_array['error_code']	= -1;
			$tmp_array['error_msg']		= "";

			echo json_encode($tmp_array);
			exit;
		}

		$uri = explode('/',$_SERVER['QUERY_STRING']);
		for ($x=3; $x < count($uri); $x++)
		{
			$param = explode(":",$uri[$x]);
			$this->$param[0] = $param[1];
		}
		
		////////////////////////////////////////////						
		if(strlen($this->session->userdata('timezone'))>0)
		date_default_timezone_set($this->session->userdata('timezone'));		   				   	
		/////////////////////////////////////////////
	}

	public function twitter()
	{
//		$this->twitter->apiBuild($this->method,$_POST);
		if ($this->twitter->execute())
		{
//			if ($this->methods[$this->method]['template'])
//			{
//			//	$this->twitter->result['type'] = @$this->type;
//				$tmp_array['foods']	= $this->load->view($this->methods[$this->method]['template'],array("foods" => $this->twitter->result),true);
//				if ($this->methods[$this->method]['callBack'])
//				{
//					$this->{$this->methods[$this->method]['callBack']}();
//				}
//			}
//			else
//			{
				$tmp_array['status']	= $this->twitter->result;
//			}

			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= '';
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= $this->twitter->error;
		}

		echo json_encode($tmp_array);
	}	
	public function fsapi()
	{		
		if(isset($_POST['ingredient']))
		$_POST['ingredient']=urlencode(str_replace("~", "&", $_POST['ingredient']));			
		
		///////////////////////////////test purpose////////
		$this->fsprofile_food->apiBuild($this->method,$_POST);
		/*$_POST['brand_type']="manufacturer";
		$_POST['starts_with']="oat";
		$this->fsprofile_food->apiBuild("food_brands.get",$_POST);
		$this->fsprofile_food->execute();
		$foods=$this->fsprofile_food->result;		
		echo "<pre>";
			print_r($foods);
		echo "</pre>";
		exit();
		*/
		///////////////////end pupose/////////////////////
		if ($this->fsprofile_food->execute())
		{			
			if ($this->methods[$this->method]['template'])
			{
				$this->fsprofile_food->result['type'] = @$this->type;
				//////////////////////////////////////////////
				$food_id="";
				$serving="";
				$foods=$this->fsprofile_food->result;												
				if($this->method=="food.get")
				{
				 $food_id=$foods['food_id'];				 				 				 
				}
				//////////////////////////////////////////////
				$tmp_array['foods']	= $this->load->view($this->methods[$this->method]['template'],array("foods" =>$foods),true);				
				if ($this->methods[$this->method]['callBack'])
				{
					$this->{$this->methods[$this->method]['callBack']}();
				}
			}
			else
			{
				$tmp_array['foods']	= $this->fsprofile_food->result;
			}

			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= $this->fsprofile_food->error;
		}

		echo json_encode($tmp_array);
	}

	/* 
	 * date	 	 		2010-09-02
	 * entryname[0][]	Cardio
	 * function			edit
	 * original_ujID[]	131
	 * time				09:30 AM
	 * type				Exercise
	 * utID				13
	  [date] => 2011-03-10
    [utID] => 37
    [time] => 12:00 AM

	*/
	public function getNutritionBox()
	{
		/////
		$sid=$_POST['sid'];		
		$msid="";
		$serving=json_decode(base64_decode($_POST['serving']));
		
		if($sid==0&&count($serving)>0)
		$msid=$serving[0]->serving_id;
		else
		$msid=substr($sid,0,strpos($sid,"~"));
		
		$data=array();
		for($i=0;$i<count($serving);$i++)
		{
			if($serving[$i]->serving_id==$msid)
			{
			 $data['serving']=$serving[$i];
			 break;
			}
		}			
		/////////////////////start pie chart/////////////
		$getPerc = array('total_calories'=>$data['serving']->calories,'total_fat'=>$data['serving']->fat,'total_carb'=>$data['serving']->carbohydrate,'dietary_fiber'=>$data['serving']->fiber,'sugar'=>$data['serving']->sugar,'total_protein'=>$data['serving']->protein);		
		$returnPerc=$this->journal->getfoodinfo($getPerc);	
		
		$pCurb = round($returnPerc['Percent_Carbs']);
		$pFat =  round($returnPerc['Percent_Fat']);
		$pProt = round($returnPerc['Percent_Protein']);
		
		$this->load->library('piechart');				
		$this->piechart->setWidth(50);
		$this->piechart->setCol(array('4ABA9C','E7B200','BD5D52'));					
		$this->piechart->setLegend('round');
		$this->piechart->setData( array($pCurb,$pFat,$pProt) );
		$hash = md5("report-pie-".$msid);		
		$this->piechart->Generate("htdocs/images/piecharts/$hash.png");
		$pieimg = '<img src="htdocs/images/piecharts/'.$hash.'.png" alt="Circle chart">';
		$data['pieimg'] = $pieimg;
		$data['pCurb']=$pCurb;	
		$data['pFat']=$pFat;	
		$data['pProt']=$pProt;	
		//////////////end pie chart//////////
		
						
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= "";
		$data['qty']=$_POST['qty'];
		
		$tmp_array['display']= $this->load->view('users/eating_journal/nutrition',$data,true);		
		echo json_encode($tmp_array);
		return;		
	   /////////
	}
	public function journalEntry()
	{
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= "Journal entry has been saved";
						
		if(isset($_POST['journalmealname'])&&strlen($_POST['journalmealname'])>0)
		@$this->name=mysql_escape_string($_POST['journalmealname']);
		
		
		if (is_array(@$_POST['entryname']))
		{
			if (@$_POST['function'] == "edit")
			{
				if (!$this->journal->update($_POST, @$this->name))
				{
					$tmp_array['error_code']	= 1;
					$tmp_array['error_msg']		= "Journal entry failed to save correctly - ".$this->journal->error_msg;
				}
			}
			elseif (@$_POST['function'] == "copy")
			{
				$this->journal->copy($_POST);
			}
			else	// assume 'add' function
			{
				if (!$this->journal->insert($_POST, @$this->name))
				{
					$tmp_array['error_code']	= 1;
					$tmp_array['error_msg']		= "Journal entry failed to save correctly - ".$this->journal->error_msg;
				}
			}
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid Journal entry";
		}

		if (@$this->data == "json")
		{
			echo json_encode($tmp_array);
		}
		else	// else assume 'xml' - wrap in <textarea> for ajaxSubmit
		{
			echo '<textarea>' . json_encode($tmp_array) . '</textarea>';
		}
	}

	public function delete()
	{		
		if (is_array(@$_POST['ujID']))
		{
			$this->journal->delete($_POST['ujID']);

			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid ujID - ".@$_POST['ujID'];
		}
		
		echo json_encode($tmp_array);
	}

	public function skipped()
	{
		$tmp_array = array();
		if (is_array($_POST['ujID']))
		{
			$data = array();
			foreach ($_POST['ujID'] AS $ujID)
			{
				$data['ujID']		= $ujID;
				$data['utID']		= $this->utID;
				$data['date']		= $this->date;
				$data['skipped']	= 1;
				$this->journal->update($data);
			}
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "invalid ujID - ".$_POST['ujID'];
		}
		echo json_encode($tmp_array);
	}

	public function ate()
	{		
		$tmp_array = array();
		if (is_array($_POST['ujID']))
		{
			$data = array();
			foreach ($_POST['ujID'] AS $ujID)
			{
				$data['ujID']		= $ujID;
				$data['utID']		= $this->utID;
				$data['date']		= $this->date;
				$data['skipped']	= 0;
				$data['planned']	= 0;
				$this->journal->update($data);
			}
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "invalid ujID - ".$_POST['ujID'];
		}
		echo json_encode($tmp_array);
	}

	public function skip()
	{
		if (is_numeric($this->utID) && $this->utID > 0)
		{					
			switch ($this->active)
			{
				default:
				$data['date']	= date('Y-m-d',strtotime($this->active));
				break;

				case "yesterday":
				$data['date']	= date('Y-m-d',strtotime("-1 day"));
				break;

				case "today":
				$data['date']	= date('Y-m-d');
				break;

				case "tomorrow":
				$data['date']	= date('Y-m-d',strtotime("+1 day"));
				break;
			}
			$query[]		= array("key" => "utID", "op" => "=", "value" => $this->utID, "text" => true);
			$time			= $this->journal->getTime($query);
			$data['time']	= $time[0]->time;
			
			///////////////////////////////////////////////get auto adjust time//////
			$sql="select * from user_custom_times where user_id='".$time[0]->user_id."' and type='".$time[0]->type."' 
			and week_period='".$time[0]->week_period."' and date='".$data['date']."' and outId='".$time[0]->utID."'";						
			$result= $this->db->query($sql)->result();
									
			if(!empty($result))
			{				
				$data['time']=$result[0]->time;				
			}						
			///////////////////////////////////////////////////
			
			
			$data['utID']			= $this->utID;
//			$data['name']			= "Skipped this meal";
			$data['skipped']		= 1;
			$this->journal->insert($data);

			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid utID - ".$this->utID;
		}
		
		echo json_encode($tmp_array);
	}
	////////////////////////////////get edit time format//
	function saveSleepJournal()
	{		
		$data=array();
								     
		$timefrom=date("H:i:s",strtotime($_POST['timefrom']));
		$timeto=date("H:i:s",strtotime($_POST['timeto']));				

		if($this->active=="today")
		$today=date('Y-m-d');
		else if($this->active=="yesterday")
		$today=date('Y-m-d',strtotime("-1 day"));
		else if($this->active=="tomorrow")
		$today=date('Y-m-d',strtotime("+1 day"));		
		else if(isset($_POST['daynameweekmonth'])&&strlen($_POST['daynameweekmonth'])>0)
		$today=$_POST['daynameweekmonth'];
		else
		$today=date('Y-m-d',strtotime($this->active));
		
		if(isset($_POST['sleepid'])&&strlen($_POST['sleepid'])>0)
		{
		/////////////////////////						
			/*date='".$today."'*/
			$sql="update user_journel_sleep set			
			from_time='".$timefrom."',
			to_time='".$timeto."' where id='".$_POST['sleepid']."'";							
			$isInsert=$this->db->query($sql);
		///////////////////////
		}
		else
		{
			
			$sql="insert into user_journel_sleep set
			user_id='".$this->session->userdata('id')."',
			from_time='".$timefrom."',
			to_time='".$timeto."',
			date='".$today."'";
			$isInsert=$this->db->query($sql);
			
		}
		
		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$tmp_array['display']=$this->load->view('users/eating_journal/journal_save_sleeptime',$data,true);
		echo json_encode($tmp_array);
		return;	
	
	}
	function getToday()
	{		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$tmp_array['display']=date("m/d/Y");
		echo json_encode($tmp_array);
		return;
	}
	function getNextDate()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$active="";
		
		$currentTime=$_POST['currentdate'];		
		$currentTime=date("Y-m-d",strtotime($currentTime));
		$nextDay=date('Y-m-d', strtotime('+1 day', strtotime($currentTime))); 
				
		if($nextDay==date("Y-m-d",strtotime("-1 day")))
		$active="yesterday";
		else if($nextDay==date("Y-m-d",strtotime("+1 day")))
		$active="tomorrow";
		else if($nextDay==date("Y-m-d"))
		$active="today";		
		else
		$active=$nextDay;
		//////////////////////////////////////
		$tmp_array['main']=$active;
		$tmp_array['nextday']=$nextDay;
		$tmp_array['display']=date("M. d, Y",strtotime($nextDay));;
		echo json_encode($tmp_array);
		return;
	}
	function getNextWeek()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$weekstart=date('Y-m-d', strtotime('+1 day', strtotime($_POST['weekend']))); 
		$weekend=date('Y-m-d', strtotime('+7 day', strtotime($_POST['weekend']))); 
		
		$tmp_array['weekstart']=$weekstart;
		$tmp_array['weekend']=$weekend;
		$tmp_array['display']=date("M. d, y",strtotime($weekstart))." - ".date("M. d, y",strtotime($weekend));
		echo json_encode($tmp_array);		
		return;
	}
	function getPrevWeek()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$weekstart=date('Y-m-d', strtotime('-7 day', strtotime($_POST['weekend']))); 
		$weekend=date('Y-m-d', strtotime('-1 day', strtotime($_POST['weekend']))); 
		
		$tmp_array['weekstart']=$weekstart;
		$tmp_array['weekend']=$weekend;
		$tmp_array['display']=date("M. d, y",strtotime($weekstart))." - ".date("M. d, y",strtotime($weekend));
		echo json_encode($tmp_array);		
		return;
	}
	function getNextMonth()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$nextmonth=date('Y-m-d', strtotime('+1 months', strtotime($_POST['cmonth']))); 
		$printText=date('F, Y', strtotime('+1 months', strtotime($_POST['cmonth']))); 
		
		$tmp_array['nextmonth']=$nextmonth;		
		$tmp_array['display']=$printText;
		echo json_encode($tmp_array);		
		return;
	
	}
	function getPrevMonth()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$nextmonth=date('Y-m-d', strtotime('-1 months', strtotime($_POST['cmonth']))); 
		$printText=date('F, Y', strtotime('-1 months', strtotime($_POST['cmonth']))); 
		
		$tmp_array['nextmonth']=$nextmonth;		
		$tmp_array['display']=$printText;
		echo json_encode($tmp_array);		
		return;
	}
	function getPrevDate()
	{
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		//////////////////////////////////////		
		$active="";
		
		$currentTime=$_POST['currentdate'];		
		$currentTime=date("Y-m-d",strtotime($currentTime));
		$nextDay=date('Y-m-d', strtotime('-1 day', strtotime($currentTime))); 
				
		if($nextDay==date("Y-m-d",strtotime("-1 day")))
		$active="yesterday";
		else if($nextDay==date("Y-m-d",strtotime("+1 day")))
		$active="tomorrow";
		else if($nextDay==date("Y-m-d"))
		$active="today";		
		else
		$active=$nextDay;
		//////////////////////////////////////
		$tmp_array['main']=$active;
		$tmp_array['nextday']=$nextDay;
		$tmp_array['display']=date("M. d, Y",strtotime($nextDay));;
		echo json_encode($tmp_array);
		return;
	}
	function getEditBedtime()
	{
		$data['user']=$this->session->userdata('id');
		$sql = "SELECT	*" ." FROM	user_times" .
				" WHERE	user_id='".$this->session->userdata('id')."'";
		$userwakebed=$this->db->query($sql)->result();	
		
		if(date('N')==6||date('N')==7)
		$isweekend="weekends";
		else
		$isweekend="weekdays";
		
		foreach($userwakebed as $key=>$value)
		{	
			if($value->type=="Bed"&&$value->week_period==$isweekend)
			{
				$data['type']=$value->type;
				$data['week_period']=$value->week_period;
				$data['time']=$value->time;
				$data['utID']=$value->utID;
			}
		}
		
		if($this->active=="today")
		$today=date('Y-m-d');
		else if($this->active=="yesterday")
		$today=date('Y-m-d',strtotime("-1 day"));
		else if($this->active=="tomorrow")
		$today=date('Y-m-d',strtotime("+1 day"));
		
		
		$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";
		$custometime=$this->db->query($sql)->result();	
		$data['custometime']=$custometime;
		
		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$tmp_array['display']=$this->load->view('users/eating_journal/journal_bedtime',$data,true);
		echo json_encode($tmp_array);
		return;
	
	}
	function saveEditBedtime()
	{		
		$data['user']=$this->session->userdata('id');		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		
		if($this->active=="today")
		$today=date('Y-m-d');	
		else if($this->active=="yesterday")
		$today=date('Y-m-d',strtotime("-1 day"));
		else if($this->active=="tomorrow")
		$today=date('Y-m-d',strtotime("+1 day"));		
		
		$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";
		$custometime=$this->db->query($sql)->result();			
		
		$flag="";		
		if(!isset($custometime[0]->bed_time))
		{
			$sql="insert into user_customwakebed set 
			user_id='".$this->session->userdata('id')."',
			bed_time='".date("H:i:s",strtotime($_POST['bedtime']))."',
			date='".$today."'";			
			$flag=$this->db->query($sql);	
		}
		else if(isset($custometime[0]->bed_time))
		{
			$sql="update user_customwakebed set 
			user_id='".$this->session->userdata('id')."',
			bed_time='".date("H:i:s",strtotime($_POST['bedtime']))."',
			date='".$today."' where id='".$custometime[0]->id."'";		
			$flag=$this->db->query($sql);	
		}
		
		$tmp_array['display']=$this->load->view('users/eating_journal/save_waketime',$data,true);
		echo json_encode($tmp_array);		
		return;
	}
	function getEditWaketime()
	{
		$data['user']=$this->session->userdata('id');
		$sql = "SELECT	*" ." FROM	user_times" .
				" WHERE	user_id='".$this->session->userdata('id')."' order by time ASC";
		$userwakebed=$this->db->query($sql)->result();	
				
		$isweekend =$this->journal->dayType(date("D"));		
								
		foreach($userwakebed as $key=>$value)
		{	
			if($value->type=="Wakeup"&&$value->week_period==$isweekend)
			{
				$data['type']=$value->type;
				$data['week_period ']=$value->week_period;
				$data['time']=$value->time;
				$data['utID']=$value->utID;
			}
			else if($value->type=="Bed"&&$value->week_period==$isweekend)
			{
				$data['timeBed']=$value->time;
			}
		}
		if($this->active=="today")
		$today=date('Y-m-d');
		else if($this->active=="yesterday")
		$today=date('Y-m-d',strtotime("-1 day"));
		else if($this->active=="tomorrow")
		$today=date('Y-m-d',strtotime("+1 day"));
		else
		$today=date('Y-m-d',strtotime($this->active));
				
		$data['today']=$today;
		
		$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";
		$custometime=$this->db->query($sql)->result();	
		$data['custometime']=$custometime;
		
		if(isset($_POST['isFirstTime']))
		$data['isFirstTime']=$_POST['isFirstTime'];
		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$tmp_array['display']=$this->load->view('users/eating_journal/journal_waketime',$data,true);
		echo json_encode($tmp_array);
		return;
	}
	/////////////
	function setAutoAdjust($waketime,$today)
	{
		$day = date("D",strtotime($today));		
		$query = "SELECT * FROM user_times WHERE week_period='".$this->journal->dayType($day)."' AND user_id=".$this->session->userdata('id') . " AND isdisable=0 ORDER BY time";
		
		$user_times = $this->db->query($query)->result();
		$flag=0;
		$current_order=array();
		$OUtid=array();
		
		$refertime="";
		$flagwd=1;
		for($i=0;$i<count($user_times);$i++)
		{			
			if($user_times[$i]->type=="Wakeup")
			{
				if($waketime==$user_times[$i]->time)
				{
					$flag=1;
					break;	
				}
				else
				{
					$refertime=$user_times[$i]->time;
					$OUtid[$user_times[$i]->type]=$user_times[$i]->utID;
				}									
			}	
			else
			{
			  	if($user_times[$i]->type=="Snack")
			  	{
					$OUtid[$user_times[$i]->type.($flagwd)]=$user_times[$i]->utID;
			  		$current_order[$user_times[$i]->type.($flagwd++)]=$user_times[$i]->time;
			  	}
				else
				{							
					$OUtid[$user_times[$i]->type]=$user_times[$i]->utID;
					$current_order[$user_times[$i]->type]=$user_times[$i]->time;
					
				}
				
			}
		}
		/*echo "<pre>";
			print_r($OUtid);
			print_r($current_order);
		echo "</pre>";
		return;*/				
		///////////////////////////////
		$neworder=array();
		$temp=array();
				
		if($flag==0)
		{
		  foreach($current_order as $key=>$value)
		  {		  	
		  	$timDiff=$this->getTimeDiff($refertime,$value);		  	 		  
		  	$hour=substr($timDiff,0,2);
		  	$minute=substr($timDiff,3,2);		  				  	
		  	$neworder[$key]=date("H:i:s",strtotime($waketime)+($hour*60*60)+$minute*60);		  	 
		  }
		  $neworder['Wakeup']=$waketime;
		  		 
		  $week_period=$this->journal->dayType($day);
		  foreach($neworder as $key=>$value)
		  {
		  	$temp=$key;
		  	if(substr($key,0,5)=="Snack")
		  	$key="Snack";
		  	
		  	$sql="insert into user_custom_times set
		  	  	user_id='".$this->session->userdata('id')."',
		  	  	type='".$key."',
		  	  	week_period='".$week_period."',
		  	  	time='".$value."',
		  	  	date='".date("Y-m-d")."',
		  	  	outId='".$OUtid[$temp]."'";		  	
		  	$this->db->query($sql);
		  }									  	
		}						
	}
	/////////////
	function saveEditWaketime()
	{		
		$data['user']=$this->session->userdata('id');		
		error_reporting(0);
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$today=date('Y-m-d');
				
		if($this->active=="today")
		{
			$today=date('Y-m-d');
			$sql="SELECT * FROM users WHERE id='".$this->session->userdata('id')."' and SUBSTRING(last_login,1,10)='".$today."'";			
			$userstatus=$this->db->query($sql)->result();
			if(isset($userstatus[0]->first_time_flag)&&$userstatus[0]->first_time_flag==0)
			{
				$sql="update users set first_time_flag='1' where id='".$this->session->userdata('id')."'";
				$this->db->query($sql);								
			}
			
		}	
		else if($this->active=="yesterday")
		$today=date('Y-m-d',strtotime("-1 day"));
		else if($this->active=="tomorrow")
		$today=date('Y-m-d',strtotime("+1 day"));
				
		
		$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";
		$custometime=$this->db->query($sql)->result();			
				
		$flag="";
		$wakebed="";
		if($_POST['waketime'])
		$wakebed.="wake_time='".date("H:i:s",strtotime($_POST['waketime']))."',";
		
		if($_POST['bedtime'])
		$wakebed.="bed_time='".date("H:i:s",strtotime($_POST['bedtime']))."',";
								
		if(!isset($custometime[0]->wake_time))
		{
			$sql="insert into user_customwakebed set 
			user_id='".$this->session->userdata('id')."',".$wakebed."					
			date='".$today."'";							
		}
		else
		{
			$sql="update user_customwakebed set 
			user_id='".$this->session->userdata('id')."',".$wakebed."					
			date='".$today."' where id='".$custometime[0]->id."'";						
		}			
		$flag=$this->db->query($sql);					
		//////////////auto adjust procedure/////////
		
		if(isset($_POST['autoadjust'])&&$_POST['autoadjust']==1)
		{
						
			$this->setAutoAdjust($_POST['waketime'],$today);				
		}
		////////////////////////////////////////////////
		$tmp_array['display']=$this->load->view('users/eating_journal/save_waketime',$data,true);
		echo json_encode($tmp_array);		
		return;
	}
	public function editSleeptime()
	{
		$data['user']=$this->session->userdata('id');		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		
		$sql = "SELECT * FROM user_journel_sleep WHERE id='".$_POST['ujsid']."'";		
		$sleeptime=$this->db->query($sql)->result();
		$data['sleeptime']=$sleeptime;
		
		$tmp_array['display']=$this->load->view('users/eating_journal/editsleeptime',$data,true);
		echo json_encode($tmp_array);		
		return;
	}		
	/////////////////////////////////////
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
		RETURN $hours.':'.$mins.':'.$secs;
	}
	function getSleptTime($today="")
	{//////////////
		$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";			
		$custometime=$this->db->query($sql)->result();
		$wake_time="";
		$bed_time="";
				
		$sql = "SELECT	*" ." FROM	user_times" .
				" WHERE	user_id='".$this->session->userdata('id')."'";
		$userwakebed=$this->db->query($sql)->result();	
		
		if(date('N')==6||date('N')==7)
		$isweekend="weekends";
		else
		$isweekend="weekdays";
				
		
		if(isset($custometime[0]->wake_time)&&strlen($custometime[0]->wake_time)>0)
		$wake_time=$custometime[0]->wake_time;	
		else
		{
			foreach($userwakebed as $key=>$value)
				if($value->type=="Wakeup"&&$value->week_period==$isweekend)
				$wake_time=$value->time;
		}		
		if(isset($custometime[0]->bed_time)&&strlen($custometime[0]->bed_time)>0)
		$bed_time=$custometime[0]->bed_time;	
		else
		{
			foreach($userwakebed as $key=>$value)
				if($value->type=="Bed"&&$value->week_period==$isweekend)
				$bed_time=$value->time;
		}		
		$timediff=$this->getTimeDiff(substr($bed_time,0,5),substr($wake_time,0,5));
		$sleptime['from_time']=substr($bed_time,0,5);
		$sleptime['to_time']=substr($wake_time,0,5);
		$sleptime['duration']=$timediff;		
		return $sleptime;
	}/////////////
	////////////////////////////////
	public function get()
	{
		//$_POST['when'] = 'week';				
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		$tmp_array['active']		= $_POST['when'];
		
		/////////////////check only date//		
		if(date("Y-m-d",strtotime($_POST['when']))==date("Y-m-d",strtotime("-1 day")))
		$_POST['when']="yesterday";
		else if(date("Y-m-d",strtotime($_POST['when']))==date("Y-m-d",strtotime("+1 day")))
		$_POST['when']="tomorrow";
		else if(date("Y-m-d",strtotime($_POST['when']))==date("Y-m-d"))
		$_POST['when']="today";
										
										
		$monthweekparm="";
		if(isset($_POST['weekstart']))
		$monthweekparm=strlen($_POST['weekstart'])>0?$_POST['weekstart']:"";
		else if(isset($_POST['currentmonth']))
		$monthweekparm=$_POST['currentmonth'];
		else		
		$monthweekparm="";
		
		if (($times = $this->journal->get($_POST['when'],$monthweekparm)) === false)
		{		
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid 'when' - ".$_POST['when'];
			echo json_encode($tmp_array);
			return;
		}
		elseif ($_POST['when'] == "week")
		{			
			///////////////////////////////////week claenar view/////			
			$printText=date("M. d, y",strtotime($times['week'][0]))." - ".date("M. d, y",strtotime($times['week'][6]));
			$tmp_array['weekstart']=$times['week'][0];
			$tmp_array['weekend']=$times['week'][6];
			$tmp_array['displaytext']=$printText;
			/////////////////////////////////////////////
			$tmp_array['display'] = '';
			for ($x=0; $x < 7; $x++)
			{
				//////////////////////////get sleep time///////								
				$sql="select * from user_journel_sleep where user_id='".$this->session->userdata('id')."' and date='".$times[$x][0]->today."'";
				$times[$x]['sleep_time']=$this->db->query($sql)->result();									
				////////////////////////////////////////
				$data = array("times" => $times[$x]);
				$tmp_array['display'] .= $this->load->view('users/eating_journal/journal_week',$data,true);
				if (($x & 1) == 1)
				{
					$tmp_array['display'] .= '<div style="clear:both;"></div>';
				}				
			}
			$tmp_array['display'] .= '<div style="clear:both;"></div>';
			echo json_encode($tmp_array);
			return;
		}
		elseif ($_POST['when'] == "month")
		{						
			
			$printText=date("F, Y",strtotime($times['month'][15]));			
			$tmp_array['currentmonth']=date("Y-m-d",strtotime($times['month'][15]));			
			$tmp_array['displaytext']=$printText;
			
			/////////////////////////////////////////////
			
			$tmp_array['display'] = '';
			$display = '';
									
			foreach ($times AS $time)
			{
				//////////////////////////get sleep time///////				
				$sql="select * from user_journel_sleep where user_id='".$this->session->userdata('id')."' and date='".$time[0]->today."'";				
				$time['sleep_time']=$this->db->query($sql)->result();				
				///////////////////////////////////week claenar view/////
				$data = array("times" => $time);
				$display .= $this->load->view('users/eating_journal/journal_month',$data,true);
			}
			$data = array("journal_display" => $display);
			$tmp_array['display'] .= $this->load->view('users/eating_journal/journal_monthly_view',$data,true);
			echo json_encode($tmp_array);
			return;
		}		
		/*
		var_dump($times);
		exit;*/
		//////////////
		
		///////////////
		$lastTime				= false;
		$output					= array();
		$this->journal_output	= array();
		
		$globalwaketime="";
		$globalbedtime="";	

		/////////////////////get global wake time and bed time/
		if($_POST['when']=="today")
		$today=date('Y-m-d');
		else if($_POST['when']=="yesterday")
		$today=date("Y-m-d",strtotime("-1 day"));
		else if($_POST['when']=="tomorrow")
		$today=date("Y-m-d",strtotime("+1 day"));
		else
		$today=date("Y-m-d",strtotime($_POST['when']));					
		$endmeal="";		
		
		foreach($times AS $time)
		{
			if ($time->type == 'Wakeup')
			{
				//////////////////////////////////////omar bglbal///////					
				$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";			
				$custometime=$this->db->query($sql)->result();				
				if(isset($custometime[0]->wake_time)&&strlen($custometime[0]->wake_time)>0)
				{
					$time->time=$custometime[0]->wake_time;	
					$time->hour=intval(substr($time->time,0,2));
					$time->minutes=intval(substr($time->time,2,2));
				}
				$globalwaketime=$time->time;
				///////////////////////////////////////////////////////			
			}
			else if($time->type=="Bed")
			{
					$sql = "SELECT * FROM user_customwakebed WHERE user_id='".$this->session->userdata('id')."' and date='".$today."'";			
					$custometime=$this->db->query($sql)->result();				
					if(isset($custometime[0]->bed_time)&&strlen($custometime[0]->bed_time)>0)
					{
						$time->time=$custometime[0]->bed_time;	
					}					
					$globalbedtime=$time->time;
				////////////////////			
			}
			else if($time->journal)			
			{
				if(!isset($time->journal[0]->skipped))
				$endmeal=$time->journal[0]->time;								
			}
		}		
		//////////////////////////////////////				
		$beforewFlag=0;
		$beforewFlagc=0;
		foreach($times AS $time)
		{			
			if ($time->type == 'Wakeup')
			{					
					$data = array();					
					$data['hour'] 	= date("h:i A",strtotime($time->time));				
					$data['slept']	= $time->hour;																
					////////////////////////////////get slept time/////////
					$slepttime=$this->getSleptTime($today);
					$data['slept_time']=$slepttime;
					$data['type']="Wakeup";
					$data['utID']=$time->utID;
					$data['week_period']=$time->week_period;										
					//////////////////////////////////
					$this->journal_output[-1] = $this->load->view('users/eating_journal/journal_sleep',$data,true);
			}				
			$data = array();
			if($time->type == 'Wakeup')
			$beforewFlag=1;
			if($beforewFlag==0&&in_array($time->type,array("Snack","Breakfast","Dinner","Lunch")))
			{
				$beforewFlagc++;
				$data['beforewFlagc']=$beforewFlagc;
				$data['endmeal']=$endmeal;
			}
			
			$data['globalwaketime']=$globalwaketime;
			$data['globalbedtime']=$globalbedtime;
			$data['activetime']=$today;
			$data['endmeal']=$endmeal;
			if ($time->journal)
			{				
				if ($time->type == 'Exercise')
				{					
					foreach ($time->journal AS $jt)
					{	// make a seperate entry for exercise journal entries
						$data['time'] = $time;
						unset($data['time']->journal);						
						$data['time']->journal[0]=$jt;
						$this->loadOutput($time->type,$data,$jt->hour.sprintf("%02d",$jt->minutes));
					}
				}
				else
				{														
					$data['time']	= $time;
					$this->loadOutput($time->type,$data,$time->journal[0]->hour.sprintf("%02d",$time->journal[0]->minutes));
				}
			}
			else
			{												
				if($time->type=="sleeptime")
				{
					$sdata=array();
					$sdata['sleep']=$time;					
					$this->journal_output[sprintf("%d",str_replace(":","",substr($time->from_time,0,5)))]=$this->load->view('users/eating_journal/journal_sleeptime',$sdata,true);					
				}
				else if($time->type!="Exercise")
				{				
				 $data['time']	= $time;
				 $this->loadOutput($time->type,$data,$time->hour.sprintf("%02d",$time->minutes));
				}				
			}			
		}																
		ksort($this->journal_output);				
		
		// fill in the blank journal entries
		$lasthour				= 0;
		$ret					= '';
		$tmp_array['display']	= '';
		
		
		/////////////////////////
		foreach ($this->journal_output AS $time => $display)
		{						
			$hour		= substr($time,0,-2);			
			$x			= $lasthour + 1;
			$lasthour	= $hour;			
			if ($x > 1)
			{			
				while ($x < $lasthour)
				{									
					/////////////////////////////////////////////
					$data = array();
					if (($y=$x) >= 12) { $y -= 12; $data['ampm'] = "PM"; } else { $data['ampm'] = "AM"; }
					$data['hour'] = sprintf("%02d:%02d",$y,0);
					$tmp_array['display'] .= $this->load->view('users/eating_journal/journal',$data,true);
					$x++;
				}
			}
			$tmp_array['display'] .= $display;
		}		
		echo json_encode($tmp_array);
	}

	private function loadOutput($type,$data,$index)
	{
		while (!empty($this->journal_output[$index]))
		{									
			if($type=="Wakeup")
			$index--;		
			else
			$index++;		// make sure there are no duplicate time entries
		}			
		$sql = "SELECT	*" ." FROM	user_times" .
				" WHERE	user_id='".$this->session->userdata('id')."'";
		$data['userwakebed']=$this->db->query($sql)->result();															
		$this->journal_output[$index] = $this->load->view('users/eating_journal/journal_'.$type,$data,true);
	}

	private function display($template,$time)//$hour,$minutes)
	{
		$ret = '';
		$data['ampm'] = "AM";
		$x = $time->hour + 1;
		$this->hour = $time->hour;
		while ($x < $time->hour)
		{
			if (($y=$x) >= 12) { $y -= 12; $data['ampm'] = "PM"; }
			$data['hour'] = sprintf("%02d:%02d",$y,0);
			$ret .= $this->load->view('users/eating_journal/journal',$data,true);
			$x++;
		}

		if ($time->hour >= 12) { $time->hour -= 12; $data['ampm'] = "PM"; }
		$data['hour'] = sprintf("%02d:%02d",$time->hour,$time->minutes);
		if ($time->hour >= 12) { $time->hour -= 12; $data['ampm'] = "PM"; }
		$data['hour'] = sprintf("%02d:%02d",$time->hour,$time->minutes);
		$ret .= $this->load->view('users/eating_journal/'.$template,$data,true);
		return $ret;
	}

	public function getJournal()
	{
		if (is_numeric($this->ujID) && $this->ujID > 0)
		{
			$query = "SELECT	*" .
					" FROM		user_journal uj, user_times ut" .
					" WHERE		ut.utID=uj.utID AND uj.ujID=".$this->ujID;
			if ($tmp_array['journal'] = $this->db->query($query)->result())
			{
				$query = "SELECT	*" .
						" FROM		user_journal_items" .
						" WHERE		ujID=".$tmp_array['journal'][0]->ujID;
				$tmp_array['journal'][0]->items = $this->db->query($query)->result();
				$tmp_array['error_code']	= 0;
				$tmp_array['error_msg']		= "";
			}
			else
			{
				$tmp_array['error_code']	= 1;
				$tmp_array['error_msg']		= 'journal.php (getJournal) - invalid journal entry ('.$this->ujID.')';
			}
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= 'journal.php (getJournal) - invalid ujID ('.$this->ujID.')';
		}
		echo json_encode($tmp_array);
	}

	public function getItem()
	{
		if (is_numeric($this->ujiID) && $this->ujiID > 0)
		{
			$query = "SELECT	*" .
					" FROM		user_journal_items" .
					" WHERE		ujiID=".$this->ujiID;
			$tmp_array['item']			= $this->db->query($query)->result();
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= 'journal.php (getItem) - invalid ujiID ('.$this->ujiID.')';
		}
		echo json_encode($tmp_array);
	}

	public function getEditJournal()
	{    		
		if (is_numeric(@$this->utID) && @$this->utID > 0)
		{			
			////////////////////modified omarbglobal for edit //			
			//$_POST['ujID'][0]=@$this->ujID;;			
			////////////////////////////////////
			
			$query[]		= array("key" => "ujID", "op" => "IN",	"value" => $_POST['ujID'],	"text" => false);
			$data['time']	= $this->journal->getJournal($this->utID,$query);
			$data['utID']	= @$this->utID;
			$data['date']	= $data['time'][0]->journal[0]->date;
			$dataR['type']	= $data['time'][0]->type;

			if ($data['time'][0]->type != "Exercise")
			{
				$where		= array();
				$where[]	= "ut.type='".$dataR['type']."'";
				$where[]	= "uj.name IS NOT NULL";
				$where[]	= "uj.name!=''";
				$dataR['favoriteMeals']		= $this->journal->getJournalEntry($where,3);
				$data['favoriteMeals']		= $this->load->view('users/eating_journal/favoriteMeals', $dataR, true);
	
				$where		= array();
				$where[]	= "ut.type='".$dataR['type']."'";
				$where[]	= "uj.date<='".$data['time'][0]->journal[0]->date."'";
				$dataR['recentItems']		= $this->journal->getJournalItems($where,6);
				$data['recentItems']		= $this->load->view('users/eating_journal/recentItems', $dataR, true);
	
				$where		= array();
				$where[]	= "ut.type='".$dataR['type']."'";
				$where[]	= "uj.name IS NOT NULL";
				$where[]	= "uj.name!=''";
				$where[]	= "uj.date=DATE_SUB('".$data['time'][0]->journal[0]->date."',INTERVAL 1 DAY)";
				$dataR['yestedaysMeal']		= $this->journal->getJournalEntry($where);
	
				$where		= array();
				$where[]	= "ut.type='".$dataR['type']."'";
				$where[]	= "uj.name IS NOT NULL";
				$where[]	= "uj.name!=''";
				$where[]	= "uj.date=DATE_SUB('".$data['time'][0]->journal[0]->date."',INTERVAL 1 WEEK)";
				$dataR['weekagoMeal']		= $this->journal->getJournalEntry($where);
				$data['recentMeals']		= $this->load->view('users/eating_journal/recentMeals', $dataR, true);
			}

			$tmp_array['display']		= $this->load->view('users/eating_journal/add_to_journal', $data, true);
			$tmp_array['time']			= date("h:i A",strtotime('2010-01-01 '.$data['time'][0]->time));
			$tmp_array['type']			= $data['time'][0]->type;
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= '';
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= 'journal.php (getEditJournal) - invalid utID ('.@$this->utID.')';
		}
		echo json_encode($tmp_array);
	}

	public function getAddToJournal()
	{
		$tmp_array	= array();
		$query		= array();
		$data		= array();		
		switch ($this->active)
		{						
			case "yesterday":
			$day			= date("D",strtotime("-1 day"));
			$data['date']	= date('Y-m-d',strtotime("-1 day"));
			break;

			case "today":
			$day			= date("D");
			$data['date']	= date('Y-m-d');
			break;

			case "tomorrow":
			$day			= date("D",strtotime("+1 day"));
			$data['date']	= date('Y-m-d',strtotime("+1 day"));
			break;
			
			case "week":
			//$day			= date("D",strtotime("+7 day"));
			$day			= date("D",strtotime($this->dayname));			
			$data['date']	= $this->dayname;		    
			break;
			case "month":
			$day			= date("D",strtotime("+7 day"));
			//$data['date']	= date('Y-m-d',strtotime("+7 day"));
			$data['date']	= $this->dayname;		    
			break;
			
			default:
			$day			= date("D",strtotime($this->active));
			$data['date']	= date('Y-m-d',strtotime($this->active));
			break;
			
			/*default:
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid 'when' - ".$this->active;
			echo json_encode($tmp_array);
			return;
			break;
			*/
			
		}

		if (is_numeric(@$this->utID) && @$this->utID > 0)
		{
			$query[] = array("key" => "utID", "op" => "=", "value" => $this->utID, "text" => false);						
			$data['time']		= $this->journal->getTime($query);
						
			///////////////////////////////////////////////get auto adjust time//////
			$sql="select * from user_custom_times where user_id='".$data['time'][0]->user_id."' and type='".$data['time'][0]->type."' 
			and week_period='".$data['time'][0]->week_period."' and date='".$data['date']."' and outId='".$data['time'][0]->utID."'";						
			$result= $this->db->query($sql)->result();									
			if(!empty($result))
			{				
				$data['time'][0]->time=$result[0]->time;				
			}												
			///////////////////////////////////////////////////////////////
			
			$tmp_array['type']	= $data['time'][0]->type;
			$dataR['type']		= $data['time'][0]->type;
			$data['utID']		= $this->utID;	// request utID
		}
		else
		{
			$query[] = array("key" => "type",			"op" => "IN",	"value" => array('Breakfast','Lunch','Dinner'),	"text" => true);
			$query[] = array("key" => "week_period",	"op" => "=",	"value" => $this->journal->dayType($day),		"text" => true);
			$data['time']		= $this->journal->getTime($query);
			$tmp_array['type']	= $data['time'][0]->type;
			$dataR['type']		= $data['time'][0]->type;
		}

		$tmp_array['time']	= date("h:i A",strtotime('2010-01-01 '.$data['time'][0]->time));
		$dataR['active']	= $this->active;

		$where		= array();
		$where[]	= "ut.type='".$data['time'][0]->type."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		$dataR['favoriteMeals']		= $this->journal->getJournalEntry($where,3);
		$data['favoriteMeals']		= $this->load->view('users/eating_journal/favoriteMeals', $dataR, true);

		$where		= array();
		$where[]	= "ut.type='".$data['time'][0]->type."'";
		$where[]	= "uj.date<='".$data['date']."'";
		$dataR['recentItems']		= $this->journal->getJournalItems($where,6);
		$data['recentItems']		= $this->load->view('users/eating_journal/recentItems', $dataR, true);

		$where		= array();
		$where[]	= "ut.type='".$data['time'][0]->type."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		$where[]	= "uj.date=DATE_SUB('".$data['date']."',INTERVAL 1 DAY)";
		$dataR['yestedaysMeal']		= $this->journal->getJournalEntry($where);

		$where		= array();
		$where[]	= "ut.type='".$data['time'][0]->type."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		$where[]	= "uj.date=DATE_SUB('".$data['date']."',INTERVAL 1 WEEK)";
		$dataR['weekagoMeal']		= $this->journal->getJournalEntry($where);
		$data['recentMeals']		= $this->load->view('users/eating_journal/recentMeals', $dataR, true);
		
		/*
		echo "<pre>";
			print_r($_REQUEST);
		echo "</pre>";
		*/	
		
		$data['clear']				= (@$this->clear == 'true') ? '1' : '0';
		$tmp_array['display']		= $this->load->view('users/eating_journal/add_to_journal', $data, true);
		$tmp_array['hour']			= date("g");
		$tmp_array['minutes']		= sprintf("%02d",(intval(date("i") / 30) * 30));
		$tmp_array['ampm']			= date("a");
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';

		echo json_encode($tmp_array);
	}
	///////////////obglobal//////////get current week//////////////
	function getUtidValue()
	{
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		
		//$this->journal->dayType($day);
		//date("D",strtotime("+7 day"));
		
		$dayname=$_POST['dayname'];
		$day= date("D",strtotime($dayname));
		
		$utValue=$_POST['utValue'];		
		$weekperiod=$this->journal->dayType($day);
		
		$sql="SELECT * from user_times where type='".$utValue."' and week_period='".$weekperiod."' and user_id='".$this->session->userdata('id')."'";
		$result	= $this->db->query($sql)->result();	
						 		
		if(empty($result))
		$tmp_array['display']= "";
		else
		$tmp_array['display']= $result[0]->utID;
		
		echo json_encode($tmp_array);
	}
	function getWeek()
	{
		$omsql="SELECT DAYOFWEEK(CURDATE()) as today";
		$dayofweek	= $this->db->query($omsql)->result();			
		$dayindex=intval($dayofweek[0]->today);
		
		/*if(($dayindex-1)<1)
		$dayindex=7;
		else
		$dayindex=$dayindex-1;*/
		/////////////
		$j=0;				
		$week=array();
		for ($i=-(($dayindex-1));; $i++)
		{
			if($j==7)	
			break;
			
			$query	= "SELECT	DATE_ADD(CURDATE(),INTERVAL ".$i." DAY) AS today," .
					"			DAYNAME(DATE_ADD(CURDATE(),INTERVAL ".$i." DAY)) AS dayofweek";				
			
			$date	= $this->db->query($query)->result();	
			$week[$date[0]->today]	= $date[0]->dayofweek;
			$j++;
		}	
		/////////////		
	    return $week;
	}
	function getMonth()
	{
	//////////////
			$firstDay	= date('y').'-'.date('m').'-01';
			//$dayOfWeek	= date("N");
			$dayOfWeek	= date("N",strtotime($firstDay));
			$dayOfMonth	= date("j");
			$numDays	= date("t");
			for ($i=1; $i <= $numDays; $i++)
			{
				$temp=date('Y').'-'.date('m').'-'.$i;
				$temp=date("Y-m-d",strtotime($temp));
				$month[$temp]	= date("D",strtotime($temp));
			}
	    return $month;
	//////////////
	}
	/////////////////////////////////	
	public function addToJournal()
	{
		$tmp_array	= array();
		$query		= array();
		$data		= array();
		
		
		$data['active']=$this->active;
		switch ($this->active)
		{
			/*default:
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid 'when' - ".$this->active;
			echo json_encode($tmp_array);
			return;
			break;
			*/
			//////////////////////edit for only date not yesterday,today,tommorow
			default:
			$day			= date("D",strtotime($this->active));
			$data['date']	= date('Y-m-d',strtotime($this->active));
			break;

			case "yesterday":
			$day			= date("D",strtotime("-1 day"));
			$data['date']	= date('Y-m-d',strtotime("-1 day"));
			break;

			case "today":
			$day			= date("D");
			$data['date']	= date('Y-m-d');
			break;

			case "tomorrow":
			$day			= date("D",strtotime("+1 day"));
			$data['date']	= date('Y-m-d',strtotime("+1 day"));
			break;
			
			case "week":
			$day			= date("D",strtotime("+7 day"));
			$data['date']	= date('Y-m-d',strtotime("+7 day"));			
			$thisweek=$this->getWeek();
			$data['weekday']=$thisweek;	
			break;
			
			case "month":
			$day			= date("D",strtotime("+7 day"));
			$data['date']	= date('Y-m-d',strtotime("+7 day"));			
			$thismonth=$this->getMonth();		
			$data['month']=$thismonth;	
			break;
			
		}

		if (is_numeric(@$this->utID) && @$this->utID > 0)
		{
			$data['utID'] = $this->utID;	// request utID
			$query[] = array("key" => "utID",			"op" => "=", "value" => $this->utID,					"text" => false);
		}
		else
		{
			$query[] = array("key" => "week_period",	"op" => "=", "value" => $this->journal->dayType($day),	"text" => true);
		}

		$data['time']		= $this->journal->getTime($query);
		$tmp_array['time']	= date("h:i A",strtotime('2010-01-01 '.$data['time'][0]->time));
		$tmp_array['type']	= $data['time'][0]->type;
		//////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////	
		$tmp_array['display']		= $this->load->view('users/eating_journal/addToJournal', $data, true);
		$tmp_array['hour']			= date("g");
		$tmp_array['minutes']		= sprintf("%02d",(intval(date("i") / 30) * 30));
		$tmp_array['ampm']			= date("a");
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';

		echo json_encode($tmp_array);
	}
	
	function getMessage($mTitle,$eDate="")
	{
		if($eDate==date('Y-m-d'))				
	 	{
        		$mid=array();
				$msid=array();
				$startNew=0;
				
				$sql="select id from msg_list where title in (".implode(",",$mTitle).")";				
				$msidlist=$this->db->query($sql)->result();		
				$totalmessage=0;		
				for($i=0;$i<count($msidlist);$i++)
				{
					$mid[$i]=$msidlist[$i]->id;
					$sql="select id from msg_desc where mid='".$mid[$i]."'";
					$temp=$this->db->query($sql)->result();
					
					$totalmessage+=count($temp);
					for($j=0;$j<count($temp);$j++)
					{
					 $msid[$mid[$i]][$j]=$temp[$j]->id;
					}
				}
				
				$sql="select * from msg_board where uid='".$this->session->userdata('id')."' and mid in (".implode(",",$mid).") order by mdate desc limit 0,$totalmessage";
				$temp=$this->db->query($sql)->result();
				
				$smid=array();
				$smsid=array();
				for($i=0;$i<count($temp);$i++)
				{
					$smid[$i]=$temp[$i]->mid;	
					$smsid[$i]=$temp[$i]->msdid;	
				}		
				if(count($temp)>=$totalmessage)
				$startNew=1;			
				
				$fmid=0;
				$fmsid=0;
				$flag=0;
				$msgFlag1=array();
				$msgFlag2=array();
				$tFlag=0;	
				$j=0;
				for($i=0;$i<$totalmessage;$i++)
				{
					$tFlag=0;
					foreach($msid as $key=>$value)
					{
						if(isset($value[$flag]))
						{
							$msgFlag1[$j]=$value[$flag];	
							$msgFlag2[$j++]=$key;						
							$tFlag=1;
						}
					}
					if($tFlag==1)
					$flag++;
				}
						
				if($startNew==0)
				{
					for($i=0;$i<count($msgFlag1);$i++)
					{
						if (!in_array($msgFlag1[$i],$smsid)) 
						{
							$fmid=$msgFlag2[$i];
							$fmsid=$msgFlag1[$i];
							break;
						}
					}
				}
				else if($startNew==1)
				{
					for($i=0;$i<count($msgFlag1);$i++)
					{				
						$sql="delete from msg_board where mid='".$msgFlag2[$i]."' and msdid='".$msgFlag1[$i]."'";
						$this->db->query($sql);
						$fmid=$msgFlag2[$i];
						$fmsid=$msgFlag1[$i];
					}
				}
				
				//get final message///////////////
				$newmessage=array();
				if(isset($fmid)&&$fmid>0&&isset($fmsid)&&$fmsid>0)	
				{
					$sql="select message from msg_desc where id='$fmsid'";
					$temp=$this->db->query($sql)->result();		
					
					$newmessage['msg']=	$temp[0]->message;			
					$newmessage['time']=date("Y-m-d H:i:s");
					$sql="insert into msg_board set 
						uid='".$this->session->userdata('id')."',
						mid='".$fmid."',
						msdid='".$fmsid."',
						mdate='".date("Y-m-d H:i:s")."' ";
					
					$this->db->query($sql);	
				}
		}		
		////////////////////////////
		$sql="select msg_board.*,msg_desc.message from msg_board inner join msg_desc on msg_board.msdid=msg_desc.id where msg_board.uid='".$this->session->userdata('id')."' order by msg_board.mdate desc limit 0,30";
		$temp=$this->db->query($sql)->result();			
						
		return $temp;
	}	
	function getDashboard($advice,$eDate="") //get desh board message
	{		
		$dmessage=array();
		$msgTitle=array();
		$dIndex=0;
		$mIndex=0;
		//////////////////////////////////////////////
		if(isset($advice[count($advice)-1]['type'])&&$advice[count($advice)-1]['type']=="Bed")
		$bedtime=$advice[count($advice)-1]['time'];
		if(isset($advice[0]['type'])&&$advice[0]['type']=="Wakeup")
		$waketime=$advice[0]['time'];
		
		$tsleep=$advice[0]['total_sleep'];
		////////sleep message////		
		if($tsleep>=9)
		$msgTitle[$mIndex++]="'- More Than 9 hr'";
		else if($tsleep>=7&&$tsleep<=8)
		$msgTitle[$mIndex++]="'- 7-8 hrs'";
		else if($tsleep>=5&&$tsleep<=6)
		$msgTitle[$mIndex++]="'- 5-7 hrs'";		
		else if($tsleep<5)
		$msgTitle[$mIndex++]="'- Less than 5 hrs'";						
		
		///////////- Check for Multi ///////$dailyData
		$dailyData = $this->user_model->getDaily(date('Y-m-d'));		
		if($dailyData->vitamins==0)
		$msgTitle[$mIndex++]="'- Multi reminder'";		
		
		///////////- Check for 5 way reminder ///////$dailyData
		if($dailyData->pills==0)
		$msgTitle[$mIndex++]="'- 5 Way Reminder'";		
		
		///////////////exercise and last meal///
		$lastmeal=array();
		$exercisecount=0;
		for($i=0;$i<count($advice);$i++)
		{
			if($advice[$i]['type']=="Exercise")
			$exercisecount++;
			else if(in_array($advice[$i]['type'], array('Breakfast','Lunch','Snack','Dinner'))) 
			$lastmeal=$advice[$i];
		}	
		////////////////////////////////////								
		if($exercisecount>0)
		$msgTitle[$mIndex++]="'- Low exercise'";
		
		//////////////////motivation tips//////////		
		$lastlogin=$this->journal->getLastlogin();
		$hdif=(strtotime(date('Y-m-d H:i:s'))-strtotime($lastlogin))/(60*60);
		if($hdif>4)
		$msgTitle[$mIndex++]="'General Motivation (Tips)'";
		
		////////////////////about measurement///////
		$measurmentData=$this->journal->getMeasurement();
		if(empty($measurmentData))
		$msgTitle[$mIndex++]="'- Enter Measurement'";
		else
		{
		     $hdif=(strtotime(date('Y-m-d H:i:s'))-strtotime($measurmentData[0]['um_date']))/(24*60*60);
			 if($hdif>=22)
			 $msgTitle[$mIndex++]="'- Update Measurement'";	

			if($hdif>=22&&$measurmentData[0]['um_bweight']==0)
			$msgTitle[$mIndex++]="'- Update Weight'";			 
			 
			 
			 if($measurmentData[0]['um_neck']==0||
			 $measurmentData[0]['um_chest']==0||$measurmentData[0]['um_biceps']==0||
			 $measurmentData[0]['um_forearms']==0||$measurmentData[0]['um_wrist']==0||
			 $measurmentData[0]['um_waist']==0||$measurmentData[0]['um_hips']==0||
			 $measurmentData[0]['um_thighs']==0||$measurmentData[0]['um_calves']==0||
			 $measurmentData[0]['um_bweight']==0)
			 $msgTitle[$mIndex++]="'- Enter Measurement'";
		  
		}		
		
		//////////////////about last meal//
		if(!empty($lastmeal))
		{
			if($lastmeal['type']=="Snack")
			{
				if($lastmeal['food_description']['isfatlosplate']==1)
				$msgTitle[$mIndex++]="'- Last snack was correct'";
				else if($lastmeal['food_description']['total_calories']>250&&$lastmeal['sex']=="Male"
				||$lastmeal['food_description']['total_calories']>250&&$lastmeal['sex']=="Female")
				$msgTitle[$mIndex++]="'- Last snack was too large'";
				else if($lastmeal['food_description']['total_calories']<150&&$lastmeal['sex']=="Male"
				||$lastmeal['food_description']['total_calories']>150&&$lastmeal['sex']=="Female")
				$msgTitle[$mIndex++]="'- Last snack was too small'";
			}
			else
			{
				if($lastmeal['food_description']['isfatlosplate']==1)
				$msgTitle[$mIndex++]="'- Last meal was Fat Loss Plate'";
				else
				$msgTitle[$mIndex++]="'- Last meal was not Fat Loss Plate'";			
			}
		}
				
		$dmessage=$this->getMessage($msgTitle,$eDate);
		return $dmessage;
	}
	//////////////////////////////////////////getadvice////////
	function getadvice()
	{	
		$this->load->model('journal_model');
		
		if(!isset($_POST['when']))
		$_POST['when']="today";
		
		if($_POST['when']=="today")
		$eDate=date('Y-m-d');
		else if($_POST['when']=="yesterday")
		$eDate=date('Y-m-d',strtotime("-1 day"));
		else if($_POST['when']=="tomorrow")
		$eDate=date('Y-m-d',strtotime("+1 day"));
		else
		$eDate=date('Y-m-d',strtotime($_POST['when']));		 		
		
		
		$data['advice']=$this->journal_model->getfatlossadvice();		 		
		$data['eDate']=$eDate;
		
		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';		
		
		$tmp_array['display']		= $this->load->view('users/eating_journal/journal_fatburningzone', $data, true);
		
		///////////for dash board formulla			
		$data['dmessage']=$this->getDashboard($data['advice'],$eDate);		
		$tmp_array['dashboard']= $this->load->view('users/eating_journal/dashboard',$data, true);
		/////////////////for daily tracker left hand///////////		
		if($_POST['when']!="week"&&$_POST['when']!="month")
		{		 		 
		 //////////////////		 
		 $dtdaily['dtracker']=$_POST;
		 $dtdaily['eDate']=$eDate;	 			
		 $dtdaily['dailyData']=$this->user_model->getDaily($eDate);
		 $tmp_array['lefttracker']	=$this->load->view('users/eating_journal/getdailytracker', $dtdaily, true);;
		}
		//////////////////////////////////////////////////
		echo json_encode($tmp_array);
	}
	///////////////////////////////////////////////////
	function addrecipejournal()
	{
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		/////////////////
		$isrecipeadd=$this->journal->recipeaddjournal($_POST);		
		/////////////////
		echo json_encode($tmp_array);
		return;
	}
	function addrecipeboxjournal()
	{
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		/////////////////
		$isrecipeadd=$this->journal->boxmealaddjournal($_POST);		
		/////////////////
		echo json_encode($tmp_array);
		return;
	}
	function autoupdatepopup()
	{
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';
		/////////////////
		$rdata=array();
		$rdata["fatlossdata"]=$this->journal->autoupdateflp($_POST);	
		$tmp=$this->load->view('users/eating_journal/popupfatloss', $rdata, true);
		$temp=json_decode($tmp);				
		$tmp_array['message']=$temp->message;
		$tmp_array['flag']=$temp->flag;
		/////////////////		 
		echo '<textarea>' . json_encode($tmp_array) . '</textarea>';
	}
	function getFavourite()
	{
	////			
		$where		= array();
		$where[]	= "ut.type='".$_POST['type']."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		
		$dataR['type']=$_POST['type'];
		
		$dataR['favoriteMeals']		= $this->journal->getJournalEntry($where,3);
		$data['favoriteMeals']		= $this->load->view('users/eating_journal/favoriteMeals', $dataR, true);

		$where		= array();
		$where[]	= "ut.type='".$_POST['type']."'";
		$where[]	= "uj.date<='".date('Y-m-d')."'";
		$dataR['recentItems']		= $this->journal->getJournalItems($where,6);
		$data['recentItems']		= $this->load->view('users/eating_journal/recentItems', $dataR, true);

		$where		= array();
		$where[]	= "ut.type='".$_POST['type']."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		$where[]	= "uj.date=DATE_SUB('".date('Y-m-d')."',INTERVAL 1 DAY)";
		$dataR['yestedaysMeal']		= $this->journal->getJournalEntry($where);

		$where		= array();
		$where[]	= "ut.type='".$_POST['type']."'";
		$where[]	= "uj.name IS NOT NULL";
		$where[]	= "uj.name!=''";
		$where[]	= "uj.date=DATE_SUB('".$_POST['type']."',INTERVAL 1 WEEK)";
		$dataR['weekagoMeal']		= $this->journal->getJournalEntry($where);
		$data['recentMeals']		= $this->load->view('users/eating_journal/recentMeals', $dataR, true);							
				
		
		$tmp_array					= array();
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= '';				
		$tmp_array['display']= $this->load->view('users/eating_journal/typemeal', $data, true);
		echo json_encode($tmp_array);
	///
	}
	//////////////////////////////////////////////////	
}

?>