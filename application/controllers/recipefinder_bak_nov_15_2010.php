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
class recipefinder extends Controller
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
		//$this->viewVars['cups'] = $this->user_model->getWaterTracker();
		///////////////////////////////////////////////////////////////////////////

    	
	}
	function XmlParser($xml=null){
        $this->xml_input = $xml;
  } 
	function recipe_finder()
	{
	  $this->viewVars['themestyle']="sub-page-yellow";
	  $this->load->view("recipefinder/recipe_finder", $this->viewVars);
	}
	function my_recipebox()
	{										
		$recipe_id=$this->uri->segment(3);
		$user_id=$this->session->userdata('id');		
		$boxdata=array();
		
		$query = "SELECT * FROM	recipe_box where recipe_or_meal_id='".$recipe_id."' and user_id='".$user_id."' and ismealorrecipe='1'";
		$qResult= $this->db->query($query)->result();
				
		if(count($qResult)==0&&(!empty($recipe_id))&&(!empty($user_id)))
		{
			$boxdata['recipe_or_meal_id']=$recipe_id;
			$boxdata['user_id']=$user_id;
			$boxdata['add_date']=date("Y-m-d H:i:s");			
			$boxdata['ismealorrecipe']="1";			//1 for recipe
			
			$query = "insert into recipe_box 
			set recipe_or_meal_id='".$boxdata['recipe_or_meal_id']."',
			user_id='".$boxdata['user_id']."',
			add_date='".$boxdata['add_date']."',
			ismealorrecipe='".$boxdata['ismealorrecipe']."'";		    
			$isInBox = $this->db->query($query);
			return redirect('recipefinder/my_recipebox');	
		}	
	  ///////////select all entry from a recipe box for a particular user
	  $query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1'";
	  $boxRecipe= $this->db->query($query)->result();
	  
	  for($i=0;$i<count($boxRecipe);$i++)
	  {
		$recDet=$this->recipes_model->getRecipe($boxRecipe[$i]->recipe_or_meal_id);
		$boxRecipe[$i]->recd=$recDet;				
		$boxRecipe[$i]->rating=$this->recipes_model->getRating($boxRecipe[$i]->recipe_or_meal_id);
	  }
	  
	  $query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='2'";
	  $boxMeal= $this->db->query($query)->result();	  
	  
	  $this->viewVars['boxRecipe']=$boxRecipe;
	  $this->viewVars['boxMeal']=$boxMeal;
	  ////////////////
	 /////////////////meal type///////////
	  $mealtype=array(
			"1"=>"Appetizers",
			"2" =>"Soups",
			"3" =>"Main Dishes",
			"4" =>"Side Dishes",
			"5" =>"Breads &amp; Baked Products",
			"6" =>"Salads and Salad Dressings",
			"7" =>"Sauces and Condiments",
			"8"=>"Desserts",
			"9"=>"Snacks",
			"10"=>"Beverages",
			"11"=>"Other",
			"12"=>"Breakfast",
			"13"=>"Lunch");
		$this->viewVars['mealtype']=$mealtype;	
	/////////////////////////////////	
	  
	  $this->viewVars['themestyle']="sub-page-yellow";
	  $this->load->view("recipefinder/my_recipebox", $this->viewVars);
	}
	
	
	//////////////////////////////////////////////recipe delete from recipe box//
	function delFromRecipeBox($rId)
	{
		$this->pageVars['isajax'] = true;		
		$user_id=$this->session->userdata('id');
		$this->db->delete('recipe_box', array('recipe_or_meal_id' => $rId,'user_id'=>$user_id)); 		
		
	}
	
	function getrating($rbox_id)
	{
		$this->pageVars['isajax'] = true;		
		$user_id=$this->session->userdata('id');
		
		$query = "SELECT * FROM recipe_box where id='".$rbox_id."' and user_id='".$user_id."'";
		$boxRecipe= $this->db->query($query)->result();
		$this->viewVars['boxRecipe']=$boxRecipe;
		$this->load->view("recipefinder/getrating", $this->viewVars);
	}
	
	function saverating()
	{
		$this->pageVars['isajax'] = true;
		//data: "rating="+rating+"&review="+review+"&rbox_id="+rbox_id,				
		$query = "UPDATE recipe_box SET myrating = '".$_POST['rating']."',note='".$_POST['review']."' WHERE id ='".$_POST['rbox_id']."'";
		$isUpdateQuery= $this->db->query($query);
		if($isUpdateQuery)
		{
			$this->viewVars['myRecipeReview']=$_POST;
		}				
		$this->load->view("recipefinder/saverating", $this->viewVars);
	}
	
	
	///////////////////////////////////////////////////
	function recipemealtype($mid)
	{
		$this->pageVars['isajax'] = true;
		
	  ///////////select all entry from a recipe box for a particular user
	  $user_id=$this->session->userdata('id');
	  if($mid=="All")
	  $query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1'";
	  else if($mid!="All")
	  $query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1' and recipe_or_meal_id in (SELECT rID
FROM recipe_mealtypes WHERE mealType ='".$mid."')";
	  
	  $boxRecipe= $this->db->query($query)->result();
	  
	  for($i=0;$i<count($boxRecipe);$i++)
	  {
		$recDet=$this->recipes_model->getRecipe($boxRecipe[$i]->recipe_or_meal_id);
		$boxRecipe[$i]->recd=$recDet;				
	  }
	  
	  $this->viewVars['boxRecipe']=$boxRecipe;
	  ////////////////		
		$this->load->view("recipefinder/recipemealtype", $this->viewVars);
	}
	/////////////////////////////////////////////
	function recipebyingredient()
	{
		$this->viewVars['themestyle']="sub-page-yellow";
	  $this->load->view("recipefinder/recipebyingredient", $this->viewVars);	
	}
	function checkapi()
	{
		$this->viewVars['themestyle']="sub-page-yellow";		
		$test=$this->Recipeapi->recipeTypeGet($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'));		
		$this->viewVars['test']=$test;
	    $this->load->view("recipefinder/checkapi", $this->viewVars);
	}
  function index()
  {
    $this->viewVars['themestyle']="sub-page-yellow";		
		
    $query = "SELECT	* FROM	recipes " . " ORDER BY rID desc limit 0,6";
	$this->viewVars['recipes']['new_recipes'] = $this->db->query($query)->result();
		
    $query = "SELECT	* FROM	recipes where top_recipe ='1' limit 0,6";
    $this->viewVars['recipes']['top_recipes'] = $this->db->query($query)->result();
    
    $query = "SELECT	* FROM	recipes where quick_and_easy ='1' limit 0,6";
    $this->viewVars['recipes']['quick_and_easy'] = $this->db->query($query)->result();
    
    $query = "SELECT	* FROM	recipes where fat_loss ='1' limit 0,6";
    $this->viewVars['recipes']['fat_loss'] = $this->db->query($query)->result();
	/////////////////////////////////////////
	
	//////////////////////////////////////////////get from recipe box
	$user_id=$this->session->userdata('id');					
	$query = "SELECT * FROM	recipe_box where user_id='".$user_id."' and ismealorrecipe='1' order by add_date desc limit 0,3";
	$boxRecipe= $this->db->query($query)->result();
	///////////select all entry from a recipe box for a particular user	    
	for($i=0;$i<count($boxRecipe);$i++)
	{
		$recDet=$this->recipes_model->getRecipe($boxRecipe[$i]->recipe_or_meal_id);
		$boxRecipe[$i]->recd=$recDet;				
	}  
	$this->viewVars['boxRecipe']=$boxRecipe;	
    ////////////////////////////////////////////////////////////////
    
    $this->load->view("recipefinder/index", $this->viewVars);
       
  }
	function search()
	{
		$this->viewVars['themestyle']="sub-page-yellow";
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
    
    $this->load->view("recipefinder/recipe_finder_result", $this->viewVars);
      
	}
	
	/*********************************/
	function foodsearch()
	{		
		if(strlen(($_REQUEST['search']))>0)
		{
			$keyword=$_REQUEST['search'];
			
			$token=$this->session->userdata('auth_token');
			$secret=$this->session->userdata('auth_secret');
			$food_results=$this->Recipeapi->foodGet($token, $secret,"2",$keyword);
    
			$total_results=$food_results['total_results'];
			$this->viewVars['food_results']=$food_results;
						
			$this->load->view("recipefinder/foodsearch", $this->viewVars);			
		}	
		else
		{
			redirect('recipefinder/');
		}				
	}
	/************************************/	
	function recipe_info()
	{
     $this->viewVars['themestyle']="sub-page-yellow";        
		 $recipe_id=$this->uri->segment(3);
		 if(!empty($recipe_id))
		 {
			$query = "SELECT	* FROM	recipes where rID='".$recipe_id."'";
				$recipe_info = $this->db->query($query)->result();
				//echo  $recipe_info[0]->title;
				if(!empty($recipe_info[0]->rID))
			{
			  $query = "SELECT	* FROM	recipe_servings where rID='".$recipe_id."'";
				  $this->viewVars['recipe_servings'] = $this->db->query($query)->result();
				  $this->viewVars['recipe_details']['recipe_name'] = $recipe_info[0]->title;
				  $this->viewVars['recipe_details']['recipe_description'] = $recipe_info[0]->desc;
				  $this->viewVars['recipe_details']['preparation_time_min'] = $recipe_info[0]->prepTime;
				  $this->viewVars['recipe_details']['cooking_time_min'] = $recipe_info[0]->cookTime;
				  
			  #recipe types
			  $query = "SELECT	* FROM	recipe_types where rtID='".$recipe_info[0]->rtID."'";
				  $recipe_types= $this->db->query($query)->result();
				  
				  if(!empty($recipe_types[0]->type))
			  {
				$this->viewVars['recipe_details']['recipe_types'][0]['recipe_type'] = $recipe_types[0]->type;
			  }
			  
			  #recipe categories
			  $query = "SELECT	rc.* FROM	recipe_classificationX rct,recipe_classification rc,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rct.rID and rc.rcID=rct.rcID";
				  $recipe_categories= $this->db->query($query)->result();
				  foreach($recipe_categories as $ind=>$cat_val)
				$this->viewVars['recipe_details']['recipe_categories'][0]['recipe_category'][$ind]['recipe_category_name']=$cat_val->name;
			  
			  #recipe servings
			  $query = "SELECT	rs.* FROM	recipe_servings rs,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rs.rID";
				  $recipe_servings= $this->db->query($query)->result();
				  //print_r($recipe_servings);
				  foreach($recipe_servings as $ind=>$sval)
				$this->viewVars['recipe_details']['serving_sizes'][0]['serving'][0][$ind]['value']=$sval->entryname;
				
			  #recipe_directions
			  $query = "SELECT	rd.* FROM	recipe_directions rd,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rd.rID order by rd.sequence";
			  $recipe_servings= $this->db->query($query)->result();
			  //print_r($recipe_servings);
			  foreach($recipe_servings as $ind=>$sval)
			  {
				$this->viewVars['recipe_details']['directions'][0]['direction'][$ind]['direction_number']=$sval->sequence;
				$this->viewVars['recipe_details']['directions'][0]['direction'][$ind]['direction_description']=$sval->direction;
			  }
			  
			  #recipe_ratings
			  $query = "SELECT recipe_rating.*,recipe_rating.id as rrid, users.* FROM recipe_rating inner join users on recipe_rating.user_id=users.id where recipe_rating.recipe_id='".$recipe_id."' order by recipe_rating.id asc";
			  $recipe_rating= $this->db->query($query)->result();
			  $this->viewVars['reviews']=$recipe_rating;		  
			  $this->viewVars['recipe_id']=$recipe_id;
					  
			}
			else
			{
			  $this->viewVars['recipe_details']='';
			  $this->viewVars['recipe_servings']='';
			}
			
				//print_r($this->viewVars['recipe']);  
				
		 }
		 else
		 {
		   $this->viewVars['recipe_details']='';
		   $this->viewVars['recipe_servings']='';
		 }
		 //print_r($this->viewVars['recipe_details']);
		 $this->load->view("recipefinder/recipe_details", $this->viewVars); 
    }
	function addreview()
	{
		
		$ratereview=array();
		
		$rating=$_POST['rating'];
		$review=$_POST['review'];
		$recipe_id=$_POST['recipe_id'];
		$created =date("Y-m-d H:i:s");		
		$user_id=$this->session->userdata('id');		
		
		$query = "insert into recipe_rating set
		recipe_id='".$recipe_id."',
		ratings='".$rating."',
		reviews='".$review."', 	
		user_id='".$user_id."',
		created='".$created."'";
		//$query="";
		$recipe_rating=$this->db->query($query);
		if($recipe_rating)
		{
			$review_id=$this->db->insert_id();  
			$ratereview['review_id']=$review_id;
			$ratereview['rating']=$rating;
			$ratereview['review']=$review;
			$ratereview['created']=$created;
			$ratereview['recipe_id']=$recipe_id;
			$ratereview['updateid']=$_POST['updateid'];		
			$ratereview['username']=$this->session->userdata('username');			
			$this->viewVars['review']=$ratereview;
		}	
		$this->pageVars['isajax'] = true;				
		$this->load->view("recipefinder/addreview", $this->viewVars); 
	}  
	function recipe_details()
	{
		$recipe_id=$this->uri->segment(3);
		
    if(!empty($recipe_id))
    {
        $this->viewVars['themestyle']="sub-page-yellow";		
    		$url=BASE_URL . 'method=recipe.get&recipe_id='.$this->uri->segment(3);
    	  $token=$this->session->userdata('auth_token');
	      $secret=$this->session->userdata('auth_secret');
        $recipe_details=$this->Recipeapi->recipeInfo($url,$token, $secret);
        
        $this->viewVars['recipe_details']=$recipe_details;
        $this->load->view("recipefinder/recipe_details", $this->viewVars);
   
    }
    		    
	}
	function xml2array($xml) 
  {
      $arXML=array();
      $arXML['name']=trim($xml->getName());
      $arXML['value']=trim((string)$xml);
      $t=array();
      foreach($xml->attributes() as $name => $value) $t[$name]=trim($value);
      $arXML['attr']=$t;
      $t=array();
      foreach($xml->children() as $name => $xmlchild) $t[$name]=$this->xml2array($xmlchild);
      $arXML['children']=$t;
      return($arXML);
  }
	  /**
    * @desc Constructor
    * @param string
    */
    
    /**
    * @desc Parsing function
    * @param string
    */
    function parse($xml=null){
    
    
        if($this->xml_input==null){
            return false;
        }
       
        $this->xml_parser = xml_parser_create();
        xml_set_object($this->xml_parser, $this);
        xml_set_element_handler($this->xml_parser,"startElement","endElement");
        xml_set_character_data_handler($this->xml_parser,"characterData");
        if(!xml_parse($this->xml_parser, $this->xml_input)){
            return false;
        }
        xml_parser_free($this->xml_parser);
        return $this->elements;
    }

    function startElement($parser,$tagName,$attrs){
        $this->ref=&$this->elements;
        foreach($this->index_arr as $index){
            $this->ref = &$this->ref[$index];
        }
        $this->ref[] = array('tag'=>$tagName,'attr'=>$attrs,'data'=>'','children'=>array());
        $i = end(array_keys($this->ref));
        array_push($this->index_arr,$i);
        array_push($this->index_arr,'children');
    }

    function characterData($parser, $data){
        $index_arr = $this->index_arr;
        array_pop($index_arr);
        $ref=&$this->elements;
        foreach($index_arr as $index){
            $ref = &$ref[$index];
        }
        $ref['data']=$data;
    }

    function endElement($parser,$tagName){
        array_pop($this->index_arr);
        array_pop($this->index_arr);
    } 
}

?>
