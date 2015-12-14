<?
//require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

/**
 * recipes
 *
 * default model for recipes
 *
 * @package ripe media
 * @version 1
 * @author Brian Markham
 */
class foodsearch extends Controller
{	
	var $xml_parser;
	var $xml_input=null;

	var $elements = array();
	var $index_arr = array();
	var $ref;

  
	public function __construct()
	{
		parent::Controller();
    
		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array('users.js');
		$this->load->model(array('fatsecret/fsprofile_food','fatsecret/Recipeapi', 'user_model', 'user_food_model','recipes_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation','pagination'));
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));		
		//////////////////////////////////////////for recipe finder BGL///////////////
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
		$this->viewVars['cups'] = $this->user_model->getWaterTracker();
		///////////////////////////////////////////////////////////////////////////    
	}
	function search()
	{
		/*
		$search='';
		if(!empty($_REQUEST['search']))
		{
		  $search=$_REQUEST['search'];
		  $this->viewVars['search_box']=$_REQUEST['search'];
		}  		
		elseif(!empty($_REQUEST['ind_W1'])|| !empty($_REQUEST['ind_W2']) || !empty($_REQUEST['ind_W3']) || !empty($_REQUEST['ind_NW1']) || !empty($_REQUEST['ind_NW2']) ||!empty($_REQUEST['ind_NW3'])|| !empty($_REQUEST['extra_key'])){
		  if(!empty($_REQUEST['ind_W1']))
		  {
			$this->viewVars['ind_W1']=$_REQUEST['ind_W1'];
			$search.=$_REQUEST['ind_W1'];
		  }
		  if(!empty($_REQUEST['ind_W2']))
		  {
			$this->viewVars['ind_W2']=$_REQUEST['ind_W2'];
			$search.=" ".$_REQUEST['ind_W2'];
		  }
			
		  if(!empty($_REQUEST['ind_W3']))
		  {
			$this->viewVars['ind_W3']=$_REQUEST['ind_W3'];
			$search.=" ".$_REQUEST['ind_W2'];
		  }
		  if(!empty($_REQUEST['extra_key']))
		  {
			$this->viewVars['extra_key']=$_REQUEST['extra_key'];
			$search.=" ".$_REQUEST['extra_key'];
		  }
			
		}
		else
		{
		  $search='all';
		}    
			$url=BASE_URL . 'method=recipes.search&search_expression='.$search."&max_results=30&page_number=0";
			   
		$token=$this->session->userdata('auth_token');
		  $secret=$this->session->userdata('auth_secret');
		$recipes_results=$this->Recipeapi->recipeInfo($url,$token, $secret);
		//print_r($recipes_results);
		$total_results=$recipes_results['total_results'];
		$this->viewVars['recipes_results']=$recipes_results;		
		$this->load->view("recipefinder/recipe_finder_result", $this->viewVars);   */   
		$this->load->view("foodsearch/search", $this->viewVars);
	}
}

?>
