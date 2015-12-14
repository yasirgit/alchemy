<?php
 
class Layout
{
 	function __construct()
 	{ 
 		$this->CI = & get_instance();
 	}
 
 	public function render()
 	{
	
 		if(isset($this->CI->pageVars['isajax']))
 		{
			if (!empty($this->CI->output))
			{
 				$this->CI->output->_display();	
 			}
 		}
		else if(isset($this->CI->pageVars['isadmin']))
 		{
 			if(!isset($this->CI->pageVars))
			{
				$this->CI->pageVars = null;
			}

	 		if(!empty($this->CI->pageVars['css']))
	 		{
	 			$this->CI->pageVars['css'] =  array_reverse($this->CI->pageVars['css']);
	 		}

	 		$this->CI->pageVars['__content'] = $this->CI->output->get_output();

			$this->CI->pageVars['__header'] = $this->CI->load->view('admin/header', $this->CI->pageVars, true);
		
			$this->CI->pageVars['__footer'] = $this->CI->load->view('admin/footer', $this->CI->pageVars, true);

			$this->CI->output->_display($this->CI->load->view('admin/layout', $this->CI->pageVars, true));
 		}		
 		else
 		{
 			if(!isset($this->CI->pageVars))
			{
				$this->CI->pageVars = null;
			}

	 		if(!empty($this->CI->pageVars['css']))
	 		{
	 			$this->CI->pageVars['css'] =  array_reverse($this->CI->pageVars['css']);
	 		}

	 		$this->CI->pageVars['__content'] = $this->CI->output->get_output();

			$this->CI->pageVars['__header'] = $this->CI->load->view('layout/header', $this->CI->pageVars, true);

			$this->CI->pageVars['__top'] = $this->CI->load->view('layout/top', $this->CI->pageVars, true);

			$this->CI->pageVars['__sidebar'] = $this->CI->load->view('layout/sidebar', $this->CI->pageVars, true);

			$this->CI->pageVars['__twocolumns'] = $this->CI->load->view('layout/content', $this->CI->pageVars, true);

			$this->CI->pageVars['__footer'] = $this->CI->load->view('layout/footer', $this->CI->pageVars, true);

			$this->CI->output->_display($this->CI->load->view('layout/index', $this->CI->pageVars, true));
 		}
 	}

}

?>