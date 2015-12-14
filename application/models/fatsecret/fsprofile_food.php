<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

class Fsprofile_food extends Model {
	
	private	$fatsecret	= false;
	public	$apiURL		= false;
	public	$error		= false;

	public function __construct()
	{
		parent::Model();
		$this->fatsecret = new FatSecretAPI(API_KEY, API_SECRET);
	}

	public function apiBuild($method,$params)
	{
		$this->apiURL	= false;
		$this->error	= false;
		switch($method)
		{
		default:
			break;
		case "foods.search":
			if ($params['ingredient'] && is_numeric($params['page']) && $params['page'] >= 0)
			{
				$this->apiURL = 'method=foods.search&max_results='.PAGECNT_SMALL.'&page_number='.$params['page'].'&search_expression='.$params['ingredient'];//&format=json';
			}
			else
			{
				$this->error = "Invalid ingredient (".$params['ingredient'].") or page (".$params['page'].") requested";
			}
			break;
		case "food.get":
			if (is_numeric($params['food_id']) && $params['food_id'] >= 0)
			{
				$this->apiURL = 'method=food.get&food_id='.$params['food_id'];
			}
			else
			{
				$this->error = "Invalid food_id - ".$params['food_id'];
			}
			break;
//		case "saved_meal.create":
//			if ($params['saved_meal_name'])
//			{
//				$this->apiURL = 'method=saved_meal.create&saved_meal_name='.$params['saved_meal_name'].'&saved_meal_description='.$params['saved_meal_description'].'&meal='.strtolower($params['meal']);
//			}
//			else
//			{
//				$this->error = "Invalid saved_meal_name - ".$params['saved_meal_name'];
//			}
//			break;
		}
	}

	public function execute()
	{
//		if ($this->templates[$this->method])
//		{
//			$this->fsprofile_food->result['type'] = @$this->type;
//var_dump($this->fsprofile_food->result);
//			$tmp_array['foods']	= $this->load->view($this->templates[$this->method],array("foods" => $this->fsprofile_food->result),true);
//		}
//		else
//		{
//			$tmp_array['foods']	= $this->fsprofile_food->result;
//		}

		try
		{
			$searchurl=BASE_URL . $this->apiURL."&generic_description=portion";
			$this->result = $this->fatsecret->request($searchurl, $this->session->userdata('auth_token'), $this->session->userdata('auth_secret'));
			//$this->result = $this->fatsecret->request(BASE_URL . $this->apiURL, $this->session->userdata('auth_token'), $this->session->userdata('auth_secret'));
		}
		catch (Exception $ex)
		{
			$this->error = "FS API ERROR (".$this->apiURL.") - ".$ex->getMessage();
			return false;
		}
		return true;
	}

/*	function foodCreate($token, $secret, $data=array()) {
		$url = BASE_URL . 'method=food.create';
		foreach($data as $k => $v) {
			$url .= '&'.$k.'='.$v;
		}
		try {
			$result = $this->fatsecret->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}
	
	function foodGet($token, $secret, $food_id) {
		$url = BASE_URL . 'method=food.get&food_id='.$food_id;
		
		try {
			$result = $this->fatsecret->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}

	public function foodSearch($token, $secret, $params)
	{
		$url = BASE_URL . 'method=foods.search&max_results='.PAGECNT_SMALL.'&page_number='.$params['page'].'&search_expression='.$params['ingredient'];

		try
		{
			$this->result = $this->fatsecret->request($url, $token, $secret);
		}
		catch (Exception $ex)
		{
			$this->error = $ex->getMessage();
			return false;
		}
		return true;
	}
*/
}