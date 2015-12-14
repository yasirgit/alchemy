<?php
class User_model extends Model
{
	
	private $CI;
	private $error;

	function __construct()
	{
		parent::Model();
		$this->CI =& get_instance();
		$this->CI->load->model(array('fatsecret/fsprofile'));
		$this->error = false;				
	}
	
	function getUser(array $where)
	{
            	$user = $this->db->get_where('users', $where)->row_array();
		if(!empty($user))
		{
			return true;
		} 
		return false;
	}

        function getFuser(array $where)
	{
		$user = $this->db->get_where('users', $where)->row_array();
		if(!empty($user))
		{
			$fsdata = $this->CI->fsprofile->profileGet($user['auth_token'], $user['auth_secret']);
			$data = array_merge($user, $fsdata);
			return $data;
		}
		return false;
	}

	//////////////////////////omar bglobal last login
	function setLastLogin($user)
	{
	    
		if((substr($user['last_login'],0,10)==date('Y-m-d'))&&$user['first_time_flag']=='1')
		{
		 $sql="update users set last_login='".date('Y-m-d H:i:s')."',first_time_flag='1' where id='".$user['id']."'";
		 $isupdate=$this->db->query($sql);						 
		}
		else
		{
		  $sql="update users set last_login='".date('Y-m-d H:i:s')."',first_time_flag='0' where id='".$user['id']."'";
		  $isupdate=$this->db->query($sql);						  
		}		
		return ($isupdate);
	}	
	///////////////////////////
/*	function addUser(array $data) {
		$fsdata = $this->CI->fsprofile->profileCreate($data['email']);

		if(isset($fsdata['error']) && strstr($fsdata['error'], 'Invalid ID'))
		{
			$this->error = $fsdata['error'];
			$fsdata = $this->CI->fsprofile->profileGetAuth($data['email']);
		}
		$data = array_merge($data, $fsdata);
		$data['error'] = $this->error;
		if(!empty($this->error))
		{
			$user = $this->getUser(array('auth_token' => $data['auth_token'], 'auth_secret' => $data['auth_secret'], 'email' => $data['email']));
			if(empty($user))
			{
				$user = $this->add($data);
			}
		} else {
			$user = $this->add($data);
		}
		$user['error'] = $this->error;
		return $user;
	}
 *
*/
        function addUser(array $data)
	{
		$fsdata = $this->CI->fsprofile->profileCreate($data['email']);
                //$fsdata = array();
                //$fsdata['auth_token']	= mktime();
                //$fsdata['auth_secret']	= mktime();
		if(!isset($fsdata['error']))
		{
			return $this->add(array_merge($data,$fsdata));
		}

		return array('error' => $fsdata['error']);
	}
	
	function add(array $data)
	{
		$sql = "SELECT	*" .
				" FROM	users" .
				" WHERE	email='".$data['email']."'";
		if ($this->db->query($sql)->result())
		{
			return array('error' => 'User is already registered');
		}

		$sql = "insert into users
					set	auth_token     ='".$data['auth_token']."',".
						"auth_secret   ='".$data['auth_secret']."',".
						"username      ='".$data['username']."',".
						"username_clean='".$data['username_clean']."',".
						"password      ='".$data['password']."',".
						"first_name    ='".$data['first_name']."',".
						"last_name     ='".$data['last_name']."',".
						"email         ='".$data['email']."'";
		$this->db->query($sql);
		$id = $this->db->insert_id();
		if (!$this->getUser(array('username_clean' => $data['username_clean'])))
		{
			return array('error' => 'No profile created for fat secret');
		}

		$this->db->where('id', $id);
		$this->db->update('users', array('username_clean' => $data['username_clean'].$id));
/*
		$dataT					= array();
		$dataT['week_period']	= "weekdays";
		$dataT['user_id']		= $id;
		foreach ($data['weekdays'] AS $type => $ut)
		{
			$dataT['type']		= $type;
			$dataT['time']		= date("H:i",strtotime($ut['time']." ".$ut['meridiem']));
			$this->db->insert("user_times",$dataT);
		}
		$dataT['week_period']	= "weekends";
		foreach ($data['weekends'] AS $type => $ut)
		{
			$dataT['type']		= $type;
			$dataT['time']		= date("H:i",strtotime($ut['time']." ".$ut['meridiem']));
			$this->db->insert("user_times",$dataT);
		}
*/
		return $this->getUser(array('id' => $id));
	}

	public function getDaily($eDate="")
	{
		if(strlen($eDate)==0)
		$eDate=$this->session->userdata('date');

		$query = "SELECT	*" .
				" FROM		user_daily" .
				" WHERE		user_id=".$this->session->userdata('id')." AND date='".$eDate."'";
		if ($daily = $this->db->query($query)->result())
		{
			return $daily[0];//->cups;
		}
		else
		{
			return false;
		}
	}

	public function setWaterTracker($mode,$eDate="")
	{
		
		if(strlen($eDate)==0)
		$eDate=$this->session->userdata('date');
		
		if (($daily = $this->getDaily($eDate)) === false)
		{
			$cups	= 0;
			$insert	= true;
		}
		else
		{
			$cups	= $daily->cups;
			$insert = false;
		}

		switch ($mode)
		{
			default:
			$data = array('water' => $cups);
			break;

			case "more":
			$data = ($cups < _MAX_WATER_) ?	array('cups' => ++$cups) : array('cups' => _MAX_WATER_) ;
			break;

			case "less":
			$data = ($cups > 0) ?			array('cups' => --$cups) : array('cups' => 0) ;
			break;
		}
		
		if ($insert)
		{
			$data				= array();
			$data["user_id"]	= $this->session->userdata('id');
			$data["date"]		= $eDate;
			$data["cups"]		= $cups;
			$this->db->insert("user_daily", $data);
		}
		else
		{
			$where				= array();
			$where["user_id"]	= $this->session->userdata('id');
			$where["date"]		= $eDate;
			$this->db->update("user_daily", $data, $where);
		}
		
		return $data['cups'];
	}

	public function setDaily($field,$checked,$eDate="")
	{
		if(strlen($eDate)==0)
		$eDate=$this->session->userdata('date');
		
		if (($daily = $this->getDaily()) === false)
		{
			$insert	= true;
		}
		else
		{
			$insert = false;
		}

		$data			= array();
		$data[$field]	= $checked;
		if ($insert)
		{
			$data["user_id"]	= $this->session->userdata('id');
			$data["date"]		= $eDate;
			$this->db->insert("user_daily", $data);
		}
		else
		{
			$where				= array();
			$where["user_id"]	= $this->session->userdata('id');
			$where["date"]		= $eDate;
			$this->db->update("user_daily", $data, $where);
		}
		
		return true;
	}
	/////////////////////////////////////function new user registration////////////
	function emailverify($data)
	{		
		$result=array();
		$varification_code=base64_encode($data['email'].rand(1000, 100001));		
		$sql="select * from users where email='".$data['email']."'";
		$user=$this->db->query($sql)->result();
		if(empty($user))
		{
			$sql = "insert into users  set email='".$data['email']."',
			activation_code='".$varification_code."',auth_token='".$data['email']."',
			active='0'";					
			$this->db->query($sql);
			$id = $this->db->insert_id();		
			/////////////////////////////////////////////////////email for confirmation///
			$confirm_link="http://".$_SERVER['SERVER_NAME']."/access/emailconfirm/".$varification_code;
			$message="For the food lovers fat loss system you need to confirm emaill address.\r\n
			Please click the following link\r\n\r\n".$confirm_link;
			
			$this->load->library('email');
			$this->email->from('admin@foodlovers.com', 'Admin');
			$this->email->to($data['email']);
			$this->email->subject('Email Confirmation');
			$this->email->message($message);		
			$this->email->send();					
		}
		else if($user[0]->active==1)
		{
			$result['step2']=$user[0]->id;	
		}
		else{
                    $result['error']="User already exists with this email id.";
                }
		/////////////////////////////////////////////////		
		return $result;
	}

        function verifyemail($data)
	{
		$result=array();
		$varification_code=base64_encode($data['email'].rand(1000, 100001));

                /*$sql = "insert into users  set email='".$data['email']."',
                    activation_code='".$varification_code."', auth_token='".$data['email']."',
                    active='0'";*/
                $sql = "update users set activation_code='".$varification_code."', auth_token='".$data['email']."' where email like '".$data['email']."'";
                $this->db->query($sql);
                /////////////////////////////////////////////////////email for confirmation///
                $confirm_link="http://".$_SERVER['SERVER_NAME']."/access/emailconfirm/".$varification_code;
                $message="For the food lovers fat loss system you need to confirm emaill address.\r\n
                Please click the following link\r\n\r\n".$confirm_link;

                $this->load->library('email');
                $this->email->from('admin@foodlovers.com', 'Admin');
                $this->email->to($data['email']);
                $this->email->subject('Email Confirmation');
                $this->email->message($message);
                $this->email->send();
	}
        
	function getDefaultTime($defaultData,$type)
	{									
		foreach($defaultData[$type] as $key=>$value)		
		{
			if($key=="Wakeup")
			{
				$defaultData[$type]['Breakfast']=date("H:i:s",strtotime($value)+(30*60));	
				$defaultData[$type]['Snack1']=date("H:i:s",strtotime($defaultData[$type]['Breakfast'])+(2*60*60)+(30*60));		
				$defaultData[$type]['Lunch']=date("H:i:s",strtotime($defaultData[$type]['Snack1'])+(2*60*60)+(30*60));			
				$defaultData[$type]['Snack2']=date("H:i:s",strtotime($defaultData[$type]['Lunch'])+(2*60*60)+(30*60));		
				$defaultData[$type]['Dinner']=date("H:i:s",strtotime($defaultData[$type]['Snack2'])+(2*60*60)+(30*60));			
				$defaultData[$type]['Snack3']=date("H:i:s",strtotime($defaultData[$type]['Dinner'])+(2*60*60)+(30*60));				
				return $defaultData;
			}
			
		}
		
		return $defaultData;
	}
	function addverified($postData)
	{
		$defaultData=$this->getDefaultTime($_POST,'weekdays');						
		foreach($defaultData['weekdays'] as $key=>$value)
		{
			$temp=$key;
			if(substr($key,0,5)=="Snack")
			$temp="Snack";
			
			$sql="insert into user_times set
				user_id='".$_POST['uid']."',
				type='".$temp."',
				week_period='weekdays',
				time='".$value."'";
			$this->db->query($sql);
		}
		$defaultData=$this->getDefaultTime($_POST,'weekends');
		
		foreach($defaultData['weekends'] as $key=>$value)
		{
			$temp=$key;
			if(substr($key,0,5)=="Snack")
			$temp="Snack";
			
			$sql="insert into user_times set
				user_id='".$_POST['uid']."',
				type='".$temp."',
				week_period='weekends',
				time='".$value."'";
			$this->db->query($sql);
		}

                echo $postData['email']; exit;
		
		$fsdata = $this->CI->fsprofile->profileCreate($postData['email']);
		if(isset($fsdata['auth_token']) && strlen($fsdata['auth_token']) > 0)
		{				 		
			$sql="update users set
					first_name='".mysql_escape_string(trim($postData['first_name']))."',
					last_name='".mysql_escape_string(trim($postData['last_name']))."',
					birthdate='".mysql_escape_string(trim($postData['byear'])).'-'.mysql_escape_string(trim($postData['bmonth']))."-".mysql_escape_string(trim($postData['bday']))."',
					sex='".$postData['sex']."',
					height='".mysql_escape_string(trim($postData['hfeet']))." ".mysql_escape_string(trim($postData['hinch']))."',
					weight='".$postData['current_weight']."',
					goal_weight='".$postData['goal_weight']."',
					username='".mysql_escape_string(trim($postData['username']))."',
					username_clean='".$postData['username_clean']."',
					auth_token='".$fsdata['auth_token']."',
					auth_secret='".$fsdata['auth_secret']."',
					active='2',
					timezone='".$postData['timezone']."',
					created='".date('Y-m-d H:i:s')."',
					password='".$postData['password']."' where id='".$postData['uid']."'";			
			$this->db->query($sql);
		}
		else
		{
			$sql="update users set
					first_name='".mysql_escape_string(trim($postData['first_name']))."',
					last_name='".mysql_escape_string(trim($postData['last_name']))."',
					birthdate='".mysql_escape_string(trim($postData['byear'])).'-'.mysql_escape_string(trim($postData['bmonth']))."-".mysql_escape_string(trim($postData['bday']))."',
					sex='".$postData['sex']."',
					height='".mysql_escape_string(trim($postData['hfeet']))." ".mysql_escape_string(trim($postData['hinch']))."',
					weight='".$postData['current_weight']."',
					goal_weight='".$postData['goal_weight']."',
					username='".mysql_escape_string(trim($postData['username']))."',
					username_clean='".$postData['username_clean']."',					
					active='2',
					timezone='".$postData['timezone']."',
					created='".date('Y-m-d H:i:s')."',
					password='".$postData['password']."' where id='".$postData['uid']."'";			
			$this->db->query($sql);
			
		}
		/////////////////////////////////////////////////exercise//////////////////////////////
		$sql="select * from user_times where user_id='".$postData['uid']."' and type='Exercise' and week_period='weekdays'";		
		$tempResults=$this->db->query($sql)->result();
		if(empty($tempResults))
		{
			$sql="insert into user_times set 
			user_id='".$postData['uid']."',type='Exercise',week_period='weekdays',time='13:00:00'";
			$this->db->query($sql);
		}
		/////////////////////////////////////////////////////////////
		$sql="select * from user_times where user_id='".$postData['uid']."' and type='Exercise' and week_period='weekends'";		
		$tempResults=$this->db->query($sql)->result();
		if(empty($tempResults))
		{
			$sql="insert into user_times set 
			user_id='".$postData['uid']."',type='Exercise',week_period='weekends',time='14:00:00'";
			$this->db->query($sql);
		}		
		////////////////////////////////////////////////////////////////	
		return $postData['uid'];
	}
	///////////////////////////////////////////
	function userhomeworkaddress($data=array(),$uid,$flag)
	{
		$return=array(); 
		if($flag==1)   //select user address
		{
			$sql="select * from users_homeaddress where uid='".$uid."'";			 
			$return['home']=$this->db->query($sql)->result();
		
			$sql="select * from users_workaddress where uid='".$uid."'";
			$return['workadd']=$this->db->query($sql)->result();
			
		}
		else if($flag==2)
		{
			echo "<pre>";
				print_r($data);
			echo "</pre>";
		}
		return $return;
	}
	////////////////////////////////////////////
}
?>