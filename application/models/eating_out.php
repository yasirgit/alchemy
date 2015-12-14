<?php
class Eating_out extends Model 
{
		
	function getFeatured()
	{
		$featured_food=array();
		$sql="select * from eoa_food where isfeatured='1' order by id desc limit 0,6";
		$featured=$this->db->query($sql)->result_array();			
		for($i=0;$i<count($featured);$i++)
		{
		 $featured_food[$i]['food']=$featured[$i];
		 
		 $sql="select * from eoa_foodtype where id='".$featured[$i]['food_type_id']."'";
		 $featured_food[$i]['foodtype']=$this->db->query($sql)->result_array();
		 
		 $sql="select * from eoa_mealtype where id='".$featured[$i]['meal_type_id']."'";
		 $featured_food[$i]['mealtype']=$this->db->query($sql)->result_array();
		 
		 $sql="select * from eoa_restaurant where id='".$featured[$i]['restaurant_id']."'";
		 $featured_food[$i]['restaurant']=$this->db->query($sql)->result_array();
		 
		 $sql="select * from eoa_review where foods_id='".$featured[$i]['id']."'";
		 $featured_food[$i]['review']=$this->db->query($sql)->result_array();
		
		}
        return 	$featured_food;	
	}
	
}
?>