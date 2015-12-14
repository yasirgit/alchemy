<?php
class Fbshare extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->model(array('recipes_model'));
		$this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
	}
	
	public function shareme($rid,$descp,$title)
	{
		$data['rid'] = $rid;
		$data['descrip'] = $descp;
		$data['title'] = $title;
		$this->load->view('recipefinder/fbshareme', $data);
	}
}
?>