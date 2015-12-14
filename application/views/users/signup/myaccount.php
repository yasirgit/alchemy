
<?php
$bInfo=array(); 
echo $this->load->view('users/banner',$bInfo); ?>
<div class="how-do-use" style="height:12px;"></div>
	<form action="users/myAccount" method="post" class="signup-form signup-form-update">
		<fieldset>
          <div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="block-in-title-blue title-blue-wider" style="line-height:normal;">
							<h2 style="line-height:normal;">My Account Details</h2>
							<span style="">All fields required</span>
						</div>
						<div class="signup-type signup-type-up">							
						<?php ?> 
							<div style="font-weight:bold;color:#CC0000;">
								<?php
									if(!empty($error)) { echo "<br />".$error."<br />"; }
									echo validation_errors();
								
									foreach($uerror as $key=>$value)
									{
										if($key=="update_complete")
										echo "<span style='color:green;'>".$value."</span><br />";
										else
										echo $value."<br />";
									}																									
								?>
							</div>
							<?php
							?>
							<div class="row">
								<div class="insFieldset">
                                                        <label>First Name:</label>
                                                            <div>
                                                            <span class="text"><input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /></span>
                                                            </div>
                                                            <br class="clear" />
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Last Name:</label>
                                                            <div><span class="text"><input type="text" name="last_name" value="<?php echo $user['last_name']; ?>"  /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Email:</label>
                                                            <div><span class="text"><input type="text" name="email" value="<?php echo $user['email']; ?>" readonly /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Birthdate:</label>
                                                            <div class="define-width">
                                                            <!--<span class="text dd-size"><input type="text" name="dbday" value="<?php //echo substr($user['birthdate'],8); ?>"  /></span>--><span class="text dd-size"><select class="" name="dmonth">
															<?php for($i=0; $i<=11;$i++){ 
															 $month=array(Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec);
															?>
															<option value="<? echo $i+1; ?>" <?php echo substr($user['birthdate'],5,2)==$i+1?" selected":""; ?>><? echo $month[$i]; ?></option>
															<?
															}?>
															</select>
															</span>
                                                                <span class="slash-place">/</span>
                                                               <!-- <span class="text mm-size"><input type="text" name="dmonth" value="<?php //echo substr($user['birthdate'],5,2); ?>"  /></span>-->
															   <span class="text mm-size"><select class="" name="dbday">
															<?php for($i=1; $i<=31;$i++){ ?>
															<option value="<? echo $i; ?>" <?php echo substr($user['birthdate'],8)==$i?" selected":""; ?>><? echo $i; ?></option>
															<?
															}?>
															</select></span>
															   
                                                                <span class="slash-place">/</span>
                                                                <!--<span class="text yyyy-size"><input type="text" name="dyear" value="<?php //echo substr($user['birthdate'],0,4); ?>" /></span>-->
																<span class="text yyyy-size"><select class="" name="dyear">
															<?php for($i=1960; $i<=1995;$i++){ ?>
															<option value="<? echo $i; ?>" <?php echo substr($user['birthdate'],0,4)==$i?" selected":""; ?>><? echo $i; ?></option>
															<?
															}?>
															</select></span>
                                                                <span class="z-type" style="width:108px;">
                                                                <strong class="sex-typr-text">Sex:</strong>
                                                                <span class="text">
                                                                        <select class="select-recipe define-recipe" name="sex" style="width:70px;">
                                                                            <option value="Male" <?php echo $user['sex']=="Male"?" selected":""; ?>>Male</option>
                                                                            <option value="Female" <?php echo $user['sex']=="Female"?" selected":""; ?>>Female</option>
                                                                        </select>
                                                                    </span>
                                                                </span>
                                                                <br class="clear" />
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Height:</label>
                                                            <div>
                                                            <span class="text dd-size"><input type="text" name="fheight" value="<?php echo substr($user['height'],0,strpos($user['height']," ")); ?>" /></span>
                                                                <span class="unit-length-place">ft-</span>
                                                                <span class="text mm-size"><input type="text" name="iheight" value="<?php echo substr($user['height'],strpos($user['height']," ")+1); ?>" /></span>
                                                                <span class="unit-length-place">in</span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Current Weight:</label>
                                                            <div>
                                                            <span class="text lbs-size"><input type="text" name="weight" value="<?php echo $user['weight']; ?>" /></span>
                                                                <span class="unit-length-place">lbs.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal Weight:</span>
                                                                <span class="text lbs-size"><input type="text" name="goal_weight" value="<?php echo $user['goal_weight']; ?>" /></span>
                                                                <span class="unit-length-place">lbs.</span>
                                                            </div>
                                                            <br class="clear" />
                                                        </div>
														<div class="insFieldset">
                                                        <label>Timezone:</label>
                                                            <div>
																<span class="text">
                                                                        <select class="select-recipe define-recipe" name="timezone" style="width:150px;">
																				<option value="America/New_York" <?php echo $user['timezone']=="America/New_York"?" selected":""; ?>>Eastern Time</option>
																				<option value="America/Chicago" <?php echo $user['timezone']=="America/Chicago"?" selected":""; ?>>Central Time</option>
																				<option value="America/Denver" <?php echo $user['timezone']=="America/Denver"?" selected":""; ?>>Mountain Time</option>
																				<option value="America/Los_Angeles" <?php echo $user['timezone']=="America/Los_Angeles"?" selected":""; ?>>Pacific Time</option>
																				<option value="America/Anchorage" <?php echo $user['timezone']=="America/Anchorage"?" selected":""; ?>>Alaska Time</option>
																				<option value="Pacific/Honolulu" <?php echo $user['timezone']=="Pacific/Honolulu"?" selected":""; ?>>Hawaii Time</option>
                                                                        </select>
                                                                  </span>                                                                
                                                            </div>
                                                            <br class="clear" />
                                                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
      <div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="title-null">&nbsp;</div>
						<div class="signup-type signup-type-up">
							<div class="row">
								<div class="insFieldset">
                                                        <label>Account Name:</label>
                                                            <div>
                                                            <span class="text"><input type="text" name="username" value="<?php echo $user['email']; ?>" readonly="" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset" style="float:right;">
															<a href="users/change_password" class="sexybutton sexysimple sexygreen btn-submit">Change Password</a>
                                                        </div>
                                                        <!--<div class="insFieldset">
                                                        <label>Verify Password:</label>
                                                            <div><span class="text"><input type="password" name="cpassword" /></span></div>
                                                            <div class="clear"></div>
                                                        </div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<h3 class="outer-fieldset-title">Home Address</h3>
			<div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="title-null">&nbsp;</div>
						<div class="signup-type signup-type-up">
							<div class="row">
								<div class="insFieldset">
                                                        <label>Street Address:</label>
                                                            <div>
                                                            <span class="text"><input type="text" name="home[street_address]" value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->street_address:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Apt/Suite:</label>
                                                            <div><span class="text"><input type="text" name="home[app_suite]" value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->app_suite:""; ?>" /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>City:</label>
                                                            <div>
                                                            <span class="text city-size"><input type="text" name="home[city]"  value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->city:""; ?>" /></span>
                                                                <span class="unit-length-place">&nbsp;&nbsp;&nbsp;State:&nbsp;</span>
                                                                <span class="text lbs-size"><input type="text" name="home[state]" value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->state:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Zip Code:</label>
                                                            <div>
                                                            <span class="text zip-code-size"><input type="text" name="home[zip_code]" value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->zip_code:""; ?>" /></span>
                                                                <span class="unit-length-place">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country:&nbsp;</span>
                                                                <span class="text country-size"><input type="text" name="home[country]" value="<?php echo isset($user_address['home'][0]->id)?$user_address['home'][0]->country:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                            <?php if(isset($user_address['home'][0]->id)) {?><input type="hidden" name="home[id]" value="<?php echo $user_address['home'][0]->id; ?>" /><?php } ?>
                                                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
                                    <h3 class="outer-fieldset-title">Work Address</h3>
                                    <div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="title-null">&nbsp;</div>
						<div class="signup-type signup-type-up">
							<div class="row">
								<div class="insFieldset">
                                                        <label>Street Address:</label>
                                                            <div>
                                                            <span class="text"><input type="text" name="work[street_address]" value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->street_address:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Apt/Suite:</label>
                                                            <div><span class="text"><input type="text" name="work[app_suite]" value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->app_suite:""; ?>"  /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>City:</label>
                                                            <div>
                                                            <span class="text city-size"><input type="text" name="work[city]"  value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->city:""; ?>" /></span>
                                                                <span class="unit-length-place">&nbsp;&nbsp;&nbsp;State:&nbsp;</span>
                                                                <span class="text lbs-size"><input type="text" name="work[state]" value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->state:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Zip Code:</label>
                                                            <div>
                                                            <span class="text zip-code-size"><input type="text" name="work[zip_code]" value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->zip_code:""; ?>" /></span>
                                                                <span class="unit-length-place">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country:&nbsp;</span>
                                                                <span class="text country-size"><input type="text" name="work[country]" value="<?php echo isset($user_address['workadd'][0]->id)?$user_address['workadd'][0]->country:""; ?>" /></span>
                                                            </div>
                                                            <div class="clear"></div>
                                                            <?php if(isset($user_address['workadd'][0]->id)) {?><input type="hidden" name="work[id]" value="<?php echo $user_address['workadd'][0]->id; ?>" /><?php } ?>
                                                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="btn-area-form btn-area-form-right">
				<div class="sexybutton-area">
					<input type="hidden" name="uid" value="<?php echo $user['id']; ?>" />
					<button type="submit" class="sexybutton sexysimple sexygreen btn-submit"><span class="save">Save Changes</span></button>
				</div>
				<button type="submit" class="sexybutton sexysimple sexygreen btn-submit">Cancel</button>				
			</div>
			</form>
                                    <div class="clear">&nbsp;</div>
			<form action="users/metabolism" method="post" class="signup-form signup-form-update">	
			    <input type="hidden" name="uid" value="<?php echo $user['id']; ?>" />					
             <div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="block-in-title-blue title-blue-wider">
							<h2>21 Day Metabolism Makeover Program </h2>
						</div>
						
						<div class="signup-type signup-type-up">
							<div class="row">
								<div class="insFieldset">
                                                        <div class="im-onday-out">
                                                            <span>I'm on Day</span>
                                                                <span class="text">
                                                                    <select name="dayFixed" class="select-recipe define-recipe">
																		<?php
																			for($md=1;$md<=21;$md++)
																			{
																		?>	
																		<option value="<?php echo $md; ?>" <? if($md==$mStartDay){echo "selected='selected'";} ?> > <?php echo $md;?> </option>
																		<?php
																			}
																		?>                                                                        
                                                                    </select>
                                                                </span>
                                                                <span>of 21</span>
                                                                <div class="clear">&nbsp;</div>
                                                            </div>
                                                        <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">What time do you usually <a href="#">wake up</a> on the <a href="#" class="weekdays">weekdays</a>?</span>

																 <span class="text">
																	<?php
																	$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Wakeup', 'value'=>$wDaysWake,	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size'));//'start' => '06:00', 'end' => '11:00'));																	
																	?>                                                                    
                                                                </span>
                                                                <br class="clear" />
                                                            </div>
                                                            <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">What time do you usually <a href="#" class="gotobed">go to bed</a> on the <a href="#" class="weekdays">weekdays</a>?</span>
                                                           <span class="text">
                                                                    <?php
																	
																	$this->load->view('users/signup/sleep_time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Bed','value'=>$wDaysBed,	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size'));//'start' => '06:00', 'end' => '11:00'));																	
																	?>
                                                           </span>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">What time do you usually <a href="#">wake up</a> on the <a href="#" class="weekends">weekends</a>?</span>
                                                           <span class="text">
                                                                    <?php
																	$this->load->view('users/signup/time',array('title' => 'Weekends',	'day' => 'weekends', 'event' => 'Wakeup','value'=>$wEndWake,'start' => false, 'end' => false,'class'=>'select-recipe weekend-size'));//'start' => '06:00', 'end' => '11:00'));																	
																	?> 
															</span>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">What time do you usually <a href="#" class="gotobed">go to bed</a> on the <a href="#" class="weekends">weekends</a>?</span>
                                                            <span class="text">
                                                                    <?php
																	$this->load->view('users/signup/sleep_time',array('title' => 'Weekends',	'day' => 'weekends', 'event' => 'Bed', 'value'=>$wEndBed,'start' => false, 'end' => false,'class'=>'select-recipe weekend-size'));//'start' => '06:00', 'end' => '11:00'));																	
																	?> 
                                                                </span>
                                                                <br class="clear" />
                                                            </div>
                                                        </div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
            <div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="title-null">&nbsp;</div>
						<div class="signup-type signup-type-up">
							<div class="row">
								<div class="insFieldset">
                                                        <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">How long does it usually take you to eat breakfast (after waking):</span>
                                                            <span class="text">
                                                             <select name="breakfast_time" class="select-recipe weekend-size">
                                                                   <option value="00:30"  <?php if($breakFast=="00:30:00"){ echo "selected='selected'";} ?> >00:30</option>
																   <option value="01:00" <?php if($breakFast=="01:00:00") {echo "selected='selected'";} ?> >01:00</option>
																   <option value="01:30" <?php if($breakFast=="01:30:00"){ echo "selected='selected'";} ?> >01:30</option>
																   <option value="02:00" <?php if($breakFast=="02:00:00") {echo "selected='selected'"; }?> >02:00</option>
																   <option value="02:30" <?php if($breakFast=="02:30:00"){ echo "selected='selected'";} ?> >02:30</option>
																   <option value="03:00" <?php if($breakFast=="03:00:00") {echo "selected='selected'";} ?> >03:00</option>
                                                              </select>
                                                            </span>
                                                                <br class="clear" />
                                                                <div class="in-order-to">In order to get your metabolism started, it is best to eat within an hour of waking up.</div>
                                                            </div>
                                                            <div class="timesheet-daily-holder">
                                                            <span class="timesheet-text">How long would you like your meals to be spaced out?</span>
                                                            <span class="text">
                                                               <select name="meals_spaced_out" class="select-recipe weekend-size">
                                                                    <option value="00:30"  <?php if($mealsTime=="00:30:00"){ echo "selected='selected'";} ?> >00:30</option>
																   <option value="01:00" <?php if($mealsTime=="01:00:00") {echo "selected='selected'";} ?> >01:00</option>
																   <option value="01:30" <?php if($mealsTime=="01:30:00"){ echo "selected='selected'";} ?> >01:30</option>
																   <option value="02:00" <?php if($mealsTime=="02:00:00") {echo "selected='selected'"; }?> >02:00</option>
																   <option value="02:30" <?php if($mealsTime=="02:30:00"){ echo "selected='selected'";} ?> >02:30</option>
																   <option value="03:00" <?php if($mealsTime=="03:00:00") {echo "selected='selected'";} ?> >03:00</option>
                                                              </select>
                                                                </span>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
                                    <div class="btn-area-form btn-area-form-right">
				<div class="sexybutton-area">
					<button class="sexybutton sexysimple sexygreen btn-submit" type="submit"><span class="save">Save Changes</span></button>
				</div>
				<button class="sexybutton sexysimple sexygreen btn-submit" type="reset">Cancel</button>				
			</div>
		</form>		
		<form  action="users/saveexercise" method="post">	
                                    <div class="exersize-schedule">
                                    <h3 class="exersize-h3">Create your ideal exercise schedule</h3>
                                        <p class="exersize-p">We suggest that you alternate between 36 minutes of fat burning cardio,<br />and 24 minutes of resistance - every other day.</p>
                                        <div class="weekly-schedule-wrap">
                                        <div class="weekly-schedule-rptr">
                                            <h2>Mon</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Mon']))                                                        		
                                                        	$mainvalue=$uexercise['Mon']->cardio_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Mon', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>                                                        
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Mon']))                                                        		
                                                        	$mainvalue=$uexercise['Mon']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Mon', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr">
                                            <h2>Tue</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Tue']))                                                        		
                                                        	$mainvalue=$uexercise['Tue']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Tue', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Tue']))                                                        		
                                                        	$mainvalue=$uexercise['Tue']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Tue', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr">
                                            <h2>Wed</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Wed']))                                                        		
                                                        	$mainvalue=$uexercise['Wed']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Wed', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Wed']))                                                        		
                                                        	$mainvalue=$uexercise['Wed']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Wed', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr">
                                            <h2>Thu</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                       <?php
                                                        	if(isset($uexercise['Thu']))                                                        		
                                                        	$mainvalue=$uexercise['Thu']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Thu', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Thu']))                                                        		
                                                        	$mainvalue=$uexercise['Thu']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Thu', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr">
                                            <h2>Fri</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                         <?php
                                                        	if(isset($uexercise['Fri']))                                                        		
                                                        	$mainvalue=$uexercise['Fri']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Fri', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Fri']))                                                        		
                                                        	$mainvalue=$uexercise['Fri']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Fri', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr">
                                            <h2>Sat</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Sat']))                                                        		
                                                        	$mainvalue=$uexercise['Sat']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Sat', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Sat']))                                                        		
                                                        	$mainvalue=$uexercise['Sat']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Sat', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="weekly-schedule-rptr schedule-rptr-sun">
                                            <h2>Sun</h2>
                                                <div class="weekly-schedule-middle">
                                                Cardiovascular
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Sun']))                                                        		
                                                        	$mainvalue=$uexercise['Sun']->cardio_time ;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Sun', 'event' => 'cardio_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                    Resistance
                                                    <span class="text" style="float:none; clear:both;">
                                                        <?php
                                                        	if(isset($uexercise['Sun']))                                                        		
                                                        	$mainvalue=$uexercise['Sun']->resistance_time;
                                                        	else
                                                        	$mainvalue="";
                                                        	
															$this->load->view('users/signup/time_ecise',array('title' => 'Weekdays',	'day' => 'Sun', 'event' => 'resistance_time',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$mainvalue));//'start' => '06:00', 'end' => '11:00'));																	
														?>
                                                    </span>
                                                </div>
                                                <div class="schedule-bottom-rnd">&nbsp;</div>
                                            </div>
                                            <div class="clear">&nbsp;</div>
                                        </div>
                                        <div class="btn-area-form btn-area-form-right">
							<div class="sexybutton-area">								
								<button class="sexybutton sexysimple sexygreen btn-submit" type="submit"><span class="save">Save Changes</span></button>
							</div>							
							<button class="sexybutton sexysimple sexygreen btn-submit" type="reset">Cancel</button>							
						</div><div class="clear"></div>
                                    </div>                                                     
    </form>                                
    <form action="users/save_journaldata" method="post">
	<div class="block-in-blue block-in-blue-light-green additional-reciep-box">
	<?php
	$weekdays=array();
	$weekends=array();

	$flagwd=1;
	$flagwen=1;
	$isdisw=0;
	$isdiswd=0;
	for($i=0;$i<count($user_times);$i++)
	{	
		if($user_times[$i]->week_period=="weekdays"&&$user_times[$i]->type!="Snack")
		$weekdays[$user_times[$i]->type]=$user_times[$i]->time;
		else if($user_times[$i]->week_period=="weekdays"&&$user_times[$i]->type=="Snack")
		{
		  $weekdays[$user_times[$i]->type.($flagwd++)]=$user_times[$i]->time;
		  if($user_times[$i]->isdisable==1)
		  $isdisw=1;
		}
		else if($user_times[$i]->week_period=="weekends"&&$user_times[$i]->type!="Snack")
		$weekends[$user_times[$i]->type]=$user_times[$i]->time;		
		else if($user_times[$i]->week_period=="weekends"&&$user_times[$i]->type=="Snack")
		{
			$weekends[$user_times[$i]->type.($flagwen++)]=$user_times[$i]->time;				
			if($user_times[$i]->isdisable==1)
			$isdiswd=1;
		}
	}	
		
	if(!isset($weekdays['Breakfast']))
	$weekdays['Breakfast']=date("H:i:s",strtotime($weekdays['Wakeup'])+(30*60));
	
	if(!isset($weekdays['Snack1']))
	$weekdays['Snack1']=date("H:i:s",strtotime($weekdays['Breakfast'])+(2*60*60)+(30*60));
	
	if(!isset($weekdays['Lunch']))
	$weekdays['Lunch']=date("H:i:s",strtotime($weekdays['Snack1'])+(2*60*60)+(30*60));	
	
	if(!isset($weekdays['Snack2']))
	$weekdays['Snack2']=date("H:i:s",strtotime($weekdays['Lunch'])+(2*60*60)+(30*60));
	
	if(!isset($weekdays['Dinner']))
	$weekdays['Dinner']=date("H:i:s",strtotime($weekdays['Snack2'])+(2*60*60)+(30*60));
	
	if(!isset($weekdays['Snack3']))
	$weekdays['Snack3']=date("H:i:s",strtotime($weekdays['Dinner'])+(2*60*60)+(30*60));
	///////////////////////////////////////////////
	
	if(!isset($weekends['Breakfast']))
	$weekends['Breakfast']=date("H:i:s",strtotime($weekends['Wakeup'])+(30*60));
	
	if(!isset($weekends['Snack1']))
	$weekends['Snack1']=date("H:i:s",strtotime($weekends['Breakfast'])+(2*60*60)+(30*60));
	
	if(!isset($weekends['Lunch']))
	$weekends['Lunch']=date("H:i:s",strtotime($weekends['Snack1'])+(2*60*60)+(30*60));	
	
	if(!isset($weekends['Snack2']))
	$weekends['Snack2']=date("H:i:s",strtotime($weekends['Lunch'])+(2*60*60)+(30*60));
	
	if(!isset($weekends['Dinner']))
	$weekends['Dinner']=date("H:i:s",strtotime($weekends['Snack2'])+(2*60*60)+(30*60));
	
	if(!isset($weekends['Snack3']))
	$weekends['Snack3']=date("H:i:s",strtotime($weekends['Dinner'])+(2*60*60)+(30*60));
	?>
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="title-null">&nbsp;</div>
						<div class="signup-type signup-type-up">
							<div class="row">
                                                    <h3 class="edit-shedule-head">Edit your default eating schedule:</h3>
								<div class="weekdays-edit-holder">
                                                        <div class="weekday-black-edit">
                                                            <h2>Weekday</h2>
                                                            <div class="weekday-edit--middle">
                                                                <div class="weekend-mini-title">
                                                                    <span>Event</span>
                                                                        <span>Time</span>
                                                                        <br class="clear" />
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside ind-edit-inside-gray">
                                                                        <label>Wake Up</label>
                                                                            <span class="text zip-code-size"><input type="text" name="weekdays[Wakeup]" value="<?php echo date("g:i A",strtotime($weekdays['Wakeup'])); ?>" readonly /></span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Breakfast</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Breakfast',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Breakfast']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Snack1',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Snack1']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Lunch</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Lunch',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Lunch']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Snack2',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Snack2']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Dinner</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Dinner',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Dinner']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					if($isdisw==1)
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Snack3',	'start' => false,'isnone'=>1, 'end' => false,'class'=>'select-recipe weekend-size','value'=>""));//'start' => '06:00', 'end' => '11:00'));																	
																					else																					
																					$this->load->view('users/signup/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Snack3',	'start' => false,'isnone'=>1, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekdays['Snack3']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside ind-edit-inside-gray">
                                                                        <label>Bed Time</label>
                                                                            <span class="text zip-code-size"><input type="text" name="weekdays[Bed]" value="<?php echo date("g:i A",strtotime($weekdays['Bed'])); ?>" readonly /></span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="weekday-edit-bottom">&nbsp;</div>
                                                            </div>
                                                            <div class="weekday-black-edit weekday-black-right">
                                                            <h2>Weekend</h2>
                                                            <div class="weekday-edit--middle">
                                                                <div class="weekend-mini-title">
                                                                    <span>Event</span>
                                                                        <span>Time</span>
                                                                        <br class="clear" />
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside ind-edit-inside-gray">
                                                                        <label>Wake Up</label>
                                                                            <span class="text zip-code-size"><input type="text" name="weekends[Wakeup]" value="<?php echo date("g:i A",strtotime($weekends['Wakeup'])); ?>" readonly /></span>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Breakfast</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekends',	'day' => 'weekends','isnone'=>0, 'event' => 'Breakfast',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Breakfast']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekends','isnone'=>0,	'day' => 'weekends', 'event' => 'Snack1',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Snack1']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Lunch</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekends','isnone'=>0,	'day' => 'weekends', 'event' => 'Lunch',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Lunch']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekends','isnone'=>0,	'day' => 'weekends', 'event' => 'Snack2',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Snack2']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label>Dinner</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					$this->load->view('users/signup/time',array('title' => 'Weekends',	'day' => 'weekends','isnone'=>0, 'event' => 'Dinner',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Dinner']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside">
                                                                        <label class="snack">Snack</label>
                                                                            <span class="text selecter-recipe">
                                                                                <?php
																					if($isdiswd==1)
																					$this->load->view('users/signup/time',array('title' => 'Weekends',	'day' => 'weekends','isnone'=>1, 'event' => 'Snack3',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>""));//'start' => '06:00', 'end' => '11:00'));
																					else
																					$this->load->view('users/signup/time',array('title' => 'Weekends',	'day' => 'weekends','isnone'=>1, 'event' => 'Snack3',	'start' => false, 'end' => false,'class'=>'select-recipe weekend-size','value'=>$weekends['Snack3']));//'start' => '06:00', 'end' => '11:00'));																	
																				?>
                                                                            </span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="weekend-ind-edit">
                                                                    <div class="weekend-ind-edit-inside ind-edit-inside-gray">
                                                                        <label>Bed Time</label>
                                                                            <span class="text zip-code-size"><input type="text" name="weekends[Bed]" value="<?php echo date("g:i A",strtotime($weekends['Bed'])); ?>" readonly /></span>
                                                                            <br class="clear" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="weekday-edit-bottom">&nbsp;</div>
                                                            </div>
                                                            <div class="clear">&nbsp;</div>
                                                        </div>
							</div>
						</div>
					</div>						
				</div>
			</div>
			<div class="btn-area-form btn-area-form-right">
				<div class="sexybutton-area">								
					<button type="submit" class="sexybutton sexysimple sexygreen btn-submit"><span class="save">Save Changes</span></button>
				</div>							
				<button type="reset" class="sexybutton sexysimple sexygreen btn-submit">Cancel</button>							
			</div>
		</fieldset>
	</form>