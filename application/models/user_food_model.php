<?php
class User_food_model extends Model {
	
	private $CI;
	
	function __construct() {
		parent::Model();
		$this->CI =& get_instance();
		$this->CI->load->model('fatsecret/fsprofile_food');
	}
	
	function foodCreate($data=array()) {
		$result = $this->fsprofile_food->foodCreate($this->CI->session->userdata('auth_token'), $this->CI->session->userdata('auth_secret'), $data);
		if(!isset($result['error'])) {
			return $this->db->insert('user_food', $data);
		}
		return $result;
	}
	
	function foodsGet($user_id) {
		$result = $this->db->get_where('user_food', array('user_id'=>$user_id))->result_array();
		if(!empty($result)) {
			foreach($result as $k => $v) {
				$fsdata = $this->fsprofile_food->foodGet($this->session->userdata('auth_token'), $this->session->userdata('auth_secret'), $v['food_id']);
				$result[$k] = $fsdata;
			}
		}
		return $result;
	}
}