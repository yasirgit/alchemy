<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');
class Successjournal extends Controller {
   private $viewVars = array();

 public function __construct()
 {
    parent::Controller();
	//$this->pageVars['css'] = array();
	//$this->pageVars['js'] = array();
	
	
	$this->load->model(array('user_model', 'user_food_model', 'succ_measure_model','success_journal_model','journal_model'));
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
		
		 $this->pageVars['css'] = array('slider/jquery.css','slider/jquery.ui.slider.css','slider/demos.css','slider/jquery.ui.theme.css','calendar/calendar.css','goal_meter/jquery.css','goal_meter/demos.css','goal_meter/progress_bar.css','jgraph/jquery.jqplot.css','count_down/jquery.countdown.css');

	    
		 $this->pageVars['js'] = array('sliderjs/jquery_003.js','sliderjs/jquery_004.js','sliderjs/jquery.js','sliderjs/jquery_002.js','sliderjs/custom.js','calendar/calendar.js','goal_meter/jquery.js','goal_meter/jquery_002.js','goal_meter/jquery_003.js','jgraph/jquery.jqplot.js','jgraph/jqplot.dateAxisRenderer.js','jgraph/jqplot.canvasAxisTickRenderer.min.js','jgraph/jqplot.canvasTextRenderer.min.js','count_down/jquery.countdown.js','ultimate_goal.js');
		 
 
 }
 
 function index()
  {
       
      $u_id=$this->session->userdata('id');
      /*if($this->input->post('upJournal'))
	  {
	     $this->success_journal_model->updateJournal();
	  }*/
	 $this->viewVars['msg'] =0; 
	  
	 if($this->input->post('journalEntry')){
	     $this->form_validation->set_rules('addtitle', 'Addtitle', 'required');
		 $this->form_validation->set_rules('details', 'Details', 'required');
		 $this->form_validation->set_rules('access-type', 'public / private', 'required');
		
	     if ($this->form_validation->run() == FALSE)
		 {
		   $this->viewVars['msg'] =2;
		 }
		 else
		 {
	          $this->success_journal_model->addjournal();
			  $this->viewVars['msg'] =2;
		 }
     // exit();
	 }
	 if($this->input->post('upLoadImage'))
	 {
	    $this->success_journal_model->uploadGallery($u_id);
	 }
	 
	
	// $this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();

     $this->viewVars['row']= $this->success_journal_model->orginalMeasure();
	 $this->viewVars['getuval']= $this->success_journal_model->get_start_userval();
	 $this->viewVars['weekcount']= $this->success_journal_model->weekCount();
	 $this->viewVars['ugoalset']= $this->success_journal_model->getUltimateGoal();
	 $this->viewVars['bckcount']= $this->success_journal_model->bckListCount();
	 $this->viewVars['bcklist']= $this->success_journal_model->getBucketList();
     $this->viewVars['uacDate']= $this->success_journal_model->getuserActiveDate();
	 $this->viewVars['weekGoal']= $this->success_journal_model->getWeekGoal();
	 $this->viewVars['bonusGoal']= $this->success_journal_model->getBonusGoal();
	 $this->viewVars['bonusOptions']= $this->success_journal_model->getBonusOptions();
	 $this->viewVars['fetureid']= $this->success_journal_model->getfeatureName();
	 $this->viewVars['nonfetured']= $this->success_journal_model->getNonfeatureName();
	// $this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();
	 
	 //update measurement //
	   
	
		$this->viewVars['first_dayMsr'] = $this->succ_measure_model->get_firstday_um($u_id);
		$this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	    $this->viewVars['all_val'] = $this->succ_measure_model->get_all_um($u_id);
		$this->viewVars['to_umval'] = $this->succ_measure_model->getall_um_todate($u_id);
		////////////////////Week Calculate/////////////////////////////
		$day=date("w"); //echo "---";
	    $weekstart=date("Y-m-d",strtotime("-$day day"));//echo "---";
	    $weekend=date("Y-m-d",strtotime((6-$day)." day"));//echo "<br/>";
	    for($i=0;$i<=6;$i++)
		 {
		    $theWeekLastDate=date("Y-m-d",strtotime("$i day",strtotime($weekstart))); //echo "<br/>";
		    if($theWeekLastDate==date("Y-m-d"))
			break;	
			  
		 }
		    $this->viewVars['week_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $weekstart);
		    $this->viewVars['week_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $theWeekLastDate);
			
		////////////////////end Week Calculation/////////////////////////////	
		
		////////////////////Month Calculate/////////////////////////////
		
		 $monthkstart=date("Y-m-"."01");
         $total_day = date("t",strtotime($monthkstart));
		 for($i=0;$i<$total_day;$i++)
		 {
		    $theMonthLastDate=date("Y-m-d",strtotime("$i day",strtotime($monthkstart)));		
			if($theMonthLastDate==date("Y-m-d"))
			 break; 
		 }
			 $theMonthLastDate;
			
			$this->viewVars['month_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $monthkstart);
		    $this->viewVars['month_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $theMonthLastDate);
			
		////////////////////end Month Calculation/////////////////////////////	
		
		////////////////////Year Calculate/////////////////////////////
		 $first_dayof_year = date("Y-"."01"."-01");
		 if(strtotime($first_dayof_year) < strtotime($this->viewVars['first_dayMsr']->um_date))
		 {
		    $firstDayYear = $this->viewVars['first_dayMsr']->um_date;
		 }
		 else{
		    $firstDayYear =  $first_dayof_year;
		 }
		 
		 foreach($this->viewVars['last_dayMsr'] as $lastY)
		 {
		    $lastDayYear = $lastY['um_date'];
		 }
		 
		 $this->viewVars['year_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $firstDayYear);
		 $this->viewVars['year_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $lastDayYear);
		 
		
		/*              ------end Year Calculation---------             */
		///////////////////update_measurement value calculation//////////////
		 $mstart = $this->success_journal_model->metabolismStartDay();
		 $mbDay = $mstart['metabolism_start_day'];
		 $mbCreateDate = strtotime($mstart['createdOn']);
         $mStartDay = date('Y-m-d', strtotime('-'.$mbDay.'days',$mbCreateDate));
		// $startDay = $this->viewVars['first_dayMsr']->um_date;
		// $remainDay = strtotime($toDay)-strtotime($startDay) ;
		 $toDay = date("Y-m-d");
         $remainDay = strtotime($toDay) - strtotime($mStartDay) ;
		 

		$convertDays = floor($remainDay/(60*60*24));
		//$convertDays=400;
		$incre=7;
		if($convertDays <= 21)
		{  
		   
		    $waitingDay = 21 - $convertDays;
		}
		else if($convertDays <= 56)
		{
		  $x = 21;
		  for($i=$x; $i<=56; $i=$i+7)
		  {
		    //echo $i; echo "<br/>";
			if($convertDays<=$i)
			{ 
			   $waitingDay = $i - $convertDays;
			  break;
			}
		  }
		  
		}else if($convertDays <= 90)
		{
		   $i=90; //90+56; 
		 
		   $waitingDay = $i - $convertDays;
		  
		}else if($convertDays <= 180)
		{
		   $x=90;
		  
		 for($i=$x; $i<=180; $i=$i+30)
		  {
		     
			if($convertDays<=$i)
			{
			   $waitingDay = $i - $convertDays;
			  break;
			}
		  }
		}
		else{
		  $x=180;
		  $end=$x+90;
		  
		 for($i=$x; $i<=$end; $i=$i+90)
		 {
          	if($convertDays <= $i)
			{
			   
			   $waitingDay = $i - $convertDays;
			   break;
			}
			else{
			   $end= $end+90;
			   
			}
			
		 }
		}
		
		
		$this->viewVars['waitingDay'] = $waitingDay;
		//exit();
			//echo substr('abcdef fhfhfh hrh srygrdy ryry ', 0, 20); 
		///////////////////update_measurement value calculation//////////////	
		
		//	print_r($this->viewVars['month_startVal']);
		//	print_r($this->viewVars['month_umval']);
		////////////////////End Week Calculate/////////////////////////////
		
		//$this->viewVars['week_umval'] = $this->succ_measure_model->getall_um_week($u_id); 
		//$this->viewVars['month_umval'] = $this->succ_measure_model->getall_um_month($u_id); 
		//$this->viewVars['year_umval'] = $this->succ_measure_model->getall_um_year($u_id);
		$this->viewVars['graph_week_val'] = $this->succ_measure_model->count_eightWeek($u_id);
        $this->viewVars['rest_dayMsr'] = $this->succ_measure_model->get_restday_um($u_id) ;
		

		$this->viewVars['call_gallery'] = $this->success_journal_model->callGallery($u_id) ;
		$this->viewVars['show_gallery'] = $this->success_journal_model->getGalleryData($u_id) ;
		$this->viewVars['get_latest_bf'] = $this->success_journal_model->getlatestBfpic($u_id) ;
		$this->viewVars['get_latest_after'] = $this->success_journal_model->getlatestAfterpic($u_id) ;
		$this->viewVars['show_after_gallery'] = $this->success_journal_model->getGalleryAfterData($u_id) ;		
		
	   //////////////Read Mor////////////////
	   //$data['read_me']=$_POST['id'];
/*	   if (!empty($_POST['id'])){
            echo "Data=".$_POST['id'];
            $this->viewVars['thisPost']=$this->success_journal_model->getThisJournalPost($data['read_me']);
            
			
       }*/
	   $init_ctrack = $this->success_journal_model->initialCtracker() ;
	   foreach($init_ctrack as $intTrk)
	   {
	      $this->viewVars['ctrack_name'] = $intTrk['name'];
		  $this->viewVars['ctrack_blog'] = $intTrk['blog'];
	   }
	   $this->viewVars['get_ctrack'] = $this->success_journal_model->getCompliment($u_id) ;
	   //$this->viewVars['get_active_track'] = $this->success_journal_model->getActiveCompliment($u_id) ;
	   $this->viewVars['get_All_ctrack'] = $this->success_journal_model->getComplimentList($u_id) ;
	   $this->viewVars['get_cycle_ctrack'] = $this->success_journal_model->getAscComplimentList($u_id) ;
	   
	  // $total = $this->succ_measure_model->get_restday_umtot($u_id);
	//   $this->viewVars['lastPage'] = ceil($total/2);
	
	
	    //Compliment Cycle//

		session_start() ;
		$inc=0; 
		foreach($this->viewVars['get_cycle_ctrack'] as $getres)
		{
		   $id[]= $getres['id']; 
		   $inc++;
		}
		
		if (empty($_SESSION['inc']) || !is_numeric($_SESSION['inc']) || $_SESSION['inc'] >= $inc) {
                  $_SESSION['quote_num'] = $id[0]; //echo "<br/>";
			      $_SESSION['inc']= 1 ; //echo "<br/>";

			
			  
        } else {
		     // print_r($_SESSION);
		          $_SESSION['inc'] = $_SESSION['inc']; //echo "<br/>";
                  $_SESSION['quote_num'] = $id[$_SESSION['inc']];
				 
			      $_SESSION['inc'] = $_SESSION['inc']+1; 
				  
        }
		 $this->viewVars['get_active_track'] = $this->success_journal_model->getnewActiveCompliment($_SESSION['quote_num'],$u_id) ;
		//exit();
//end sompliment;
/*        	foreach($this->viewVars['uacDate'] as $ures)
            {
   
                $birthDay=strtotime($ures['birthdate']);
                $toDate = date('y-m-d'); 
                $countAge = strtotime($toDate)-strtotime($birthDay);
              echo "age=".  $age = floor(($countAge/(60*60*24))/365);
				echo " sex=". $ures['sex'];
			}*/

       $this->load->view("successjournal/index", $this->viewVars);
  }
 
function ajax_paging()
{  
   $this->pageVars['isajax'] = true;
	
	//echo "OMar";
	
	$u_id=$this->session->userdata('id');
     $this->viewVars['first_dayMsr'] = $this->succ_measure_model->get_firstday_um($u_id);
     $this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	  $this->viewVars['uacDate']= $this->success_journal_model->getuserActiveDate();
	 
	if( count($this->viewVars['first_dayMsr'] ) > 0) 
	{
	    $this->viewVars['list1'] =1;
        $this->viewVars['list2'] = '';
        $this->viewVars['list3'] = '';
		$this->viewVars['page']=1;
	   
    $total = $this->succ_measure_model->get_restday_umtot($u_id);
    $perPage = 6;
	$pageNum = 1; 
	 
	 if (isset($_POST['p'])){
          $pageNum = $_POST['p'];
	 }
	 $offset = ($pageNum - 1) * $perPage;
	 
	// $this->viewVars['pageNum'] = $pageNum;
	 
	 $this->viewVars['first_page_res'] = $this->succ_measure_model->get_firstPage_um($offset,$perPage,$u_id) ;
	 $maxPage = ceil($total/$perPage);
	 $this->viewVars['maxPage'] = ceil($total/$perPage);
	 $this->viewVars['nav'] = '';
   

	    if ($pageNum >= 1) {   

                 $this->viewVars['page'] = $pageNum;
				 $page=$pageNum - 1;
                 $this->viewVars['prev'] = "<a href='#' id='$page' onclick='return false;' class='goto'><strong>< Prev</strong></a>";
				 $this->viewVars['list1'] = $this->viewVars['page'] ;
                 $this->viewVars['list2'] = $this->viewVars['page']+1;
                 $this->viewVars['list3'] = $this->viewVars['page']+2;
		/*	  $this->viewVars['list3'] = $maxPage;
			  $this->viewVars['list2'] =$maxPage-1;
			  $this->viewVars['list1'] =$maxPage-2;
*/
        }
        else {
                 $this->viewVars['prev']  = '<strong> </strong>';
        }

        if ($pageNum < $maxPage) {  
                 $this->viewVars['page'] = $pageNum;
				// $maxPage = $pageNum;
/*				 if($pageNum==1){
				   $page =1;
				 }else{*/
				 $page=$pageNum + 1;
				// }
                 $this->viewVars['next']  = "<a href='#' id='$page' onclick='return false;' class='goto'><strong>Next ></strong></a>";                
				 
				 $this->viewVars['list1']= $this->viewVars['page'] ;
                 $this->viewVars['list2']= $this->viewVars['page']+1;
                 $this->viewVars['list3']= $this->viewVars['page']+2;
				  /* $this->viewVars['list3'] = $maxPage;
			       $this->viewVars['list2'] =$maxPage-1;
			       $this->viewVars['list1'] =$maxPage-2;
*/
         }
         else {
                 $this->viewVars['next'] = '<strong> </strong>';
         }
	   /*-------------------paging-----------------------*/
	   
	       $page_col = count($this->viewVars['first_page_res']);

		   $this->viewVars['total_col']= $page_col;
	       echo $this->load->view("layout/ajax_load",$this->viewVars);

	   
	 
}
else
{
    echo $this->load->view("layout/initial_load",$this->viewVars);
}
	//$this->load->view("successjournal/ajax_paging");

}
 function ajax_recent_post(){
    
	$this->pageVars['isajax'] = true;
	$u_id=$this->session->userdata('id');
     $jtotal = count($this->success_journal_model->get_all_jCount($u_id));
	$jperPage = 5;
	$jpageNum = 1; 
	if (isset($_POST['p'])){
          $jpageNum = $_POST['p'];
	}
	$joffset = ($jpageNum - 1) * $jperPage;
	 
	 $this->viewVars['jpost'] = $this->success_journal_model->getJournalPost($joffset,$jperPage,$u_id) ;
	 
	$maxPage = ceil($jtotal/$jperPage);

	
		if ($jpageNum > 1) {

            $page = $jpageNum - 1;
            $this->viewVars['prev'] = "<a href='#' id='$page' onclick='return false;' class='rp'><strong>< Newer Post</strong></a>";

        }
        else {
            $this->viewVars['prev']  = '<strong> </strong>';
        }

        if ($jpageNum < $maxPage) {
                 $page = $jpageNum + 1;
                 $this->viewVars['next']  = "<a href='#' id='$page' onclick='return false;' class='rp'><strong>Older Post ></strong></a>";

         }
         else {
                 $this->viewVars['next'] = '<strong> </strong>';
         }
   // $this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();

    echo $this->load->view("successjournal/ajax_recent_post",$this->viewVars);
 }
 
 function upload_before_img()
 {
    $this->pageVars['isajax'] = true;
   
   /*echo "<pre>";
     print_r($_FILES);
     echo "</pre>";
    */
     $u_id = $this->session->userdata('id');
	 $this->success_journal_model->uploadGalleryBefore($u_id) ;
 }
 
 function upload_after_img()
 {
    $this->pageVars['isajax'] = true;
   
   /*echo "<pre>";
     print_r($_FILES);
     echo "</pre>";
    */
     $u_id = $this->session->userdata('id');
	 $this->success_journal_model->uploadGalleryAfter($u_id) ;
 }
  
 function jedit($id)
  {   
        
		$this->viewVars['msg'] =1; 
		$this->viewVars['editJournal'] = $this->success_journal_model->editJournalPost($id);
		
	 if($this->input->post('upJournal'))
	  {
	     $this->success_journal_model->updateJournal();
	  }
	 
	  
	 if($this->input->post('journalEntry')){
	     $this->form_validation->set_rules('addtitle', 'Addtitle', 'required');
		 $this->form_validation->set_rules('details', 'Details', 'required');
		 $this->form_validation->set_rules('access-type', 'public / private', 'required');
		
	     if ($this->form_validation->run() == FALSE)
		 {
		   $this->viewVars['msg'] =2;
		 }
		 else
		 {
	          $this->success_journal_model->addjournal();
		 }
     // exit();
	 }
	 
	
	 //$this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();
   
		
		/*              ------end Year Calculation---------             */
     $this->viewVars['row']= $this->success_journal_model->orginalMeasure();
	 $this->viewVars['getuval']= $this->success_journal_model->get_start_userval();
	 $this->viewVars['weekcount']= $this->success_journal_model->weekCount();
	 $this->viewVars['ugoalset']= $this->success_journal_model->getUltimateGoal();
	 $this->viewVars['bckcount']= $this->success_journal_model->bckListCount();
	 $this->viewVars['bcklist']= $this->success_journal_model->getBucketList();
     $this->viewVars['uacDate']= $this->success_journal_model->getuserActiveDate();
	 $this->viewVars['weekGoal']= $this->success_journal_model->getWeekGoal();
	 $this->viewVars['bonusGoal']= $this->success_journal_model->getBonusGoal();
	 $this->viewVars['bonusOptions']= $this->success_journal_model->getBonusOptions();
	 $this->viewVars['fetureid']= $this->success_journal_model->getfeatureName();
	 $this->viewVars['nonfetured']= $this->success_journal_model->getNonfeatureName();
	 
	 //update measurement //
	    $u_id=$this->session->userdata('id');
	
		$this->viewVars['first_dayMsr'] = $this->succ_measure_model->get_firstday_um($u_id);
		$this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	    $this->viewVars['all_val'] = $this->succ_measure_model->get_all_um($u_id);
		//$this->viewVars['to_umval'] = $this->succ_measure_model->getall_um_todate($u_id);
		//$this->viewVars['week_umval'] = $this->succ_measure_model->getall_um_week($u_id); 
		//$this->viewVars['month_umval'] = $this->succ_measure_model->getall_um_month($u_id); 
		//$this->viewVars['year_umval'] = $this->succ_measure_model->getall_um_year($u_id);
		$this->viewVars['graph_week_val'] = $this->succ_measure_model->count_eightWeek($u_id);
		

       $this->viewVars['rest_dayMsr'] = $this->succ_measure_model->get_restday_um($u_id) ;
	   
	   $this->viewVars['call_gallery'] = $this->success_journal_model->callGallery($u_id) ;
		$this->viewVars['show_gallery'] = $this->success_journal_model->getGalleryData($u_id) ;
		$this->viewVars['get_latest_bf'] = $this->success_journal_model->getlatestBfpic($u_id) ;
		$this->viewVars['get_latest_after'] = $this->success_journal_model->getlatestAfterpic($u_id) ;
		$this->viewVars['show_after_gallery'] = $this->success_journal_model->getGalleryAfterData($u_id) ;		
	   
	    $this->viewVars['to_umval'] = $this->succ_measure_model->getall_um_todate($u_id);
		////////////////////Week Calculate/////////////////////////////
		$day=date("w"); //echo "---";
	    $weekstart=date("Y-m-d",strtotime("-$day day"));//echo "---";
	    $weekend=date("Y-m-d",strtotime((6-$day)." day"));//echo "<br/>";
	    for($i=0;$i<=6;$i++)
		 {
		    $theWeekLastDate=date("Y-m-d",strtotime("$i day",strtotime($weekstart))); //echo "<br/>";
		    if($theWeekLastDate==date("Y-m-d"))
			break;	
			  
		 }
		    $this->viewVars['week_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $weekstart);
		    $this->viewVars['week_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $theWeekLastDate);
			
		////////////////////end Week Calculation/////////////////////////////	
/*		if($this->viewVars['first_dayMsr'])
		{
		   foreach($this->viewVars['first_dayMsr'] as $firstVal)
		   {
		            $thigh = $toallum['um_thighs'];
	                $hip = $toallum['um_hips'];
	                $calf = $toallum['um_calves'];
	                $wrist = $toallum['um_wrist'];
	                $waist = $toallum['um_waist'];
	                $forearms = $toallum['um_forearms'];
	                $weight = $toallum['um_bweight'];
		   }
		}*/
		
		////////////////////Month Calculate/////////////////////////////
		
		 $monthkstart=date("Y-m-"."01");
         $total_day = date("t",strtotime($monthkstart));
		 for($i=0;$i<$total_day;$i++)
		 {
		    $theMonthLastDate=date("Y-m-d",strtotime("$i day",strtotime($monthkstart)));		
			if($theMonthLastDate==date("Y-m-d"))
			 break; 
		 }
			 $theMonthLastDate;
			
			$this->viewVars['month_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $monthkstart);
		    $this->viewVars['month_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $theMonthLastDate);
			
		////////////////////end Month Calculation/////////////////////////////	
		
		////////////////////Year Calculate/////////////////////////////
		 $first_dayof_year = date("Y-"."01"."-01");
		 if(strtotime($first_dayof_year) < strtotime($this->viewVars['first_dayMsr']->um_date))
		 {
		    $firstDayYear = $this->viewVars['first_dayMsr']->um_date;
		 }
		 else{
		    $firstDayYear =  $first_dayof_year;
		 }
		 
		 foreach($this->viewVars['last_dayMsr'] as $lastY)
		 {
		    $lastDayYear = $lastY['um_date'];
		 }
		 
		 $this->viewVars['year_startVal'] = $this->succ_measure_model->getall_um_date_cal($u_id, $firstDayYear);
		 $this->viewVars['year_umval'] = $this->succ_measure_model->getall_um_date_cal($u_id, $lastDayYear);
		 
		 /*  //////////////////First Day Body Fat///////////////////////  */
		 
		 
		  /*  /////////////////////////////////////////  */
	   
	 $this->load->view("successjournal/index", $this->viewVars);
  }
  
  function update($id)
  {   //$this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();
       //echo $id = end($this->uri->segments); 
      $this->viewVars['msg'] =$id; 
	  //$this->viewVars['editJournal'] = $this->success_journal_model->editJournalPost($id);
	  if($this->input->post('upJournal'))
	  {
	     $this->success_journal_model->updateJournal($id);
	  }
	 //  $this->viewVars['editJour'] ="successjournal/editjournal";
	 redirect('successjournal/index','refresh');
  }
  
  function postdel()
	   {
	         $data['delete_me']=$_POST['id'];
			 if (!empty($data['delete_me'])){
                   //$this->load->model('properties', '', TRUE);
                   $this->success_journal_model->deleteJpost($data['delete_me']);
                   $this->output->set_output('works');
             } else {
              $this->output->set_output('dontwork');

             }
			 
			 $this->load->view("successjournal/postdel");
			 //$this->success_journal_model->deleteJpost($id);
            // redirect('successjournal/index','refresh');
	   }
	
  function readdetails()
   {
     	$this->pageVars['isajax'] = true;
		
		/*echo "<pre>";
			print_r($_REQUEST);
		echo "</pre>";*/
		if (isset($_POST['pid'])){
          $test = $_POST['pid'];
		  $this->viewVars['thisPost']=$this->success_journal_model->getThisJournalPost($test);
	  }

		return $this->load->view("successjournal/read_more_popup",$this->viewVars); 
   }  
	   
	   
  function ugoalentry()
	   {
	        /*if($this->input->post('journalEntry')){
               $this->success_journal_model->addjournal();
	        }*/
	         $this->viewVars['msg'] =0; 
	         //$this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();
			
	          $this->success_journal_model->ultimateGoal();
      
		   
		    $this->load->view("successjournal/index", $this->viewVars);
			 redirect('successjournal/index','refresh');
	   }
	   
	function weekgoal()
	   {
	        /*if($this->input->post('journalEntry')){
               $this->success_journal_model->addjournal();
	        }*/
	         $this->viewVars['msg'] =0; 
	         //$this->viewVars['jpost'] = $this->success_journal_model->getJournalPost();
			
	         //$this->success_journal_model->eightWeekGoal();
      
		   //exit();
		   // $this->load->view("successjournal/index", $this->viewVars);
			redirect('successjournal/index','refresh');
	   }

 
	//update measerements
	public function updmeasure()
	{
		$this->pageVars['isajax'] = true;
		
		$u_id=$this->session->userdata('id'); 
		print_r($_POST);
	     $row= $this->success_journal_model->orginalMeasure();
		if (isset($_POST))
		{
			
			/*   calculation baody fat*/
		   $uacDate= $this->success_journal_model->getuserActiveDate();
		   
		   $um_neck = $this->input->post('m_neck');
           $um_chest = $this->input->post('m_chest');
           $um_biceps = $this->input->post('m_biceps');
           $um_forearms = $this->input->post('m_forearms');
           $um_wrist = $this->input->post('m_wrist');
           $um_waist = $this->input->post('m_waist');
           $um_hips = $this->input->post('m_hips');
           $um_thighs = $this->input->post('m_thighs');
           $um_calves = $this->input->post('m_calves');
           $um_bweight = $this->input->post('body_wegt');
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
	                       $bodyfat = $um_waist + ($um_hips * 0.5) - ($um_forearms * 3.0) - $um_wrist ;  
		                  
	                  }else{      
	                       //Male 31 years old or more= waist + (hips x 0.5) - (forearms x 2.7) - wrist = % body fat
		                   $bodyfat = $um_waist + ($um_hips * 0.5) - ($um_forearms * 2.7) - $um_wrist;   
	                  }
	   
	                  //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 
	                  $fatWeight =  $um_bweight * ($bodyfat/100);   
	                  //Lean Body Mass = (My Body Weight)  –  (My Fat Weight)
	                  $leanBodyMass = $um_bweight - $fatWeight;
                 }
                 else if($ures['sex']=='Female')
                 { 
                      if($age <= 30)
	                  {       
	                      //Female 30 years old or less= hips + (thigh x 0.8) - (calf x 2.0) - wrist = % body fat
		                  $bodyfat = $um_hips + ($um_thighs * 0.8) - ($um_calves * 2.0) - $um_wrist ; 
		   
	                  }else{
	                       //Female 31 years old or more= hips + thigh - (calf x 2.0) - wrist = % body fat
		                   $bodyfat = $um_hips + $um_thighs - ($um_calves * 2.0) - $um_wrist ; 
	                  }
	                  //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 
	                  $fatWeight =  $um_bweight * ($bodyfat/100);  
					  //Lean Body Mass = (My Body Weight)  –  (My Fat Weight)
	                  $leanBodyMass = $um_bweight - $fatWeight;
                  }
			}
			
			/*   end baody fat*/
			/*   BMI Calculate*/
			
			 $getuval= $this->success_journal_model->get_start_userval();
			 $uheight= $getuval->height;
			 
			 $height= explode(' ',$uheight);
             $feet_height = $height[0];
             $inch_height = $height[1];
			 
			 $total_inch_height = ($feet_height * 12) + $inch_height;
			 $bmi = round((($um_bweight * 703)/($total_inch_height * $total_inch_height)),2);
			 
			/*   end BMI Calculate*/

			$curDate = date("Y-m-d");
			$checked_reg = $this->succ_measure_model->chk_reg_msr($u_id,$curDate);
			if(count($checked_reg)>0)
			{
				$mid = $checked_reg->um_id;
				$mesr_upd = $this->succ_measure_model->upd_usr_mesr($u_id,$curDate,$mid,$bodyfat,$fatWeight,$leanBodyMass,$bmi);
				if(count($mesr_upd)>0)
				{
					$updated = 'You have entered a new measurement successfully.';
				} else {
					$updated = 'Database error! try again';
				}
				$this->session->set_flashdata('upd_mesrmnt', $updated);
				redirect('successjournal/index');
			} else {
				$mesr_ins = $this->succ_measure_model->ins_usr_mesr($u_id,$curDate,$bodyfat,$fatWeight,$leanBodyMass,$bmi );
				if($mesr_ins>0)
				{
					$inserted = 'You have entered a new measurement successfully.';
				} else {
					$inserted = 'Database error! try again';
				}
				$this->session->set_flashdata('ins_mesrmnt', $inserted);
			}
			redirect('successjournal/index');
		}

		
		
	}


	
	function complimentTracker()
    {
	   $this->success_journal_model->insertCompliment();
       redirect('successjournal/index');
    } 
	
	function ajax_tracker_editpost(){
	
	   $this->pageVars['isajax'] = true;
	  // $u_id=$this->session->userdata('id');
	   if (isset($_POST['eid'])){
          $edit_id = $_POST['eid'];
	   }
	   
	   if (isset($_POST['upid'])){
            $up_name = $_POST['name'];
		    $up_msg = $_POST['msg'];
		    $up_id = $_POST['upid'];
		  $this->success_journal_model->tracker_update($up_id,$up_name,$up_msg);
	   }
	   
	   $this->viewVars['editId'] = $this->success_journal_model->getEditComplimentId($edit_id);
	   echo $this->load->view("successjournal/ajax_tracker_edit", $this->viewVars);
	    
	}
	
	function ajax_tracker_delete(){
	
	   $this->pageVars['isajax'] = true;
	  
       if (isset($_POST['del'])){
          $del_id = $_POST['del'];
	   }
	  // $id =  $this->input->post('bloger_id');
      $this->success_journal_model->tracker_delete($del_id);
	}
	
    function ajax_tracker_active(){
	
	  $this->pageVars['isajax'] = true;
	  
	  if (isset($_POST)){
	   //  $this->success_journal_model->tracker_setActive(); 
	      $act_id = $_POST['actid'];
		  $status = $_POST['setStatus'];
		  $this->success_journal_model->tracker_Active($act_id,$status);
	  }

      
	}
	
	//////////////////////start plan goals/////////////////	
	function save_goal_plan()
	{      
	  $goal_plan_id = $this->input->post('goal_plan_id');
      $gp_result = $this->success_journal_model->goalPlanResult($_POST['userId']);

      foreach ($gp_result->result() as $gp)
	  {
            $this->success_journal_model->deleteGoalPlan($gp->user_id);
      }

      foreach($goal_plan_id as $goal_id)
	  {
       if($goal_id != ''){
          $time_per_week = $this->input->post('time_per_week_gp_'.$goal_id);
          $daily = $this->input->post('daily_gp_'.$goal_id);

          if($time_per_week != '' && $daily == ''){
              $data = array(
                   'user_id' => $_POST['userId'] ,
                   'goal_plan_id' => $goal_id ,
                   'time_day' => $time_per_week,
                   'day_list' => '',
                );

              $this->db->insert('user_goal_plan', $data);
          }

          if($daily != '' && $time_per_week == '')
		  {
              $daily_id = substr($daily, -1);
             
              $mon = $this->input->post('mon_gp_'.$goal_id);
              $tue = $this->input->post('tue_gp_'.$goal_id);
              $wed = $this->input->post('wed_gp_'.$goal_id);
              $thu = $this->input->post('thu_gp_'.$goal_id);
              $fri = $this->input->post('fri_gp_'.$goal_id);
              $sat = $this->input->post('sat_gp_'.$goal_id);
              $sun = $this->input->post('sun_gp_'.$goal_id);
             
              $str = '';
              
              if($mon != ''){
                  $str .= $mon.',';
              }
              if($tue != ''){
                  $str .= $tue.',';
              }
              if($wed != ''){
                  $str .= $wed.',';
              }
              if($thu != ''){
                  $str .= $thu.',';
              }
              if($fri != ''){
                  $str .= $fri.',';
              }
              if($sat != ''){
                  $str .= $sat.',';
              }
              if($sun != ''){
                  $str .= $sun.',';
              }

              $data = array(
               'user_id' => $_POST['userId'] ,
               'goal_plan_id' => $goal_id ,
               'time_day' => $daily,
               'day_list' => $str,
              );
              $this->db->insert('user_goal_plan', $data);
              }
            }
      }
  }
   
  function circlePoint( $deg, $dia )
  {
        $x = cos( deg2rad( $deg ) ) * ( $dia / 2 );
        $y = sin( deg2rad( $deg ) ) * ( $dia / 2 );    
        return array( $x, $y );
  }  
  function popupimage($pf,$uid,$popupgoalname)
  {
	/*****************start********************/
    $imageWidth = 78;                             //image width
    $imageHeight = 78;                            //image height
    $diameter = 78;                               //pie diameter
    $centerX = 39;                                //pie center pixels x
    $centerY = 39;                                //pie center pixels y
    $labelWidth = 5;                              //label width, no need to change
    /*************************End****************************/
    
    $data = array( $pf, 100-$pf);    
    for( $i = 0; $i < count( $data ); $i++ )
    {
        $dataTotal += $data[ $i ];
    }           
    $im = ImageCreate( $imageWidth, $imageHeight );
    
    $color[] = ImageColorAllocate( $im, 39, 166, 194 ); //red
    $color[] = ImageColorAllocate( $im, 255, 115, 30 );//yellow    
    $white = ImageColorAllocate( $im, 255, 255, 255 );
    $black = ImageColorAllocate( $im, 0, 0, 0 );
    $grey = ImageColorAllocate( $im, 215, 215, 215 );

    ImageFill( $im, 0, 0, $white );
    
    $degree = 0;
    for( $i = 0; $i < count( $data ); $i++ )
    {
        $startDegree = round( $degree );
        $degree += ( $data[ $i ] / $dataTotal ) * 360;
        $endDegree = round( $degree );
        
        $currentColor = $color[ $i % ( count( $color ) ) ];
        
        ImageArc( $im, $centerX, $centerY, $diameter, $diameter, $startDegree, $endDegree, $currentColor );
                
		
		list( $arcX, $arcY ) = $this->circlePoint( $startDegree, $diameter );
        ImageLine( $im, $centerX, $centerY, floor( $centerX + $arcX ), floor( $centerY + $arcY ), $currentColor );
        
        list( $arcX, $arcY ) = $this->circlePoint( $endDegree, $diameter );
        ImageLine( $im, $centerX, $centerY, ceil( $centerX + $arcX ), ceil( $centerY + $arcY ), $currentColor );
        
        $midPoint = round( ( ( $endDegree - $startDegree ) / 2 ) + $startDegree );
        
		list( $arcX, $arcY ) = $this->circlePoint( $midPoint, $diameter / 1.5 );
        ImageFillToBorder( $im, floor( $centerX + $arcX ), floor( $centerY + $arcY ), $currentColor, $currentColor );
		
        if($i==0)
		{
	 	 ImageString( $im, 5, floor( $centerX + $arcX ), floor( $centerY + $arcY ), intval( round( $data[ $i ] / $dataTotal * 100 ) ) . "%", $white );
		}
		
    }
	$filename=$popupgoalname.$uid.".png";	
    Header( "Content-type: image/PNG" );
    ImagePNG( $im,"htdocs/popupgoal/".$filename);		
	return $filename;
  }
  function getpopup()
  {  
	$this->pageVars['isajax'] = true;
	////////////////////////////////////////for goal plan/////////////////	
	$u_id=$this->session->userdata('id');	
	$active=$_POST['active'];		
	$this->viewVars['active']=$active;			
	$today=date("Y-m-d");
	
	
	$regdate=date("Y-m-d",strtotime($this->session->userdata('regdate')));
	//////////////////////get todate start day last date///////////////
	if($active=="todate")
	{
		$lastdate=date("Y-m-d");
		$startdate=date("Y-m-",strtotime('-2 months'))."01";		
		$startdate=$startdate>=$regdate?$startdate:$regdate;
		
		if(isset($_POST['startdate'])&&isset($_POST['lastdate']))
		{			
			if(isset($_POST['direction'])&&$_POST['direction']=="left")
			{
				$temp1=date('Y-m-d', strtotime('-2 months', strtotime($_POST['startdate'])));
				$temp2=date('Y-m-d', strtotime('-1 day', strtotime($_POST['startdate'])));
				if($temp1>=$regdate&&$temp2>=$regdate)
				{
					$lastdate=$temp2;
					$startdate=$temp1;
				}
				else
				{
				   $startdate=date("Y-m-d",strtotime($regdate));
				   $lastdate=date("Y-m-",strtotime('+2 months',strtotime($regdate)))."01";				
				}						
			}
			else if(isset($_POST['direction'])&&$_POST['direction']=="right")
			{
				$temp1=date('Y-m-d', strtotime('+2 months', strtotime($_POST['lastdate'])));
				$temp2=date('Y-m-d', strtotime('+1 day', strtotime($_POST['lastdate'])));
				if($temp1<=$today&&$temp2<=$today)
				{
					$lastdate=$temp1;
					$startdate=$temp2;
				}
				else
				{
				   $lastdate=date("Y-m-d");				
				   $startdate=date("Y-m-",strtotime('-2 months'))."01";				   
				}									
			}
			else
			{
				   $lastdate=$_POST['lastdate'];				
				   $startdate=$_POST['startdate'];
			}
		}	
	}
	else if($active=="week")//////////get week start day last date///////////////
	{
		$lastdate=date("Y-m-d");
		$dayc=date("w");
		$startdate=date("Y-m-d",strtotime("-$dayc day"));		
		$startdate=$startdate>=$regdate?$startdate:$regdate;
		
		if(isset($_POST['startdate'])&&isset($_POST['lastdate']))
		{			
			if(isset($_POST['direction'])&&$_POST['direction']=="left")
			{
				$temp1=date('Y-m-d', strtotime('-7 day', strtotime($_POST['startdate'])));
				$temp2=date('Y-m-d', strtotime('-1 day', strtotime($_POST['startdate'])));
				if($temp1>=$regdate&&$temp2>=$regdate)
				{
					$lastdate=$temp2;
					$startdate=$temp1;
				}
				else
				{
				   $startdate=date("Y-m-d",strtotime($regdate));
				   $lastdate=date("Y-m-d",strtotime('+7 day',strtotime($regdate)));				
				}						
			}
			else if(isset($_POST['direction'])&&$_POST['direction']=="right")
			{
				$temp1=date('Y-m-d', strtotime('+7 day', strtotime($_POST['lastdate'])));
				$temp2=date('Y-m-d', strtotime('+1 day', strtotime($_POST['lastdate'])));
				if($temp1<=$today&&$temp2<=$today)
				{
					$lastdate=$temp1;
					$startdate=$temp2;
				}
				else
				{
				   $lastdate=date("Y-m-d");
				   $dayc=date("w");
				   $startdate=date("Y-m-d",strtotime("-$dayc day"));
				}									
			}
			else
			{
				   $lastdate=$_POST['lastdate'];				
				   $startdate=$_POST['startdate'];
			}
		}	
	}
	else if($active=="month")//////////get month start day last date///////////////
	{
		$lastdate=date("Y-m-d");
		$startdate=date("Y-m-")."01";		
		$startdate=$startdate>=$regdate?$startdate:$regdate;
		
		if(isset($_POST['startdate'])&&isset($_POST['lastdate']))
		{			
			if(isset($_POST['direction'])&&$_POST['direction']=="left")
			{
				$temp1=date('Y-m-d', strtotime('-1 months', strtotime($_POST['startdate'])));
				$temp2=date('Y-m-t', strtotime($temp1));
				if($temp1>=$regdate&&$temp2>=$regdate)
				{
					$lastdate=$temp2;
					$startdate=$temp1;
				}
				else
				{
				   $startdate=date("Y-m-d",strtotime($regdate));
				   $lastdate=date("Y-m-t",strtotime($startdate));				
				}						
			}
			else if(isset($_POST['direction'])&&$_POST['direction']=="right")
			{
				$temp1=date('Y-m-', strtotime('+1 months', strtotime($_POST['lastdate'])))."01";
				$temp2=date('Y-m-t', strtotime($temp1));
				if($temp1<=$today&&$temp2<=$today)
				{
					$lastdate=$temp2;
					$startdate=$temp1;
				}
				else
				{
				   $lastdate=date("Y-m-d");				   
				   $startdate=date("Y-m-")."01";
				}									
			}
			else
			{
				   $lastdate=$_POST['lastdate'];				
				   $startdate=$_POST['startdate'];
			}
		}
	
	}			
	$this->viewVars['startdate']=$startdate;
	$this->viewVars['lastdate']=$lastdate;
	/////////////////////////////////////////////////
	$goal_plan = $this->success_journal_model->getGoalPlan();
    $goal_plan_user = $this->success_journal_model->goalPlanResult($u_id);	
	
	$plangoalfield=array();	
	$plangoaltitle=array();	
	
	foreach ($goal_plan->result() as $goal_plan_list)
	{
		$plangoalfield[$goal_plan_list->id]=$goal_plan_list->field_name;
		$plangoaltitle[$goal_plan_list->field_name]=$goal_plan_list->title;
	}
	
	$plangoalId=array();
	foreach ($goal_plan_user->result() as $goal_plan_list)
	{
		if($goal_plan_list->time_day=="daily")
		{
		 $plangoalId[$plangoalfield[$goal_plan_list->goal_plan_id]]=substr($goal_plan_list->day_list,0,strlen($goal_plan_list->day_list)-1);
		}
		else
		{
			$temp=array("mon","tue","wed","thu","fri","sat","sun");
			shuffle($temp);
			$temp=array_slice($temp,0,$goal_plan_list->time_day); 						
			$plangoalId[$plangoalfield[$goal_plan_list->goal_plan_id]]=implode(",",$temp);		
		}
	}	
	$plangoal=$this->journal_model->getPlangoalScore($this->viewVars['startdate'],$this->viewVars['lastdate'],$plangoalId);
	$this->viewVars['plangoaltitle']=$plangoaltitle;
	
	
	
	$plangoalimage=array();
	foreach($plangoal as $key=>$value)
	$plangoalimage[$key]=$this->popupimage($value,$u_id,$key);	
	
	$this->viewVars['plangoal']=$plangoal;
	$this->viewVars['plangoalimage']=$plangoalimage;
	
	
	///////////////////////////////////////////////////
	$tmp_array					= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= "";		
	$tmp_array['plangoallayout']= $this->load->view('successjournal/plangoallayout',$this->viewVars,true);				
	echo json_encode($tmp_array);			
  }
  function getuserpopup()
  {	
	$this->pageVars['isajax'] = true;
	////////////////////////////////////////for goal plan/////////////////
	$u_id=$this->session->userdata('id');	
	$this->viewVars['goal_plan'] = $this->success_journal_model->getGoalPlan();
    $this->viewVars['goal_plan_user'] = $this->success_journal_model->goalPlanResult($u_id);
	/////////////////////////////////////////////////
	$tmp_array					= array();
	$tmp_array['error_code']	= 0;
	$tmp_array['error_msg']		= "";	
	$tmp_array['popup']= $this->load->view('successjournal/plangoal_popup',$this->viewVars,true);				
	echo json_encode($tmp_array);
  }
 //////////////////////end plan goals/////////////////	
 
 //////////////////////ajax ultimate goal /////////////////	
  function up_uggoal()
	{
		$this->pageVars['isajax'] = true;
		$ugoalset = $this->success_journal_model->getUltimateGoal();
		
		if(isset($_POST)){	
		   if(count($ugoalset) > 0){	
		        $this->success_journal_model->upUltimateGoal();
			}
			else{
			    $this->success_journal_model->ultimateGoal();
			}
		}
			
	}
 
 
 
    function ajax_ultimate(){
         $this->pageVars['isajax'] = true;
	
	     $u_id=$this->session->userdata('id');
	

	     $this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	     $this->viewVars['row']= $this->success_journal_model->orginalMeasure();

	     $this->viewVars['ugoalset']= $this->success_journal_model->getUltimateGoal();
	     return $this->load->view("successjournal/afterset_ultimategoal",$this->viewVars);
	
	
   }
 
   function ajax_snapshot_ultimate(){
  
       $this->pageVars['isajax'] = true;
       $u_id=$this->session->userdata('id');
	

	   $this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	   $this->viewVars['row']= $this->success_journal_model->orginalMeasure();

	   $this->viewVars['ugoalset']= $this->success_journal_model->getUltimateGoal();
	   return $this->load->view("successjournal/snapshot_ultimate_goal",$this->viewVars);
	
	
   }
 
   function ajax_snapshot_week(){
  
        $this->pageVars['isajax'] = true;
        $u_id=$this->session->userdata('id');
	

	    $this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	    $this->viewVars['row']= $this->success_journal_model->orginalMeasure();
	    $this->viewVars['weekcount']= $this->success_journal_model->weekCount();
        $this->viewVars['weekGoal']= $this->success_journal_model->getWeekGoal();
	
	    return $this->load->view("successjournal/snapshot_8week_goal",$this->viewVars);
	
	
   }
   
    function ajax_week(){
        $this->pageVars['isajax'] = true;
	
	    $u_id=$this->session->userdata('id');
	
	    $this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	    $this->viewVars['row']= $this->success_journal_model->orginalMeasure();
	    $this->viewVars['weekcount']= $this->success_journal_model->weekCount();
        $this->viewVars['weekGoal']= $this->success_journal_model->getWeekGoal();
		
		if(count($this->viewVars['weekcount'])>0)
		{
	        return $this->load->view("successjournal/afterset_8weekgoal",$this->viewVars);
	    }
		else{
		    return $this->load->view("successjournal/before_8weekgoal",$this->viewVars);
		}
		 
	
     }
	 
	 
	function up_weekgoal()
	{
	     $this->pageVars['isajax'] = true;
		
		 $weekGoal= $this->success_journal_model->getWeekGoal();

		
		 if(isset($_POST)){	
		      if(count($weekGoal) > 0){	
		           $this->success_journal_model->upWeekGoal();
			  }
			  else{
			       $this->success_journal_model->eightWeekGoal();
			  }
		 }



	}
	
	//bonus goal
	
	 function ajax_bonus_load(){
  
        $this->pageVars['isajax'] = true;
        $u_id=$this->session->userdata('id');
	
	    $this->viewVars['bonusGoal']= $this->success_journal_model->getBonusGoal();
	    $this->viewVars['bonusOptions']= $this->success_journal_model->getBonusOptions();
	    $this->viewVars['fetureid']= $this->success_journal_model->getfeatureName();
	    $this->viewVars['nonfetured']= $this->success_journal_model->getNonfeatureName();
		
		if (count($this->viewVars['bonusGoal']) > 0){
			return $this->load->view("successjournal/afterset_bonusgoal",$this->viewVars);
		}
		else 
		{ 
			return $this->load->view("successjournal/before_bonusgoal",$this->viewVars); 
		}
		
	
     }
	 
	function bonus_update()
	{
	    $this->pageVars['isajax'] = true;
        $u_id=$this->session->userdata('id');
	    $this->viewVars['bonusGoal'] = $this->success_journal_model->getBonusGoal(); 
		
        if(isset($_POST)){	
		      if(count($this->viewVars['bonusGoal']) > 0){	
		           $this->success_journal_model->bonusGoalupdate();
			  }
			  else{
			       $this->success_journal_model->bonusGoalEntry();
			  }
		 }
	}
	

	
		
	function bonus_popup_meter_desc()
	{
	    $this->pageVars['isajax'] = true;
        $u_id=$this->session->userdata('id');
		$this->viewVars['first_dayMsr'] = $this->succ_measure_model->get_firstday_um($u_id);
		$this->viewVars['last_dayMsr'] = $this->succ_measure_model->get_max_res($u_id);
	    $this->viewVars['bonusGoal']= $this->success_journal_model->getBonusGoal();
	    $this->viewVars['bonusOptions']= $this->success_journal_model->getBonusOptions();
	    $this->viewVars['fetureid']= $this->success_journal_model->getfeatureName();
	    $this->viewVars['nonfetured']= $this->success_journal_model->getNonfeatureName();
		//echo "rima";
        if(count($this->viewVars['bonusGoal'])>0) {
	          return $this->load->view("successjournal/ajax_bgoal_popup",$this->viewVars);
	    }
	    else{
	         return $this->load->view("successjournal/entry_bonus",$this->viewVars);
	    }
	}
	
	function ajax_show_bcklist()
	{
	   	  $this->pageVars['isajax'] = true;
          $u_id=$this->session->userdata('id');
		  $this->viewVars['bckcount']= $this->success_journal_model->bckListCount();
		  $this->viewVars['bcklist']= $this->success_journal_model->getBucketList();
		  if (count($this->viewVars['bckcount']) > 0)
		  {
			  $this->load->view("successjournal/after_backetlist",$this->viewVars); 
		  }
		  else{
			  $this->load->view("successjournal/before_backet_list",$this->viewVars); 
		  }
		
	}  
	
		
	function bucketlist_update()
	{  //$x=0;
	   $u_id=$this->session->userdata('id');
       $this->viewVars['bckcount']= $this->success_journal_model->bckListCount();
/*	   if($this->input->post('bucketedit')){
	        $this->success_journal_model->bckList_del($u_id);
			   
               $this->success_journal_model->bckList();
			 
	   }*/
	   		
        if(isset($_POST)){	
		      if(count($this->viewVars['bckcount']) > 0){	
		           $this->success_journal_model->bckList_del($u_id);
				   $this->success_journal_model->bckList();
			  }
			  else{
			       $this->success_journal_model->bckList();
			  }
		 }
	}
	
		   
   function bucketlist()
   {  
       if($this->input->post('bucketAdd')){
	    // echo count($this->input->post('item'));
		   print_r($this->input->post('bucketAdd'));
           $this->success_journal_model->bckList();

	   }
	  // redirect('successjournal/index','refresh');
	  
   }

	 

	
 
}
?>