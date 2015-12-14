<?$CI =& get_instance();?>
<div class="register">
	<div class="page_head">
            <div class="page_head_left">Recipe Selection Update</div>
            <div class="page_head_right">&nbsp;</div>
        </div>        
        
        <div class="registerBox">
            <form method="post" action="">
                <table cellspacing="1" cellpadding="3" border="0" style="width: 100%;">
                <tbody>
                   <tr>
                         <td class="event">Title</td>
                         <td class="event"><?php echo $recipe[0]->title;?></td>
                   </tr>
                   <tr>
                         <td class="event">Description</td>
                         <td class="event"><?php echo $recipe[0]->desc;?></td>
                   </tr>
                   <tr>
                         <td class="event">Cook Time</td>
                         <td class="event"><?php echo $recipe[0]->cookTime;?></td>
                   </tr>
                   <tr>
                         <td class="event">Note</td>
                         <td class="event"><?php echo $recipe[0]->note_servSugg;?></td>
                   </tr>
                   
                   <tr>
                       <td class="event">Status</td>
                         <td class="event"> <?php echo $recipe[0]->status;?></td>
                   </tr>
                   <tr>
                         <td class="event">Recipe Type</td>
                         <td class="event">
                              <?php  $recipeType=$recipeTypeSelection[0]->recipeTypeId;?>
                             <select name="rtID">
                                 <option value="" <?php if($recipeType=="") echo 'selected="selected"';?>>Not Selected</option>
                             <?php for($j=0; $j<count($recipe_types); $j++){ ?>
                                 <option value="<?php echo $recipe_types[$j]->rtID;?>" <?php if($recipeType==$recipe_types[$j]->rtID) echo 'selected="selected"';?>><?php echo $recipe_types[$j]->type;?></option>
                             <?php } ?>
                              </select>
                         </td>
                   </tr>
                   <tr>
                       <td class="event">&nbsp;</td>
                         <td class="event">
                            <input type="hidden"  value="<?php echo $recipe[0]->rID;?>" id="rID" name="rID">
                            <input type="submit" value="Update" class="submit">
                         </td>
                   </tr>
                   
           </tbody>
            </table>
                </form>
		
              
	</div>
</div>	
