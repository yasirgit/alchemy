<?php

class recipes_model extends Model
{

	private $CI;

	function __construct()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

	public function get($rID)
	{
		$query = "SELECT	*
					FROM	recipes
					WHERE	rID=".$rID;
		if ($recipes = $this->db->query($query)->result())
		{
			for ($x=0; $x < count($recipes); $x++)
			{
				$query = "SELECT * FROM recipe_directions WHERE rID=".$recipes[$x]->rID." ORDER BY sequence";
				$recipes[$x]->directions	= $this->db->query($query)->result();
				$query = "SELECT * FROM recipe_mealTypes WHERE rID=".$recipes[$x]->rID;
				//$recipes[$x]->mealTypes		= $this->db->query($query)->result();
				$query = "SELECT * FROM recipe_servings WHERE rID=".$recipes[$x]->rID;
				$recipes[$x]->servings		= $this->db->query($query)->result();
			}
		}
		return $recipes;
	}
	
	public function getRecipe($rid)
	{
	
		$return=array();		
		$query = "SELECT * FROM recipes where rID='".$rid."'";
		$return['recipe']= $this->db->query($query)->result();		
		
		$query = "SELECT * FROM users where id='".$return['recipe'][0]->createdBy."'";
		$return['users']= $this->db->query($query)->result();
		
		$query = "SELECT * FROM recipe_images where rID='".$rid."'";
		$return['images']= $this->db->query($query)->result();
		
		return $return;
	}
	public function getRating($rid)
	{
		$return=array();		
		$query = "SELECT avg(ratings) as actualrat, COUNT(user_id) as totusers FROM recipe_rating where recipe_id='".$rid."'";
		$return['rating']= $this->db->query($query)->result();						
		return $return;
	}
	
	public function chk_usr_rating($uid,$recid)
	{
		$query = $this->db->get_where('recipe_rating', array('user_id' => $uid, 'recipe_id' => $recid));
        if ($query->num_rows() > 0)
        {
             return $query->row();
        }
	}
	
	public function get_numRecipies($uid)
	{
		$query = $this->db->get_where('recipe_box', array('user_id' => $uid, 'ismealorrecipe' => 1));
        if ($query->num_rows() > 0)
        {
             return $query->num_rows();
        }
	}
	
	function get_boxRecipies($num, $offset, $uid)
	{
		$this->db->limit($num, $offset);
		$query = $this->db->get_where('recipe_box', array('user_id' => $uid, 'ismealorrecipe' => 1));
                if ($query->num_rows() > 0)
                {
                    return $query->result();
                }
	}

}

?>
