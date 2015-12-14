<script type="text/javascript">
function submit_form2()
{
  document.recipe_finder.submit();
}
</script>
<form action="recipefinder/search" class="signup" name="recipe_finder" method="post">
	<fieldset>
		<span class="text"><span><input type="text" name="search" value="<? if(!empty($search)) echo $search;?>"/></span></span>
		<a href="javascript: submitform2()" class="sexybutton sexyorange sexybtn"><span><span>Go</span></span></a>
	</fieldset>
	
	<span style="float:left;">Meal / Course
	<?php
	  
	  if(!empty($recipe_types)){
	    
	    foreach($recipe_types as $ind=>$val)
	    {
	    ?>
	      <input type="checkbox" name="extended[<?php echo $val->name;?>]" value="<?php echo $val->id;?>"  <?php if(!empty($extended)){ foreach($extended as $ind2=>$val2){ if($val2==$val->id) { ?>checked=checked<?}} } ?> /><?php echo $val->name;?>&nbsp;
	    <?  
	    }
	     
	}?>
	    <a href="javascript: submit_form2()" class="sexybutton sexyorange sexybtn"><span><span style="width:90px;">Submit</span></span></a>
	</span>
	
	
</form>
