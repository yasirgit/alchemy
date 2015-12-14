<?php
class Succ_measure_model extends Model {
	
	function Succ_measure_model(){
        parent::Model();
        $this->load->database();
    }
	
	function chk_reg_msr($uid,$cur_date)
	{
		$query = $this->db->get_where('users_measurements', array('uid' => $uid, 'um_date' => $cur_date));
        if ($query->num_rows() > 0)
        {
             $row = $query->row();
             return $row;
        }
	}
	
	function ins_usr_mesr($uid,$cur_date,$bodyFat,$fatWeight,$leanBodyMass,$bmi)
	{
		$data = array(
           'um_neck'=> $this->input->post('m_neck'),
           'um_chest'=>$this->input->post('m_chest'),
           'um_biceps'=>$this->input->post('m_biceps'),
           'um_forearms'=>$this->input->post('m_forearms'),
           'um_wrist'=>$this->input->post('m_wrist'),
           'um_waist'=>$this->input->post('m_waist'),
           'um_hips'=>$this->input->post('m_hips'),
           'um_thighs'=>$this->input->post('m_thighs'),
           'um_calves'=>$this->input->post('m_calves'),
           'um_bweight'=>$this->input->post('body_wegt'),
		   'um_bodyfat'=>$bodyFat,
		   'um_fatweight'=>$fatWeight,
		   'um_leanbodymass'=>$leanBodyMass,
		   'um_bmi'=>$bmi,
           'um_date'=>$cur_date,
           'uid'=>$uid
            );
        $this->db->insert('users_measurements', $data);
        $aff_row = $this->db->affected_rows();
        return $aff_row;
	}
	
	function upd_usr_mesr($uid,$cur_date,$mid,$bodyFat,$fatWeight,$leanBodyMass,$bmi)
	{
		$data = array(
           'um_neck'=> $this->input->post('m_neck'),
           'um_chest'=>$this->input->post('m_chest'),
           'um_biceps'=>$this->input->post('m_biceps'),
           'um_forearms'=>$this->input->post('m_forearms'),
           'um_wrist'=>$this->input->post('m_wrist'),
           'um_waist'=>$this->input->post('m_waist'),
           'um_hips'=>$this->input->post('m_hips'),
           'um_thighs'=>$this->input->post('m_thighs'),
           'um_calves'=>$this->input->post('m_calves'),
           'um_bweight'=>$this->input->post('body_wegt'),
		   'um_bodyfat'=>$bodyFat,
		   'um_fatweight'=>$fatWeight,
		   'um_leanbodymass'=>$leanBodyMass,
		   'um_bmi'=>$bmi,
           'um_date'=>$cur_date,
           'uid'=>$uid
            );
		$this->db->where('um_id', $mid);
        $this->db->update('users_measurements', $data);
        $aff_row = $this->db->affected_rows();
        return $aff_row;
	}
	
	function get_firstday_um($uid)
	{
		$this->db->order_by("um_date", "asc");
		$query = $this->db->get_where('users_measurements', array('uid' => $uid));
        if ($query->num_rows() > 0)
        {
            return $query->row(); 
			//return $query->result();
        }
	}
	
	function get_restday_umtot($uid)
	{
		$this->db->order_by("um_date", "asc");
		$query = $this->db->get_where('users_measurements', array('uid' => $uid));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows(); 
        }
	}

	
	function get_firstPage_um($limit, $perPage, $uid)
	{
		//$this->db->order_by("um_date", "asc");
		//$query = $this->db->get_where('users_measurements', array('uid' => $uid), $limit, $perPage);
		$sql="SELECT * FROM `users_measurements` WHERE uid = $uid ORDER BY um_date asc limit $limit, $perPage ";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->result(); 
        }
	}
	function get_restday_um($uid)
	{
		$this->db->order_by("um_date", "asc");
		$query = $this->db->get_where('users_measurements', array('uid' => $uid));
        if ($query->num_rows() > 0)
        {
            return $query->result(); 
        }
	}
	
	
	function get_max_res($uid)
	{   
		$data = array();
		$sql="SELECT * FROM users_measurements
                                WHERE uid= '$uid' and um_date IN (SELECT max(um_date) FROM users_measurements
               WHERE uid= '$uid')";
		
		$query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 
		
	}
	
    function get_all_um($uid)
	{
		$this->db->order_by("um_date", "asc");
		$query = $this->db->get_where('users_measurements', array('uid' => $uid));
        if ($query->num_rows() > 0)
        {
            return $query->result_array(); 
        }
	}
	
	function getall_um_todate($uid)
	{
	    $data = array();
		$date=date('y-m-d');
		$sql = "(select * from `users_measurements` where uid='$uid' and um_date='$date' limit 1)";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
	}
	
/*	function getall_um_week($uid)
	{
	    
		 $week = date('W');
         $year = date('Y');
   
         $lastweek=$week-1;
   
         if ($lastweek==0){
                $week = 52;
                $year--;
         }
   
         $lastweek=sprintf("%02d", $lastweek);
         for ($i=1;$i<=7;$i++){
              $arrdays[] = strtotime("$year". "$lastweek"."$i");
         }
	     $day1= date('Y-m-d', $arrdays[0]);
	     $day2= date('Y-m-d',$arrdays[6]);
		
		
		
		$data = array();

		$sql = "(SELECT * FROM `users_measurements` WHERE um_date BETWEEN '$day1' AND '$day2' and uid='$uid')";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
		   
	}*/
/*  function getall_um_start_week($uid,$wfirstdate='')
	{
		$data = array();

		$sql = "(SELECT * FROM `users_measurements` WHERE um_date='$wfirstdate' and uid='$uid')";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
		   
	}*/
	
	function getall_um_date_cal($uid,$date='')
	{
		$data = array();

		$sql = "(SELECT * FROM `users_measurements` WHERE um_date='$date' and uid='$uid' limit 1)";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
		   
	}
	
	
/*	function getall_um_month($uid)
	{
	    $data = array();
		$date=date('y-m-d');
		$sql = "(select * from users_measurements where `uid`='$uid' and `um_date` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
	}*/
	
	function getall_um_year($uid)
	{
	    $data = array();
		$date=date('y-m-d');
		$sql = "(select * from users_measurements where `uid`='$uid' and `um_date` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 
	}
	
	function count_eightWeek($uid){
	    
		$data = array();
		$date=date('y-m-d');
		$sql = "(SELECT max(um_date) as mxDate,um_bweight,um_waist,um_thighs,um_hips,um_calves,um_wrist,um_forearms,um_bodyfat, um_fatweight,um_bmi, DATE_ADD(um_date, INTERVAL(2-DAYOFWEEK(um_date)) DAY) as startWeekDate, DATE_ADD(um_date, INTERVAL(8-DAYOFWEEK(um_date)) DAY) as endWeekDate FROM users_measurements WHERE uid='$uid' GROUP BY
    WEEK(um_date) )";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
        }
           $query->free_result();  
           return $data; 

	}
	
	

}

?>