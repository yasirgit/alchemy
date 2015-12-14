<?php
class Stringhelper {
	
	private $CI;
	
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model(array('favorite_item_model'));
	}
	
	function cleanUsername($string) {
		$string = preg_replace( "/[[:punct:]]/", '', $string);
		$string = preg_replace("/[\s]/", '', $string);
		return $string;
	}
}