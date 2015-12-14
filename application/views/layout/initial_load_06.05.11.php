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
		      
            
		
               <div class="pagingDiv">
    
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
				</li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li></li>
			  <li class="col-end"></li>
			  <li class="col-head-02"></li>
			  <li class="col-start">30%</li>
			  <li>30%</li>
			  <li class="col-end">30%</li>
			</ul>
			
		<!--	<div id="test">-->
			
		<div class="parent-table-wrapper">
		
					<ul class="col-01 ">
					  <li class="col-head">start <br />
						</li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li></li>
					  <li class="col-end"></li>

					  <li class="col-head-02"></li>
					  <li class="col-start">30%</li>
					  <li>30%</li>
					  <li class="col-end">30%</li>
					</ul>
					
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
   