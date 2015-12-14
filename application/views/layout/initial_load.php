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
						                    var  id = 1;
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


<div class="popup_pagination"><?  //echo "INITIAL LOAD=".$total_col; ?>

       <div class="pagingDiv" style="width:303px; padding-left:10px;">
                     
                     <div class="pNo" style="text-align:center;"><?php echo "1" ;?></div>
                        <?php //echo $nav; ?>
						<div class="plist">
                       
	                    </div>
                     <div class="pNo"></div>
                     
			  </div>
        
       </div>
	   		<style>
				#popup-measurement {left:274px; position:absolute;}
				.measurement-auto { width:506px;}
				.measurement-auto .popup-middle{ width:auto; }
			</style>
	   
	   <div class="left-side"> 
		<?php
		$attributes = array('name' => 'upd_mesr', 'id' => 'upd_mesr');
		echo form_open('successjournal/updmeasure/', $attributes);
		?>
			<div class="left-table"  style="float:right;">
			<ul class="col-01">
			  <li class="col-head">Start <br />
				<?php echo date('m/d/y'); ?></li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="initial_col">&nbsp;</li>
			  <li class="col-end initial_col">&nbsp;</li>
			  <li class="col-head-02 initial_col">&nbsp;</li>
			  <li class="col-start initial_col2">&nbsp;</li>
			  <li class="initial_col2">&nbsp;</li>
			  <li class="col-end initial_col2">&nbsp;</li>
			</ul>
			
		<!--	<div id="test">-->
		 <div class="load_before4"  style="margin:auto; position:fixed; width:250px; top:300px; left:420px;"></div>	
	<!--	<div class="parent-table-wrapper" style="display:none;">

					<ul class="col-01">
					  <li class="col-head"  style="height:30px;"> <br />
					  </li>
						
					  <li class="initial_col">&nbsp;</li>
                      <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="initial_col">&nbsp;</li>
					  <li class="col-end initial_col">&nbsp;</li>
					  <li class="col-head-02 initial_col">&nbsp;</li>
					  <li class="col-start initial_col2">&nbsp;</li>
					  <li class="initial_col2" >&nbsp;</li>
					  <li class="col-end initial_col2">&nbsp;</li>
					</ul>
					
			</div>-->
	
	
			<!--</div>-->

			
			<ul class="col-01 summary-table">
			  <li class="col-head" style="height:30px; line-height:42px;">Change 
			  </li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="initial_col"></li>
			  <li class="col-end initial_col"></li>
			  <li class="col-head-02 initial_col"></li>
			  <li class="col-start initial_col2"></li>
			  <li class="initial_col2"></li>
			  <li class="col-end initial_col2"></li>
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
				<label>Lean Body Maas</label>
				
			  </li>
			</ul>
			<div style="clear:both"></div>
			<fieldset class="usmbtn">

				<a class="close2" onclick="return false;"><img align="absmiddle" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"></a>
				<input type="image" name="measur_sub" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" id="measur_sub" />       
			</fieldset>
			
			</div>
	    </form>
   