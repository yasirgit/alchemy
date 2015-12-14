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
					  <li><?php echo $rest->um_neck; ?> in</li>
					  <li><?php echo $rest->um_chest; ?> in</li>
					  <li><?php echo $rest->um_biceps; ?> in</li>
					  <li><?php echo $rest->um_forearms; ?> in</li>
					  <li><?php echo $rest->um_wrist; ?> in</li>
					  <li><?php echo $rest->um_waist; ?> in</li>
					  <li><?php echo $rest->um_hips; ?> in</li>
					  <li><?php echo $rest->um_thighs; ?> in</li>
					  <li class="col-end"><?php echo $rest->um_calves; ?> in</li>
					  <li class="col-head-02"><?php echo $rest->um_bweight; ?> lbs</li>
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
			
			<ul class="col-01 summary-table">
			  <li class="col-head">start <br />
				01/01/10</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li>12 in</li>
			  <li class="col-end">12 in</li>
			  <li class="col-head-02">210 lbs</li>
			  <li class="col-start">30%</li>
			  <li>30%</li>
			  <li class="col-end">30%</li>
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
				<label>Lean Body Masss</label>
				
			  </li>
			</ul>
			<div style="clear:both"></div>
			<fieldset class="usmbtn">

				<a class="close2" onclick="return false;"><img align="absmiddle" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"></a>
				<input type="image" name="measur_sub" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />       
			</fieldset>
			
			</div>
	    </form>
   