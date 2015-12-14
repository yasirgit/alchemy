<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');
class Successjournal extends Controller {
   private $viewVars = array();

 public function __construct()
 {
    parent::Controller();
	//$this->pageVars['css'] = array();
	//$this->pageVars['js'] = array();
	
	
	$this->load->model(array('user_model', 'user_food_model', 'succ_measure_model','success_journal_model'));
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

	    
		 $this->pageVars['js'] = array('sliderjs/jquery_003.js','sliderjs/jquery_004.js','sliderjs/jquery.js','sliderjs/jquery_002.js','sliderjs/custom.js','calendar/calendar.js','goal_meter/jquery.js','goal_meter/jquery_002.js','goal_meter/jquery_003.js','jgraph/jquery.jqplot.js','jgraph/jqplot.dateAxisRenderer.js','jgraph/jqplot.canvasAxisTickRenderer.min.js','count_down/jquery.countdown.js');
		 
 
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
	// print_r($this->viewVars['ugoalset']);
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
		 $startDay = $this->viewVars['first_dayMsr']->um_date;
		 $toDay = DATE("Y-m-d");
		$remainDay = strtotime($toDay)-strtotime($startDay) ;
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
	   $this->viewVars['get_ctrack'] = $this->success_journal_model->getCompliment($u_id) ;

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
    $perPage = 2;
	$pageNum = 1; 
	 
	 if (isset($_POST['p'])){
          $pageNum = $_POST['p'];
	 }
	 $offset = ($pageNum - 1) * $perPage;
	 
	 $this->viewVars['first_page_res'] = $this->succ_measure_model->get_firstPage_um($offset,$perPage,$u_id) ;
	 $maxPage = ceil($total/$perPage);
	 $this->viewVars['maxPage'] = ceil($total/$perPage);
	 $this->viewVars['nav'] = '';
   
       /*for($page = 1; $page <= $maxPage; $page++) {
             if ($page == $pageNum) {
                      $this->viewVars['nav'] .= "<div class=\"pNo\">$page|</div>";
             }
             else
             {
               $this->viewVars['nav'] .= "<div class=\"pNo\"><a href='#' id='$page' onclick='return false;' class='goto'>$page|</a></div>";
             }
        }*/
/*		if($pageNum == 1)
		{
		   $this->viewVars['page'] = 1;
		   $this->viewVars['list1'] = $this->viewVars['page'] ;
		   $this->viewVars['list2'] = $this->viewVars['page']+1;
           $this->viewVars['list3'] = $this->viewVars['page']+2;
		   $this->viewVars['next']  = "<a href='#' id='$page+1' onclick='return false;' class='goto'><strong>Next ></strong></a>";                
		}*/
	    if ($pageNum > 1) {   

                 $this->viewVars['page'] = $pageNum - 1;
				 $page=$pageNum - 1;
                 $this->viewVars['prev'] = "<a href='#' id='$page' onclick='return false;' class='goto'><strong>< Prev</strong></a>";
				 $this->viewVars['list1'] = $this->viewVars['page'] ;
                 $this->viewVars['list2'] = $this->viewVars['page']+1;
                 $this->viewVars['list3'] = $this->viewVars['page']+2;

        }
        else {
                 $this->viewVars['prev']  = '<strong> </strong>';
        }

        if ($pageNum < $maxPage) {  
                 $this->viewVars['page'] = $pageNum + 1;
/*				 if($pageNum==1){
				   $page =1;
				 }else{*/
				 $page=$pageNum + 1;
				// }
                $this->viewVars['next']  = "<a href='#' id='$page' onclick='return false;' class='goto'><strong>Next ></strong></a>";                
				 
				 $this->viewVars['list1']=$this->viewVars['page']+1-2 ;
                 $this->viewVars['list2']= $this->viewVars['page'];
                 $this->viewVars['list3']= $this->viewVars['page']+1;

         }
         else {
                 $this->viewVars['next'] = '<strong> </strong>';
         }
	   /*-------------------paging-----------------------*/
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
	$jperPage = 2;
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
			
	         $this->success_journal_model->eightWeekGoal();
      
		   //exit();
		   // $this->load->view("successjournal/index", $this->viewVars);
			redirect('successjournal/index','refresh');
	   }
	   
   function bucketlist()
   {  
       if($this->input->post('bucketAdd')){
	    // echo count($this->input->post('item'));
           $this->success_journal_model->bckList();

	   }
	   redirect('successjournal/index','refresh');
	  
   }
   function showbucketlist()
	{
	   
	}   
 
    function up_uggoal()
	{
	    /*$u_id=$this->session->userdata('id');
		$last_dayMsr = $this->succ_measure_model->get_max_res($u_id);
		foreach($last_dayMsr as $ulist){ $curWeight= $ulist['um_bweight']; }
		$loseweight = $row['weight']- $curWeight;*/
		$this->success_journal_model->upUltimateGoal();
		
		redirect('successjournal/index','refresh');
	}
	
	function up_weekgoal()
	{
	    $this->success_journal_model->upWeekGoal();
		
		redirect('successjournal/index','refresh');
	}
	
	//update measerements
	public function updmeasure()
	{
		$u_id=$this->session->userdata('id'); 
		//print_r($_POST);
	
		if (isset($_POST['measur_sub_x']))
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
	                  $fatWeight =  $um_bweight *  $bodyfat;   
	                  //Lean Body Mass = (My Body Weight)  �  (My Fat Weight)
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
	                  $fatWeight =  $um_bweight *  $bodyfat; 
					  //Lean Body Mass = (My Body Weight)  �  (My Fat Weight)
	                  $leanBodyMass = $um_bweight - $fatWeight;
                  }
			}
			
			/*   baody fat*/

			$curDate = date("Y-m-d");
			$checked_reg = $this->succ_measure_model->chk_reg_msr($u_id,$curDate);
			if(count($checked_reg)>0)
			{
				$mid = $checked_reg->um_id;
				$mesr_upd = $this->succ_measure_model->upd_usr_mesr($u_id,$curDate,$mid,$bodyfat,$fatWeight,$leanBodyMass);
				if(count($mesr_upd)>0)
				{
					$updated = 'You have entered a new measurement successfully.';
				} else {
					$updated = 'Database error! try again';
				}
				$this->session->set_flashdata('upd_mesrmnt', $updated);
				redirect('successjournal/index');
			} else {
				$mesr_ins = $this->succ_measure_model->ins_usr_mesr($u_id,$curDate,$bodyfat,$fatWeight,$leanBodyMass);
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
	function bonus_entry()
	{
	   $this->viewVars['bonusGoal'] = $this->success_journal_model->bonusGoalEntry(); 
	   redirect('successjournal/index');
	}
	
	function bonus_update()
	{  
	  // if($this->input->post('upbonus')){ echo "goooo"; 
	       //print_r($this->input->post('upbonus'));
	       $this->success_journal_model->bonusGoalupdate(); 
	 //  }
	   redirect('successjournal/index');
	}
	
	function bucketlistedit()
	{  //$x=0;
	   $u_id=$this->session->userdata('id');
	   if($this->input->post('bucketedit')){
	        $this->success_journal_model->bckList_del($u_id);
			   
               $this->success_journal_model->bckList();
			 
	   }
	   redirect('successjournal/index');
	}
	
	function update_msr_shedule()
	{
	    
		
		/*$dayArray = array(1,21,28,35,42,49,56);
		
		
		$k[]='';
		for($i=0; $i<=5;$i++)
		{  echo "rima";
		 echo "res".$k[]=$dayArray[$i+1]-$dayArray[$i];
		}*/
//echo $first_dayMsr = $this->succ_measure_model->get_firstday_um($u_id);
		
		//echo $first_dayMsr->um_date();
		
			

    }
	
	function complimentTracker()
    {
	   $this->success_journal_model->insertCompliment();
       redirect('successjournal/index');
    } 
 
}
?>