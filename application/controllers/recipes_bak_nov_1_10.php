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
class recipes extends Controller
{
	private $start	= 0;
	private $ob		= 'recipes.createdOn';
	private $order	= 'DESC';
	private $init	= false;

	public function __construct()
	{
		parent::Controller();

		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array('users.js');
		$this->load->model(array('fatsecret/fsprofile_food', 'user_model', 'user_food_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation'));
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
		if (!$this->auth->isLoggedIn())
		{
			return redirect('/login');
		}
		$this->viewVars['user'] = $this->user_model->getUser(array('username_clean' => $this->session->userdata('username_clean')));

	//	$uri = explode('/',uri_string());
		$uri = explode('/',$_SERVER['QUERY_STRING']);
		for ($x=3; $x < count($uri); $x++)
		{
			$param = explode(":",$uri[$x]);
			$this->$param[0] = $param[1];
		}

		$this->session->set_userdata('start',	($this->start) ? $this->start : 0 );
		$this->session->set_userdata('ob',		($this->ob) ? $this->ob : 'recipes.createdOn' );
		$this->session->set_userdata('order',	($this->order) ? $this->order : 'DESC' );

		if ($this->init == 'yes')
		{
			$this->session->unset_userdata('S_title');
		}
	}

	public function fsapi()
	{
		$this->fsprofile_food->apiBuild($this->method,$_POST);
		if ($this->fsprofile_food->execute())//$this->session->userdata('auth_token'), $this->session->userdata('auth_secret')))//, $_POST))
		{
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
			$tmp_array['foods']			= $this->fsprofile_food->result;
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= $this->fsprofile_food->error;
		}

		$this->pageVars['isajax'] = true;
		echo json_encode($tmp_array);
	}

	public function recipeSubmit()
	{
		if ($_POST['title']
				&&
			$_POST['description']
				&&
			$_POST['cookTime']
				&&
			$_POST['portions']
				&&
			$_POST['prepTime']
				&&
			$_POST['directions'][0]
				&&
			$_POST['food_id'][0])
		{
			if ($_POST['rID']
					&&
				!$this->db->query("SELECT * FROM recipes WHERE rid!=".$_POST['rID']." AND title='".$_POST['title']."' AND createdBy=".$this->session->userdata('id'))->result())
			{
				$data['title']			= mysql_escape_string($_POST['title']);
				$data['desc']			= mysql_escape_string($_POST['description']);
				$data['cookTime']		= $_POST['cookTime'];
				$data['portions']		= $_POST['portions'];
				$data['prepTime']		= $_POST['prepTime'];
				$data['rtID']			= @$_POST['rtID'];
				$data['cuisineType']	= @$_POST['cuisineType'];
				$data['mainProtein']	= @$_POST['mainProtein'];
				$data['mainVegetable']	= @$_POST['mainVegetable'];
				$data['mainCarb']		= @$_POST['mainCarb'];
				$data['adventurous']	= @$_POST['adventurous'];
				$data['substitution']	= @$_POST['substitution'];
			//	$data['rcID']			= $_POST['rcID'];
			//	$data['rhiID']			= $_POST['rhiID'];
				$data['bodyType']		= $_POST['bodyType'];
				$data['modifiedBy']		= $this->session->userdata('id');
				$this->db->update("recipes", $data, array("rID" => $_POST['rID']));

				$this->db->delete("recipe_directions",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_mealTypes",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_servings",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_healthIssuesX",	array("rID" => $_POST['rID']));
				$this->db->delete("recipe_classificationX",	array("rID" => $_POST['rID']));
				$this->insertRecipe($_POST['rID']);

				$tmp_array['error_code']	= 0;
				$tmp_array['error_msg']		= "";
			}
			elseif (!$this->db->query("SELECT * FROM recipes WHERE title='".$_POST['title']."' AND createdBy=".$this->session->userdata('id'))->result())
			{
				$data['title']			= mysql_escape_string($_POST['title']);
				$data['desc']			= mysql_escape_string($_POST['description']);
				$data['cookTime']		= $_POST['cookTime'];
				$data['portions']		= $_POST['portions'];
				$data['prepTime']		= $_POST['prepTime'];
				$data['rtID']			= @$_POST['rtID'];
				$data['cuisineType']	= @$_POST['cuisineType'];
				$data['mainProtein']	= @$_POST['mainProtein'];
				$data['mainVegetable']	= @$_POST['mainVegetable'];
				$data['mainCarb']		= @$_POST['mainCarb'];
				$data['adventurous']	= @$_POST['adventurous'];
				$data['substitution']	= @$_POST['substitution'];
			//	$data['rcID']			= $_POST['rcID'];
			//	$data['rhiID']			= $_POST['rhiID'];
				$data['bodyType']		= $_POST['bodyType'];
				$data['createdBy']		= $this->session->userdata('id');
				$data['createdOn']		= date("Y-m-d H:i:s");
				$this->db->insert("recipes",$data);

				$this->insertRecipe($this->db->insert_id(), true);

				$tmp_array['error_code']	= 0;
				$tmp_array['error_msg']		= "";
			}
			else
			{
				$tmp_array['error_code']	= 1;
				$tmp_array['error_msg']		= "This recipe has already been submitted";
			}
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "Invalid recipe";
		}

		$this->pageVars['isajax'] = true;
		echo json_encode($tmp_array);
	}

	private function insertRecipe($rID,$createdOn=false)
	{
		$dataD['rID'] = $rID;
		$dataD['createdBy']	= $this->session->userdata('id');
		if ($createdOn == false)
		{
			$dataD['createdOn']	= date("Y-m-d H:i:s");
		}
		$dataD['sequence']	= 0;
		foreach ($_POST['directions'] AS $direction)
		{
			if ($direction)
			{
				$dataD['sequence']++;
				$dataD['direction'] = mysql_escape_string($direction);
				$this->db->insert("recipe_directions",$dataD);
			}
		}

		if (@$_POST['meal_type'])
		{
			$dataM = array();
			$dataM['rID'] = $dataD['rID'];
			$dataM['createdBy']	= $this->session->userdata('id');
			$dataM['createdOn']	= date("Y-m-d H:i:s");
			foreach (@$_POST['meal_type'] AS $meal_type => $mealType)
			{
				$dataM['mealType'] = $mealType;
				$this->db->insert("recipe_mealTypes",$dataM);
			}
		}

		$dataS['rID'] = $dataD['rID'];
		$dataS['createdBy']	= $this->session->userdata('id');
		$dataS['createdOn']	= date("Y-m-d H:i:s");
		for ($x=0; $x < count($_POST['food_id']); $x++)
		{
			$dataS['food_id']	= $_POST['food_id'][$x];
			$dataS['entryname']	= mysql_escape_string($_POST['entryname'][$x]);
			$dataS['qty']		= $_POST['qty'][$x];
			$dataS['serving']	= mysql_escape_string($_POST['serving'][$x]);
			$dataS['nutrition']	= $_POST['nutrition'][$x];
			$dataS['optional']	= @$_POST['optional'][$x];
			$this->db->insert("recipe_servings",$dataS);
		}

		if (@$_POST['rcID'])
		{
			$dataC = array();
			$dataC['rID'] = $dataD['rID'];
			for ($x=0; $x < count(@$_POST['rcID']); $x++)
			{
				$dataC['rcID']	= $_POST['rcID'][$x];
				$this->db->insert("recipe_classificationX",$dataC);
			}
		}

		if (@$_POST['rhiID'])
		{
			$dataH = array();
			$dataH['rID'] = $dataD['rID'];
			for ($x=0; $x < count(@$_POST['rhiID']); $x++)
			{
				$dataH['rhiID']	= $_POST['rhiID'][$x];
				$this->db->insert("recipe_healthIssuesX",$dataH);
			}
		}
	}

	public function listAll()
	{
		$this->load->library("Search");
		$this->search->set(	array("key" => "rID",	"op" => "=", 	"text" => false),
							array("key" => "title",	"op" => "LIKE", "text" => true));
		$this->search->where[] = "createdBy=".$this->session->userdata('id');
		$query = "SELECT		SQL_CALC_FOUND_ROWS *
					FROM		recipes 
					WHERE		".implode(' AND ',$this->search->where)."
					ORDER BY	".$this->session->userdata('ob')." ".$this->session->userdata('order')."
					LIMIT		".$this->session->userdata('start').",".PAGECNT_SMALL;
		if ($recipes = $this->db->query($query)->result())
		{
			$this->load->library('paginator');
			$cnt = $this->db->query("SELECT FOUND_ROWS() as records")->result();
			$this->paginator->setPaginator(array(	'records' =>	$cnt[0]->records,
													'pages' =>		5,
													'start' =>		$this->session->userdata('start'),
													'controller' =>	'recipes',
													'method' =>		'listAll'));
			$this->viewVars["paginator"] = $this->paginator->getPaginator();

			for ($x=0; $x < count($recipes); $x++)
			{
				$query = "SELECT * FROM recipe_directions WHERE rID=".$recipes[$x]->rID;
				$recipes[$x]->directions	= $this->db->query($query)->result();
				$query = "SELECT * FROM recipe_mealTypes WHERE rID=".$recipes[$x]->rID;
				$recipes[$x]->mealTypes		= $this->db->query($query)->result();
				$query = "SELECT * FROM recipe_servings WHERE rID=".$recipes[$x]->rID;
				$recipes[$x]->servings		= $this->db->query($query)->result();
			}
			$this->viewVars['recipes'] = $recipes;
		}
		return $this->load->view('users/recipe_finder/list', $this->viewVars);
	}

	public function delete()
	{
		if (is_numeric($this->rID) && $this->rID > 0)
		{
			$this->db->delete("recipe_directions",	array("rID" => $this->rID) );
			$this->db->delete("recipe_mealTypes",	array("rID" => $this->rID) );
			$this->db->delete("recipe_servings",	array("rID" => $this->rID) );
			$this->db->delete("recipes",			array("rID" => $this->rID) );
		}
		$this->listAll();
	}

}

?>