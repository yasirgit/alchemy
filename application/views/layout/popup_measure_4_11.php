<div class="popup-measurement" id="popup-measurement" >
  <div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
    <div class="top-mid">
      <h2>My Measurements</h2>
    </div>
    <div class="top-right"> </div>
  </div>
  <div class="popup-middle">
    <h2 class="heading">My Measurements<span>Record your starting weight and take your initial body measurements with a measuring tape (cloth measuring 
        tape preffered.). If you find it difficult to do your own measurements, enlist the help of a friend to make it easier.</span></h2>
         <div class="popup_pagination">
              <a href="" class="no-underline">&lt; Prev</a>|
        	   <a href=""> 1</a>|
              <a href="">2</a>|
              <a href="">3</a>|
              <a href="">4</a>|
               <a href="" class="no-underline">Next &gt;</a>
			   <?php //echo $this->jquery_pagination->create_links()?>
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
			
			
			<div class="parent-table-wrapper">
			<?php
			$trackid = 1;
			if(count($rest_dayMsr)>0){
				foreach($rest_dayMsr as $rest)
				{
					if($first_dayMsr->um_id != $rest->um_id){
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
			}	
			?>
			</div>
			
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
				<label>Neck</label>
				
			  </li>
			  <li>
				<label>Neck</label>
				
			  </li>
			  <li class="col-end">
				<label>Neck</label>
				
			  </li>
			</ul>
			<fieldset class="btn">
				<input type="image" name="measur_can" class="cancelMeasure" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
				<input type="image" name="measur_sub" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />       
			</fieldset>
			
			</div>
	    </form>
    </div>
    <div class="right-side">
        <div class="neck-point"></div>
         <div class="chest-point"></div>
         <div class="arm-point"></div>
         <div class="waist-point"></div>
          <div class="hand-point"></div>
         <div class="wrist-point"></div>
         <div class="belly-point"></div>
         <div class="thumb-point"></div>
         <div class="leg-point"></div>
    
    </div>
  </div>
  