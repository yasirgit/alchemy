<script type="text/javascript">
function submit_form2()
{
  document.recipe_finder.submit();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    <?php if($_REQUEST['tracker']==1){?>
		    $('.options-short-view').hide();
			$('#tracker').val(1);
	<?}?>
		
});
</script>
<form action="recipefinder/search/"  name="recipe_finder" method="post">
    <div class="rf2-top-round">&nbsp;</div>
    <div class="rf2-search-middle">
		<div class="rf2-search-field">
			<fieldset>
			  <span class="texter"><input type="text" value="<? if(!empty($_REQUEST['search'])) echo $_REQUEST['search'];?>" name="search"></span>
			  <a class="sexybutton sexyorange sexybtn" href="javascript:submit_form2();"><span><span>Go</span></span></a>
			  
			<br class="clear" />
			</fieldset>
			<fieldset class="options-short-view">
			  <label>Meal/Course:</label>
			  <?php
		  //print_r($_REQUEST['extended'])	;
	  			if(!empty($recipe_types)){
	  				  
				  foreach($recipe_types as $ind=>$val)
				  {
				  ?>
					<span><input type="checkbox" name="extended[<?php echo $val->name;?>]" value="<?php echo $val->id;?>"  <?php if(!empty($_REQUEST['extended'])){ foreach($_REQUEST['extended'] as $ind2=>$val2){ if($val2==$val->id) { ?>checked=checked<?}} } ?> /><?php echo $val->name;?></span>
				  <?  
				  }
			   
			  }?>
			</fieldset>
		</div>
	<!--Expand Area-->
	<div class="expand-wrapper">
	    <div class="expand-top-round">&nbsp;</div>
	    <div class="expand-middle">
		<fieldset>
			<label>Meal/Course:</label>
			<?php
			if(!empty($recipe_types))
			{
			foreach($recipe_types as $ind=>$val)
			{
			?>
			<span><input type="checkbox" name="meal_course[<?php echo $val->name;?>]" value="<?php echo $val->id;?>"  <?php if(!empty($_REQUEST['meal_course'])){ foreach($_REQUEST['meal_course'] as $ind2=>$val2){ if($val2==$val->id) { ?>checked=checked<?}} } ?> /><?php echo $val->name;?></span>
			<?  
			}
			}?>
		    
		</fieldset>
		<!--fieldset>
			<label>Cuisine Type:</label>
		    <span><input type="checkbox" name="" /> Text</span>
		    <span><input type="checkbox" name="" /> Text</span>
		    <span><input type="checkbox" name="" /> Text</span>
		    <span><input type="checkbox" name="" /> Text</span>
		</fieldset-->
		<fieldset>
		  <label>Dietary Restrictions:</label>
		<?php 
		  if (!empty($directory_restrictions))
		  {
		    foreach ($directory_restrictions AS $ind=>$class)
			{
			  if ($class->rcID)
			  {
			?><span><input type="checkbox" name="drestrict[]" value="<?php echo $class->rcID;?>" id="<?php echo $class->name;?>" <?php if(!empty($_REQUEST['drestrict'])){ foreach($_REQUEST['drestrict'] as $ind3=>$val3){ if($val3==$class->rcID) { ?>checked=checked<?}}}?>/><?php echo $class->name;?></span>
		<?php }
			}
		 }	
		 ?>
 	    </fieldset>
		<fieldset class="plate-compnt">
			<label>Fat Loss Plate Component:</label>
		    <span><input type="checkbox" name="fatloss[protien]" value="7" <?php if(!empty($_REQUEST['fatloss']['protien'])){ if($_REQUEST['fatloss']['protien']==7) { ?>checked=checked<?php }}?>/> Protein</span>
		    <span><input type="checkbox" name="fatloss[fast_carb]" value="1" <?php if(!empty($_REQUEST['fatloss']['fast_carb'])){ if($_REQUEST['fatloss']['fast_carb']==1) { ?>checked=checked<?php }}?> /> Fast Carb</span>
		    <span><input type="checkbox" name="fatloss[slow_carb]" value="2" <?php if(!empty($_REQUEST['fatloss']['slow_carb'])){ if($_REQUEST['fatloss']['slow_carb']==2) { ?>checked=checked<?php }}?>/> Slow Carb</span>
		    <span><input type="checkbox" name="fatloss[fat_loss_solo]" value="6" <?php if(!empty($_REQUEST['fatloss']['fat_loss_solo'])){ if($_REQUEST['fatloss']['fat_loss_solo']==6) { ?>checked=checked<?php }}?>/> Fat Loss Solo</span>
		</fieldset>
		<fieldset class="plate-compnt">
			<label>Prep Time:</label>
		    <span><input type="checkbox" name="PresTime[active]" <?php if(!empty($_REQUEST['PresTime']['active'])){ if($_REQUEST['PresTime']['active']==7) { ?>checked=checked<?php }}?>/> Active</span>
		    <span><input type="checkbox" name="PresTime[inactive]" <?php if(!empty($_REQUEST['PresTime']['inactive'])){ if($_REQUEST['PresTime']['inactive']==7) { ?>checked=checked<?php }}?>/> Inactive</span>
		</fieldset>
		<div class="btn-submit">
			<a class="sexybutton sexyorange" href="javascript: submit_form2();"><span><span>Submit</span></span></a>
		    <br class="clear" />
		</div>
	    </div>
	</div>
    <!--/Expand Area-->
    </div>
    <div class="rf2-bottom-round"><a href="#" class="min-max" id="linko">VIEW ALL OPTIONS</a><br class="clear" /></div>
    <input type="hidden" name="tracker" id="tracker" value="0" />
</form>