<div id="plangoalloading" style="position:fixed;z-index: 215;display:none;margin: 65px 0 0 215px;"><img src="htdocs/images/final_loading_big.gif"></div>
<div class="top" id="plan_goal_top">
		<a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
		<div class="top-mid">
			   <h2>Plan Goals</h2>
		</div>
		<div class="top-right"></div>
</div>
<div class="popup-middle">	
	<h2 class="heading">Goals<span>Select the 6 goals to display on the Success Journal page and the frequency options to your goals below.</span></h2>
	<form action="#" class="feature formPlangoal" id="goal_plan_form">
		<?php
		  $goal_plan_users = $goal_plan_user->result();
		  //print_r($goal_plan_list);
		  foreach ($goal_plan->result() as $goal_plan_list):
		?>
		<script>
			$(document).ready(function () {
				$("#checked_<?php echo $goal_plan_list->id; ?>").click(function () {
				   if($(this).is(':checked')){						
						$("#time_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
				   }
				   else{
					   $("#time_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
				   }
				});

			   if($('#checked_<?php echo $goal_plan_list->id; ?>').is(':checked')){
					$("#time_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
			   }
			   else{
				   $("#time_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
			   }

				$("#time_<?php echo $goal_plan_list->id; ?>").click(function () {
					if($("#time_<?php echo $goal_plan_list->id; ?>").val() != ''){
						$("#checked_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#mon_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#tue_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#wed_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#thu_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#fri_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#sat_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#sun_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
					}
					else{
					   $("#checked_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#mon_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#tue_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#wed_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#thu_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#fri_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#sat_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#sun_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
				   }
				});

					if($("#time_<?php echo $goal_plan_list->id; ?>").val() != ''){
						$("#checked_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#mon_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#tue_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#wed_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#thu_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#fri_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#sat_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
						$("#sun_<?php echo $goal_plan_list->id; ?>").attr("disabled", "disabled");
					}
					else{
					   $("#checked_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#mon_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#tue_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#wed_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#thu_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#fri_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#sat_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
					   $("#sun_<?php echo $goal_plan_list->id; ?>").removeAttr("disabled");
				   }
			});
		</script>
		<fieldset>
			   <div class="checkItem">
				  <label>Display</label>
				  <input type="checkbox"
						<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id)  echo "checked='checked'";  } ?>
						 class="goal_plan_class" name="goal_plan_id[]" value="<?php echo $goal_plan_list->id; ?>" />
			   </div>
				 <div class="displayTime">
				 <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td valign="middle" height="50"><?php echo $goal_plan_list->title; ?></td>
					</tr>
				 </table>
				 
			   </div>
			   <div class="displayItem">
			   <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
				  <tr>
					<td width="100" align="center"><label>Times Per Week</label>
						   <select name="time_per_week_gp_<?php echo $goal_plan_list->id; ?>" id="time_<?php echo $goal_plan_list->id; ?>">
							   
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '')  echo "selected='selected'";  } ?>
									value="">Select</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '1')  echo "selected='selected'";  } ?>
									value="1">1</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '2')  echo "selected='selected'";  } ?>
									value="2">2</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '3')  echo "selected='selected'"; } ?>
									value="3">3</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '4')  echo "selected='selected'";  } ?>
									value="4">4</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '5')  echo "selected='selected'";  } ?>
									value="5">5</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '6')  echo "selected='selected'";  } ?>
									value="6">6</option>
								<option
									<?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == '7')  echo "selected='selected'";  } ?>
									value="7">7</option>
							</select>
						</td>
						<td width="25" align="center"> or</td>
						<td width="35" align="center"><label>Daily</label>
							<input type="checkbox"
								   <?php if(isset($goal_plan_users)) foreach ($goal_plan_users as $goal_plan){  if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily')  echo "checked='checked'";  } ?>
								   id="checked_<?php echo $goal_plan_list->id; ?>" name="daily_gp_<?php echo $goal_plan_list->id; ?>" value="daily" />
						</td>
				  </tr>
			   </table>
			   </div>
			   <div class="displayDay">
				  <label>Mon</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'mon') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="mon_<?php echo $goal_plan_list->id; ?>" name="mon_gp_<?php echo $goal_plan_list->id; ?>" value="mon" />
			   </div>
				 <div class="displayDay">
				  <label>Tue</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'tue') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="tue_<?php echo $goal_plan_list->id; ?>" name="tue_gp_<?php echo $goal_plan_list->id; ?>" value="tue" />
			   </div>
				<div class="displayDay">
				  <label>Wed</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'wed') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="wed_<?php echo $goal_plan_list->id; ?>" name="wed_gp_<?php echo $goal_plan_list->id; ?>" value="wed" />
			   </div>  
			   <div class="displayDay">
				  <label>Thu</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'thu') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="thu_<?php echo $goal_plan_list->id; ?>" name="thu_gp_<?php echo $goal_plan_list->id; ?>" value="thu" />
			   </div>
				<div class="displayDay">
				  <label>Fri</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'fri') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="fri_<?php echo $goal_plan_list->id; ?>" name="fri_gp_<?php echo $goal_plan_list->id; ?>" value="fri" />
			   </div>
				<div class="displayDay">
				  <label>Sat</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'sat') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="sat_<?php echo $goal_plan_list->id; ?>" name="sat_gp_<?php echo $goal_plan_list->id; ?>" value="sat" />
			   </div>
				 <div class="displayDay">
				  <label>Sun</label>
				  <input type="checkbox"
						 <?php
						 if(isset($goal_plan_users)){
							 foreach ($goal_plan_users as $goal_plan)
								 {
									 if($goal_plan->goal_plan_id == $goal_plan_list->id && $goal_plan->time_day == 'daily'){
										 $ex = explode(',', $goal_plan->day_list);
										 $count_ex = count($ex);
										 for($c = 0; $c < $count_ex; $c++){
											 if($ex[$c] == 'sun') echo "checked='checked'";
										 }
									 }
								 }
						 }
						 ?>
						 id="sun_<?php echo $goal_plan_list->id; ?>" name="sun_gp_<?php echo $goal_plan_list->id; ?>" value="sun" />
			   </div>
			</fieldset>
		<?php endforeach; ?>
		<label class="error" style="display: none; color: red;">select exactly 6 goals</label>
		<input type="hidden" name="userId" value="<?php echo $user['id']; ?>" />
			  <fieldset class="btn saveBtn">
				<input type="image" class="cancelbtn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" />
				<input type="image" id="submit_btn" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" />
			 </fieldset>
	</form>
</div>
<div class="bottom">
	<div class="bottom-mid">
	</div>
	<div class="bottom-right">
	</div>
</div>