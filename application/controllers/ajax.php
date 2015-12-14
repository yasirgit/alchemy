<?php
class Ajax extends Controller {
	
	function __construct() {
		parent::Controller();
		$this->pageVars['isajax'] = true;
	}
	
	function getAddToJournalWindow() {
		echo $this->viewVars['addtojournal'] = $this->load->view('users/eating_journal/add_to_journal', null, true);
	}
}