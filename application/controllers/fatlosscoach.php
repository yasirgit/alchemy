<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');
class Fatlosscoach extends Controller {
   private $viewVars = array();

 public function __construct()
 {
    parent::Controller();
	$this->pageVars['css'] = array();
	$this->pageVars['js'] = array();
	$this->load->model(array('user_model', 'user_food_model','journal_model'));	
	$this->load->library(array('Auth', 'form_validation'));
	$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
	
	if(!$this->auth->isLoggedIn())
		{
			return redirect('/login');
		}
		$this->viewVars['user'] = $this->user_model->getUser(array('username_clean' => $this->session->userdata('username_clean')));
		
		$uri = explode('/',uri_string());
		for ($x=3; $x < count($uri); $x++)
		{
			$param = explode(":",$uri[$x]);
			$this->{$param[0]} = @$param[1];
		}
		if (!$this->session->userdata('date'))
		{
			$this->session->set_userdata(array("date" => date("Y-m-d")));
		} 
 }
 
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
 
 function cmp($a, $b) 
 {			  	 
	 $a=$a[key($a)];
	 $b=$b[key($b)];	 
     if ($a==$b) 
	  {
		   return 0;
	  }
	  return ($a < $b) ? -1 : 1;
  } 
 function getFeedBackMsg($msgTitleArray,$flag=0)
 {
	  $mainArray=array();
	  $i=0;
	  foreach($msgTitleArray as $key=>$value) 
	  $mainArray[$i++]=array($key=>$value);  
	  usort($mainArray, array("Fatlosscoach", "cmp"));  
	  
	  $msgTitle="";
	  for($i=0;$i<count($mainArray);$i++)
	  {
	   $msgTitle.="'".key($mainArray[$i])."'";
	   if($flag==0&&$i==3)
	   break;
	   else if($i==4)
	   break;
	   if($i<(count($mainArray)-1))
	   $msgTitle.=",";
	  }
	  
	  $msglist=array();
	  if(strlen($msgTitle)>0)
	  {	   
		  $sql="select fatloss_msg_list.*,fatloss_msg_desc.* from fatloss_msg_list inner join   fatloss_msg_desc on fatloss_msg_list.id=fatloss_msg_desc.fmid where fatloss_msg_list.title in ($msgTitle) and fatloss_msg_desc.dayflag=$flag order by fatloss_msg_desc.priority asc";	 
		  $result=$this->db->query($sql)->result();	  
		  
		  $messageArray=array();
		  for($i=0;$i<count($result);$i++)
		  $messageArray[$result[$i]->title][]=$result[$i]->message;
			  
		  $i=0;
		  foreach($messageArray as $key=>$value)
		  {
		   $rendomvalue=rand(1,1000);
		   $msglist[$i++]=$messageArray[$key][$rendomvalue%3];	   
		  }
	  }	  
	  return $msglist;
 }
 
 function gettodaycoach()
 {
	$this->pageVars['isajax'] = true;
	$tmp_array= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= '';
	$this->load->model('journal_model');		
	
	$data=array();
	$result="";
	$data['active']=$_POST['active'];	
	
	if(date('Y-m-d',strtotime($_POST['active']))==date("Y-m-d"))
	$_POST['active']="today";
	
	if($_POST['active']=="today")
	{
		$data['advice']=$this->journal_model->getfatlossadvice();		
		$data['istoday']=1;
		$temp=$this->load->view('fatloss/fatloss_today', $data, true);			
		$result['data']=json_decode($temp);
		
		$display=$this->load->view('fatloss/chart', $result, true);			
		//$tmp_array['grade']	= $this->gradeCalculate($result['data']->total_score);
		$tmp_array['grade']	= "--";
		$tmp_array['fat_burning_mode']	= round($result['data']->fat_burning_mode);				
		$tmp_array['active']	= "Today";	
		
		$tmp_array['active_date']	= date("m/d/Y");							
	}	
	else if($_POST['active']=="yesterday")
	{
		$data['advice']=$this->journal_model->getfatlossadvice(date("Y-m-d",strtotime("-1 day")));		
		$temp=$this->load->view('fatloss/fatloss_today', $data, true);			
		$result['data']=json_decode($temp);
		
		$display=$this->load->view('fatloss/chart', $result, true);			
		$tmp_array['grade']	= $this->gradeCalculate($result['data']->total_score);
		$tmp_array['fat_burning_mode']	= round($result['data']->fat_burning_mode);				
		$tmp_array['active']	= "Yesterday";
		$tmp_array['active_date']	= date("m/d/Y",strtotime("-1 day"));				
	}
	else
	{		
		$theExactDate=date("Y-m-d",strtotime($data['active']));
		
		$data['advice']=$this->journal_model->getfatlossadvice($theExactDate);		
		$temp=$this->load->view('fatloss/fatloss_today', $data, true);			
		$result['data']=json_decode($temp);		
		
		$display=$this->load->view('fatloss/chart', $result, true);			
		$tmp_array['grade']	= $this->gradeCalculate($result['data']->total_score);
		$tmp_array['fat_burning_mode']	= round($result['data']->fat_burning_mode);				
		
		if($theExactDate==(date("Y-m-d",strtotime("-1 day"))))		
		$tmp_array['active']	= "Yesterday";
		else if($theExactDate==(date("Y-m-d")))		
		$tmp_array['active']	= "Today";
		else
		$tmp_array['active']	= date("F j, Y",strtotime($theExactDate));
		
		$tmp_array['active_date']	= date("m/d/Y",strtotime($theExactDate));
	}	
	
	///////////////// /////////fat loss coach feedback///				
	$areaofimprovement=array_count_values($result['data']->areaofimprovement);
	$areayoudowell=array_count_values($result['data']->youdidwell);				
	$msglist['negative']=$this->getFeedBackMsg($areaofimprovement);	
	$msglist['positive']=$this->getFeedBackMsg($areayoudowell);		
		
	$tmp_array['positivefeedback']=$this->load->view('fatloss/tpfeedback', $msglist, true);
	$tmp_array['negativefeedback']=$this->load->view('fatloss/tnfeedback', $msglist, true);
	//////////////////////////end fat loss coach////////	
	$tmp_array['display']		= $display;				
	echo json_encode($tmp_array);
 }
 ///////////////////////////////////////
 function getweekcoach()
 {
	
	$this->pageVars['isajax'] = true;
	$tmp_array= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= '';
	
	//////////////////////////////////////////////fat loss feedback////////
	$arrayofneedimprove=array();
	$arrayofdidwell=array();
	$totalcardio=0;
	$totalresistance=0;
	$isCarFlag=0;
	$isResisFlag=0;
	$isNoExFlag=0;
	/////////////////////////////////////////////////
	
	if(isset($_POST['ws'])&&strlen($_POST['ws'])>0)
	{
		$weekstart=date("Y-m-d",strtotime($_POST['ws']));
		$weekend=date("Y-m-d",strtotime("+6 day",strtotime($weekstart)));
	}
	
	
	if(strlen($weekstart)==0&&strlen($weekend)==0)
	{
		$day=date("w");
		$weekstart=date("Y-m-d",strtotime("-$day day"));
		$weekend=date("Y-m-d",strtotime((6-$day)." day"));
	}		
	//////////////calculate week date////////
	if(isset($weekstart)&&strlen($weekstart)>0)
	{		
		 $data=array();
		 $result=array();
		 $total_fatburning=0;
		 $total_score=0;
		 $count=0;
		 for($i=0;$i<=6;$i++)
		 {
			$theExactDate=date("Y-m-d",strtotime("$i day",strtotime($weekstart)));		
			if($theExactDate==date("Y-m-d"))
			break;			
						
			$count++;
			$result['advice']=$this->journal_model->getfatlossadvice($theExactDate);		
			$temp=$this->load->view('fatloss/fatloss_today', $result, true);						
			$result['data']=json_decode($temp);	
			$data['fat_burning_mode'][$theExactDate]=round($result['data']->fat_burning_mode);
			$total_fatburning+=$result['data']->fat_burning_mode;
			
			$data['grade'][$theExactDate]=$this->gradeCalculate($result['data']->total_score);
			$data['total_score'][$theExactDate]=$result['data']->total_score;		
			$total_score+=$result['data']->total_score;
			
			//////////////////////fat loss coach/////////////////////
			$arrayofneedimprove=array_merge($arrayofneedimprove,$result['data']->areaofimprovement);
			$arrayofdidwell=array_merge($arrayofdidwell,$result['data']->youdidwell);
			$totalcardio+=$result['data']->cardio_exercise;						
			$totalresistance+=$result['data']->resistance_exercise;									
			if($result['data']->cardio_exercise==0&&$result['data']->resistance_exercise==0)
			$isNoExFlag++;
			else
			$isNoExFlag=0;
			
			if($result['data']->cardio_exercise==0)
			$isCarFlag++;
			else
			$isCarFlag=0;
			
			if($result['data']->resistance_exercise==0)
			$isResisFlag++;
			else
			$isResisFlag=0;
			
			if($isNoExFlag>=3)
			{
			  array_push($arrayofneedimprove, "Not enough Cardio/Resistance");	
			  $isNoExFlag=0;
			}
			else if($isCarFlag>=4)
			{
			  array_push($arrayofneedimprove, "Not enough Cardio");	
			  $isCarFlag=0;			
			}
			else if($isResisFlag>=4)
			{
			  array_push($arrayofneedimprove, "Not enough Resistance");	
			  $isResisFlag=0;			
			}						
			//////////////////////end fat loss coach/////////////////////
		 }		 
		 if($count==0)
		 {
			$data['final_grade']="F";
			$data['final_fat_burning']=0;
		 }
		 else
		 {
		  $data['final_grade']=$this->gradeCalculate($total_score/$count);
		  $data['final_fat_burning']=round($total_fatburning/$count);
		 }
		 
		 $tmp_array['final_grade']		= $data['final_grade'];	
		 $tmp_array['final_fat_burning']= $data['final_fat_burning'];		
		 $tmp_array['dispalyweeek']= date("m/d/Y",strtotime($weekstart))."-".date("m/d/Y",strtotime($weekend));		 		 
		 $display=$this->load->view('fatloss/weekchart', $data, true);		 
		 $tmp_array['weekly_chart_view_label']=$this->load->view('fatloss/weekchart_view_label', $data, true);		 
		 $tmp_array['display']		= $display;		
		 
	///////////////// /////////fat loss coach feedback///						
		if($totalcardio==0&&$totalresistance==0)
		array_push($arrayofneedimprove, "No Exercise (cardio or resistance)");
		else if($totalcardio>=3&&$totalresistance>=2)
		array_push($arrayofdidwell, "Exercised correct amount (c/r)");
		
		$areaofimprovement=array_count_values($arrayofneedimprove);
		$areayoudowell=array_count_values($arrayofdidwell);				
		$msglist['negative']=$this->getFeedBackMsg($areaofimprovement,1);	
		$msglist['positive']=$this->getFeedBackMsg($areayoudowell,1);		

		$tmp_array['positivefeedback']=$this->load->view('fatloss/tpfeedback', $msglist, true);
		$tmp_array['negativefeedback']=$this->load->view('fatloss/tnfeedback', $msglist, true);		
	//////////////////////////end fat loss coach////////		 
		 
		 
		 echo json_encode($tmp_array);
	 }
	///////////////////////////////////////////	
 }
 ///////////////////////////////////////
 function getmonthcoach()
 {
	$this->pageVars['isajax'] = true;
	$tmp_array= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= '';
	$total_day=0;
	
	//////////////////////////////////////////////fat loss feedback////////
	$arrayofneedimprove=array();
	$arrayofdidwell=array();
	$totalcardio=0;
	$totalresistance=0;
	$isCarFlag=0;
	$isResisFlag=0;
	$isNoExFlag=0;
	/////////////////////////////////////////////////
	
	
	////////////////////////////////////////
	if(isset($_POST['ms'])&&strlen($_POST['ms'])>0)
	{
		$monthkstart=date("Y-m-d",strtotime($_POST['ms']));
	}	
	if(strlen($monthkstart)==0&&strlen($monthkstart)==0)
	{
		$monthkstart=date("Y-m-"."01");
		
	}	
	if(isset($monthkstart)&&strlen($monthkstart)>0)
	{		
		 $data=array();
		 $result=array();
		 $total_fatburning=0;
		 $total_score=0;
		 $count=0;
		 $total_day=date("t",strtotime($monthkstart));/////upto today
		 $data['total_day']=$total_day;
		 for($i=0;$i<$total_day;$i++)
		 {
			$theExactDate=date("Y-m-d",strtotime("$i day",strtotime($monthkstart)));		
			if($theExactDate==date("Y-m-d"))
			break;			
						
			$count++;
			$result['advice']=$this->journal_model->getfatlossadvice($theExactDate);		
			$temp=$this->load->view('fatloss/fatloss_today', $result, true);						
			$result['data']=json_decode($temp);	
			$data['fat_burning_mode'][$theExactDate]=round($result['data']->fat_burning_mode);
			$total_fatburning+=$result['data']->fat_burning_mode;
			
			$data['grade'][$theExactDate]=$this->gradeCalculate($result['data']->total_score);
			$data['total_score'][$theExactDate]=$result['data']->total_score;		
			$total_score+=$result['data']->total_score;
			
			//////////////////////fat loss coach/////////////////////
			$arrayofneedimprove=array_merge($arrayofneedimprove,$result['data']->areaofimprovement);
			$arrayofdidwell=array_merge($arrayofdidwell,$result['data']->youdidwell);
			$totalcardio+=$result['data']->cardio_exercise;						
			$totalresistance+=$result['data']->resistance_exercise;									
			if($result['data']->cardio_exercise==0&&$result['data']->resistance_exercise==0)
			$isNoExFlag++;
			else
			$isNoExFlag=0;
			
			if($result['data']->cardio_exercise==0)
			$isCarFlag++;
			else
			$isCarFlag=0;
			
			if($result['data']->resistance_exercise==0)
			$isResisFlag++;
			else
			$isResisFlag=0;
			
			if($isNoExFlag>=3)
			{
			  array_push($arrayofneedimprove, "Not enough Cardio/Resistance");	
			  $isNoExFlag=0;
			}
			else if($isCarFlag>=4)
			{
			  array_push($arrayofneedimprove, "Not enough Cardio");	
			  $isCarFlag=0;			
			}
			else if($isResisFlag>=4)
			{
			  array_push($arrayofneedimprove, "Not enough Resistance");	
			  $isResisFlag=0;			
			}						
			//////////////////////end fat loss coach/////////////////////
			
		 }		 
		 if($count==0)
		 {
			$data['final_grade']="F";
			$data['final_fat_burning']=0;
		 }
		 else
		 {
		  $data['final_grade']=$this->gradeCalculate($total_score/$count);
		  $data['final_fat_burning']=round($total_fatburning/$count);
		 }

		 $tmp_array['final_grade']		= $data['final_grade'];	
		 $tmp_array['final_fat_burning']= $data['final_fat_burning'];
			
		 $tmp_array['displaymonth']= date('F, Y', strtotime($monthkstart));
		 $tmp_array['reference_month']= date('m/d/Y', strtotime($monthkstart));

		 $display=$this->load->view('fatloss/monthchart', $data, true);		 
		 $tmp_array['display']		= $display;	

		///////////////// /////////fat loss coach feedback///											
			if($totalcardio==0&&$totalresistance==0)
			array_push($arrayofneedimprove, "No Exercise (cardio or resistance)");
			else if($totalcardio>=3&&$totalresistance>=2)
			array_push($arrayofdidwell, "Exercised correct amount (c/r)");
			
			$areaofimprovement=array_count_values($arrayofneedimprove);
			$areayoudowell=array_count_values($arrayofdidwell);				
						
			$msglist['negative']=$this->getFeedBackMsg($areaofimprovement,2);	
			$msglist['positive']=$this->getFeedBackMsg($areayoudowell,2);		

			$tmp_array['positivefeedback']=$this->load->view('fatloss/tpfeedback', $msglist, true);
			$tmp_array['negativefeedback']=$this->load->view('fatloss/tnfeedback', $msglist, true);		
		//////////////////////////end fat loss coach////////		 
		 echo json_encode($tmp_array);
	}
	////////////////////////////////////////
 }
 ////////////////////////////////
  function count_days( $ab, $bc )
  {		
		$beginDate = strtotime($ab);
		$endDate = strtotime($bc);		 
		$diff = ceil(abs($beginDate-$endDate) / (60*60*24)) ;
		return $diff;		
  }
 /////////////////////////////////////
 function getmthcoach($monthstart)
 {
	 $data=array();
	 $result=array();
	 $total_fatburning=0;
	 $total_score=0;
	 $count=0;
	 
	 $total_day=date("t",strtotime($monthstart));
 //////////////////////////
	 for($i=0;$i<$total_day;$i++)
	 {
		$theExactDate=date("Y-m-d",strtotime("$i day",strtotime($monthstart)));		
		if($theExactDate==date("Y-m-d"))
		break;
		
		$count++;
		$result['advice']=$this->journal_model->getfatlossadvice($theExactDate);		
		$temp=$this->load->view('fatloss/fatloss_today', $result, true);						
		$result['data']=json_decode($temp);			
		$total_fatburning+=$result['data']->fat_burning_mode;				
		$total_score+=$result['data']->total_score;
	 }
	 $return['fatburning']=round($total_fatburning/$count);
	 $return['grade']=$this->gradeCalculate($total_score/$count);
	 
	 $return['score']=$total_score;
	 $return['fatburning_data']=$total_fatburning;
	 $return['count']=$count;
	 
	 return $return;
 
 }	
 ///////////////////////////////////////
 function getwkcoach($weekstart)
 {	 
	 $data=array();
	 $result=array();
	 $total_fatburning=0;
	 $total_score=0;
	 $count=0;
 //////////////////////////
	 for($i=0;$i<=6;$i++)
	 {
		$theExactDate=date("Y-m-d",strtotime("$i day",strtotime($weekstart)));		
		if($theExactDate==date("Y-m-d"))
		break;
		
		$count++;
		$result['advice']=$this->journal_model->getfatlossadvice($theExactDate);		
		$temp=$this->load->view('fatloss/fatloss_today', $result, true);						
		$result['data']=json_decode($temp);			
		$total_fatburning+=$result['data']->fat_burning_mode;				
		$total_score+=$result['data']->total_score;
	 }
	 $return['fatburning']=round($total_fatburning/$count);
	 $return['grade']=$this->gradeCalculate($total_score/$count);
	 
	 $return['score']=$total_score;
	 $return['fatburning_data']=$total_fatburning;
	 $return['count']=$count;
	 
	 return $return;
 //////////////////////////
 }
 ////////////////////////////////////////
 function gettodatecoach()
 {
	$this->pageVars['isajax'] = true;
	$tmp_array= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= '';
	
	$startdate= date("Y-m-d",strtotime($this->session->userdata('regdate')));
	$enddate=date("Y-m-d");
	$daydiff=$this->count_days($startdate,$enddate);
		
	
	$weekarray=array();
	$data=array();
	$final=array();
	$intervalstart="";
	$intervalend="";
	
	$montharray=array();	
	
	if($daydiff<=56)///////8week
	{
		$i=0;
		$temp=strtotime($startdate);
		$intervalstart=date("m/d/Y",strtotime($startdate));
		while($temp<=strtotime($enddate))
		{
			$weekarray[$i]['start']=date("Y-m-d",$temp);						
			$weekarray[$i]['end']=date("Y-m-d",strtotime('+6 day',$temp));			
			$temp=strtotime('+7 day', $temp);	
			$intervalend=date("m/d/Y",strtotime($weekarray[$i]['end']));	
			$i++;
		}
	/////////////////////////////////////////////
	  $total_count=0;		
	  $total_fatburning=0;
	  $total_score=0;
	  for($i=0;$i<count($weekarray);$i++)	 
	  {
		 $data=$this->getwkcoach($weekarray[$i]['start']);
		 $weekarray[$i]['fatburning']=$data['fatburning'];
		 $weekarray[$i]['grade']=$data['grade'];
		
         $total_score+=$data['score'];
		 $total_fatburning+=$data['fatburning_data'];
		 $total_count+=$data['count'];	  
	  }
	  $final['result']=$weekarray;
	  $final['grade']=$this->gradeCalculate($total_score/$total_count);
	  $final['fatburning']=round(($total_fatburning/$total_count));
	  
	  $tmp_array['final_grade']= $final['grade'];
	  $tmp_array['final_fatburning']= $final['fatburning'];
	  $tmp_array['interval']= $intervalstart."-".$intervalend;
	  		
	  $final['isweek']=1;
	  $chart=$this->load->view('fatloss/todatechart', $final, true);
	  $label=$this->load->view('fatloss/todatechartlabel', $final, true);	  
	/////////////////////////////////////////////	
	}
	else	//last eight month
	{
		$montharray[0]['start']=date('Y-m')."-01";
		$montharray[0]['end']=date("Y-m-d");
		
		if(strlen($startdate)>0)
		{
			$i=1;
			$temp=strtotime($montharray[0]['start']);		
			while(strtotime('-1 months',$temp)>=strtotime($startdate))
			{				
				$montharray[$i]['start']=date("Y-m-d",strtotime('-1 months',$temp));			
				$montharray[$i]['end']=date("Y-m",strtotime($montharray[$i]['start']))."-".date("t",strtotime($montharray[$i]['start']));								
				$temp=strtotime($montharray[$i]['start']);									
				
				if($i==7)
				break;
				
				$i++;				
			}
		}
		sort($montharray);
		/////////////////////////////////////////////
		  $total_count=0;		
		  $total_fatburning=0;
		  $total_score=0;
		  $intervalstart=date("m/d/Y",strtotime($montharray[0]['start']));
		  $intervalend=date("m/d/Y",strtotime($montharray[count($montharray)-1]['end']));
		  
		  for($i=0;$i<count($montharray);$i++)	 
		  {
			 $data=$this->getmthcoach($montharray[$i]['start']);			 
			 $montharray[$i]['fatburning']=$data['fatburning'];
			 $montharray[$i]['grade']=$data['grade'];
			
			 $total_score+=$data['score'];
			 $total_fatburning+=$data['fatburning_data'];
			 $total_count+=$data['count'];	  
		  }
		  $final['result']=$montharray;
		  $final['grade']=$this->gradeCalculate($total_score/$total_count);
		  $final['fatburning']=round(($total_fatburning/$total_count));
		  
		  $tmp_array['final_grade']= $final['grade'];
		  $tmp_array['final_fatburning']= $final['fatburning'];
		  $tmp_array['interval']= $intervalstart."-".$intervalend;		
		
		  $final['ismonth']=1;	
		  $chart=$this->load->view('fatloss/todatechart', $final, true);
		  $label=$this->load->view('fatloss/todatechartlabel', $final, true);		  
		/////////////////////////////////////////////	
	}	
	
	$tmp_array['chart']		= $chart;		
	$tmp_array['label']		= $label;		
	echo json_encode($tmp_array);
 }
 ////////////////////////
 function index()
  {    
	$this->load->view("fatloss/index",$this->viewVars);	
  }
 
}
?>