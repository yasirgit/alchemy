<script>
$(document).ready(function(){

	 
	 $('.featureBtn').click(function(){
	     var id = $(this).attr("id");  valid = true; var p = $("#ft").val();
		 if ( $("#ft").val()==null )
		 { 
		 $("#b"+id).hide('slow');
		 $('<input type="hidden" id="ft" name="fitem" value="'+id+'" />').animate({ opacity: "show" }, "slow").appendTo('#featureVal'+id);
	     $('<span id="selectfb">Featured</span>').animate({ opacity: "show" }, "slow").appendTo('#featureVal'+id);
		 }
		 else{
		    alert("You have already selected one feature item!");
	         valid = false;
		 }
		 //return valid;
		 
		
		$('#bonus_entry').ajaxSubmit(
			{
						url:			"successjournal/bonus_update",
						type:			'post',	
						beforeSubmit:	function()
										{
											$('.load_before4').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/final_loading_big.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                  
										   $("#bonus-box").load('successjournal/ajax_bonus_load');
										   $('.load_before4').css('display',"none");
										   $("#ajax_bonus_data").load('successjournal/bonus_popup_meter_desc');
										  
										
                                        }
										
			});
			
			return false;
		
		 
	 });
	 
	 $("#featuresave").click(function() { 
	        $('#bonus_entry').ajaxSubmit(
			{
						url:			"successjournal/bonus_update",
						type:			'post',	
						beforeSubmit:	function()
										{
											$('.load_before4').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/final_loading_big.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                  
										   $("#bonus-box").load('successjournal/ajax_bonus_load');
										   $('.load_before4').css('display',"none");
										   $("#ajax_bonus_data").load('successjournal/bonus_popup_meter_desc');
										  
										   disableBonusPopup();
                                        }
										
			});
			
			return false;
	           
               
	 });	
			
        
		
	return false; 	

});
	
</script>
<?php 

		if($last_dayMsr){ 
		 foreach($last_dayMsr as $curerntres)
		 {
		    $uwaist = $curerntres['um_waist'];
			$uthighs = $curerntres['um_thighs'];
			$uweight = $curerntres['um_bweight'];
			$uhip = $curerntres['um_hips'];
			$ubodyfat = $curerntres['um_bodyfat'];
		 }
	   }
	   else
	   { 
	      $uwaist=0;
		  $uthighs=0;
		  $uweight=0;
		  $uhip=0;
		  
	   }
?>
<?php



	foreach ($bonusGoal as  $bGlist)
    {
	               foreach ($fetureid as $fture){
		                  $options= $fture['options'];
					      $fid= $fture['id'];
						  $st_val_name= $fture['start_val_name'];
		                  $cur_val_name= $fture['cur_val_name'];
			              $goal_val_name= $fture['goal_val_name'];
					      $unit= $fture['ms_unit'];
				}

	    
	$dynWidth='';
	//$lose = $bGlist[$cur_val_name]-$bGlist[$st_val_name];
	$lose = $bGlist[$st_val_name] - $bGlist[$goal_val_name];
	$startRange = $bGlist[$st_val_name];
	$endRange = $bGlist[$goal_val_name];
	$midRange = (($lose/2)+$endRange);
	$curlose = $bGlist[$cur_val_name]- $bGlist[$st_val_name];
	
	if($curlose < 0){
	 if(abs($curlose) >= $lose)
	 {
	   $dynWidth=365;
	   
	 }
	 else{
	     $scalling = (float) (365/$lose)  ;
			        $diffWeight = abs($curlose) * $scalling;
			        if($diffWeight < 365)
			        {
			            $dynWidth = $diffWeight;
			        }
			        else
			        {
			            $dynWidth = 365;
			        }
	 }
	}else{
	  $dynWidth=5;
	}
?>	


<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
 </div>

 
 
        <div class="popup-middle">
		  <div id="bonus_featured_meter">
            <p class="heading"><? echo  $options; ?> </p>
	       
        	<div class="bonus-goal-graph" id="bonus-goal-graph">
			<? if($fid==5) {
			?>
			<div class="comm-progress bobus-bar "  <?php echo "style='width:".$dynWidth."px;'";?>><?php  echo $unit." ".abs($curlose); ?> </div>
			<?
			}
			else{?>
			<div class="comm-progress bobus-bar "  <?php echo "style='width:".$dynWidth."px;'"  ;?>><?php  echo abs($curlose)." ".$unit;?> </div>
			<? } ?>
			   <div class="popup-bonus-unit">
			   <? if($fid==5) 
			   {
			   ?>
			         <span><? echo $unit; ?> <? echo $startRange; ?> </span>
                     <span class="middle"><? echo $unit; ?> <? echo $midRange; ?> </span>
                     <span class="right"> <? echo $unit; ?> <? echo $endRange; ?></span>
			   <?
			   }else{
			   ?>
			   
                      <span><? echo $startRange; ?> <? echo $unit; ?></span>
                      <span class="middle"><? echo $midRange; ?> <? echo $unit; ?></span>
                      <span class="right"><? echo $endRange; ?> <? echo $unit; ?></span>
				<? } ?>
                </div>
            </div>
			 </div>
			<form action="successjournal/bonus_update" class="feature" method="post" name="bonus_entry" id="bonus_entry">
			
            <p class="graph-calc">
			<input type="hidden" name="<? echo $st_val_name; ?>" value="<?php  echo $bGlist[$st_val_name]; ?>" />
		
			 <input type="hidden" name="curfid" id="curfid" value="<?php  echo $fid; ?>" />  
			    
			<?	
			   if($fid==1)
				{
			?>
			    <input type="hidden" name="<? echo $cur_val_name; ?>" value="<?php echo $uhip; ?>" />
			<?
				}elseif($fid==2){
			?>
			     <input type="hidden" name="<? echo $cur_val_name; ?>" value="<?php echo $uthighs; ?>" />
			<?	
				}elseif($fid==3){
			?>
			     <input type="hidden" name="<? echo $cur_val_name; ?>" value="<?php echo $ubodyfat; ?>" />
			<?
			   }elseif($fid==4){
			?>  
			    <input type="hidden" name="<? echo $cur_val_name; ?>" value="<?php echo $uweight; ?>" />
			<?
			    }elseif($fid==8){
			?>
			    <input type="hidden" name="<? echo $cur_val_name; ?>" value="<?php echo $uwaist; ?>" />
			<? } ?>
			  
			  
			  
			   
			    <? if(($fid==5) ||($fid==6) || ($fid==7)){ ?>
				<label style="width:124px; font-size:13px;">
				Current = <input type="text" name="<? echo $cur_val_name; ?>" value="<?php  echo $bGlist[$cur_val_name]; ?>" class="goal" /><span style="width:25px; position:relative; top:-22px; left:28px;">&nbsp;<?  echo $unit ?></span><br/>
				<? 
				} elseif($fid==1){ 
				?>
				<label style="width:110px; font-size:13px;">
			   Current = <?php echo $uhip; ?>&nbsp;<?  echo $unit ?><br/>
			   <? 
			     }elseif($fid==2){
			   ?> 
			    <label style="width:110px; font-size:13px;">
			    Current = <?php echo $uthighs; ?>&nbsp;<?  echo $unit ?><br/>
			   <? }elseif($fid==3){ ?>
			    <label style="width:110px; font-size:13px;">
			    Current = <?php echo $ubodyfat; ?>&nbsp;<?  echo $unit ?><br/>
			   
			   <? }elseif($fid==4){ ?>
			    <label style="width:110px; font-size:13px;">
			    Current = <?php echo $uweight; ?>&nbsp;<?  echo $unit ?><br/>
			   <? }elseif($fid==8){ ?>
			    <label style="width:110px; font-size:13px;">
			    Current = <?php echo $uwaist; ?>&nbsp;<?  echo $unit ?><br/>
			
			   <? } ?> 
			   Start = <?php  echo $bGlist[$st_val_name]; ?>&nbsp;<? echo $unit; ?></label>
			    
			   <span><label style="font-size:13px;">Goal =</label><span style="float:right; width:30px; font-size:13px;">&nbsp;<? echo $unit; ?></span><input type="text" name="<? echo $goal_val_name; ?>" value="<?php  echo $bGlist[$goal_val_name]; ?>" /></span>
			</p>
			 <div class="load_before4"  style="margin:auto; position:fixed; width:250px; top:300px; left:500px;"></div>
             <p class="heading" style="padding-top:5px;">Other Options</p>
			 <?
			 	       foreach ($nonfetured as $key => $nonfture){
					      $n_id= $nonfture['id'];
				      	  $n_options= $nonfture['options'];
                          $n_st_val_name= $nonfture['start_val_name'];
		                  $n_cur_val_name= $nonfture['cur_val_name'];
			              $n_goal_val_name= $nonfture['goal_val_name'];
					      $n_unit= $nonfture['ms_unit'];
				
              ?>
               <fieldset>
			       
				  
				  <? if(($n_id==1) ||($n_id==2) || ($n_id==3) || ($n_id==4) ||($n_id==8) ){ ?>
				   <input type="hidden" name="<? echo $n_st_val_name; ?>" value="<?php  echo $bGlist[$n_st_val_name]; ?>" />
				  
				  <? } ?>
				  <!---->
				  <? 
				   if($n_id==1){
				  ?>
				   <input type="hidden" name="<? echo $n_cur_val_name; ?>" value="<?php  echo $uhip; ?>" />

				  <?
					}
				  elseif($n_id==2){
				  ?>
				   <input type="hidden" name="<? echo $n_cur_val_name; ?>" value="<?php  echo $uthighs; ?>" />
				  <? } 
				  elseif($n_id==3){
				  ?>
				   <input type="hidden" name="<? echo $n_cur_val_name; ?>" value="<?php  echo $ubodyfat; ?>" />
				  <? } 
				  elseif($n_id==4){
				  ?>
				   <input type="hidden" name="<? echo $n_cur_val_name; ?>" value="<?php  echo $uweight; ?>" />
				  <? } 
				  elseif($n_id==8){
				  ?>
				   <input type="hidden" name="<? echo $n_cur_val_name; ?>" value="<?php  echo $uwaist; ?>" />
				  <?
				   } 
			       ?>
				  <!---->
                  <label class="current"><? echo $n_options; ?> <br/><span class="start_val">Start =&nbsp;
				  
				  <? if(($n_id==5) ||($n_id==6) || ($n_id==7)){ ?>
				 
				 <input type="text" name="<? echo $n_st_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_st_val_name];?>" />                 </span>&nbsp;<? echo $n_unit; ?></label>
				  <?php }else {echo $bGlist[$n_st_val_name]; ?> 
				  &nbsp;<? echo $n_unit; ?></span></label>
				  
				  <? } ?>
				  
				  <? 
				  if(($n_id==5) ||($n_id==6) || ($n_id==7)){ ?>
				  <p style="width:128px;">Current = <span class="units_label"><? echo $n_unit; ?></span><input type="text" name="<? echo $n_cur_val_name; ?>" class="goal" value="<? echo $bGlist[$n_cur_val_name]; ?>" /><br />
				<label class="bgoal">Goal =</label><span class="units_label"><? echo $n_unit; ?></span><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" /></p>
				  <? 

				  }elseif($n_id==1){ ?> 
				  	  <p>Current = </span><?php  echo $uhip; ?>&nbsp;<? echo $n_unit; ?><br />
				 
				     <label class="bgoal">Goal =</label><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" />
					 </p>
				  
				  <? }elseif($n_id==2){ ?>
				  	  <p>Current = </span><?php  echo $uthighs; ?>&nbsp;<? echo $n_unit; ?><br />
				 
				     <label class="bgoal">Goal =</label><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" />
				   </p>
				   
				  <? }elseif($n_id==3){ ?>
				  	  <p>Current = </span><?php  echo $ubodyfat; ?>&nbsp;<? echo $n_unit; ?><br />
				 
				     <label class="bgoal">Goal =</label><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" />
					  </p>
				  
				  <? }elseif($n_id==4){ ?>
				  	  <p>Current = </span><?php  echo $uweight; ?>&nbsp;<? echo $n_unit; ?><br />
				 
				     <label class="bgoal">Goal =</label><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" />
					  </p>
				  
				  <? }elseif($n_id==8){ ?>
				  	  <p>Current = </span><?php  echo $uwaist; ?>&nbsp;<? echo $n_unit; ?><br />
				 
				     <label class="bgoal">Goal =</label><input type="text" name="<? echo $n_goal_val_name; ?>" class="goal" value="<?php  echo $bGlist[$n_goal_val_name]; ?>" />
					  </p>
				  
				  <? } ?>
				   <!---->
				   
				   
				   
				   
				   
				<div id="b<? echo $n_id; ?>">  <img id="<? echo $n_id; ?>" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
							 
				  <span id="featureVal<? echo $n_id; ?>"></span>
               </fieldset>
			<? } ?>
			
			
			
			
		
             <fieldset class="btn saveBtn">
			 <input type="submit" name="upbonus" id="featuresave" value="" /> 
			     <a class="close2" id="waistadd" href=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"/></a>
 
            	<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />         -->     
           </fieldset>
             </form>
        </div>
		
		
		
 <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
  </div>
  <? } ?>