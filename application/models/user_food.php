<?php
class User_food extends Model {
	function __construct() {
		parent::Model();
	}
	
	function foodCreate($data=array()) {
		return $this->db->insert('user_food', $data);
	}
	
	function foodGet($user_id) {
		return $this->db->get_where('user_food', array('user_id'=>$user_id))->result_array();
	}
}