<?php
//require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

class Users extends Controller {

	private $viewVars = array();

	function __construct()
	{
		parent::Controller();

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

		$this->viewVars['daily'] = $this->user_model->getDaily();
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
		$this->load->model('journal_model', 'journal');
		$this->viewVars['user_times']	= $this->journal->getTime();
		$this->pageVars['_assets_js']	= array('setup.js');
		$this->pageVars['_assets_css']	= array('setup.css');
		return $this->load->view('users/setup', $this->viewVars);
	}

	public function eating_journal()
	{
		$this->pageVars['_assets_js']	= array('eatingJournal.js');
		$this->viewVars['active']		= "today";
		return $this->load->view('users/eating_journal/content', $this->viewVars);
	}

	function recipe_finder()
	{
		if (@$this->rID)
		{
			$this->load->model("recipes_model","recipes");
			$this->viewVars['recipe'] = $this->recipes->get($this->rID);
		}
		##SHAHED Receipe type changes##
		$query = "SELECT	*" .
				" FROM		eoa_recipe_type" .
				" ORDER BY name";
		$this->viewVars['recipeTypes'] = $this->db->query($query)->result();
		
	        ##SHAHED Receipe type changes ##
        
		$query = "SELECT	*" .
				" FROM		recipe_healthIssues rh";
		if (@$this->rID)
		{
			$query .= " LEFT JOIN recipe_healthIssuesX rhX ON rhX.rID=".$this->rID." AND rhX.rhiID=rh.rhiID";
		}
		$query .= " ORDER BY rh.issue";
		$this->viewVars['healthIssues'] = $this->db->query($query)->result();

		$query = "SELECT	*" . " FROM		recipe_classification rc";
		if (@$this->rID)
		{
			$query .= " LEFT JOIN recipe_classificationX rcX ON rcX.rID=".$this->rID." AND rcX.rcID=rc.rcID";
		}
		$query .= " ORDER BY rc.name";
		$this->viewVars['classification'] = $this->db->query($query)->result();
		
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