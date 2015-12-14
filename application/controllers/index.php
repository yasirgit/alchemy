<?php
class Index extends Controller {
	
	function __construct() {
		parent::Controller();
		$this->load->model(array('fatsecret/fsprofile', 'user_model'));
		$this->load->library(array('Auth', 'form_validation'));
		$this->pageVars['css'] = array();
		$this->pageVars['js'] = array();
	}
	
	function index() {
		$this->load->view('index');
	}
}