<?php
class Auth {
	
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}

	public function isLoggedIn()
	{
		if($this->CI->session->userdata('logged_in') == true)
		{ 
			if ($this->CI->session->userdata('id'))
			{
				$where = array('id' => $this->CI->session->userdata('id'));
				if ($user = $this->CI->user_model->getUser($where))
				{
					return $user;
				}
			}
		}
		return false;
	}

        public function isAdminLoggedIn()
	{
		if($this->CI->session->userdata('alogged_in') == true)
		{
			if ($this->CI->session->userdata('aid'))
			{
                            $where = array('id' => $this->CI->session->userdata('aid'));
                            if ($user = $this->CI->admin_user_model->getAdminUser($where))
                            {
                                return $user;
                            }
			}
		}
		return false;
	}
	
	
	public function isSetup()
	{
		$this->CI->load->model('journal_model', 'journal');
		if ($this->CI->session->userdata('id') && $this->CI->journal->getTime())
		{ 
                    return true;
		}
		return false;
	}


        public function isAdminSetup()
	{
		$this->CI->load->model('journal_model', 'journal');
		if ($this->CI->session->userdata('id') && $this->CI->journal->getTime())
		{
			return true;
		}
		return false;
	}

	public function login($data)
	{
                $user = $this->CI->user_model->getUser($data);
		if($user) {
			$this->doLogin($user);
			return $user;
		}
		return false;
	}

        public function loginAd($data)
	{
                $user = $this->CI->user_model->getFuser($data);
		if($user) {
			$this->doLogin($user);
			return $user;
		}
		return false;
	}
	
	public function adminlogin($data)
	{
		$user = $this->CI->admin_user_model->getAdminUser($data);
		if($user) {
			$this->doAdminLogin($user);
			return $user;
		}
		return false;
	}
	
	public function register($data)
	{
		return $this->CI->user_model->addUser($data);
	}

        public function logout(){
		$this->CI->session->sess_destroy();
	}

	public function adminlogout(){
		$this->CI->session->sess_destroy();
	}
	
	private function doLogin($data) {				
		$session['logged_in'] = true;
		$session['id'] = $data['id'];
		$session['username'] = $data['username'];
		$session['username_clean'] = $data['username_clean'];
		$session['email'] = $data['email'];
		$session['auth_token'] = $data['auth_token'];
		$session['auth_secret'] = $data['auth_secret'];
		$session['sex']=$data['sex'];				
		$session['timezone']=$data['timezone'];				
		$session['regdate']=$data['created'];
		$this->CI->session->set_userdata($session);
	}
	
	private function doAdminLogin($data) {				
		$session['alogged_in'] = true;
		$session['aid'] = $data['id'];
		$session['ausername'] = $data['username'];
                $session['first_name'] = $data['first_name'];
                $session['last_name'] = $data['last_name'];
                $session['aregdate']=$data['created'];
                $session['group_id']=$data['group_id'];
		$this->CI->session->set_userdata($session);
	}
}
?>