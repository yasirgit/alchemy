<?php
require_once(APPPATH.'libraries/fatsecret/FatSecretAPI.php');

class Fsprofile extends Model {
	
	private $fatsecret;
	
	function __construct() {
		parent::Model();
		$this->fatsecret = new FatSecretAPI(API_KEY, API_SECRET);
	}

	// Setters
	function profileCreate($userId=null) {
		$url = BASE_URL . 'method=profile.create';
		if(!empty($userId)){
			$url = $url . '&user_id=' . $userId;
		}
		try {
			$result = $this->fatsecret->request($url);
		} catch(Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}
	
	function weightUpdate($token, $secret, $currentWeight, $goalWeight=null, $height=null) {
		$url = BASE_URL . 'method=weight.update&current_weight_kg='.$currentWeight;
		if(!empty($goalWeight)) {
			$url .= "&goal_weight_kg=".$goalWeight;
		}
		if(!empty($height)) {
			$url .= "&current_height_cm=".$height;
		}
		try {
			$result = $this->fatsecret->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
	}
	
	//END Setters
	
	//Getters
	
	function profileGet($token, $secret) {
		$url = BASE_URL . 'method=profile.get';
		try {
			$result = $this->fatsecret->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}
	
	function profileGetAuth($userId) {
		$url = BASE_URL . 'method=profile.get_auth&user_id='.$userId;
		return $this->fatsecret->request($url);
	}
	
	// END Getters
}
?>