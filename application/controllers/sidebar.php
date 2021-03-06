<?php
/*
 * sidebar
 *
 * default model for journal
 *
 * @package ripe media
 * @version 1
 * @author Brian Markham
 */
class sidebar extends Controller
{

	function __construct()
	 {
		parent::Controller();
		$this->pageVars['isajax'] = true;

		$this->load->model('user_model');
		$this->load->library('Auth');
		if (!$this->auth->isLoggedIn())
		{
			$tmp_array['error_code']	= -1;
			$tmp_array['error_msg']		= "";

			echo json_encode($tmp_array);
			exit;
		}

		$uri = explode('/',$_SERVER['QUERY_STRING']);
		for ($x=3; $x < count($uri); $x++)
		{
			$param = explode(":",$uri[$x]);
			$this->$param[0] = $param[1];
		}
	}

	public function setDailyDate()
	{
		switch ($this->dir)
		{
			default:
			$date = strtotime($this->session->userdata('date'));
			break;

			case 1:
			$date = strtotime("+1 day", strtotime($this->session->userdata('date')));
			break;

			case -1:
			$date = strtotime("-1 day", strtotime($this->session->userdata('date')));
			break;
		}
		$tmp_array['date'] = date('l, F d',$date);
		$this->session->set_userdata('date', date("Y-m-d", $date));

		$tmp_array['daily']			= $this->user_model->getDaily();

		$tmp_array['error_code']	= 0;
		$tmp_array['error_msg']		= "";//"date=".$date." dir=".$this->dir;
		echo json_encode($tmp_array);
	}

	public function setWaterTracker()
	{		
		if (($tmp_array['cups']=$this->user_model->setWaterTracker($this->mode,$_POST['eDate'])) !== false)
		{
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";//"mode=".$this->mode." cups=".$tmp_array['cups'];
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "sidebar.php (waterTracker) - Invalid";
		}

		echo json_encode($tmp_array);
	}

	public function daily()
	{
		if ($this->user_model->setDaily($this->daily,$this->checked,$_POST['eDate']) !== false)
		{
			$tmp_array['error_code']	= 0;
			$tmp_array['error_msg']		= "";//"daily=".$this->daily." checked=".$this->checked;
		}
		else
		{
			$tmp_array['error_code']	= 1;
			$tmp_array['error_msg']		= "sidebar.php (daily) - Invalid";
		}

		echo json_encode($tmp_array);
	}

}

?>