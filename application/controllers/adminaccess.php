<?php
class Adminaccess extends Controller
{
	
	function __construct()
	{
		parent::Controller();
        $this->pageVars['isadmin'] = true;
		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array();
                
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
		$this->load->library(array('Auth', 'form_validation'));
		$this->load->model(array('fatsecret/fsprofile', 'admin_user_model'));
	}
	
	function adminlogin()
	{
		$viewVars = array();
		
		//print_r($_POST);
		//die();
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|sha1');
				
		
		if ($this->form_validation->run() !== FALSE)
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$data = array('username' => $username, 'password' => $password);
			$user = $this->auth->adminlogin($data);

                        //print_r($user);
                        //die();
			if(!$user)
			{
				$viewVars['error'] = "Incorrect username or password";
			}
			else
			{														
                            //$isupdate=$this->admin_user_model->setLastLogin($user);
                            redirect('/admin');
				
			}
		}		
		return $this->load->view('admin/adminlogin', $viewVars);
	}
	function adminlogout()
	{								
		$this->auth->adminlogout();
		redirect('/adminlogin');
	}	
}
?>