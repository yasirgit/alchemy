<?php
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
	private $ob	= 'recipes.createdOn';
	private $order	= 'DESC';
	private $init	= false;

	public function __construct()
	{
		parent::Controller();

		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array('users.js');
		$this->load->model(array('fatsecret/fsprofile_food', 'user_model', 'user_food_model', 'journal_model'));	// includes fsprofile
		$this->load->library(array('Auth', 'form_validation'));
		$this->load->helper(array('html', 'url', 'strings', 'fsdate', 'ui'));
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
		$this->fsprofile_food->apiBuild($this->method, $_POST);
		if ($this->fsprofile_food->execute())//$this->session->userdata('auth_token'), $this->session->userdata('auth_secret')))//, $_POST))
		{
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";
			$tmp_array['foods']		= $this->fsprofile_food->result;
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
           		
		if ($_POST['title'] && $_POST['description'] && $_POST['portions'] && $_POST['directions'][0] && $_POST['food_id'][0])
		{
			if ($_POST['rID'] && !$this->db->query("SELECT * FROM recipes WHERE rID!=".$_POST['rID']." AND title='".$_POST['title']."' AND createdBy=".$this->session->userdata('id'))->result())
			{
				
				$data['title']			= mysql_escape_string($_POST['title']);
				$data['desc']			= mysql_escape_string($_POST['description']);
				$data['cookTime']		= $_POST['cookTime'];
				$data['portions']		= $_POST['portions'];
				//$data['prepTime']		= $_POST['prepTime'];
				//$data['prepTime']=$_POST['prepTimeHours']*60+$_POST['prepTimeMins'];
				
				$data['prepActiveTime']=$_POST['prepActiveTime'];
				$data['prepInactiveTime']=$_POST['prepInactiveTime'];
				
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
				//if(!empty($_POST['adventurous']))
					$data['adventurous']=$_POST['adventurous'];
				if(!empty($_POST['substitution']))
					$data['substitution']=$_POST['substitution'];
				if(!empty($_POST['serving_suggestion']))
					$data['note_servSugg']=$_POST['serving_suggestion'];	
				//$data['rcID']			= $_POST['rcID'];
				//$data['rhiID']			= $_POST['rhiID'];
				//$data['bodyType']		= $_POST['bodyType'];
								
				$data['modifiedBy']		= $this->session->userdata('id');
				$this->db->update("recipes", $data, array("rID" => $_POST['rID']));

				$this->db->delete("recipe_directions",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_mealtype_selections",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_servings",		array("rID" => $_POST['rID']));
				$this->db->delete("recipe_type_selections",		array("rID" => $_POST['rID']));
				//$this->db->delete("recipe_healthIssuesX",	array("rID" => $_POST['rID']));
				//$this->db->delete("recipe_classificationX",	array("rID" => $_POST['rID']));
				$this->db->delete("recipe_directory_considerations_selections",	array("rID" => $_POST['rID']));
				//$this->insertRecipeImage($_POST['rID']);
				$this->insertRecipe($_POST['rID']);
                                if($_FILES['recipe_image']['name']){
                                    $this->insertRecipeImage($_POST['rID']);
                                }
								
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
				if(!empty($_POST['serving_suggestion']))
					$data['note_servSugg']=$_POST['serving_suggestion'];
					
				//$data['bodyType']	= $_POST['bodyType'];
				$data['createdBy']	= $this->session->userdata('id');
				$data['createdOn']	= date("Y-m-d H:i:s");
				
                                
				$this->db->insert("recipes",$data);
				$rId = $this->db->insert_id();
				$this->insertRecipe($rId, true);
				if($_FILES['recipe_image']['name']){
                                    $this->insertRecipeImage($rId);
                                }
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
		 $known_photo_types = array(
		  'image/pjpeg' => 'jpg',
		  'image/jpeg' => 'jpg',
		  'image/gif' => 'gif',
		  'image/bmp' => 'bmp',
		  'image/png' => 'png'
		 );

		 $rand_file_name = mt_rand(105, 200009)."_".str_replace(" ", "_", $_FILES['recipe_image']['name']);

		 $file_location = RECIPE_IMAGE_FOLDER.$rand_file_name;
                 
		 if(move_uploaded_file($_FILES['recipe_image']['tmp_name'], $file_location)) // Add logic by Shaiful...
		 { 
			$dataD='';
			chmod($file_location,0777);
			$dataD['rID'] = $rID;
			$dataD['image_name'] = $rand_file_name;
			$dataD['image_size'] = $_FILES['recipe_image']['size'];
			$dataD['image_type'] = $_FILES['recipe_image']['type'];
			$thumb_file_name = "thumb_".$rand_file_name;
			$dataD['thumb_img_name'] = $thumb_file_name;
                        $rescipe_id = $this->db->query("SELECT * FROM recipe_images WHERE rID =".$rID)->result();
                        //print_r($rescipe_id); exit;
                        if(!empty($rescipe_id)){
                            $this->db->update("recipe_images", $dataD, array("rID" => $rID));
                        }
                        else{
                            $this->db->insert("recipe_images", $dataD);
                        }
			
			$filetype = $_FILES['recipe_image']['type'];
			$extention = $known_photo_types[$filetype];
			$this->resizeimg($file_location,$thumb_file_name,$extention);
		 }	
	}
	
	private function resizeimg($filename,$name,$extention)
	{
		//$filename = 'image/8.jpg';
		// Set a maximum height and width
		$width = 62;
		$height = 62;

		// Content type
		//header('Content-type: image/jpeg');

		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filename);

		//$ratio_orig = $width_orig/$height_orig;

		/*if ($width/$height > $ratio_orig) {
		   $width = $height*$ratio_orig;
		} else {
		   $height = $width/$ratio_orig;
		}*/

		// Resample
		$image_p = imagecreatetruecolor($width, $height);
		if($extention == 'jpg'){
			$image = imagecreatefromjpeg($filename);
		} elseif($extention == 'gif') {
			$image = imagecreatefromgif($filename);
		} elseif($extention == 'bmp'){
			$image = imagecreatefromwbmp($filename);
		} elseif($extention == 'png') {
			$image = imagecreatefrompng($filename);
		} else {
		
		}
		
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		
		//imagedestroy($image_p);
		// Output
		$images_dir=RECIPE_IMAGE_FOLDER."thumb";
		$saveto = $images_dir.'/'.$name;
		if($extention == 'jpg')
		{
			imagejpeg($image_p, $saveto, 100);
		} elseif($extention == 'gif') {
			imagegif($image_p, $saveto);
		} elseif($extention == 'bmp') {
			imagewbmp($image_p, $saveto);
		} elseif($extention == 'png') {
			imagepng($image_p, $saveto);
		} else {
		
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
	
	
	private function insertRecipe($rID, $createdOn=false)
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
				$this->db->insert("recipe_mealtype_selections",$dataM);
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
                        $this->journal_model->storefoodinformation($_POST['food_id'][$x]);
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
				$this->db->insert("recipe_directory_considerations_selections",$dataC);
				
			}
		}

		/*if (@$_POST['rhiID'])
		{
			$dataH = array();
			$dataH['rID'] = $dataD['rID'];
			for ($x=0; $x < count(@$_POST['rhiID']); $x++)
			{
				$dataH['rhiID']	= $_POST['rhiID'][$x];
				$this->db->insert("recipe_healthissuesx",$dataH);
			}
		}

                print_r($_POST); exit;*/
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
		if($recipes = $this->db->query($query)->result())
		{
			$this->load->library('paginator');
			$cnt = $this->db->query("SELECT FOUND_ROWS() as records")->result();
			$this->paginator->setPaginator(array(	'records' =>	$cnt[0]->records,
													'pages' =>		5,
													'start' =>		$this->session->userdata('start'),
													'controller' =>	'recipes',
													'method' =>		'listAll'));
			$number_pages = ceil($cnt[0]->records / PAGECNT_SMALL);  // get total num of pages ... SHAIFUL
			$lastid = (($number_pages * PAGECNT_SMALL) - PAGECNT_SMALL);
			//$lasturl= base_url().'recipefinder/my_recipebox/list/'.$lastid;
			$this->viewVars["totrows"] = $cnt[0]->records;
			$this->viewVars["number_pages"] = $number_pages;
			$this->viewVars["lastid"] = $lastid;
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
				$sql = "SELECT * FROM recipe_images WHERE rID=".$recipes[$x]->rID;
				$recipes[$x]->imgages		= $this->db->query($sql)->row();
				#SHAIFUL counting avg ratings ....
				$ratsql = "SELECT SUM(ratings) as totRat, COUNT(user_id) as totusers FROM recipe_rating WHERE recipe_id=".$recipes[$x]->rID;
				$recipes[$x]->ratings		= $this->db->query($ratsql)->result();
				
				#SHAIFUL started section for count curb of servings or ingredients.....
				$query = "SELECT rs.* FROM recipe_servings rs,recipes r where r.rID='".$recipes[$x]->rID."' and r.rID=rs.rID";
			    $recipe_servings= $this->db->query($query)->result();
				
                            $fatloss=array();
			    $total_carb=0;
			    $total_protein=0;
			    $total_fat=0;	
			    $total_calories=0;	
			    $dietary_fiber=0;	
			    $sugar=0;	
				
				if(count($recipe_servings)>0)
				{
					foreach($recipe_servings as $ing)
					{	
						$sql="select * from food_description where food_id='".$ing->food_id."' and measurement_description='".stripslashes($ing->serving)."'";	
						$fatloss=$this->db->query($sql)->row_array();
											
						if(empty($fatloss))
						{
							$temp=$this->journal_model->getFoodInformation($ing->food_id);							
							for($k=0;$k<count($temp['servings'][0]['serving']);$k++)
							{
								$tempservice=$temp['servings'][0]['serving'][$k];
								if($tempservice['measurement_description']==$ing->serving)
								$fatloss = $tempservice;																	
							}
						}						
						////////////////////												
						foreach($fatloss as $key => $value)
						{
							if($key=='carbohydrate'){
								$total_carb+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='protein'){
								$total_protein+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='fat'){
								$total_fat+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='calories'){
								$total_calories+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='fiber'){
								$dietary_fiber+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='sugar'){
								$sugar+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='saturated_fat'){
								$saturated_fat+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='polyunsaturated_fat'){
								$polyunsat_fat+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='monounsaturated_fat'){
								$monounsat_fat+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='cholesterol'){
								$cholesterol+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='sodium'){
								$sodium+=$value;
							}
							if($key=='potassium'){
								$potassium+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='vitamin_a'){
								$vitamin_a+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='vitamin_c'){
								$vitamin_c+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='calcium'){
								$calcium+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
							if($key=='iron'){
								$iron+=($value/$fatloss['number_of_units'])*$ing->qty;
							}
						}					
					////////////////////												
					}
					$getPerc = array('total_calories'=>$total_calories,'total_fat'=>$total_fat,'total_carb'=>$total_carb,'dietary_fiber'=>$dietary_fiber,'sugar'=>$sugar,'total_protein'=>$total_protein);
					$returnPerc=$this->journal_model->getfoodinfo($getPerc);
				    $recipes[$x]->direction = $returnPerc['directions'];
				}
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
			$this->db->delete("recipe_mealtype_selections",	array("rID" => $this->rID) );
			$this->db->delete("recipe_box",	array("recipe_or_meal_id" => $this->rID) );
			$this->db->delete("recipe_servings",	array("rID" => $this->rID) );
			$this->db->delete("recipes",			array("rID" => $this->rID) );
			$this->db->delete("recipe_images", array("rID" => $this->rID) );
		}
		//$this->listAll();
		redirect('recipes/listAll');
	}

}

?>
