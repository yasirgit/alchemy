<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".goto").click(function() {   

            var  id = $(this).attr("id");
			
			var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_paging";
	   	
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "p="+id,
                 success: function(success){
	
					$('#test').html(success);

                    // success.html(html);
						
                   
                  }
               });               
       	  
		 });  
		 
				 
	 	$("#measur_sub").click(function() { 
	  
			$('#upd_mesr').ajaxSubmit(
			{
						url:			"successjournal/updmeasure",
						type:			'post',	
						beforeSubmit:	function()
										{
										   $('.load_before4').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/final_loading_big.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                    //alert("Success");
										     var  id = "<? echo $maxPage;?>";
											 var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_paging";
										     $.ajax({
                                                 type: "POST",
                                                 url:url ,
				                                 data: "p="+id,
                                                 success: function(success){
					                             $('#test').html(success);
                                                }
                                             });         
                                          
   
										}
										
			});
			
			return false;
        });	  
		  

         
       return false;
     });  
</script>


<div class="popup_pagination"><? // echo "MID PAGE LOAD=".$total_col; ?>
		      
             <!-- <a href="<?php echo $i; ?>" id="<?php echo $i; ?>" onclick="return false;" class="goto"><?php echo $i; ?></a>-->
		
                <div class="pagingDiv">
                     
                     <div class="pNo"><?php echo $prev ;?></div>
                        <?php //echo $nav; ?>
						<div class="plist">
                         <?php 
	   
	                         if($list1<=$maxPage)
		                     {   
		                         echo "<span class='goto_bar'>|</span>";  
                                 if($page==$list1){
								 echo  "<a href='#' class='active' id='$list1' onclick='return false;'>$list1</a>";
								 }
								 else{
								 echo  "<a href='#' class='goto' id='$list1' onclick='return false;'>$list1</a>";
								 }
								 echo "<span class='goto_bar'>|</span>";
								 
		                     }
		                     if(($list2<=$maxPage) && ($list2!=''))
		                     {
		                         if($page==$list2){
								 echo  "<a href='#' class='active' id='$list2' onclick='return false;'>$list2</a>";
								 }
								 else{
								 echo  "<a href='#' class='goto' id='$list2' onclick='return false;'>$list2</a>";
								 }
								 echo "<span class='goto_bar'>|</span>";
		                     }
		                     if(($list3<=$maxPage) && ($list3!=''))
		                     {
		                        if($page==$list3){
								 echo  "<a href='#' class='active' id='$list3' onclick='return false;'>$list3</a>";
								}
								else{
								 echo  "<a href='#' class='goto' id='$list3' onclick='return false;'>$list3</a>";
								 }
								 echo "<span class='goto_bar'>|</span>";
		                     }
		
	                    ?>
	                  </div>
                     <div class="pNo"><?php echo $next; ?></div>
                     
			  </div>
        
 </div>
	   
	   <div class="left-side"> 
		<?php
		$attributes = array('name' => 'upd_mesr', 'id' => 'upd_mesr');
		echo form_open('successjournal/updmeasure/', $attributes);
		?>
			<div class="left-table">
			<ul class="col-01">
			  <li class="col-head">Start <br />
				<?php echo date('m/d/y', strtotime($first_dayMsr->um_date)); ?></li>
			  <li><?php echo $first_dayMsr->um_neck; ?> in</li>
			  <li><?php echo $first_dayMsr->um_chest; ?> in</li>
			  <li><?php echo $first_dayMsr->um_biceps; ?> in</li>
			  <li><?php echo $first_dayMsr->um_forearms; ?> in</li>
			  <li><?php echo $first_dayMsr->um_wrist; ?> in</li>
			  <li><?php echo $first_dayMsr->um_waist; ?> in</li>
			  <li><?php echo $first_dayMsr->um_hips; ?> in</li>
			  <li><?php echo $first_dayMsr->um_thighs; ?> in</li>
			  <li class="col-end"><?php echo $first_dayMsr->um_calves; ?> in</li>
			  <li class="col-head-02"><?php echo $first_dayMsr->um_bweight; ?> lbs</li>
			  <li class="col-start"  style="color:#F7F9C8;"><?php echo $first_dayMsr->um_bodyfat; ?> %</li>
			  <li  style="color:#F7F9C8;"><?php echo $first_dayMsr->um_fatweight; ?> </li>
			  <li class="col-end"  style="color:#F7F9C8;"><?php echo $first_dayMsr->um_leanbodymass; ?> </li>
			</ul>
			
		 <div class="load_before4"  style="margin:auto; position:fixed; width:250px; top:300px; left:420px;"></div>	
			
		<div class="parent-table-wrapper new_wrapper">
			<?php
			
			
			$trackid = 1; 
			if(count($first_page_res)>0){
				foreach($first_page_res as $rest)
				{        
					
					//echo $trackid;
					?>
					<ul class="col-01 <?php if(($trackid%6) == 0) { echo "col-01-last"; } ?>">
					  <li class="col-head"><br />
						<?php echo date('m/d/y', strtotime($rest->um_date)); ?></li>
						
					  <li <?php if($rest->um_neck!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_neck!=0){ echo $rest->um_neck; echo " in";  }else {echo "";}?> </li>
					  
					  <li <?php if($rest->um_chest!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_chest!=0){ echo $rest->um_chest; echo " in"; }else {echo "";}?></li>
					  
					  <li <?php if($rest->um_biceps!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_biceps!=0){ echo $rest->um_biceps; echo " in";} else {echo "";} ?></li>
					  
					  <li <?php if($rest->um_forearms!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_forearms!=0){ echo $rest->um_forearms; echo " in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_wrist!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_wrist!=0){ echo $rest->um_wrist; echo " in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_waist!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_waist!=0){ echo $rest->um_waist; echo " in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_hips!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_hips!=0){ echo $rest->um_hips; echo " in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_thighs!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_thighs!=0){ echo $rest->um_thighs; echo " in";} else {echo "";} ?></li>
					  <li class="col-end <?php if($rest->um_calves!=0) {echo "col_hasitem";} else {echo "col_noitem";} ?>"><?php if($rest->um_calves!=0){ echo $rest->um_calves; echo " in";} else {echo "";} ?></li>
					  <li class="col-head-02 <?php if($rest->um_bweight!=0) {echo "col_hasitem";} else {echo "col_noitem";} ?>"><?php if($rest->um_bweight!=0){ echo $rest->um_bweight; echo " lbs";} else {echo "";} ?></li>
					  <li class="col-start"  style="color:#F7F9C8;"><?php echo $rest->um_bodyfat; ?> %</li>
					  <li  style="color:#F7F9C8;"><?php echo $rest->um_fatweight; ?> </li>
					  <li class="col-end"  style="color:#F7F9C8;"><?php echo $rest->um_leanbodymass; ?> </li>
					</ul>
					<?php
					$trackid++;
					
				}
			}	
			?>
			</div>
	
	
			
			<?php
			if(count($last_dayMsr)>0) {
			
			    foreach($last_dayMsr as $last){
				  $df_um_neck = $last['um_neck']-$first_dayMsr->um_neck;
				  $df_um_chest = $last['um_chest']-$first_dayMsr->um_chest;
				  $df_um_biceps = $last['um_biceps']-$first_dayMsr->um_biceps;
				  $df_um_forearms = $last['um_forearms']-$first_dayMsr->um_forearm;
				  $df_um_wrist = $last['um_wrist']-$first_dayMsr->um_wrist;
				  $df_um_waist = $last['um_waist']-$first_dayMsr->um_waist;
				  $df_um_hips = $last['um_hips']-$first_dayMsr->um_hips;
				  $df_um_thighs = $last['um_thighs']-$first_dayMsr->um_thighs;
				  $df_um_calves = $last['um_calves']-$first_dayMsr->um_calves;
				  $df_um_bweight = $last['um_bweight']-$first_dayMsr->um_bweight;
				  $df_um_bodyfat = $last['um_bodyfat']-$first_dayMsr->um_bodyfat;
				  $df_um_fatweight = $last['um_fatweight']-$first_dayMsr->um_fatweight;
				  $df_um_leanbodymass = $last['um_leanbodymass']-$first_dayMsr->um_leanbodymass;
				}
				
				
			 }
			 
			?>
			<?
			  
			  if($total_col==1)
			  {
			     $prewidth=507;
				 $cal_width = $total_col*81;
				 $width = $cal_width+$prewidth;
				 $left=240;
			  }
			  else if($total_col>1 && $total_col<6 ){
			     $prewidth=520;
			     $cal_width = $total_col*68;
				 $width = $cal_width+$prewidth;
				 $preleft=30*$total_col;
				 $left=240-$preleft;
			  }
			  if($total_col==6)
			  {
			   $width=934;
			   $left=35.5;
			  }
			 
			 
			?>
			<style>
				#popup-measurement { width:<? echo $width; ?>px; left:<? echo $left; ?>px; position:absolute;}
				.measurement-auto .popup-middle{ widows:auto; }
			</style>
			<ul class="col-01 summary-table">
			  <li class="col-head" style="height:30px; line-height:42px;">Change 
			  </li>
			  <li><?php echo $df_um_neck ; ?> in</li>
			  <li><?php echo $df_um_chest ; ?> in</li>
			  <li><?php echo $df_um_biceps ; ?> in</li>
			  <li><?php echo $df_um_forearms ; ?>in</li>
			  <li><?php echo $df_um_wrist ; ?> in</li>
			  <li><?php echo $df_um_waist ; ?> in</li>
			  <li><?php echo $df_um_hips ; ?> in</li>
			  <li><?php echo $df_um_thighs ; ?> in</li>
			  <li class="col-end" ><?php echo $df_um_calves ; ?> in</li>
			  <li class="col-head-02"><?php echo $df_um_bweight ; ?> lbs</li>
			  <li class="col-start"  style="color:#F7F9C8;"><?php echo $df_um_bodyfat; ?> %</li>
			  <li  style="color:#F7F9C8;"><?php echo $df_um_fatweight; ?> </li>
			  <li class="col-end"  style="color:#F7F9C8;"><?php echo $df_um_leanbodymass; ?> </li>
			</ul>
			
			
			<ul class="col-01 form-table">
			  <li class="col-head" style="padding:11px 0 12px;">Today <br />
				<?php echo date("m/d/y"); ?></li>
			  <li>
				<label>Neck:</label>
				<input type="text" name="m_neck" value="" />
			  </li>
			  <li>
				<label>Chest:</label>
				<input type="text" name="m_chest" value="" />
			  </li>
			  <li>
				<label>Biceps:</label>
				<input type="text" name="m_biceps" value="" />
			  </li>
			  <li>
				<label>Forearms:</label>
				<input type="text" name="m_forearms" value="" />
			  </li>
			  <li>
				<label>Wrist:</label>
				<input type="text" name="m_wrist" value="" />
			  </li>
			  <li>
				<label>Waist:</label>
				<input type="text" name="m_waist" value="" />
			  </li>
			  <li>
				<label>Hips:</label>
				<input type="text" name="m_hips" value="" />
			  </li>
			  <li>
				<label>Thighs:</label>
				<input type="text" name="m_thighs" value="" />
			  </li>
			  <li class="col-end">
				<label>Calves:</label>
				<input type="text" name="m_calves" value="" />
			  </li>
			  <li class="col-head-02" style="height:18px;">
				<label>Body Weight:</label>
				<input type="text" name="body_wegt" value="" />
			  </li>
			  <li class="col-start"  style="height:20px;">
				<label style="color:#F7F9C8;">%Body Fat:</label>
				
			  </li>
			  <li  style="height:20px;color:#F7F9C8;">
				<label>Fat Weight:</label>
				
			  </li>
			  <li class="col-end"  style="height:20px;color:#F7F9C8;">
				<label>Lean Body Maas:</label>
				
			  </li>
			</ul>
			<div style="clear:both"></div>
			<fieldset class="usmbtn">

				<a class="close2" onclick="return false;"><img align="absmiddle" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"></a>
				<input type="image" name="measur_sub" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value=""  id="measur_sub" />       
			</fieldset>
			<? echo form_close(); ?>
			</div>
	    
        </div>