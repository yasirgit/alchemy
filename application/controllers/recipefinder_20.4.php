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
		$this->load->model(array('fatsecret/fsprofile_food','fatsecret/Recipeapi', 'user_model', 'user_food_model','recipes_model','journal_model'));	// includes fsprofile
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
			//$param = explode(":",$uri[$x]);
			//$this->{$param[0]} = @$param[1];
		}
		if (!$this->session->userdata('date'))
		{
			$this->session->set_userdata(array("date" => date("Y-m-d")));
		}
		
		$query = "SELECT * FROM recipe_mealtypes order by id";
		$recipe_types= $this->db->query($query)->result();
	        $this->viewVars['recipe_types']=$recipe_types;
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
		if($this->uri->segment(3) == 'list')
		{
			$recipe_id=0;
		} else {
			$recipe_id=$this->uri->segment(3);
		}
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
		
		$config['base_url']= base_url().'recipefinder/my_recipebox/list/';
		$config['total_rows']=$this->recipes_model->get_numRecipies($user_id);
		$this->viewVars['totRecipe']=$config['total_rows'];
		$config['per_page']='2';
		
		$number_pages = ceil($config['total_rows'] / $config['per_page']);  // get total num of pages ... SHAIFUL
		$lastid = (($number_pages * $config['per_page']) - $config['per_page']);
		$lasturl= base_url().'recipefinder/my_recipebox/list/'.$lastid;
		
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		//$config['full_tag_open'] = '<div class="paging-holder">';
		//$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<ul><li><span>';
		$config['cur_tag_close'] = '</span></li> <li><strong>of</strong></li> <li><a href="'.$lasturl.'">'.$number_pages.'</a></li></ul>';
		$config['num_tag_open'] = '<span class="digitnone">';
		$config['num_tag_close'] = '</span>'; 
		
		$config['uri_segment'] = '4';
		$this->pagination->initialize($config);
		//echo $this->pagination->last_link;
		
		$boxRecipe = $this->recipes_model->get_boxRecipies($config['per_page'],$this->uri->segment(4),$user_id);
	  ///////////select all entry from a recipe box for a particular user
	  /*$query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1'";
	  $boxRecipe= $this->db->query($query)->result();*/
	  
	  for($i=0;$i<count($boxRecipe);$i++)
	  {
		$recDet=$this->recipes_model->getRecipe($boxRecipe[$i]->recipe_or_meal_id);
		$boxRecipe[$i]->recd=$recDet;				
		$boxRecipe[$i]->rating=$this->recipes_model->getRating($boxRecipe[$i]->recipe_or_meal_id);
		#recipe servings by SHAIFUL
		$query = "SELECT rs.* FROM recipe_servings rs,recipes r where r.rID='".$boxRecipe[$i]->recipe_or_meal_id."' and r.rID=rs.rID";
		$recipe_servings= $this->db->query($query)->result();
		
		$fatloss=array();			
		$total_carb=0;
		$total_protein=0;
		$total_fat=0;	
		$total_calories=0;	
		$dietary_fiber=0;	
		$sugar=0;	
		$boxRecipe[$i]->direction = array();
		
		if(count($recipe_servings)>0)
		{
			foreach($recipe_servings as $ing)
			{	
				$temp=$this->journal_model->getFoodInformation($ing->food_id);	
				
				for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
				{
					$tempservice=$temp['servings'][0]['serving'][$k];
					if($tempservice['measurement_description']==$ing->serving)
					{
						$fatloss = $tempservice;
						foreach($fatloss as $key => $value){
							if($key=='carbohydrate'){
								$total_carb+=$value;
							}
							if($key=='protein'){
								$total_protein+=$value;
							}
							if($key=='fat'){
								$total_fat+=$value;
							}
							if($key=='calories'){
								$total_calories+=$value;
							}
							if($key=='fiber'){
								$dietary_fiber+=$value;
							}
							if($key=='sugar'){
								$sugar+=$value;
							}
						}
					}
				}
				
				/*echo "<pre>";
				print_r($temp);
				echo "<pre>";*/
			}
			
			$getPerc = array('total_calories'=>$total_calories,'total_fat'=>$total_fat,'total_carb'=>$total_carb,'dietary_fiber'=>$dietary_fiber,'sugar'=>$sugar,'total_protein'=>$total_protein);
			$returnPerc=$this->journal_model->getfoodinfo($getPerc);
			/*echo "<pre>";
			print_r($returnPerc);
			echo "</pre>";
			exit;*/
			$boxRecipe[$i]->direction = $returnPerc['directions'];
		}
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
	  $query = "SELECT * FROM recipe_directory_considerations ORDER BY name";
	  $this->viewVars['directory_restrictions'] = $this->db->query($query)->result();
	  
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
		
		//select all entry from a recipe box for a particular user
		$user_id=$this->session->userdata('id');
		if($mid=="All")
		$query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1'";
		else if($mid!="All")
		$query = "SELECT * FROM recipe_box where user_id='".$user_id."' and ismealorrecipe='1' and recipe_or_meal_id in (SELECT rID FROM recipe_mealtypes WHERE mealType ='".$mid."')";
		
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
			    
		$query = "SELECT * FROM	recipes " . " ORDER BY rID desc limit 0,6";
		$newRecps = $this->db->query($query)->result();
		for($p=0; $p < count($newRecps); $p++)
		{
			$sql = "SELECT * FROM recipe_images WHERE rID=".$newRecps[$p]->rID;
			$newRecps[$p]->imgages = $this->db->query($sql)->row();
		}
		$this->viewVars['recipes']['new_recipes'] = $newRecps;
		
		$query = "SELECT * FROM	recipes where top_recipe ='1' ORDER BY rID DESC limit 0,6";
		$topRcps = $this->db->query($query)->result();
		for($q=0; $q < count($topRcps); $q++)
		{
			$sql = "SELECT * FROM recipe_images WHERE rID=".$topRcps[$q]->rID;
			$topRcps[$q]->imgages = $this->db->query($sql)->row();
		}
		$this->viewVars['recipes']['top_recipes'] = $topRcps;
		
		$query = "SELECT * FROM	recipes where quick_and_easy ='1' ORDER BY rID DESC limit 0,6";
		$quickRcps = $this->db->query($query)->result();
		for($r=0; $r < count($quickRcps); $r++)
		{
			$sql = "SELECT * FROM recipe_images WHERE rID=".$quickRcps[$r]->rID;
			$quickRcps[$r]->imgages = $this->db->query($sql)->row();
		}
		$this->viewVars['recipes']['quick_and_easy'] = $quickRcps;
		
		$query = "SELECT * FROM	recipes where fat_loss ='1' ORDER BY rID DESC limit 0,5";
		//$this->viewVars['recipes']['fat_loss'] = $this->db->query($query)->result();
		$feat_recipies = $this->db->query($query)->result();
		
		for ($x=0; $x < count($feat_recipies); $x++)
		{
			$ratsql = "SELECT SUM(ratings) as totRat, COUNT(user_id) as totusers FROM recipe_rating WHERE recipe_id=".$feat_recipies[$x]->rID;
			$feat_recipies[$x]->ratings = $this->db->query($ratsql)->result();
			$sql = "SELECT * FROM recipe_images WHERE rID=".$feat_recipies[$x]->rID;
			$feat_recipies[$x]->imgages = $this->db->query($sql)->row();
		}
		$this->viewVars['recipes']['fat_loss'] = $feat_recipies;
		
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
		$this->load->view("recipefinder/index", $this->viewVars);
       
	}
	function search()
	{
		
		$this->viewVars['themestyle']="sub-page-yellow";
		$search='';
		//directory restrictions/considerrations
		$current_page=$this->uri->segment(3);
		$page_entry=10;
		
		if(empty($current_page))
		{
				$next_page_entry=0;
				$ses_recipes_results=$this->session->userdata('ses_recipes_results');
				//$this->viewVars['recipes_results']=array_slice($ses_recipes_results,5);
				//$st=session_id();
				//if ($st=='') session_start();
				//$_REQUEST=$_SESSION['request_data'];
							
		}
		else{
				$next_page_entry=$current_page*$page_entry-$page_entry;
						 
				$st=session_id();
				if ($st=='') session_start();
				$_REQUEST=$_SESSION['request_data'];		
								
		}
				
		$query = "SELECT * FROM	recipe_directory_considerations ORDER BY name";
		$this->viewVars['directory_restrictions'] = $this->db->query($query)->result();
		
		
		if(isset($_REQUEST['tracker']))
		{
				if($_REQUEST['tracker']==0)		
				{
									
						if(!empty($_REQUEST['search']) && empty($_REQUEST['extended']))
						{
						  $this->viewVars['search_box']=$_REQUEST['search'];
						  $search=$_REQUEST['search'];
						  $keyword_string=explode(" ",$_REQUEST['search']);
						  if(count($keyword_string)<1)
							  $keyword_string=" rp.title like '%".$_REQUEST['search']."%'";
						  else
							  $keyword_string="(rp.title like '%" . implode("%' or rp.title like '%",$keyword_string) . "%')";
												  
						  
						  //total results
						  $query = "SELECT rp.*, rimg.thumb_img_name as recipe_image, rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where " . $keyword_string . " group by rID";
						  $this->viewVars['recipes_total_results'] = $this->db->query($query)->result();
						  $this->viewVars['total_results'] = count($this->viewVars['recipes_total_results']);

						  $query = "SELECT rp.*,rimg.thumb_img_name as recipe_image, SUM(rt.ratings) as totRat, COUNT(rt.user_id) as totusers, rtype.recipeTypeId as recipe_type, usr.username as uname FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID LEFT JOIN users usr ON usr.id=rp.createdBy where " . $keyword_string . " group by rID limit $next_page_entry,$page_entry";//echo $query;
						  $this->viewVars['recipes_results']= $this->db->query($query)->result();
						  
						  // force sesssion
						  //$this->viewVars['recipes_results']= $this->db->query($query)->result();						  
						  $this->viewVars['search']=$_REQUEST['search'];
						  
						  
						}  		
						elseif(empty($_REQUEST['search']) && (!empty($_REQUEST['extended'])))
						{
						  
						  $opt_count=count($_REQUEST['extended']);
						
						  
						  if($opt_count>1)
						  {
							$cn=0;			
							//if more than one extended option is selected with no keyword search
							$ids='';
							foreach($_REQUEST['extended'] as $ind=>$val)
							{
								$cnv=$cn+1;
								if($cnv<$opt_count)
								{
									
									/*$gen_tables.= "`recipe_mealType_selections` rm$cnv,";
									$condition.="rm$cnv.MealTypeId='".$val."' and ";
									$cnv2=$cnv+1;
									if($cnv2<$opt_count+3 ){
										if($cnv2<$opt_count)
											$cond2.="rm$cnv.rID=rm$cnv2.rID and ";
										else
											$cond2.="rm$cnv.rID=rm$cnv2.rID";
									}
									*/
									$ids.="'".$val."',";
									
								}
								else{
									/*$condition.="rm$cnv.MealTypeId='".$val."'";
									$gen_tables.= "`recipe_mealType_selections` rm$cnv";
									$cnv2=$cnv+1;
									if($cnv2<$opt_count)
									$cond2.="rm$cnv.rID=rm$cnv2.rID";
									*/
									$ids.="'".$val."'";
									
								}
								
								$cn++;
								
								
							}
							
							$search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId in(".$ids.") group by rp2.rID)";
							$query = "SELECT rp.*,rimg.image_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipe_mealtype_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where ".$search_string." group by rp.rID ";
						    $this->viewVars['recipes_total_results']= $this->db->query($query)->result();
							$this->viewVars['total_results']=count($this->viewVars['recipes_total_results']);
							
							$search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId in(".$ids.") group by rp2.rID)";
							$query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,SUM(rt.ratings) as totRat, COUNT(rt.user_id) as totusers,rtype.recipeTypeId as recipe_type, usr.username as uname FROM recipe_mealtype_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID LEFT JOIN users usr ON usr.id=rp.createdBy where " . $search_string . " group by rp.rID limit $next_page_entry,$page_entry";
							//echo $query;
							$this->viewVars['recipes_results']= $this->db->query($query)->result();
							$this->viewVars['extended']=$_REQUEST['extended'];
							
						  }
						  else
						  {     //if one extended option is selected with no keyword search
							foreach($_REQUEST['extended'] as $ind=>$val)
							{
								$search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId=".$val." group by rp2.rID)";
							}
							$query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipe_mealtype_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where " . $search_string . " group by rp.rID ";

							$this->viewVars['recipes_total_results'] = $this->db->query($query)->result();
							$this->viewVars['total_results'] = count($this->viewVars['recipes_total_results']);

							$query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,SUM(rt.ratings) as totRat, COUNT(rt.user_id) as totusers,rtype.recipeTypeId as recipe_type, usr.username as uname FROM recipe_mealtype_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID LEFT JOIN users usr ON usr.id=rp.createdBy where " . $search_string . " group by rp.rID limit $next_page_entry,$page_entry";
							//echo $query;
							$this->viewVars['recipes_results']= $this->db->query($query)->result();
							$this->viewVars['extended']=$_REQUEST['extended'];
					
						  }
						  
									
						}
						elseif(!empty($_REQUEST['search']) && (!empty($_REQUEST['extended'])))
						{
						//echo "hi this is saif";
							/*
							//parse keyword string
							$keyword_string=explode(" ",$_REQUEST['search']);
							if(count($keyword_string)<1)
							   $keyword_string=" rp2.title like '%".$_REQUEST['search']."%'";
							else
							   $keyword_string="(rp2.title like '%" . implode("%' or rp2.title like '%",$keyword_string) . "%')";
								
							$opt_count=count($_REQUEST['extended']);
							
							if($opt_count>1)
							{
								  
								  $cn=0;			
								  //if more than one extended option is selected with no keyword search
								  
								  foreach($_REQUEST['extended'] as $ind=>$val)
								  {
									  $cnv=$cn+1;
									  if($cnv<$opt_count)
									  {
										  
										  $ids.="'".$val."',";
										  
									  }
									  else{
										  $ids.="'".$val."'";
										  
									  }
									  
									  $cn++;
									  
									  
								  }
								  
								  $search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId in(".$ids.") and  $keyword_string group by rp2.rID)";
								  $query = "SELECT rp.*,rimg.image_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipe_mealtype_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where ".$search_string." group by rp.rID limit $next_page_entry,$page_entry";
								  $this->viewVars['recipes_results']= $this->db->query($query)->result();
							
								  //find the ratings
								  //$search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId in(".$ids.") and  $keyword_string group by rp2.rID)";
								  //$query = "SELECT rp.*,rimg.image_name as recipe_image,rt.ratings as ratings FROM recipe_mealType_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID where ".$search_string." group by rp.rID limit 0,10";
								  //$this->viewVars['recipes_ratings']= $this->db->query($query)->result();
				
								  //print_r($this->viewVars['recipes_results']);
								 
								 			   
								  
							}
							else
							{
								  //if one extended option is selected with no keyword search
								  foreach($_REQUEST['extended'] as $ind=>$val)
								  {
									  $search_string=" rp.rID in(select rp2.rID as rID from recipe_mealType_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId=".$val." and $keyword_string group by rp2.rID )";
								  }
								  $query = "SELECT rp.*,rimg.image_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipe_mealType_selections rms,recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where ".$search_string." group by rp.rID limit 0,10";
								  //echo $query;
								  
								  $this->viewVars['recipes_results']= $this->db->query($query)->result();
								  //print_r($this->viewVars['recipes_results']);
								  
						  
							}
							*/
							    
								$recipes_keywords_res=$this->search_keywords();
								if(!empty($recipes_keywords_res))
								{ 
									   
									   foreach($recipes_keywords_res as $ind=>$val)
									   {
											   $total_results[]=$val->rID;
									   
									   }
								}
														   
								if(!empty($_REQUEST['extended']))
								{
								   $recipes_meal_course_res=$this->search_meal_course($_REQUEST['extended']);
								   if(!empty($recipes_meal_course_res))
								   {
										   
										   foreach($recipes_meal_course_res as $ind=>$val)
										   {
												   $total_results[]=$val->rID;
										   }		
								   }
								   
								   
								}
								
								$combined_rec_ids =$this->array_common($total_results);
								if(!empty($combined_rec_ids))
								{
									   $cn=0;
									   $opt_count=count($combined_rec_ids);
									   $ids='';
									   foreach($combined_rec_ids as $ind=>$val)
									   {
											 $cnv=$cn+1;
											 if($cnv<$opt_count)
												 $ids.="'".$val."',";
											 else
												 $ids.="'".$val."'";
											 $cn++;
									   }
									   $query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where rp.rID in (" . $ids . ") group by rp.rID ";
									   $this->viewVars['recipes_total_results'] = $this->db->query($query)->result();
									   $this->viewVars['total_results'] = count($this->viewVars['recipes_total_results']);

									   $query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,SUM(rt.ratings) as totRat, COUNT(rt.user_id) as totusers,rtype.recipeTypeId as recipe_type, usr.username as uname FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID LEFT JOIN users usr ON usr.id=rp.createdBy where rp.rID in (" . $ids . ") group by rp.rID limit $next_page_entry,$page_entry";
									   //echo $query;
									   //exit();
									   $this->viewVars['recipes_results']= $this->db->query($query)->result();
								} 	
									
						   $this->viewVars['search']=$_REQUEST['search'];
						   $this->viewVars['extended']=$_REQUEST['extended'];
							
						}
				//print_r($this->viewVars['recipes_results']);
				}
				elseif($_REQUEST['tracker']==1) // if extended options selected
				{
					$track_section=0;
					//find the result for single 
					if(!empty($_REQUEST['meal_course']))
					{
						$recipes_meal_course_res=$this->search_meal_course();
						if(!empty($recipes_meal_course_res))
						{
								$track_section++;
								foreach($recipes_meal_course_res as $ind=>$val)
								{
										$total_results[]=$val->rID;
								}		
						}
						
						
					}
					//find the result for drestrict 
					if(!empty($_REQUEST['drestrict']))
					{
						$recipes_drestrict_res=$this->search_drestrict();
						if(!empty($recipes_drestrict_res))
						{
								$track_section++;
								foreach($recipes_drestrict_res as $ind=>$val){
										$total_results[]=$val->rID;
								}
						}	
					}
					//find the result for fatloss 
					if(!empty($_REQUEST['fatloss']))
					{
						$recipes_fatloss_res=$this->search_fatloss();
						if(!empty($recipes_fatloss_res))
						{
								$track_section++;
								foreach($recipes_fatloss_res as $ind=>$val){
										$total_results[]=$val->rID;
								}
						}		
					}
					//find the result for preparation time 
					if(!empty($_REQUEST['PresTime']))
					{
						$recipes_PresTime_res=$this->search_PresTime();
						if(!empty($recipes_PresTime_res))
						{
								$track_section++;
						
								foreach($recipes_PresTime_res as $ind=>$val){
										$total_results[]=$val->rID;
								}
						}		
					}
					//find the result for search keywords
					if(!empty($_REQUEST['search']))
					{
						$recipes_keywords_res=$this->search_keywords();
						if(!empty($recipes_keywords_res))
						{
								//$track_section++;
								foreach($recipes_keywords_res as $ind=>$val)
								{
										$total_results[]=$val->rID;
										//echo $val->rID;
										//echo "<br>";
								}
						}		
					}
					
					//merge the result
					if($track_section>1)
					$combined_rec_ids =$this->array_common($total_results);
					else
					$combined_rec_ids=$total_results;
					if(!empty($combined_rec_ids))
					{
						$cn=0;
						$opt_count=count($combined_rec_ids);
						$ids='';
						foreach($combined_rec_ids as $ind=>$val)
						{
							  $cnv=$cn+1;
							  if($cnv<$opt_count)
								  $ids.="'".$val."',";
							  else
								  $ids.="'".$val."'";
							  $cn++;
						}
						$query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,rt.ratings as ratings,rtype.recipeTypeId as recipe_type FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID where rp.rID in (" . $ids . ") group by rp.rID ";
						$this->viewVars['recipes_total_results'] = $this->db->query($query)->result();
						$this->viewVars['total_results'] = count($this->viewVars['recipes_total_results']);

						$query = "SELECT rp.*,rimg.thumb_img_name as recipe_image,SUM(rt.ratings) as totRat, COUNT(rt.user_id) as totusers,rtype.recipeTypeId as recipe_type,usr.username as uname FROM recipes rp LEFT JOIN recipe_images rimg ON rimg.rID=rp.rID LEFT JOIN recipe_rating rt ON rt.recipe_id=rp.rID LEFT JOIN recipe_type_selections rtype ON rtype.rID=rp.rID LEFT JOIN users usr ON usr.id=rp.createdBy where rp.rID in (" . $ids . ") group by rp.rID limit $next_page_entry,$page_entry";
                        //echo $query; 
						$this->viewVars['recipes_results']= $this->db->query($query)->result();
						//print_r($this->viewVars['recipes_results']);
					}
					else
					{
							$this->viewVars['recipes_results']="";
					}
					
								  
				}
		}
		/*$url=BASE_URL . 'method=recipes.search&search_expression='.$search."&max_results=30&page_number=0";
		$token=$this->session->userdata('auth_token');
		$secret=$this->session->userdata('auth_secret');
		$recipes_results=$this->Recipeapi->recipeInfo($url,$token, $secret);
		
		//print_r($recipes_results);
		$total_results=$recipes_results['total_results'];
		$this->viewVars['recipes_results']=$recipes_results;
		*/
		//print_r($this->viewVars['recipes_results']);
		$this->load->view("recipefinder/recipe_finder_result", $this->viewVars);
		$st=session_id();
		if ($st=='') session_start();
		$_SESSION['request_data']=$_REQUEST;
		
		  
	}
	function search_keywords()
	{
		$this->viewVars['search_box']=$_REQUEST['search'];
		$search=$_REQUEST['search'];
		$search_string=explode(" ",$search);
		if(count($search_string>1))
		$search_string=" rp.title like '%" . implode("%' or rp.title like '%",$search_string) . "%'";
		else
		$search_string=" rp.title like '%".$_REQUEST['search']."%' ";
		
		$query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
		
		$recipes_keywords_res= $this->db->query($query)->result();
		$this->viewVars['search']=$_REQUEST['search'];
		return $recipes_keywords_res; 	
	}
	function search_PresTime()
	{
		if(!empty($_REQUEST['PresTime']['inactive']))
		{
			  $search_string=" rp.prepInactiveTime!='0' ";
			  $query = "SELECT  rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_drestrict_res= $this->db->query($query)->result();
		}
		elseif(!empty($_REQUEST['PresTime']['active']))
		{
			  $search_string=" rp.prepActiveTime!='0' ";
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_drestrict_res= $this->db->query($query)->result();
		}
		elseif(!empty($_REQUEST['PresTime']['active']) && !empty($_REQUEST['PresTime']['inactive']))
		{
		      $search_string=" rp.prepActiveTime!='0' && rp.prepInactiveTime!='0' ";
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_drestrict_res= $this->db->query($query)->result();
		}
		$this->viewVars['search']=$_REQUEST['search'];
		//$this->viewVars['meal_course']=$_REQUEST['meal_course'];
		return $recipes_drestrict_res; 	
		
	}
	function search_drestrict()
	{
		
		$opt_count=count($_REQUEST['drestrict']);
		$ids='';
		if($opt_count>1)
		{
			  $cn=0;			
			  //if more than one extended option is selected with no keyword search
			  foreach($_REQUEST['drestrict'] as $ind=>$val)
			  {
				  $cnv=$cn+1;
				  if($cnv<$opt_count)
				  	  $ids.="'".$val."',";
				  else
				      $ids.="'".$val."'";
				  $cn++;
			  }
			  
			  $search_string=" rp.rID in(select rID from recipe_directory_considerations_selections where rcID in(".$ids.") group by rID)";
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_drestrict_res= $this->db->query($query)->result();
		}
		else
		{
			  //if one extended option is selected with no keyword search
			  
			  foreach($_REQUEST['drestrict'] as $ind=>$val)
			  { 
				  $search_string=" rp.rID in(select rID from recipe_directory_considerations_selections where rcID=".$val." group by rID)";
			  
			  }
			  $query = "SELECT  rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_drestrict_res= $this->db->query($query)->result();
		}
		return $recipes_drestrict_res; 	
		
	}
	
	function search_fatloss()
	{
		
		$opt_count=count($_REQUEST['fatloss']);
		$ids='';
		if($opt_count>1)
		{
			  $cn=0;			
			  //if more than one extended option is selected with no keyword search
			  foreach($_REQUEST['fatloss'] as $ind=>$val)
			  {
				  $cnv=$cn+1;
				  if($cnv<$opt_count)
				  	  $ids.="'".$val."',";
				  else
				      $ids.="'".$val."'";
				  $cn++;
			  }
			  			  
			  $search_string=" rp.rID in(select rp2.rID as rID from recipe_type_selections rts,recipes rp2 where rp2.rID=rts.rID and rts.recipeTypeId in(".$ids.") group by rp2.rID)";
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID";
			  $recipes_fatloss_res= $this->db->query($query)->result();
			  		  
		}
		else
		{
			  //if one extended option is selected with no keyword search
			  foreach($_REQUEST['fatloss'] as $ind=>$val)
			  {
				  $search_string=" rp.rID in(select rp2.rID as rID from recipe_type_selections rts,recipes rp2 where rp2.rID=rts.rID and rts.recipeTypeId=".$val." group by rp2.rID)";
			  
			  }
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID ";
			  $recipes_fatloss_res= $this->db->query($query)->result();
			  

		}
		$this->viewVars['search']=$_REQUEST['search'];
		$this->viewVars['fatloss']=$_REQUEST['fatloss'];
		return $recipes_fatloss_res; 	
		
	}
	function search_meal_course($extended=null)
	{
		
		if(!empty($extended))
		{
				$res=$extended;
				$opt_count=count($extended);
		}
		else
		{
				$opt_count=count($_REQUEST['meal_course']);
				$res=$_REQUEST['meal_course'];		
		}
		
		
		$ids='';
		if($opt_count>1)
		{
			  $cn=0;			
			  //if more than one extended option is selected with no keyword search
			  foreach($res as $ind=>$val)
			  {
				  $cnv=$cn+1;
				  if($cnv<$opt_count)
				  	  $ids.="'".$val."',";
				  else
				      $ids.="'".$val."'";
				  $cn++;
			  }
			  			  

			  $search_string=" rp.rID in(select rp2.rID as rID from recipe_mealtype_selections rms,recipes rp2 where rp2.rID=rms.rID and rms.MealTypeId in(".$ids.") group by rp2.rID)";
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID limit 0,10";
			  //echo $query;
			  $recipes_meal_course_res= $this->db->query($query)->result();
		}
		else
		{
			  			  
			  //if one extended option is selected with no keyword search
			  foreach($res as $ind=>$val)
			  {
				  $search_string=" rp.rID in(select rms.rID as rID from recipe_mealtype_selections rms where rms.MealTypeId=".$val."  )";
			  }
			  $query = "SELECT rp.rID FROM recipes rp where ".$search_string." group by rp.rID limit 0,10";
			  //echo $query;
			  $recipes_meal_course_res= $this->db->query($query)->result();
			  

		}
		$this->viewVars['search']=$_REQUEST['search'];
		$this->viewVars['meal_course']=$res;
		return $recipes_meal_course_res; 			
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
			$query = "SELECT recipes.*, users.* FROM recipes, users where recipes.rID='" . $recipe_id . "' AND recipes.createdBy = users.id";
			$recipe_info = $this->db->query($query)->result();
				//echo  $recipe_info[0]->title;
			if(!empty($recipe_info[0]->rID))
			{
			  $query = "SELECT * FROM recipe_servings where rID='".$recipe_id."'";
				  $this->viewVars['recipe_servings'] = $this->db->query($query)->result();
				  $this->viewVars['recipe_details']['recipe_name'] = $recipe_info[0]->title;
				  $this->viewVars['recipe_details']['recipe_description'] = $recipe_info[0]->desc;
				  $this->viewVars['recipe_details']['recipe_servNote'] = $recipe_info[0]->note_servSugg;
				  
				  $this->viewVars['recipe_details']['user_name'] = $recipe_info[0]->username;
				  $this->viewVars['recipe_details']['user_id'] = $recipe_info[0]->id;
				  
				  $this->viewVars['metatitle'] = $recipe_info[0]->title; 
				  $this->viewVars['metadesc'] = $recipe_info[0]->desc; 
				  
				  $this->viewVars['recipe_details']['cooking_time_min'] = $recipe_info[0]->cookTime;
				  $this->viewVars['recipe_details']['no_serving'] = $recipe_info[0]->portions;
				  $this->viewVars['recipe_details']['act_time'] = $recipe_info[0]->prepActiveTime;
				  $this->viewVars['recipe_details']['inact_time'] = $recipe_info[0]->prepInactiveTime;
				  
			  #recipe types
			  $query = "SELECT * FROM recipe_types where rtID='".$recipe_info[0]->rtID."'";
				  $recipe_types= $this->db->query($query)->result();
				  
				  if(!empty($recipe_types[0]->type))
			  {
				$this->viewVars['recipe_details']['recipe_types'][0]['recipe_type'] = $recipe_types[0]->type;
			  }
			  
			  #recipe categories
			  $query = "SELECT rc.* FROM recipe_directory_considerations_selections rct,recipe_directory_considerations rc,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rct.rID and rc.rcID=rct.rcID";
				  $recipe_categories= $this->db->query($query)->result();
				  foreach($recipe_categories as $ind=>$cat_val)
				$this->viewVars['recipe_details']['recipe_categories'][0]['recipe_category'][$ind]['recipe_category_name']=$cat_val->name;
			  
			  #recipe servings
			  $query = "SELECT rs.* FROM recipe_servings rs,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rs.rID";
			  $recipe_servings= $this->db->query($query)->result();
			  
			  $fatloss=array();			
			  $total_carb=0;
			  $total_protein=0;
			  $total_fat=0;	
			  $total_calories=0;	
			  $dietary_fiber=0;	
			  $sugar=0;	
			  $saturated_fat=0;	
			  $polyunsat_fat=0;	
			  $monounsat_fat=0;	
			  $cholesterol=0;	
			  $sodium=0;	
			  $potassium=0;	
			  $vitamin_a=0;	
			  $vitamin_c=0;	
			  $calcium=0;	
			  $iron=0;	
			  
			  if(count($recipe_servings)>0)
				{
					$toting = 0;
					foreach($recipe_servings as $ing)
					{	
						$temp=$this->journal_model->getFoodInformation($ing->food_id);	
						
						for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
						{
							$tempservice=$temp['servings'][0]['serving'][$k];
							if($tempservice['measurement_description']==$ing->serving)
							{
								$fatloss = $tempservice;
								foreach($fatloss as $key => $value){
									if($key=='carbohydrate'){
										$total_carb+=$value;
									}
									if($key=='protein'){
										$total_protein+=$value;
									}
									if($key=='fat'){
										$total_fat+=$value;
									}
									if($key=='calories'){
										$total_calories+=$value;
									}
									if($key=='fiber'){
										$dietary_fiber+=$value;
									}
									if($key=='sugar'){
										$sugar+=$value;
									}
									if($key=='saturated_fat'){
										$saturated_fat+=$value;
									}
									if($key=='polyunsaturated_fat'){
										$polyunsat_fat+=$value;
									}
									if($key=='monounsaturated_fat'){
										$monounsat_fat+=$value;
									}
									if($key=='cholesterol'){
										$cholesterol+=$value;
									}
									if($key=='sodium'){
										$sodium+=$value;
									}
									if($key=='potassium'){
										$potassium+=$value;
									}
									if($key=='vitamin_a'){
										$vitamin_a+=$value;
									}
									if($key=='vitamin_c'){
										$vitamin_c+=$value;
									}
									if($key=='calcium'){
										$calcium+=$value;
									}
									if($key=='iron'){
										$iron+=$value;
									}
								}
							}
						}
						$toting++;
						
						/*echo "<pre>";
						print_r($temp);
						echo "<pre>";*/
					}
					//echo $total_carb;
					//echo $total_protein;
					//echo $total_fat;
					//echo $toting;
					
					$getPerc = array('total_calories'=>$total_calories,'total_fat'=>$total_fat,'total_carb'=>$total_carb,'dietary_fiber'=>$dietary_fiber,'sugar'=>$sugar,'total_protein'=>$total_protein);
					$returnPerc=$this->journal_model->getfoodinfo($getPerc);
					/*echo "<pre>";
					print_r($returnPerc);
					echo "</pre>";
					exit;*/
					$this->viewVars['recipe_details']['direction'] = $returnPerc['directions'];
					
					$pCurb = round($returnPerc['Percent_Carbs']);
					$pFat = round($returnPerc['Percent_Fat']);
					$pProt = round($returnPerc['Percent_Protein']);
					$this->viewVars['recipe_details']['percCarb'] = $pCurb;
					$this->viewVars['recipe_details']['percFat'] = $pFat;
					$this->viewVars['recipe_details']['percProt'] = $pProt;
					
					# this section is for pie chart... #SHAIFUL
					$this->load->library('piechart');
					// Set variables etc
					//$this->piechart->showLabel(true);
					//$this->piechart->showPercent(true);
					//$this->piechart->showParts(true);
					$this->piechart->setWidth(50);
					$this->piechart->setCol(array('4ABA9C','E7B200','BD5D52'));
					//$this->piechart->setFont('c:/wamp/www/classroombookings/tahoma.ttf', 9);
					$this->piechart->setLegend('round');
					$this->piechart->setData( array($pCurb,$pFat,$pProt) );
					//$this->piechart->setLabels( array('Room 14','ICT Suite','Room 13','Study Centre','Technology Suite') );

					// Make unique filename
					$hash = md5("report-pie-".$recipe_id);

					// Generate pie and save it
					$this->piechart->Generate("htdocs/images/piecharts/$hash.png");
							
					//$layout['title'] = 'Reports';
					//$layout['showtitle'] = $layout['title'];
					//$layout['body'] = $this->load->view('reports/reports_index', NULL, True);
					$pieimg = '<img src="htdocs/images/piecharts/'.$hash.'.png" alt="Circle chart">';
					$this->viewVars['recipe_details']['pieimg'] = $pieimg;
					
					$this->viewVars['recipe_details']['totFat'] = $total_fat;
					$this->viewVars['recipe_details']['totCarb'] = $total_carb;
					$this->viewVars['recipe_details']['totProt'] = $total_protein;
					$this->viewVars['recipe_details']['totCal'] = $total_calories;
					$this->viewVars['recipe_details']['saturated_fat'] = $saturated_fat;
					$this->viewVars['recipe_details']['polyunsat_fat'] = $polyunsat_fat;
					$this->viewVars['recipe_details']['monounsat_fat'] = $monounsat_fat;
					$this->viewVars['recipe_details']['cholesterol'] = $cholesterol;
					$this->viewVars['recipe_details']['sodium'] = $sodium;
					$this->viewVars['recipe_details']['potassium'] = $potassium;
					$this->viewVars['recipe_details']['dietary_fiber'] = $dietary_fiber;
					$this->viewVars['recipe_details']['sugar'] = $sugar;
					
					if($toting>0){
						$a_avg = ($vitamin_a/$toting);
						$c_avg = ($vitamin_c/$toting);
						$calc_avg = ($calcium/$toting);
						$iron_avg = ($iron/$toting);
					} else {
						$a_avg = 0;
						$c_avg = 0;
						$calc_avg = 0;
						$iron_avg = 0;
					}
					$this->viewVars['recipe_details']['vitamin_a'] = $a_avg;
					$this->viewVars['recipe_details']['vitamin_c'] = $c_avg;
					$this->viewVars['recipe_details']['calcium'] = $calc_avg;
					$this->viewVars['recipe_details']['iron'] = $iron_avg;
				}
			  
			  //exit;
			  //print_r($recipe_servings);
			  foreach($recipe_servings as $ind=>$sval)
			  $this->viewVars['recipe_details']['serving_sizes'][0]['serving'][0][$ind]['value']=$sval->entryname;
				
			  #recipe_directions
			  $query = "SELECT	rd.* FROM	recipe_directions rd,recipes r where r.rID='".$recipe_info[0]->rID."' and r.rID=rd.rID order by rd.sequence";
			  $recipe_directions= $this->db->query($query)->result();
			  //print_r($recipe_servings);
			  foreach($recipe_directions as $ind=>$sval)
			  {
				$this->viewVars['recipe_details']['directions'][0]['direction'][$ind]['direction_number']=$sval->sequence;
				$this->viewVars['recipe_details']['directions'][0]['direction'][$ind]['direction_description']=$sval->direction;
			  }
			  
			  # recipe meal type selection.... #SHAIFUL..
			  $query = "SELECT	*" .
					" FROM		recipe_mealtype_selections, recipe_mealtypes WHERE recipe_mealtype_selections.rID=".$recipe_id." AND recipe_mealtype_selections.MealTypeId = recipe_mealtypes.id";
			  $this->viewVars['recipe_mlType_slc'] = $this->db->query($query)->result();
			  
			  # recipe Dietary Restrictions ... #SHAIFUL
			  $query = "SELECT	*" . " FROM		recipe_directory_considerations rc, recipe_directory_considerations_selections rcX";
			  $query .= " WHERE rcX.rID=".$recipe_id." AND rcX.rcID=rc.rcID";
			  $this->viewVars['dietary_sel'] = $this->db->query($query)->result();
			  
			  #recipe ratings details #SHAIFUL
			  //$query = "SELECT recipe_rating.*,recipe_rating.id as rrid, users.* FROM recipe_rating inner join users on recipe_rating.user_id=users.id where recipe_rating.recipe_id='".$recipe_id."' order by recipe_rating.id asc";
			  $query = "SELECT recipe_rating.*, users.* FROM recipe_rating, users WHERE recipe_rating.recipe_id='".$recipe_id."' AND recipe_rating.user_id = users.id ORDER BY recipe_rating.id DESC";
			  $re_rating_details= $this->db->query($query)->result();
			  $this->viewVars['rat_details']=$re_rating_details;
			  
			  #recipe_ratings
			  //$query = "SELECT recipe_rating.*,recipe_rating.id as rrid, users.* FROM recipe_rating inner join users on recipe_rating.user_id=users.id where recipe_rating.recipe_id='".$recipe_id."' order by recipe_rating.id asc";
			  $query = "SELECT SUM(ratings) as totRat, COUNT(user_id) as totusers FROM recipe_rating WHERE recipe_id=".$recipe_id;
			  $recipe_rating= $this->db->query($query)->result();
			  
			  $query = "SELECT * FROM recipe_images where rID='".$recipe_id."'";
			  $recipe_img = $this->db->query($query)->result();
			  
			  $this->viewVars['reviews']=$recipe_rating;		  
			  $this->viewVars['recipe_id']=$recipe_id;
			  $this->viewVars['recipe_img']=$recipe_img;  
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
		$this->viewVars['alreay_added'] = 0;
		$rating=$_POST['rating'];
		$review=$_POST['review'];
		$recipe_id=$_POST['recipe_id'];
		$created =date("Y-m-d H:i:s");		
		$user_id=$this->session->userdata('id');		
		
		$chked_rat = $this->recipes_model->chk_usr_rating($user_id,$recipe_id);
		if(count($chked_rat)>0)
		{
			$this->viewVars['alreay_added'] = 1;
		} else {
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
		    
		    $this->viewVars['recipe_id']=$recipe_id;
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
	function array_common($combined_array)
	{
		$common = array();
		//$result2 = array_unique($combined_array);
		
		for($i=0;$i<count($combined_array);$i++)
		{
				for($j=$i+1;$j<count($combined_array);$j++)
				{
						if($combined_array[$i]==$combined_array[$j]){
								$common[]=$combined_array[$i];
						}
						
						
						
				}
		}
		
	return 	$common;
	}
}

?>
