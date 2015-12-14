<?php
class Success_journal_model extends Model
{
    function __construct()
	{
		parent::Model();
    	$this->CI =& get_instance();
		//$this->load->database();    $this->load->helper('url');
		$uid=$this->session->userdata('id');
		$this->gallery_path = realpath(APPPATH . '../uploads/video');
		$this->gallery_path_url = base_url().'uploads/video/';
	} 
	
	function addjournal()
	{ 
        $uid=$this->session->userdata('id');
		$modifiedon= date("Y-m-d H:i:s");
		$created=date("y-m-d");
		$showdate=date("F j");
		//$config['allowed_types'] 	= 'mov|mpeg|mp3|avi';

		if($_FILES['userfile'])
		{
		    $filepost = $_FILES['userfile']['name'];
			$config = array(
			'allowed_types' => 'mov|mpeg|mp3|avi',
			'upload_path' => $this->gallery_path,
			'max_size' => 2000
		);
        $this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();
		

		}
		else
		{
		    $filepost='';
		}
		
		if($this->input->post('vaddtitle')!='')
		{
		    $vaddtitle = $this->input->post('vaddtitle');
		}
		else
		{
		    $vaddtitle=$this->input->post('addtitle');
		}
		
		
		if($this->input->post('vdetails')!='')
		{
		    $vdetails = $this->input->post('vdetails');
		}
		else
		{
		    $vdetails=$this->input->post('details');
		}
		
		
	    $data=array(
		            'uid'=>$uid,
					'title'=>$vaddtitle,
					'details' =>$vdetails,
					'file' =>$filepost,
					'hungerlevel'=>$this->input->post('hungerlevel'),
					'energylevel'=>$this->input->post('englevel'),
					'esteemlevel' =>$this->input->post('esteemlevel'),
					'sleeplevel' =>$this->input->post('sleepquality'),
					'status'=>$this->input->post('access-type'),
					'showdate' =>$showdate,
					'createdOn' =>$created,
					'modifiedOn' => $modifiedon
		          );
	
		    $this->db->insert('add_journal_entry',$data);
			

	}
	/*function get_all_jCount($uid)
	{
		$this->db->order_by("id", "desc");
		$sql = "(SELECT * FROM `add_journal_entry` WHERE status='2') UNION (SELECT * FROM `add_journal_entry` WHERE uid='$uid')";
        if ($query->num_rows() > 0)
        {
            return $query->num_rows(); 
        }
	}*/
	
	function getJournalPost($limit, $perPage, $uid)
	{
		$sql = "(SELECT * FROM `add_journal_entry` WHERE status='2') UNION (SELECT * FROM `add_journal_entry` WHERE uid='$uid') ORDER BY id DESC limit $limit, $perPage";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->result(); 
        }
	}
	
	function get_all_jCount()
	{ 
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(SELECT * FROM `add_journal_entry` WHERE status='2') UNION (SELECT * FROM `add_journal_entry` WHERE uid='$uid') ORDER BY id DESC";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 
	}
	
	
	
	function editJournalPost($id)
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(SELECT * FROM `add_journal_entry` WHERE id='$id' and uid='$uid' LIMIT 1)";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 
	}
	
	function updateJournal($id)
	{
	   $uid=$this->session->userdata('id');
	   $modifiedon= date("Y-m-d H:i:s");
	   $created=date("y-m-d");
	   $data=array(
		            'uid'=>$uid,
					'title'=>$this->input->post('addtitle'),
					'details' =>$this->input->post('details'),
					'hungerlevel'=>$this->input->post('hungerlevel'),
					'energylevel'=>$this->input->post('englevel'),
					'esteemlevel' =>$this->input->post('esteemlevel'),
					'sleeplevel' =>$this->input->post('sleepquality'),
					'status'=>$this->input->post('access-type'),
					'createdOn' =>$created,
					'modifiedOn' => $modifiedon
		          );
				  
			 $this->db->where('id', $id);
	         $this->db->update('add_journal_entry', $data);	
	}
	
	
	function deleteJpost($id){
             $this->db->where('id', $id);
	         $this->db->delete('add_journal_entry');	
    }
	
	function ultimateGoal()
	{ 
        $uid=$this->session->userdata('id');
		//$modifiedon= date("Y-m-d H:i:s");
		$created=date("y-m-d");
		//$showdate=date("F j");
	    $data=array(
		            'uid'=>$uid,
					'losePounds'=>$this->input->post('losePounds'),
					'pounds' =>$this->input->post('pounds'),
					'loseClothing'=>$this->input->post('loseClothing'),
					'clothingSize'=>$this->input->post('clothingSize'),
					'loseBodyfat' =>$this->input->post('loseBodyfat'),
					'bodyFat' =>$this->input->post('bodyFat'),
					'daySpa'=>$this->input->post('daySpa'),
                    'weekendTrip' =>$this->input->post('weekendTrip'),
					'concertTickets'=>$this->input->post('concertTickets'),
					'nightOuts'=>$this->input->post('nightOuts'),
					'newOutfit' =>$this->input->post('newOutfit'),
					'myOwnreward' =>$this->input->post('myOwnreward'),
					'createdOn' =>$created,
					
		          );
	
		    $this->db->insert('ultimate_goal',$data);
			

	}
	
	function orginalMeasure(){
	
	    // $row = array();
	      $uid=$this->session->userdata('id');
          $sql = "select weight,height from `users` where id= '$uid'";
          $res = $this->db->query($sql);
	      $row= $res->row_array();
		  return $row;
    }
	
	function get_start_userval()
	{
	    $uid=$this->session->userdata('id');
		$query = $this->db->get_where('users', array('id' => $uid));
        if ($query->num_rows() > 0)
        {
            return $query->row(); 
			//return $query->result();
        }
	}
	
	
	function eightWeekGoal()
	{ 
        $uid=$this->session->userdata('id');
		//$modifiedon= date("Y-m-d H:i:s");
		$created=date("y-m-d H:i:s");
		//$showdate=date("F j");
		if($this->input->post('endingDate'))
		{
           $enddate= $this->input->post('endingDate');
		 }
		 else
		 {
		   $enddate=  date('Y-m-d h:i:s', strtotime('+8 week'));
		 }
	    $data=array(
		            'uid'=>$uid,
					'losePounds'=>$this->input->post('losePounds'),
					'pounds' =>$this->input->post('pounds'),
					'loseClothing'=>$this->input->post('loseClothing'),
					'clothingSize'=>$this->input->post('clothingSize'),
					'loseBodyfat' =>$this->input->post('loseBodyfat'),
					'bodyFat' =>$this->input->post('bodyFat'),
					'daySpa'=>$this->input->post('daySpa'),
                    'weekendTrip' =>$this->input->post('weekendTrip'),
					'concertTickets'=>$this->input->post('concertTickets'),
					'nightOuts'=>$this->input->post('nightOuts'),
					'newOutfit' =>$this->input->post('newOutfit'),
					'endingDate' =>$enddate,
					'myOwnreward' =>$this->input->post('myOwnreward'),
					'createdOn' =>$created,
					
		          );
	
		    $this->db->insert('eight_week_goal',$data);
			

	}
	
	 function weekCount(){

	      $uid=$this->session->userdata('id');
          $sql = "select id from `eight_week_goal` where uid='$uid'";
          $res = $this->db->query($sql);
	      $row= $res->row_array();
		  return $row;
     }
	 
	function getUltimateGoal()
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(select * from `ultimate_goal` where uid='$uid' limit 1)";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 

	}
	
	
	function bckList()
	{ 
        $uid=$this->session->userdata('id');
		//$modifiedon= date("Y-m-d H:i:s");
		$created=date("y-m-d");
		//$showdate=date("F j");
		
		if($this->input->post('item')!='')
		{
		foreach (($this->input->post('item')) as $sitem) {
	         $data=array(
		            'uid'=>$uid,
					'item'=>$sitem,
                    'createdOn' =>$created,
             );
             $this->db->insert('bucket_list',$data);
		}
		}
		
	

	}
	
	function bckListCount(){

	      $uid=$this->session->userdata('id');
          $sql = "select id,item from `bucket_list` where uid='$uid'";
          $res = $this->db->query($sql);
	      $row= $res->row_array();
		  return $row;
     }
	 
	 function getBucketList()
	{ 
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(SELECT * FROM `bucket_list` WHERE uid='$uid')";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 
	}
	
/*	function bucketedit()
	{ 
	  
	   $uid=$this->session->userdata('id');
		//$modifiedon= date("Y-m-d H:i:s");
		$created=date("y-m-d");
		//$showdate=date("F j");
		foreach (($this->input->post('item')) as $sitem) {
	    $data=array(
		            'uid'=>$uid,
					'item'=>$sitem,
                    'createdOn' =>$created,
        );
		// $this->db->where('uid', $uid);
	     $this->db->update('bucket_list', $data);	
		}
	}*/
	
	function bckList_del($uid)
	{
	    $this->db->delete('bucket_list', array('uid' => $uid));
	   
	}


	
	function upUltimateGoal()
	{ 
	   $uid=$this->session->userdata('id');
	   $modifiedon= date("Y-m-d H:i:s");
	   $created=date("y-m-d");
	   $data=array(
		            'uid'=>$uid,
					'losePounds'=>$this->input->post('losePounds'),
					'pounds' =>$this->input->post('pounds'),
					'loseClothing'=>$this->input->post('loseClothing'),
					'clothingSize'=>$this->input->post('clothingSize'),
					'loseBodyfat' =>$this->input->post('loseBodyfat'),
					'bodyFat' =>$this->input->post('bodyFat'),
					'daySpa'=>$this->input->post('daySpa'),
                    'weekendTrip' =>$this->input->post('weekendTrip'),
					'concertTickets'=>$this->input->post('concertTickets'),
					'nightOuts'=>$this->input->post('nightOuts'),
					'newOutfit' =>$this->input->post('newOutfit'),
					'myOwnreward' =>$this->input->post('myOwnreward'),
					'createdOn' =>$created,
		          );
				  
			 $this->db->where('uid', $uid);
	         $this->db->update('ultimate_goal', $data);	
	}
	
	function getuserActiveDate()
	{                                                             
	  $data = array();
	  $uid=$this->session->userdata('id'); 
	  $sql = "SELECT birthdate,sex,created,DATE_ADD(created,INTERVAL 8 WEEK) AS eightWeekDate FROM `users` WHERE id='$uid'";  
	  $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 
 	}
	
	function getWeekGoal()
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(select * from `eight_week_goal` where uid='$uid' limit 1)";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 

	}
	
	function upWeekGoal()
	{ 
	   $uid=$this->session->userdata('id');
	   $modifiedon= date("Y-m-d H:i:s");
	   if($this->input->post('endingDate'))
		{
           $enddate= $this->input->post('endingDate');
		}
		else
		 {
		   $enddate=  date('Y-m-d h:i:s', strtotime('+8 week'));
		 }
	    $data=array(
		            'uid'=>$uid,
					'losePounds'=>$this->input->post('losePounds'),
					'pounds' =>$this->input->post('pounds'),
					'loseClothing'=>$this->input->post('loseClothing'),
					'clothingSize'=>$this->input->post('clothingSize'),
					'loseBodyfat' =>$this->input->post('loseBodyfat'),
					'bodyFat' =>$this->input->post('bodyFat'),
					'daySpa'=>$this->input->post('daySpa'),
                    'weekendTrip' =>$this->input->post('weekendTrip'),
					'concertTickets'=>$this->input->post('concertTickets'),
					'nightOuts'=>$this->input->post('nightOuts'),
					'newOutfit' =>$this->input->post('newOutfit'),
					'endingDate' =>$enddate,
					'myOwnreward' =>$this->input->post('myOwnreward'),
					'modifiedOn' =>$modifiedon,
	
		          );
				  
			 $this->db->where('uid', $uid);
	         $this->db->update('eight_week_goal', $data);	
	}

   function bonusGoalEntry()
   {   $fitem=8;
	   $uid=$this->session->userdata('id');
	   if($this->input->post('fitem'))
	   {
	     $fitem = $this->input->post('fitem');
	   }

	   if($fitem==8)
	   {
	     $fcur_val=$this->input->post('cur_waist');
		 $fgoal_val=$this->input->post('gl_waist');
	   }
	   else if($fitem==7)
	   {
	     $fcur_val=$this->input->post('cur_cholest');
		 $fgoal_val=$this->input->post('gl_cholest');
	   }
	    else if($fitem==6)
	   {
	     $fcur_val=$this->input->post('cur_blood');
		 $fgoal_val=$this->input->post('gl_blood');
	   }
	    else if($fitem==5)
	   {
	     $fcur_val=$this->input->post('cur_size');
		 $fgoal_val=$this->input->post('gl_size');
	   }
	    else if($fitem==4)
	   {
	     $fcur_val=$this->input->post('cur_weight');
		 $fgoal_val=$this->input->post('gl_weight');
	   }
	    else if($fitem==3)
	   {
	     $fcur_val=$this->input->post('cur_bodyfat');
		 $fgoal_val=$this->input->post('gl_bodyfat');
	   }
	    else if($fitem==2)
	   {
	     $fcur_val=$this->input->post('cur_thighs');
		 $fgoal_val=$this->input->post('gl_thighs');
	   }
	    else if($fitem==1)
	   {
	     $fcur_val=$this->input->post('cur_hips');
		 $fgoal_val=$this->input->post('gl_hips');
	   }	   

	   
	   $created = date("Y-m-d H:i:s");
	   $data = array(
		            'uid'=>$uid,
					'fid'=>$fitem,
					'cur_val'=>$fcur_val,
					'goal_val'=>$fgoal_val,
/*					'featured_cur_val' =>$fcur_val,
					'featured_goal_val' =>$fgoal_val,
					'cur_waist' =>$this->input->post('cur_waist'),
					'goal_waist' =>$this->input->post('gl_waist'),
					'cur_hips' =>$this->input->post('cur_hips'),
					'goal_hips' =>$this->input->post('gl_hips'),
					'cur_thighs' =>$this->input->post('cur_thighs'),
					'goal_thighs' =>$this->input->post('gl_thighs'),
					'cur_bodyfat' =>$this->input->post('cur_bodyfat'),
					'goal_bodyfat' =>$this->input->post('gl_bodyfat'),
					'cur_weight' =>$this->input->post('cur_weight'),
					'goal_weight' =>$this->input->post('gl_weight'),
					'cur_size' =>$this->input->post('cur_size'),
					'goal_size' =>$this->input->post('gl_size'),
					'cur_blood' =>$this->input->post('cur_blood'),
					'goal_blood'=>$this->input->post('gl_blood'),
					'cur_cholest'=>$this->input->post('cur_cholest'),
					'goal_cholest'=>$this->input->post('gl_cholest'),*/
                    'createdOn' =>$created,
		            );
       $this->db->insert('bonus_featured', $data);

	}
	
  function bonusGoalupdate()
   {   
	   $uid=$this->session->userdata('id');
	   if($this->input->post('fitem'))
	   {
	     $fitem = $this->input->post('fitem');
	   }
	   else{
	      $fitem = $this->input->post('feature');
	   }

	   if($fitem==8)
	   {
	     $fcur_val=$this->input->post('cur_waist');
		 $fgoal_val=$this->input->post('gl_waist');
	   }
	   else if($fitem==7)
	   {
	     $fcur_val=$this->input->post('cur_cholest');
		 $fgoal_val=$this->input->post('gl_cholest');
	   }
	    else if($fitem==6)
	   {
	     $fcur_val=$this->input->post('cur_blood');
		 $fgoal_val=$this->input->post('gl_blood');
	   }
	    else if($fitem==5)
	   {
	     $fcur_val=$this->input->post('cur_size');
		 $fgoal_val=$this->input->post('gl_size');
	   }
	    else if($fitem==4)
	   {
	     $fcur_val=$this->input->post('cur_weight');
		 $fgoal_val=$this->input->post('gl_weight');
	   }
	    else if($fitem==3)
	   {
	     $fcur_val=$this->input->post('cur_bodyfat');
		 $fgoal_val=$this->input->post('gl_bodyfat');
	   }
	    else if($fitem==2)
	   {
	     $fcur_val=$this->input->post('cur_thighs');
		 $fgoal_val=$this->input->post('gl_thighs');
	   }
	    else if($fitem==1)
	   {
	     $fcur_val=$this->input->post('cur_hips');
		 $fgoal_val=$this->input->post('gl_hips');
	   }	   

	   
	   $modifiedon = date("Y-m-d H:i:s");
	   $data = array(
		            
					'fid'=>$fitem,
					'cur_val'=>$fcur_val,
					'goal_val'=>$fgoal_val,
                    'modifiedon' =>$modifiedon,
		            );
       $this->db->where('uid', $uid);
	   $this->db->update('bonus_featured', $data);	

	}
	
  function getBonusOptions()
	{
	   $data = array();
       $sql = "(select * from `bonus_goal_options`)";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 

	}	
	function getBonusGoal()
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(select * from `bonus_featured` where uid='$uid')";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 

	}
	
	function getfeatureName()
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(select bonus_goal_options.id, bonus_goal_options.options,bonus_goal_options.cur_val_name,bonus_goal_options.goal_val_name,bonus_goal_options.ms_unit, bonus_featured.fid, bonus_featured.cur_val, bonus_featured.goal_val from `bonus_goal_options`, `bonus_featured` where bonus_featured.fid=bonus_goal_options.id and  bonus_featured.uid='$uid')";
	   $query = $this->db->query($sql);

       if ($query->num_rows() > 0){
           foreach ($query->result_array() as $row){
           $data[] = $row;
           }
       }
           $query->free_result();  
           return $data; 

	}
	
	function getNonfeatureName()
	{
	   $data = array();
	   $uid=$this->session->userdata('id');
       $sql = "(SELECT bonus_goal_options.id,bonus_goal_options.options,bonus_goal_options.cur_val_name,bonus_goal_options.goal_val_name,bonus_goal_options.ms_unit FROM `bonus_goal_options`,bonus_featured WHERE bonus_goal_options.id<>bonus_featured.fid and bonus_featured.uid='$uid')";
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