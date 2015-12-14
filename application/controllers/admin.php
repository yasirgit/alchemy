<?php
class Admin extends Controller {

	private $viewVars = array();
        
	function __construct()
	{
		parent::Controller();
		//$this->pageVars['isadmin'] = true;
		//$this->pageVars['css'] = array();
		//$this->pageVars['js'] = array();//('users.js');
		$this->load->model(array('user_model', 'user_food_model','admin_user_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation', 'pagination', 'session'));
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
	}
        
        function index()
	{
          $aid=$this->session->userdata('aid');
          if($aid != ''){
              $this->load->view("admin/index",true);
          }
          else{
              redirect('adminaccess/adminlogin');
          }
	  
	}

        function adduser(){

                if(!empty($_POST['username'])){
                    $viewVars = array();
                    $sql = "SELECT	*" .
				" FROM	admin_users" .
				" WHERE	username='".$_POST['username']."'";                   
                   
                    if($this->db->query($sql)->result())
                    {
                        $viewVars['error']="User is already registered";
                        return $this->load->view('admin/adduser', $viewVars);
                    }

                    $this->form_validation->set_rules('email',	    'Email',	'trim|required|valid_email|xss_clean');
                    $this->form_validation->set_rules('username',	'Username',	'trim|required|min_length[2]|xss_clean');
                    $this->form_validation->set_rules('password',	'Password',	'trim|required|min_length[5]|sha1');
                    $this->form_validation->set_rules('first_name',	'First Name',	'trim|required');
                    $this->form_validation->set_rules('last_name',	'Last Name',	'trim|required');

                    if($this->form_validation->run() !== FALSE)
                    {
                            $data = array(  'username'          => $this->input->post('username'),
                                            'password'		=> $this->input->post('password'),
                                            'email'		=> $this->input->post('email'),
                                            'first_name'	=> $this->input->post('first_name'),
                                            'last_name'		=> $this->input->post('last_name'),
                                            'group_id'		=> $this->input->post('group_id'),
                                            'active'		=> $this->input->post('active'));


                            if(empty($user['error']))
                            {
                                    $viewVars['error'] = "Thank you for registering. Please log in";
                                    $this->db->insert("admin_users", $data);
                                    //return $this->load->view('admin/adduser', $viewVars);
                                    redirect('admin/viewuser');
                            }
                            else
                            {
                                    $viewVars['error'] = $user['error'];
                            }
                    }
                }
                
		$this->load->view("admin/adduser",true);
        }

        function viewuser(){            
            $data=array();
            $data['user']=$this->admin_user_model->viewUser();
            $this->load->view("admin/viewuser",$data);
        }

        function listUser(){

            $config['base_url'] = "http://".$_SERVER['SERVER_NAME']."/alchemy/admin/listUser";
            $config['total_rows'] = $this->db->get('users')->num_rows();
            $config['per_page'] = 10;
            $config['num_links'] = 20;
            $config['full_tag_open'] = '<div id="pagination">';
            $config['full_tag_close'] = '</div>';

            $this->pagination->initialize($config);

            $data['users'] = $this->db->get('users', $config['per_page'], $this->uri->segment(3));

            $this->load->view('admin/listUser', $data);
        }
        
        function edituser($uId){

           //echo $this->session->userdata('uid'); exit;
           
           if(!empty($_POST['uId'])){
                $error=array();

                if(strlen($this->session->userdata('error')) > 0)
		{
			$error['update_complete'] = $this->session->userdata('error');			
			$this->session->unset_userdata('error');			
		}


                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
				$this->form_validation->set_rules('first_name',	'First Name',	'trim|required');
				$this->form_validation->set_rules('last_name',	'Last Name',	'trim|required');
                $this->form_validation->set_rules('username',	'User Name',	'trim|required');

                /*
                if(isset($_POST['password'])&&strlen($_POST['password'])>0)
		{
			$this->form_validation->set_rules('password',	'Password',		'trim|required|matches[cpassword]|min_length[5]|sha1');
		}
                */
                
                if($this->form_validation->run() !== FALSE)
		{
                    $sql="update admin_users set
                            group_id='".mysql_escape_string(trim($_POST['group_id']))."',
                            username='".mysql_escape_string(trim($_POST['username']))."',
                            first_name='".mysql_escape_string(trim($_POST['first_name']))."',
                            last_name='".mysql_escape_string(trim($_POST['last_name']))."',
                            active='".mysql_escape_string(trim($_POST['active']))."',                            
                            email='".mysql_escape_string(trim($_POST['email']))."' where id='".$_POST['uId']."'";
                    $this->db->query($sql);
                }
           }
           $data=array();
           $data['user']=$this->admin_user_model->editUser($uId);
           //$this->viewVars['uerror'] = $error;
           $this->load->view("admin/edituser",$data);
        }

        function editfrontuser($uId){

           //echo $this->session->userdata('uid'); exit;

           if(!empty($_POST['uId'])){
                $error=array();

                if(strlen($this->session->userdata('error')) > 0)
		{
			$error['update_complete'] = $this->session->userdata('error');
			$this->session->unset_userdata('error');
		}


                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
				$this->form_validation->set_rules('first_name',	'First Name',	'trim|required');
				$this->form_validation->set_rules('last_name',	'Last Name',	'trim|required');

                /*
                if(isset($_POST['password'])&&strlen($_POST['password'])>0)
		{
			$this->form_validation->set_rules('password',	'Password',		'trim|required|matches[cpassword]|min_length[5]|sha1');
		}
                */

                if($this->form_validation->run() !== FALSE)
		{
                    $sql="update admin_users set
                            group_id='".mysql_escape_string(trim($_POST['group_id']))."',
                            username='".mysql_escape_string(trim($_POST['username']))."',
                            first_name='".mysql_escape_string(trim($_POST['first_name']))."',
                            last_name='".mysql_escape_string(trim($_POST['last_name']))."',
                            active='".mysql_escape_string(trim($_POST['active']))."',
                            email='".mysql_escape_string(trim($_POST['email']))."' where id='".$_POST['uId']."'";
                    $this->db->query($sql);
                }
           }
           
           $data=array();
           $data['user']=$this->admin_user_model->editfrontuser($uId);
           //$this->viewVars['uerror']=$error;
           $this->load->view("admin/editfrontuser",$data);
        }

        function change_password(){
                $aid=$this->session->userdata('aid');
                /// $data=array();
		if(isset($aid)){
                      $sql="select password from admin_users where id=$aid";
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

		$this->form_validation->set_rules('oldPass','Old Password','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if(isset($_POST['password'])&& strlen($_POST['password'])>0)
		{
  		  $this->form_validation->set_rules('password','Password','trim|required|matches[conpassword]|min_length[5]|sha1');
		}
                
                //echo sha1($oldPass);
		if($this->form_validation->run() !== FALSE)
		{
		   if((sha1($_POST['oldPass']))== $oldPass)
		   {
                                                      
                            $sql="update admin_users set password='".$_POST['password']."' where id=$aid";
                            $this->db->query($sql);
                            if(empty($error))
			    {
                                $this->session->set_userdata('error', 'Password Changed successfully.');
                                redirect('/admin/change_password');
			    }
			}
			else {
			   //echo "False";
			   $this->viewVars['error_custom']='Not matched old password';
			  //redirect('/users/change_password');
                        }

                }
                $this->load->view("admin/change_password", $this->viewVars);
        }
        
        function delUser($aid) {
            $this->admin_user_model->delUser($aid);
            redirect('admin/viewuser');
            //$this->load->view("admin/viewuser",true);
        }
        function myaccount(){
            $data['user']=$this->admin_user_model->myAccount();
            $this->load->view("admin/myaccount",$data);
        }

        function recipe() {

            $config['base_url'] = "http://".$_SERVER['SERVER_NAME']."/alchemy/admin/recipe";
            $config['total_rows'] = $this->db->get('recipes')->num_rows();
            $config['per_page'] = 10;
            $config['num_links'] = 20;
            $config['full_tag_open'] = '<div id="pagination">';
            $config['full_tag_close'] = '</div>';
            $this->pagination->initialize($config);

            //$sql = "SELECT *" . " FROM	recipes";
            //$recipe['recipe']=$this->db->query($sql)->result();
            $data['recipe'] = $this->db->get('recipes', $config['per_page'], $this->uri->segment(3));
            $this->load->view("admin/recipe",$data);





                //$data['users'] = $this->db->get('users', $config['per_page'], $this->uri->segment(3));

                //$this->load->view('admin/listUser', $data);


        }

        function recipeDetails($rID){
            $data=array();
            $sql = "SELECT *" . " FROM	recipes WHERE rID='".$rID."'";
            $recipe['recipe']=$this->db->query($sql)->result();
            $data['recipe']=$recipe['recipe'];


            // Recipe type of this recepe
            $sql = "SELECT recipeTypeId FROM recipe_type_selections WHERE rID='".$rID."'";
            $recipeTypeSelection=$this->db->query($sql)->result();
            $data['recipeTypeSelection']=$recipeTypeSelection;

            // Get Recipe type
            $sql = "SELECT *" . " FROM	recipe_types";
            $data['recipe_types']=$this->db->query($sql)->result();

            if(!empty($_POST['rtID'])){

               $sql = "SELECT recipeTypeId FROM recipe_type_selections WHERE rID='".$rID."'";
               $recipeType=$this->db->query($sql)->result();

               if($recipeType){
                   $sql="update recipe_type_selections set  recipeTypeId='".mysql_escape_string(trim($_POST['rtID']))."' where rID='".$_POST['rID']."'";
                   $this->db->query($sql);
                   return redirect('admin/recipe');
                }

            }

            $this->load->view("admin/recipeDetails",$data);
        }
}
?>
