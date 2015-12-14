<?
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

/**
 * recipes
 *
 * default model for recipes
 *
 * @package ripe media
 * @version 1
 * @author Brian Markham
 */
class eatingout extends Controller
{
	private $start	= 0;
	private $ob		= 'recipes.createdOn';
	private $order	= 'DESC';
	private $init	= false;
	
	public $recipe_search_res;
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
		$this->load->model(array('fatsecret/fsprofile_food','fatsecret/Recipeapi','eating_out', 'user_model', 'user_food_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation'));
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
		//$this->viewVars['cups'] = $this->user_model->getWaterTracker();
		///////////////////////////////////////////////////////////////////////////
	}
	
  function index()
  {    
    $featured_product=$this->eating_out->getFeatured();
	$this->viewVars['featured']=$featured_product;	
	$this->load->view("eatingout/index", $this->viewVars);      
  }
  function iminmood()
  {
	$this->load->view("eatingout/iminmood", $this->viewVars);      
  }
  function getFood()
  {
		$keywords="se";
		$test=$this->Recipeapi->foodGet($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'),"2",$keywords);				
		foreach($test as $key=>$food)		
		{
			if(isset($food->food_id))
			{
			
				$keywords=$food->food_id;
				$result=$this->Recipeapi->foodGet($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'),"1",$keywords);				
				echo "<pre>";
					print_r($result);			
				echo "</pre>";
			}	
		}
		
		exit();
	    
  }		

}

?>
