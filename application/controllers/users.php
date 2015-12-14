<?php
//require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

class Users extends Controller {

	private $viewVars = array();

	function __construct()
	{
		parent::Controller();
		error_reporting(0);
		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array();//('users.js');
		$this->load->model(array('user_model', 'user_food_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation'));
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
		if(!$this->auth->isLoggedIn())
		{
			return redirect('/login');
		}
		$this->viewVars['user'] = $this->user_model->getUser(array('username_clean' => $this->session->userdata('username_clean')));
		/////////////////////////////////////////////
		$active=$this->viewVars['user']['active'];
		if($active!=2)
		redirect('access/signup_step2/'.$this->viewVars['user']['id']);		
		//////////////////////////////////////////////
				
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

	public function setup()
	{
		if (@$this->init != 'no')
		{
			$this->pageVars['_assets_js']	= array('setup.js');
			$this->pageVars['_assets_css']	= array('setup.css');
			return $this->load->view('users/setup', $this->viewVars);
		}

		$this->load->model('journal_model', 'journal');
		foreach ($_POST['weekdays'] AS $type => $time)
		{
			$this->journal->putTime(array(	'type' => $type, 'time' => $time, 'week_period' => 'weekdays'));
		}
		foreach ($_POST['weekends'] AS $type => $time)
		{
			$this->journal->putTime(array(	'type' => $type, 'time' => $time, 'week_period' => 'weekends'));
		}
		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= "";
		echo json_encode($tmp_array);

		$this->pageVars['isajax'] = true;
	}

	public function myAccount()
	{
		///////////////////////previous code				
		/*
		$this->load->model('journal_model', 'journal');
		$this->viewVars['user_times']	= $this->journal->getTime();
		$this->pageVars['_assets_js']	= array('setup.js');
		$this->pageVars['_assets_css']	= array('setup.css');		
		return $this->load->view('users/setup', $this->viewVars);		
		*/
		/////////////////////new registration
		
		$error=array();
		///////////////////////update complete//new my account page load
		if(strlen($this->session->userdata('error'))>0)
		{
			$error['update_complete'] = $this->session->userdata('error');			
			$this->session->unset_userdata('error');			
		}			
		///////////////////////
		
		$this->load->model('journal_model', 'journal');		
		/////////////////////////////usertime//////		
		$this->viewVars['user_times']= $this->journal->getTime();				 
		//////////////////////////////////////////////				
		$this->form_validation->set_rules('email',		'Email',		'trim|required|valid_email|xss_clean');
		//$this->form_validation->set_rules('username',	'Username',		'trim|required|min_length[2]|xss_clean');		
		$this->form_validation->set_rules('first_name',	'First Name',	'trim|required');
		$this->form_validation->set_rules('last_name',	'Last Name',	'trim|required');
		
		if(isset($_POST['password'])&&strlen($_POST['password'])>0)
		{
			$this->form_validation->set_rules('password',	'Password',		'trim|required|matches[cpassword]|min_length[5]|sha1');
		}

		if($this->form_validation->run() !== FALSE)
		{
			
			////////////user user profile update//////
			$sql="update users set
				first_name='".mysql_escape_string(trim($_POST['first_name']))."',
				last_name='".mysql_escape_string(trim($_POST['last_name']))."',
				birthdate='".$_POST['dyear'].'-'.$_POST['dmonth']."-".$_POST['dbday']."',
				sex='".$_POST['sex']."',
				height='".$_POST['fheight']." ".$_POST['iheight']."',
				weight='".$_POST['weight']."',
				goal_weight='".$_POST['goal_weight']."',
				timezone='".$_POST['timezone']."'
				where id='".$_POST['uid']."'";			
			$this->db->query($sql);						
			$this->session->set_userdata(array("timezone" => $_POST['timezone']));
			/////////////////////////////////////////////
		/*	$sql="select * from users where username='".$_POST['username']."' and id!='".$_POST['uid']."'";
			$result=$this->db->query($sql)->result();
			if(!empty($result))
			{
				$error['username']="This username already exists";	
			}
			else
			{
				$sql="update users set username='".$_POST['username']."' where id='".$_POST['uid']."'";
				$this->db->query($sql);			
			}*/
													
			if(strlen($_POST['password'])>0)
			{
				$sql="update users set password='".$_POST['password']."' where id='".$_POST['uid']."'";
				$this->db->query($sql);
			}				
			
			/////////////check home address///////////////
			$sql="select * from users_homeaddress where uid='".$_POST['uid']."'";
			$result=$this->db->query($sql)->result();
			if(empty($result))
			{
				$sql="insert into users_homeaddress set
				  	uid='".$_POST['uid']."',
				  	street_address='".mysql_escape_string(trim($_POST['home']['street_address']))."',
				  	app_suite='".mysql_escape_string(trim($_POST['home']['app_suite']))."',
				  	city='".mysql_escape_string(trim($_POST['home']['city']))."',
				  	state='".mysql_escape_string(trim($_POST['home']['state']))."',
				  	zip_code='".mysql_escape_string(trim($_POST['home']['zip_code']))."',
				  	country='".mysql_escape_string(trim($_POST['home']['country']))."'";
				$this->db->query($sql);
			}
			else
			{
				$sql="update users_homeaddress set
				  	uid='".$_POST['uid']."',
				  	street_address='".mysql_escape_string(trim($_POST['home']['street_address']))."',
				  	app_suite='".mysql_escape_string(trim($_POST['home']['app_suite']))."',
				  	city='".mysql_escape_string(trim($_POST['home']['city']))."',
				  	state='".mysql_escape_string(trim($_POST['home']['state']))."',
				  	zip_code='".mysql_escape_string(trim($_POST['home']['zip_code']))."',
				  	country='".mysql_escape_string(trim($_POST['home']['country']))."' where id='".$_POST['home']['id']."'";
				$this->db->query($sql);
			}
			
		/////////////check work address///////////////
			$sql="select * from users_workaddress where uid='".$_POST['uid']."'";
			$result=$this->db->query($sql)->result();
			if(empty($result))
			{
				$sql="insert into users_workaddress set
				  	uid='".$_POST['uid']."',
				  	street_address='".mysql_escape_string(trim($_POST['work']['street_address']))."',
				  	app_suite='".mysql_escape_string(trim($_POST['work']['app_suite']))."',
				  	city='".mysql_escape_string(trim($_POST['work']['city']))."',
				  	state='".mysql_escape_string(trim($_POST['work']['state']))."',
				  	zip_code='".mysql_escape_string(trim($_POST['work']['zip_code']))."',
				  	country='".mysql_escape_string(trim($_POST['work']['country']))."'";
				$this->db->query($sql);
			}
			else
			{
				$sql="update users_workaddress set
				  	uid='".$_POST['uid']."',
				  	street_address='".mysql_escape_string(trim($_POST['work']['street_address']))."',
				  	app_suite='".mysql_escape_string(trim($_POST['work']['app_suite']))."',
				  	city='".mysql_escape_string(trim($_POST['work']['city']))."',
				  	state='".mysql_escape_string(trim($_POST['work']['state']))."',
				  	zip_code='".mysql_escape_string(trim($_POST['work']['zip_code']))."',
				  	country='".mysql_escape_string(trim($_POST['work']['country']))."' where id='".$_POST['work']['id']."'";
				$this->db->query($sql);
			}
			if(empty($error))
			{
				$this->session->set_userdata('error', 'Update user data successfully.');
				redirect('/users/myAccount');
			}
		}	
		/////////////////////////////get metabolism//////////////////
		
		 $sql="select * from user_21day_metabolism where uid='".$this->session->userdata('id')."'";
		$result=$this->db->query($sql)->result();
		
		   foreach($result  as $key=> $metdata)
		   {   //echo "1";
		    // echo $this->viewVars['mStartDay']=$metdata['metabolism_start_day'];
		      $this->viewVars['mStartDay']= $metdata->metabolism_start_day;
			  $this->viewVars['wDaysWake']=$metdata->weekdays_wakeup_time;
			  $this->viewVars['wDaysBed']=$metdata->weekdays_bed_time;
			  $this->viewVars['wEndWake']=$metdata->weekends_wakeup_time;
			  $this->viewVars['wEndBed']=$metdata->weekends_bed_time;
			  $this->viewVars['breakFast']=$metdata->breakfast_time;
			  $this->viewVars['mealsTime']=$metdata->meals_time;
		   }
		
	/////////////////////////////get metabolism//////////////////
									
		$data=array();
		$this->viewVars['user_address']= $this->user_model->userhomeworkaddress($data,$this->session->userdata('id'),1);
		$this->viewVars['uerror']=$error;
		/////////////////////////////get all exercise data
		$sql="select * from daily_exercise where uid='".$this->session->userdata('id')."'";
		$uexercise=$this->db->query($sql)->result();
		$muexercise=array();
				
		for($i=0;$i<count($uexercise);$i++)
		$muexercise[$uexercise[$i]->week_day]=$uexercise[$i];
						
		$this->viewVars['uexercise']=$muexercise;
		/////////////////////////////		
		return $this->load->view('users/signup/myaccount', $this->viewVars);
	}
//////////////////////////My edit Page/////////////////////////////////////	
    function change_password()
    {
	   /// $data=array();
		if(isset($_POST['uid'])){
	        $sql="select password from users where id='".$_POST['uid']."'";
		      $result=$this->db->query($sql)->result();
			 foreach($result as $key=>$upass){
			   $oldPass= $upass->password;
			 }
			
		}
		
		$error=array();
		$this->viewVars['error_custom']='';
		///////////////////////update complete//new my account page load
		if(strlen($this->session->userdata('error'))>0)
		{
			$error['update_complete'] = $this->session->userdata('error');			
			$this->session->unset_userdata('error');			
		}			
		$this->load->model('journal_model', 'journal');
		
		    $this->form_validation->set_rules('oldPass','Old Password','required');
			$this->form_validation->set_rules('password','Password','required');
		 //   $this->form_validation->set_rules('cpassword','Verify Password','required');
		
/*		if(($_POST['oldPass'])!=sha1($oldPass))
		{
		   
		         echo "False";
		       //  $this->form_validation->set_rules('oldPass','Old Password matched','required');
				 $this->form_validation->set_message('oldPass', 'Old password not matched');
           
		 }*/
         
		  
		if(isset($_POST['password'])&& strlen($_POST['password'])>0)
		{
			
			$this->form_validation->set_rules('password','Password','trim|required|matches[cpassword]|min_length[5]|sha1');
			
			
		}
		//echo sha1($oldPass);
		
		if($this->form_validation->run() !== FALSE)
		{
		   if((sha1($_POST['oldPass']))== $oldPass)
			{
				//echo "true";
				$sql="update users set password='".$_POST['password']."' where id='".$_POST['uid']."'";
				$this->db->query($sql);
				if(empty($error))
			    {
				
				$this->session->set_userdata('error', 'Update user data successfully.');
				redirect('/users/myAccount');
			    }
				
				
			}	
			else{
			   //echo "False";
			   $this->viewVars['error_custom']='Not Matched old password';
			 //  redirect('/users/change_password');
			   
			}
			
			
			
		}
		
		
       $this->load->view('users/signup/change_password', $this->viewVars);
    }

//////////////////////////My edit Page/////////////////////////////////////	
	
	
	
	////////////////////////////////////////////
	function save_journaldata()
	{
	/////////////////////////////////////////					
		$sql="select * from user_times where user_id='".$this->session->userdata('id')."' order by time asc";
		$user_times=$this->db->query($sql)->result();
		
				
		$weekdays=array();
		$weekends=array();
	
		$flagwd=1;
		$flagwen=1;
		for($i=0;$i<count($user_times);$i++)
		{	
			if($user_times[$i]->week_period=="weekdays"&&$user_times[$i]->type!="Snack")
			{
			 $weekdays[$user_times[$i]->type]['time']=$user_times[$i]->time;
			 $weekdays[$user_times[$i]->type]['id']=$user_times[$i]->utID;			 
			} 
			else if($user_times[$i]->week_period=="weekdays"&&$user_times[$i]->type=="Snack")
			{
			 $weekdays[$user_times[$i]->type.($flagwd)]['time']=$user_times[$i]->time;
			 $weekdays[$user_times[$i]->type.($flagwd)]['id']=$user_times[$i]->utID;
			 $flagwd++;
			}
			else if($user_times[$i]->week_period=="weekends"&&$user_times[$i]->type!="Snack")
			{
			 $weekends[$user_times[$i]->type]['time']=$user_times[$i]->time;
			 $weekends[$user_times[$i]->type]['id']=$user_times[$i]->utID;
			}		
			else if($user_times[$i]->week_period=="weekends"&&$user_times[$i]->type=="Snack")
			{
			 $weekends[$user_times[$i]->type.($flagwen)]['time']=$user_times[$i]->time;
			 $weekends[$user_times[$i]->type.($flagwen)]['id']=$user_times[$i]->utID;
			 $flagwen++;
			}
		}		
		////////////////insert/update weekdays value
		foreach($_POST['weekdays'] as $key=>$value)
		{
			if(empty($weekdays[$key]))
			{
				
				if(substr($key,0,5)=="Snack")
				$temp="Snack";
				else
				$temp=$key;
				
				$sql="select * from user_times where time='".date("H:i:s",strtotime($value))."'
				and user_id='".$this->session->userdata('id')."' and
				type='".$temp."' and week_period='weekdays'"; 
								
				$tempResults=$this->db->query($sql)->result();
				if(empty($tempResults))
				{								
					$sql="insert into user_times set
					time='".date("H:i:s",strtotime($value))."',
					user_id='".$this->session->userdata('id')."',
					type='".$temp."',
					week_period='weekdays'";
					$this->db->query($sql);
				}
				else
				{
				   $this->session->set_userdata('error', 'Please check the time correctly.');
				   redirect('/users/myAccount');
				}																			
			}
			else
			{
				/////////add none option in last snack//////
				if(strlen($value)==0)
				$sql="update user_times set isdisable='1' where utID='".$weekdays[$key]['id']."'";
				else
				{
				////////////////////////////////////////////				
				$sql="update user_times set
				time='".date("H:i:s",strtotime($value))."',isdisable='0' where utID='".$weekdays[$key]['id']."'";
				}
				$this->db->query($sql);
			}					
		}
		////////////////////end insert/update weekdays value//		
		////////////////insert/update weekends value
		foreach($_POST['weekends'] as $key=>$value)
		{
			if(empty($weekends[$key]))
			{
				
				if(substr($key,0,5)=="Snack")
				$temp="Snack";
				else
				$temp=$key;
				
				$sql="select * from user_times where time='".date("H:i:s",strtotime($value))."'
				and user_id='".$this->session->userdata('id')."' and
				type='".$temp."' and week_period='weekends'"; 
								
				$tempResults=$this->db->query($sql)->result();
				if(empty($tempResults))
				{								
					$sql="insert into user_times set
					time='".date("H:i:s",strtotime($value))."',
					user_id='".$this->session->userdata('id')."',
					type='".$temp."',
					week_period='weekends'";
					$this->db->query($sql);
				}
				else
				{
				   $this->session->set_userdata('error', 'Please check the time correctly.');
				   redirect('/users/myAccount');
				}																			
			}
			else
			{
				
				/////////add none option in last snack//////
				if(strlen($value)==0)
				$sql="update user_times set isdisable='1' where utID='".$weekends[$key]['id']."'";
				else
				{
				////////////////////////////////////////////
				$sql="update user_times set
				time='".date("H:i:s",strtotime($value))."',isdisable='0' where utID='".$weekends[$key]['id']."'";
				}				
				$this->db->query($sql);
			}				
		}	
		////////////////////end insert/update weekdays value//
		redirect('/users/myAccount');		
		////////////////////////////////////////////		
	}
	///////////////////////////////////////////////
	function metabolism(){
				/////////////check 21 day meabolism///////////////
			$sql="select * from user_21day_metabolism where uid='".$_POST['uid']."'";
			$result=$this->db->query($sql)->result();
			$created=date("Y-m-d");
			if(empty($result))
			{
				$sql="insert into user_21day_metabolism set
				  	uid='".$_POST['uid']."',
					metabolism_start_day='".mysql_escape_string(trim($_POST['dayFixed']))."',
				  	weekdays_wakeup_time='".mysql_escape_string(trim($_POST['weekdays']['Wakeup']))."',
				  	weekdays_bed_time='".mysql_escape_string(trim($_POST['weekdays']['Bed']))."',
				  	weekends_wakeup_time='".mysql_escape_string(trim($_POST['weekends']['Wakeup']))."',
				  	weekends_bed_time='".mysql_escape_string(trim($_POST['weekends']['Bed']))."',
				  	breakfast_time='".mysql_escape_string(trim($_POST['breakfast_time']))."',
					meals_time='".mysql_escape_string(trim($_POST['meals_spaced_out']))."',
				  	createdOn='".$created."'";
					
				    $this->db->query($sql);
			}
			else
			{;
				$sql="update user_21day_metabolism set
				    uid='".$_POST['uid']."',
					metabolism_start_day='".mysql_escape_string(trim($_POST['dayFixed']))."',
				  	weekdays_wakeup_time='".mysql_escape_string(trim($_POST['weekdays']['Wakeup']))."',
				  	weekdays_bed_time='".mysql_escape_string(trim($_POST['weekdays']['Bed']))."',
				  	weekends_wakeup_time='".mysql_escape_string(trim($_POST['weekends']['Wakeup']))."',
				  	weekends_bed_time='".mysql_escape_string(trim($_POST['weekends']['Bed']))."',
				  	breakfast_time='".mysql_escape_string(trim($_POST['breakfast_time']))."',
					meals_time='".mysql_escape_string(trim($_POST['meals_spaced_out']))."',
				  	createdOn='".$created."'";
				$this->db->query($sql);
			}
			if(empty($error))
			{
				$this->session->set_userdata('error', 'Update user data successfully.');
				redirect('/users/myAccount');
			}
			
	}
			
		///////////////////////////21 day metabolism ///////////////////////////////////	
	
	
	
	
	function saveexercise()
	{						
		foreach($_POST as $key=>$value)
		{
			$sql="select * from daily_exercise where uid='".$this->session->userdata('id')."' and week_day='".$key."'";
			$tempResults=$this->db->query($sql)->result();
			if(empty($tempResults))
			{
				$sql="insert into daily_exercise set
				uid='".$this->session->userdata('id')."',
				cardio_time='".$value['cardio_time']."', 
				resistance_time='".$value['resistance_time']."',
				week_day='".$key."'";
				$this->db->query($sql);
			}
			else
			{
				$sql="update daily_exercise set				
				cardio_time='".$value['cardio_time']."', 
				resistance_time='".$value['resistance_time']."'
				where id='".$tempResults[0]->id."'";
				$this->db->query($sql);
			}			
		}
		
		/////////////////////////////////////////////////exercise//////////////////////////////
		$sql="select * from user_times where user_id='".$this->session->userdata('id')."' and type='Exercise' and week_period='weekdays'";		
		$tempResults=$this->db->query($sql)->result();
		if(empty($tempResults))
		{
			$sql="insert into user_times set 
			user_id='".$this->session->userdata('id')."',type='Exercise',week_period='weekdays',time='13:00:00'";
			$this->db->query($sql);
		}
		/////////////////////////////////////////////////////////////
		$sql="select * from user_times where user_id='".$this->session->userdata('id')."' and type='Exercise' and week_period='weekends'";		
		$tempResults=$this->db->query($sql)->result();
		if(empty($tempResults))
		{
			$sql="insert into user_times set 
			user_id='".$this->session->userdata('id')."',type='Exercise',week_period='weekends',time='14:00:00'";
			$this->db->query($sql);
		}		
		////////////////////////////////////////////////////////////////
		
		redirect('/users/myAccount');	 		
	}	
	public function eating_journal()
	{		
		$this->load->model('journal_model');		
		$this->pageVars['_assets_js']	= array('eatingJournal.js');
		$this->viewVars['active']		= "today";		
		return $this->load->view('users/eating_journal/content', $this->viewVars);
	}

	function recipe_finder($rID=null)
	{
		$this->viewVars['recipe_mlType_slc'] = null;
		$this->viewVars['recipe_Type_slc'] = null;
		$this->viewVars['dietary_sel'] = null;
		
		if ($rID)
		{
			$this->load->model("recipes_model","recipes");
			$this->viewVars['recipe'] = $this->recipes->get($rID);
		}
		
		if($rID)
		{
			$query = "SELECT	*" .
					" FROM		recipe_mealtype_selections, recipe_mealtypes WHERE recipe_mealtype_selections.rID=".$rID." AND recipe_mealtype_selections.MealTypeId = recipe_mealtypes.id";
			$this->viewVars['recipe_mlType_slc'] = $this->db->query($query)->result();
		}
		##SHAHED Receipe meal type changes##
		$query = "SELECT	*" .
				" FROM		recipe_mealtypes" .
				" ORDER BY id";
		$this->viewVars['recipeTypes'] = $this->db->query($query)->result();
		
		##SHAIFUL Receipe type changes##
		$query = "SELECT	*" .
				" FROM		recipe_types" .
				" ORDER BY rtID";
		$this->viewVars['only_rcpTps'] = $this->db->query($query)->result();
		
		if($rID)
		{
			$query = "SELECT	*" .
					" FROM		recipe_type_selections, recipe_types WHERE recipe_type_selections.rID=".$rID." AND recipe_type_selections.recipeTypeId = recipe_types.rtID";
			$this->viewVars['recipe_Type_slc'] = $this->db->query($query)->result();
		}
		
	    ##SHAHED Receipe type changes ##
        
		$query = "SELECT	*" .
				" FROM		recipe_healthissues rh";
		if ($rID)
		{
			$query .= " LEFT JOIN recipe_healthissuesx rhX ON rhX.rID=".$rID." AND rhX.rhiID=rh.rhiID";
		}
		$query .= " ORDER BY rh.issue";
		$this->viewVars['healthIssues'] = $this->db->query($query)->result();

		
		//$query = "SELECT	*" . " FROM		recipe_classification rc";
		$query = "SELECT	*" . " FROM		recipe_directory_considerations rc";
		$query .= " ORDER BY rc.rcID";
		$this->viewVars['dietary'] = $this->db->query($query)->result();
		
		#SHAIFUL dietary relation....
		if ($rID)
		{
			$query = "SELECT	*" . " FROM		recipe_directory_considerations rc";
			$query .= " LEFT JOIN recipe_directory_considerations_selections rcX ON rcX.rID=".$rID." AND rcX.rcID=rc.rcID";
			$this->viewVars['dietary_sel'] = $this->db->query($query)->result();
		}
		
		
		
		##SHAHED ##
		/*$query = "SELECT * " . " FROM	recipe_type_selections";
		$this->viewVars['recipeTypeSelections'] = $this->db->query($query)->result();
		*/
		##SHAHED ##
	    return $this->load->view('users/recipe_finder/builder', $this->viewVars);
		
		
	}

	function eating_out_advisor() {
		return $this->load->view('users/eating_out_advisor/content', $this->viewVars);
	}
	
	function snack_treat_guide() {
		return $this->load->view('users/snack_treat_guide/content', $this->viewVars);
	}
	
	function menu_planner() {
		return $this->load->view('users/menu_planner/content', $this->viewVars);
	}
	
	function success_journal() {
		return $this->load->view('users/success_journal/content', $this->viewVars);
	}
	
	function profile() {
		return $this->load->view('users/profile', $this->viewVars);
	}
	
	function edit($username) {
		if($this->auth->isLoggedIn()) {
			$this->viewVars['user'] = $this->user_model->getUser(array('username_clean' => $username));
			$this->viewVars['fsdata'] = $this->fsprofile->profileGet($this->viewVars['user']['auth_token'], $this->viewVars['user']['auth_secret']);
			if(!empty($this->viewVars['user'])) {
				$this->form_validation->set_rules('weight', 'Current Weight', 'trim|numeric|required|xss_clean');
				$this->form_validation->set_rules('goal_weight', 'Goal Weight','trim|numeric|xss_clean');
				$this->form_validation->set_rules('height', 'Height', 'trim|numeric|xss_clean');
				if($this->form_validation->run() !== FALSE) {
					try {
						$this->fsprofile->weightUpdate($this->viewVars['user']['auth_token'], $this->viewVars['user']['auth_secret'], 
							$this->input->post('weight'), $this->input->post('goal_weight'), $this->input->post('height'));
							redirect('/users/profile/'.$username);
					} catch(FatSecretException $e) {
						echo $e->getMessage();	
						$this->load->view('users/edit', $this->viewVars);
					}
				} else {
					$this->load->view('users/edit', $this->viewVars);
				}
			}
		} else {
			$this->load->view('users/login');
		}
	}
	
	function foodCreate() {
		$this->viewVars['foods'] = $this->user_food_model->foodsGet($this->session->userdata('id'));
		
		if($this->auth->isLoggedIn()) {
			$this->form_validation->set_rules('brand_type', 'Brand Type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('brand', 'Brand Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('name', 'Food Name','trim|required|xss_clean');
			$this->form_validation->set_rules('size', 'Serving Size', 'trim|required|xss_clean');
			$this->form_validation->set_rules('calories', 'Calories', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_rules('fat', 'Fat', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_rules('carbohydrate', 'carbohydrate', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_rules('protein', 'Protein', 'trim|numeric|required|xss_clean');
			if($this->form_validation->run() !== FALSE) {
				$data['brand_type'] = $this->input->post('brand_type');
				$data['brand_name'] = $this->input->post('brand');
				$data['food_name'] = $this->input->post('name');
				$data['serving_size'] = $this->input->post('size');
				$data['calories'] = $this->input->post('calories');
				$data['fat'] = $this->input->post('fat');
				$data['carbohydrate'] = $this->input->post('carbohydrate');
				$data['protein'] = $this->input->post('protein');
				
				$food_id = $this->fsprofile_food->foodCreate($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'), $data);
				
				echo $food_id;
				
				if(!empty($food_id)) {
					$this->user_food_model->foodCreate(array('user_id'=> $this->session->userdata('id'), 'food_id' => $food_id));
				}
				$this->viewVars['foods'] = $this->user_food_model->foodsGet($this->session->userdata('id'));
				if(!empty($this->viewVars['foods'])) {
					foreach($this->viewVars['foods'] as $k => $v) {
						$fsresult = $this->fsprofile_food->foodGet($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'), $v['food_id']);
						$this->viewVars['foods'][$k] = $fsresult;
					}
				}
			}
			$this->load->view("users/food_create", $this->viewVars);
		} else {
			$this->load->view('users/login');
		}
	}

}

?>