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
											$('.load_before3').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/final_loading_big.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                  
										   $("#bonus-box").load('successjournal/ajax_bonus_load');
										   $('.load_before3').css('display',"none");
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
<? ?>

<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>   

        <div class="popup-middle">
            <p class="heading"> Inches Lost - My Waist </p>
        	<div class="bonus-goal-graph">
            </div>
			<form action="successjournal/bonus_entry" class="feature" method="post" name="bonus_entry" id="bonus_entry">
			
            <p class="graph-calc"><input type="hidden" name="cur_waist" value="<?php echo $uwaist ;?>" />
			   <input type="hidden" name="st_waist" value="<?php  echo $first_dayMsr->um_waist; ?>" />
			   <label style="width:108px; font-size:13px;">Current = <?php echo $uwaist ;?>  in<br/>Start =<? echo $first_dayMsr->um_waist;?>&nbsp;in</label> 
			   <span><label style="font-size:13px;">Goal = </label><span style="float:right; width:15px; font-size:13px;">&nbsp;in</span><input type="text" name="gl_waist" value="" /></span>
			</p>
			
			 <div class="load_before3"  style="margin:auto; position:fixed; width:250px; top:300px; left:500px;"></div>
			 
             <p class="heading" style="padding-top:5px;">Other Options</p>

               <fieldset>
			      <input type="hidden" name="cur_hips" value="<?php echo $uhip ;?>" />
				  <input type="hidden" name="st_hips" value="<?php  echo $first_dayMsr->um_hips; ?>" />
                  <label class="current">Inches Lost - My Hips <br/><span class="start_val">Start =&nbsp;<? echo $first_dayMsr->um_hips;?> in</span></label><p>Current = <?php echo $uhip ;?> in<br /><label class="bgoal">Goal = </label><input type="text" name="gl_hips" class="goal" />
				<div id="b1">  <img id="1" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
							 
				  <span id="featureVal1"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_thighs" value="<?php echo $uthighs ;?>" />
				  <input type="hidden" name="st_thighs" value="<?php echo $first_dayMsr->um_thighs; ?>" />
                  <label class="current">Inches Lost - My Thighs <br/> <span class="start_val">Start =&nbsp;<? echo $first_dayMsr->um_thighs;?> in</span></label><p>Current = <?php echo $uthighs ;?>  in<br /><label class="bgoal">Goal = </label><input type="text" name="gl_thighs" class="goal" /></p>
				  <div id="b2"><img id="2" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
				
				  <span id="featureVal2"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_bodyfat" value="<?php echo $ubodyfat; ?>" />
				  <input type="hidden" name="st_bodyfat" value="<?php  echo $first_dayMsr->um_bodyfat; ?>" />
                  <label class="current">Reduce My Body Fat<br/> <span class="start_val">Start =&nbsp;<? echo $first_dayMsr->um_bodyfat; ?>&nbsp;%</span></label><p>Current = <?php  echo $ubodyfat; ?>&nbsp;%<br /><label class="bgoal">Goal = </label><input type="text" name="gl_bodyfat" class="goal" /></p>
				  <div id="b3"><img id="3" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" onclick="return check_feature()" ></div>
				  <span id="featureVal3"></span>
               </fieldset>
               <fieldset>
			      <input type="hidden" name="cur_weight" value="<?php echo $uweight ;?>" />
				  <input type="hidden" name="st_weight" value="<?php echo $first_dayMsr->um_bweight; ?>" />
                  <label class="current">Lose Weight<br/> <span class="start_val">Start =&nbsp;<? echo $first_dayMsr->um_bweight;?> lbs</span></label><p>Current = <?php echo $uweight ;?> lbs<br /><label class="bgoal">Goal = </label><input type="text" name="gl_weight" class="goal" /></p>
				  <div id="b4"><img id="4" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif"></div>
				  <span id="featureVal4"></span>
               </fieldset>
               <fieldset>
                  <label class="current">Reduce My Clothing Size<br/> <span class="start_val">Start =&nbsp;<input type="text" name="st_size" class="goal" value="" style="" /></span>&nbsp;size</label><p style="width:130px;">Current=  <span class="units_label">size</span><input type="text" name="cur_size" class="goal" value="" /><br /><label class="bgoal">Goal = </label><span class="units_label">size</span><input type="text" name="gl_size" class="goal" value="" /></p>
				  <div id="b5"><img id="5" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" ></div>
				  <span id="featureVal5"></span>
               </fieldset>
<!--               <fieldset>
                  <label class="current">Reduce My Blood Pressure<br/><span class="start_val">Start =&nbsp;<input type="text" name="st_blood" class="goal" value="" /></span></label><p>Current=  <input type="text" name="cur_blood" class="goal" /><br /><label class="bgoal">Goal = </label><input type="text" name="gl_blood" class="goal" /></p>
				  <div id="b6"><img id="6" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" onclick="return check_feature()" ></div>
				  <span id="featureVal6"></span>
               </fieldset>-->
               <fieldset>
                  <label class="current">Reduce My Cholesterol<br/><span class="start_val">Start =&nbsp;<input type="text" name="st_cholest" class="goal" value="" /></span>&nbsp;pts</label><p style="width:130px;">Current= <span class="units_label">pts</span><input type="text" name="cur_cholest" class="goal" /><br /><label class="bgoal">Goal = </label><span class="units_label">pts</span><input type="text" name="gl_cholest" class="goal" /></p>
				 <div id="b7"> <img id="7" class="featureBtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" ></div>
				  <span id="featureVal7"></span>
               </fieldset>
		
             <fieldset class="btn saveBtn">
			 <input type="submit" name="mm" id="featuresave" value="" /> 
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
  </div>