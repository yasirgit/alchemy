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
				 	//alert(success);
					$('#test').html(success);
                    // success.html(html);
                  }
               });               
       	  
		 });              
       return false;
     });  
</script>
<?php
if($last_dayMsr)
{  //echo "hhh";
foreach($last_dayMsr as $toallum)
{
      $thigh = $toallum['um_thighs'];
	  $hip = $toallum['um_hips'];
	  $calf = $toallum['um_calves'];
	  $wrist = $toallum['um_wrist'];
	  $waist = $toallum['um_waist'];
	  $forearms = $toallum['um_forearms'];
	  $weight = $toallum['um_bweight'];
}

foreach($uacDate as $ures)
{
   
   $birthDay=strtotime($ures['birthdate']);
   $toDate = date('y-m-d'); 
   $countAge = strtotime($toDate)-strtotime($birthDay);
   $age = floor(($countAge/(60*60*24))/365);
   

   
   if($ures['sex']=='Male')
   {
       if($age <= 30)
	   {  
	        // Male 30 years old or less= waist + (hips x 0.5) - (forearms x 3.0) - wrist = % body fat
	      $bodyfat = $waist + ($hip * 0.5) - ($forearms * 3.0) - $wrist ;  
		                  
	   }else{
	       //Male 31 years old or more= waist + (hips x 0.5) - (forearms x 2.7) - wrist = % body fat
		  $bodyfat = $waist + ($hip * 0.5) - ($forearms * 2.7) - $wrist;   
	   }
	   
	  //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 
	      $fatWeight =  $weight *  $bodyfat;   
	 //Lean Body Mass = (My Body Weight)  –  (My Fat Weight)
	      $leanBodyMass = $weight - $fatWeight;
   }
   else if($ures['sex']=='Female')
   {
       if($age <= 30)
	   {
	      //Female 30 years old or less= hips + (thigh x 0.8) - (calf x 2.0) - wrist = % body fat
		  $bodyfat = $hip + ($thigh * 0.8) - ($calf * 2.0) - $wrist ; 
		   
	   }else{
	       //Female 31 years old or more= hips + thigh - (calf x 2.0) - wrist = % body fat
		  $bodyfat = $hip + $thigh - ($calf * 2.0) - $wrist ; 
	   }
	   //Fat Weight =  (My Body Weigh) x  (My % Body Fat) 
	  $fatWeight =  $weight *  $bodyfat; 
	  $leanBodyMass = $weight - $fatWeight;
   }
}
}else
{
   $bodyfat = 0;
   $fatWeight = 0;
   $leanBodyMass = 0;
}
?>

<div class="popup_pagination">
		      
             <!-- <a href="<?php echo $i; ?>" id="<?php echo $i; ?>" onclick="return false;" class="goto"><?php echo $i; ?></a>-->
		
               <div class="pagingDiv">
                     
                     <div class="pNo"><?php echo $prev ;?></div>
                        <?php //echo $nav; ?>
						<div class="plist">
                         <?php 
	   
	                         if($list1<=$maxPage)
		                     {   
		                         echo "<span class='goto_bar'>|</span>";
								 echo  "<a href='#' class='goto' id='$page' onclick='return false;'>$list1</a>";
								 echo "<span class='goto_bar'>|</span>";
								 
		                     }
		                     if(($list2<=$maxPage) && ($list2!=''))
		                     {
		                         echo  "<a href='#' class='goto' id='$page' onclick='return false;'>$list2</a>";
								 echo "<span class='goto_bar'>|</span>";
		                     }
		                     if(($list3<=$maxPage) && ($list3!=''))
		                     {
		                         echo  "<a href='#' class='goto' id='$page' onclick='return false;'>$list3</a>";
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
			  <li class="col-head">start <br />
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
			  <li class="col-start">30%</li>
			  <li>30%</li>
			  <li class="col-end">30%</li>
			</ul>
			
		<!--	<div id="test">-->
			
		<div class="parent-table-wrapper">
			<?php
			
			
			$trackid = 1; 
			if(count($first_page_res)>0){
				foreach($first_page_res as $rest)
				{        
					
					//echo $trackid;
					?>
					<ul class="col-01 <?php if(($trackid%6) == 0) { echo "col-01-last"; } ?>">
					  <li class="col-head">start <br />
						<?php echo date('m/d/y', strtotime($rest->um_date)); ?></li>
						
					  <li <?php if($rest->um_neck!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_neck!=0){ echo $rest->um_neck; }else {echo "";}?> in</li>
					  
					  <li <?php if($rest->um_chest!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_chest!=0){ echo $rest->um_chest; echo "in"; }else {echo "";}?></li>
					  
					  <li <?php if($rest->um_biceps!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_biceps!=0){ echo $rest->um_biceps; echo "in";} else {echo "";} ?></li>
					  
					  <li <?php if($rest->um_forearms!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_forearms!=0){ echo $rest->um_forearms; echo "in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_wrist!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_wrist!=0){ echo $rest->um_wrist; echo "in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_waist!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_waist!=0){ echo $rest->um_waist; echo "in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_hips!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_hips!=0){ echo $rest->um_hips; echo "in";} else {echo "";} ?></li>
					  <li <?php if($rest->um_thighs!=0) {echo "class='col_hasitem'";} else {echo "class='col_noitem'";} ?>><?php if($rest->um_thighs!=0){ echo $rest->um_thighs; echo "in";} else {echo "";} ?></li>
					  <li class="col-end <?php if($rest->um_calves!=0) {echo "col_hasitem";} else {echo "class='col_noitem'";} ?>"><?php if($rest->um_calves!=0){ echo $rest->um_calves; echo "in";} else {echo "";} ?></li>
					  <li class="col-head-02 <?php if($rest->um_bweight!=0) {echo "col_hasitem";} else {echo "class='col_noitem'";} ?>"><?php if($rest->um_bweight!=0){ echo $rest->um_bweight; echo "lbs";} else {echo "";} ?></li>
					  <li class="col-start">30%</li>
					  <li>30%</li>
					  <li class="col-end">30%</li>
					</ul>
					<?php
					$trackid++;
					
				}
			}	
			?>
			</div>
	
	
			<!--</div>-->
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
				}
				
				
			 }
			 
			?>
			
			<ul class="col-01 summary-table">
			  <li class="col-head" style="height:28px;">Change 
			  </li>
			  <li><?php echo $df_um_neck ; ?> in</li>
			  <li><?php echo $df_um_chest ; ?> in</li>
			  <li><?php echo $df_um_biceps ; ?> in</li>
			  <li><?php echo $df_um_forearms ; ?>in</li>
			  <li><?php echo $df_um_wrist ; ?> in</li>
			  <li><?php echo $df_um_waist ; ?> in</li>
			  <li><?php echo $df_um_hips ; ?> in</li>
			  <li><?php echo $df_um_thighs ; ?> in</li>
			  <li class="col-end"><?php echo $df_um_calves ; ?> in</li>
			  <li class="col-head-02"><?php echo $df_um_bweight ; ?> lbs</li>
			  <li class="col-start"><?php echo $bodyfat; ?> %</li>
			  <li><?php echo $fatWeight; ?> %</li>
			  <li class="col-end"><?php echo $leanBodyMass; ?> %</li>
			</ul>
			
			
			<ul class="col-01 form-table">
			  <li class="col-head">Today <br />
				<?php echo date("m/d/y"); ?></li>
			  <li>
				<label>Neck</label>
				<input type="text" name="m_neck" value="" />
			  </li>
			  <li>
				<label>Chest</label>
				<input type="text" name="m_chest" value="" />
			  </li>
			  <li>
				<label>Biceps</label>
				<input type="text" name="m_biceps" value="" />
			  </li>
			  <li>
				<label>Forearms</label>
				<input type="text" name="m_forearms" value="" />
			  </li>
			  <li>
				<label>Wrist</label>
				<input type="text" name="m_wrist" value="" />
			  </li>
			  <li>
				<label>Waist</label>
				<input type="text" name="m_waist" value="" />
			  </li>
			  <li>
				<label>Hips</label>
				<input type="text" name="m_hips" value="" />
			  </li>
			  <li>
				<label>Thighs</label>
				<input type="text" name="m_thighs" value="" />
			  </li>
			  <li class="col-end">
				<label>Calves</label>
				<input type="text" name="m_calves" value="" />
			  </li>
			  <li class="col-head-02">
				<label>Body Weight</label>
				<input type="text" name="body_wegt" value="" />
			  </li>
			  <li class="col-start">
				<label>%Body Fat</label>
				
			  </li>
			  <li>
				<label>Fat Weight</label>
				
			  </li>
			  <li class="col-end">
				<label>Lean Body Maa</label>
				
			  </li>
			</ul>
			<div style="clear:both"></div>
			<fieldset class="usmbtn">

				<a class="close2" onclick="return false;"><img align="absmiddle" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"></a>
				<input type="image" name="measur_sub" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />       
			</fieldset>
			
			</div>
	    </form>
   