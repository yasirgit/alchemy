<?php
class Admin_user_model extends Model
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

        function getAdminUser(array $where)
	{
		$user = $this->db->get_where('admin_users', $where)->row_array();
                //print_r($user);
                if(!empty($user))
		{		
		  $data = array_merge($user);
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
	
	function addUser(array $data)
	{		
            return $this->add($data);		
	}
	
	function add(array $data)
	{
		$sql = "SELECT	*" .
				" FROM	admin_users" .
				" WHERE	email='".$data['email']."'";
		if ($this->db->query($sql)->result())
		{
			return array('error' => 'User is already registered');
		}
		$sql = "insert into admin_users
					set	username      ='".$data['username']."',".
						"group_id      ='".$data['group_id']."',".
                                                "activ         ='".$data['activ']."',".
						"password      ='".$data['password']."',".
						"first_name    ='".$data['first_name']."',".
						"last_name     ='".$data['last_name']."',".
						"email         ='".$data['email']."'";
		$this->db->query($sql);
		$id = $this->db->insert_id();
		if (!$this->getUser(array('username' => $data['username'])))
		{
			return array('error' => 'No profile created for fat secret');
		}

		$this->db->where('id', $id);
		$this->db->update('admin_users', array('username' => $data['username'].$id));

		return $this->getUser(array('id' => $id));
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
        function viewUser(){
            $sql = "SELECT *" . " FROM	admin_users";
            $viewUserR=$this->db->query($sql)->result();
            return $viewUserR;
        }

        function listUser(){
            $sql = "SELECT * FROM users";
            $viewUserR = $this->db->query($sql)->result();
            return $viewUserR;
        }

        function editUser($uId){
          $sql = "SELECT *" . " FROM	admin_users WHERE id='".$uId."'";
          $userInfo=$this->db->query($sql)->result();
          return $userInfo;

        }
        function delUser($aid){
          $sql = "DELETE FROM admin_users WHERE id='".$aid."'";
          $this->db->query($sql);
          return true;
        }

        function editfrontuser($uId){
          $sql = "SELECT *" . " FROM	users WHERE id='".$uId."'";
          $userInfo=$this->db->query($sql)->result();
          return $userInfo;

        }

        function myAccount(){
          $aid=$this->session->userdata('aid');
          $sql = "SELECT *" . " FROM	admin_users WHERE id='".$aid."'";
          $userInfo=$this->db->query($sql)->result();
          return $userInfo;
        }

}
?>