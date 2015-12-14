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
		//print_r($_POST);
		//die();
		if ($_POST['title']&&$_POST['description']&&$_POST['portions']&&$_POST['directions'][0]&&$_POST['food_id'][0])
		{
			if ($_POST['rID']&&!$this->db->query("SELECT * FROM recipes WHERE rid!=".$_POST['rID']." AND title='".$_POST['title']."' AND createdBy=".$this->session->userdata('id'))->result())
			{
				
				$data['title']			= mysql_escape_string($_POST['title']);
				$data['desc']			= mysql_escape_string($_POST['description']);
				$data['cookTime']		= $_POST['cookTime'];
				$data['portions']		= $_POST['portions'];
				//$data['prepTime']		= $_POST['prepTime'];
				$data['prepTime']=$_POST['prepTimeHours']*60+$_POST['prepTimeMins'];
				
				if(!empty($_POST['rtID']))
				$data['rtID']=$_POST['rtID'];
				if(!empty($_POST['cuisineType']))
				$data['cuisineType']=$_POST['cuisineType'];
				if(!empty($_POST['mainProtein']))
				$data['mainProtein']=$_POST['mainProtein'];
				if(!empty($_POST['mainVegetable']))
				$data['mainVegetable']=$_POST['mainVegetable'];
				if(!empty($_POST['mainCarb']))
				$data['mainCarb']=$_POST['mainCarb'];
				if(!empty($_POST['adventurous']))
				$data['adventurous']=1;
				if(!empty($_POST['substitution']))
				$data['substitution']=$_POST['substitution'];
				//$data['rcID']			= $_POST['rcID'];
				//$data['rhiID']			= $_POST['rhiID'];
				//$data['bodyType']		= $_POST['bodyType'];
				
				
				$data['modifiedBy']		= $this->session->userdata('id');
				$this->db->update("recipes", $data, array("rID" => $_POST['rID']));

				$this->db->delete("recipe_directions",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_mealTypes",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_servings",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_healthIssuesX",	array("rID" => $_POST['rID']));
				//$this->db->delete("recipe_classificationX",	array("rID" => $_POST['rID']));
				$this->db->delete("recipe_classification_selections",	array("rID" => $_POST['rID']));
				//$this->insertRecipeImage($_POST['rID']);
				$this->insertRecipe($_POST['rID']);
								
				$tmp_array['error_code']	= 0;
				$tmp_array['error_msg']		= "";
			}
			elseif (!$this->db->query("SELECT * FROM recipes WHERE title='".$_POST['title']."' AND createdBy=".$this->session->userdata('id'))->result())
			{
				
				$data['title']		= mysql_escape_string($_POST['title']);
				$data['desc']		= mysql_escape_string($_POST['description']);
				$data['cookTime']	= $_POST['cookTime'];
				$data['portions']	= $_POST['portions'];
				//$data['prepTime']	= $_POST['prepTime'];
				$data['prepActiveTime']=$_POST['prepActiveTime'];
				$data['prepInactiveTime']=$_POST['prepInactiveTime'];
				
				if(!empty($_POST['cuisineType']))
				$data['cuisineType']=$_POST['cuisineType'];
				if(!empty($_POST['mainProtein']))
				$data['mainProtein']=$_POST['mainProtein'];
				if(!empty($_POST['mainVegetable']))
				$data['mainVegetable']=$_POST['mainVegetable'];
				if(!empty($_POST['mainCarb']))
				$data['mainCarb']=$_POST['mainCarb'];
				if(!empty($_POST['adventurous']))
				$data['adventurous']=$_POST['adventurous'];
				if(!empty($_POST['substitution']))
				$data['substitution']=$_POST['substitution'];
				
				//$data['bodyType']	= $_POST['bodyType'];
				$data['createdBy']	= $this->session->userdata('id');
				$data['createdOn']	= date("Y-m-d H:i:s");
				
				
				$this->db->insert("recipes",$data);
				$rId=$this->db->insert_id();
				$this->insertRecipe($rId, true);
				if($_FILES['recipe_image']['name'])
				$this->insertRecipeImage($rId);
															
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
		redirect('recipes/listAll', 'location');

		//$this->pageVars['isajax'] = true;
		//echo json_encode($_POST);
	}
	
	private function insertRecipeImage($rID)
	{
		 //print_r($_FILES);
		 $rand_file_name=mt_rand(105, 200009)."_".str_replace(" ", "_", $_FILES['recipe_image']['name']);
		 $file_location=RECIPE_IMAGE_FOLDER.$rand_file_name;
		 if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $file_location))
		 {
			$dataD='';
			chmod($file_location,0777);
			$dataD['rID'] = $rID;
			$dataD['image_name']=$_FILES['recipe_image']['name'];
			$dataD['image_size']=$_FILES['recipe_image']['size'];
			$dataD['image_type']=$_FILES['recipe_image']['type'];
					
			$this->db->insert("recipe_images",$dataD);
			
		 }	
	}
	
	private function insertRecipeNutrition($rsID,$nu_data)
	{
		if(!empty($nu_data))
		{
			foreach($nu_data as $indx=>$val)
			{
				$dataN['rsID'] = $rsID;
				$indx=str_replace("_"," ",$indx);
				$dataN['nutrition_name']=$indx;
				
				if(!empty($val))
				$dataN['nutrition_amount']=$val;
				else
				$dataN['nutrition_amount']=0;
				$this->db->insert("recipe_nutritions",$dataN);	
				
			}
		
			
		}
				
		 	
	}
	
	
	private function insertRecipe($rID,$createdOn=false)
	{
		$dataD['rID'] = $rID;
		$dataD['createdBy']	= $this->session->userdata('id');
		if ($createdOn == false)
		{
			$dataD['createdOn']	= date("Y-m-d H:i:s");
		}
		$dataD['sequence']= 0;
		foreach ($_POST['directions'] AS $direction)
		{
			if ($direction)
			{
				$dataD['sequence']++;
				$dataD['direction'] = mysql_escape_string($direction);
				$this->db->insert("recipe_directions",$dataD);
			}
		}
		##Receipe type changes 
		if (!empty($_POST['rtID']))
		{
			$dataM = array();
			$dataM['rID'] = $dataD['rID'];
			$dataM['recipeTypeId']=$_POST['rtID'];
			$dataM['createdBy']	= $this->session->userdata('id');
			$dataM['createdOn']	= date("Y-m-d H:i:s");
			$this->db->insert("recipe_type_selections",$dataM);
		}
		
		if (@$_POST['recipe_mealType_selections'])
		{
			$dataM = array();
			$dataM['rID'] = $dataD['rID'];
			$dataM['createdBy']	= $this->session->userdata('id');
			$dataM['createdOn']	= date("Y-m-d H:i:s");
			foreach (@$_POST['recipe_mealType_selections'] AS $meal_type_id)
			{
				$dataM['MealTypeId'] = $meal_type_id;
				$this->db->insert("recipe_mealType_selections",$dataM);
			}
		}
				
		##SHAHED Receipe type changes #
		
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
			
			#insert nutrition items
			$this->insertRecipeNutrition($this->db->insert_id(), $_POST['nutrition_vals'][$_POST['food_id'][$x]]);
		}

		if (@$_POST['rcID'])
		{
			$dataC = array();
			$dataC['rID'] = $dataD['rID'];
			for ($x=0; $x < count(@$_POST['rcID']); $x++)
			{
				$dataC['rcID']	= $_POST['rcID'][$x];
				//$this->db->insert("recipe_classificationX",$dataC);
				$this->db->insert("recipe_classification_selections",$dataC);
				
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
				#SHAHED remove meal type
				//$query = "SELECT * FROM recipe_mealTypes WHERE rID=".$recipes[$x]->rID;
				//$recipes[$x]->mealTypes		= $this->db->query($query)->result();
				#SHAHED remove meal type
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
