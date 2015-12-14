<?$CI =& get_instance();?>
<div class="viewpage">
     <div class="page_head">Recipe</div>     
    <form method="post" action="adduser">
	<div class="viewpageBox">
            <table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
                <tbody>
                   <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Cook Time</th>                       
                        <th>Recipe Type</th>
                        <th>Action</th> 
                  </tr>
                  <?php $recipes = $recipe->result(); for($i=0; $i<count($recipes); $i++){ ?>
				  <?php 
				    $rID=$recipes[$i]->rID;
				    $sql = "SELECT recipeTypeId FROM recipe_type_selections WHERE rID='".$rID."'";
					$recipeTypeSelection=$this->db->query($sql)->result();
					$recipeTypeId=$recipeTypeSelection[0]->recipeTypeId;					
					 //
					$sql = "SELECT *" . " FROM	recipe_types WHERE rtID='".$recipeTypeId."'";
            		$recipe_types=$this->db->query($sql)->result();
					
					
					
				  ?>
                  <tr>
                    <td class="event"><?php echo $recipes[$i]->title;?></td>
                    <td class="event"><?php echo $recipes[$i]->desc;?></td>
                    <td class="event"><?php echo $recipes[$i]->cookTime;?></td>                    
                    <td class="event"><?php echo $recipe_types[0]->type;?></td>
                    <td class="event"><a href="recipeDetails/<?php echo $recipes[$i]->rID;?>">Update</a></td>
                  </tr>
                  <?php } ?>
                  <tr>
                      <td colspan="5" align="center" class="pagenav"><?php echo $this->pagination->create_links(); ?></td>
                  </tr>
           </tbody>
            </table>
               
	</div>
      </form>     
</div>

