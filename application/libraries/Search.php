<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Paginator Class
 *
 * @package	 CodeIgniter
 * @subpackage  Libraries
 * @category	Search
 * @author	  Brian Markham
 * @copyright   
 *
 */

class Search
{
//	public $data	= array();
	public $where	= array();

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->library('session');
	}

	function set($params=false)
	{
		if (is_array($params))
		{
			foreach ($params AS $param)
			{
				$key = explode(".",$param['key']);
				$keyP = $key[count($key)-1];
				if ( ($value = @$_POST["S_".$keyP]) || ($value = $this->CI->session->userdata("S_".$keyP)) )
				{
					switch($param['op'])
					{
					default:
						$this->where[] = ($param['text']) ? $param['key']." ".$param['op']." '".$value."'" : $param['key']." ".$param['op']." ".$value ;
						break;
					case "LIKE":
						$this->where[] = $param['key']." ".$param['op']." '%$value%'";
						break;
					}
					$this->CI->data["S_".$keyP] = $value;
					$this->CI->session->set_userdata("S_".$keyP,$value);
				}
				else
				{
					$this->CI->session->unset_userdata("S_".$keyP);
				}
			}
		}
		if (empty($this->where))
		{
			$this->where[] = 1;
		}
	}

}

?>
