<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

class Recipeapi extends Model {
	
	private $fatsecret;
	
	function __construct() {
		parent::Model();
		$this->fatsecret = new FatSecretAPI(API_KEY, API_SECRET);
	}	
	// END Getters
	///////////////////////////////modified by omar
	function recipeTypeGet($token, $secret) {
		$url = BASE_URL . 'method=food.get&food_id=33689';		
		//$url = BASE_URL . 'method=foods.search&search_expression=Cheese';		
		try {
			$result = $this->fatsecret->requestapi($url, $token, $secret);
			echo "<pre>";			
				print_r($result);
			echo "</pre>";
			exit();
			/*$final=array();
			$i=0;
			foreach($result->recipe_type as $key=>$test)
			$final[$i++]=(string)$test;
			*/
			
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $final;
	}
	###omar
	function foodGet($token, $secret,$type="1",$sId="") //1.food.get 2. food.search 3. 
	{	
		  $ext="";
		  if($type==1)
			$ext="method=food.get&food_id=".$sId;			  	
		  else if($type==2)
			$ext="method=foods.search&search_expression=".$sId;
		
		$url = BASE_URL.$ext;				
		try 
		{
			$result = $this->fatsecret->requestapi($url, $token, $secret);						
		} 
		catch (Exception $ex) 
		{
			$result['error'] = $ex->getMessage();
		}
	  	return $result;	
	}	
	###omar	
	##SHAHED 
	function recipeInfo($url,$token, $secret)
	{
    try {       
			$result = $this->fatsecret->requestapi($url, $token, $secret);			
			
		} 
    catch (Exception $ex) 
    {
			$result['error'] = $ex->getMessage();
		}
		return $result;
  }
  ##SHAHED
}
?>
