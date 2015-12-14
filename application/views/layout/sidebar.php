<?php
error_reporting(0);	
$CI =& get_instance();
if (($CI->auth->isLoggedIn() && $CI->auth->isSetup())||(($this->CI->router->class=="access"&&$this->CI->router->method=="signup_step2")))
{
	?>		
	<div id="sidebar">
	<?php if(($this->CI->router->class=="access"&&$this->CI->router->method=="signup_step2")) { ?>
	<style type="text/css">
			/********************* over lay in side bar **************************/			
			.sidebar-box
			{
				z-index:50;
				position:relative;
			}
/*			.overLay {
			background:#000000 none repeat scroll 0 0;
			height:983px;
			opacity:0.7;
			filter:alpha(opacity=70);
			position:absolute;
			top:43px;
			left:8px;
			width:240px;
			z-index:1001;
			}*/
					.overLay {
			background:#000000 none repeat scroll 0 0;
			height:637px;
			opacity:0.7;
			filter:alpha(opacity=70);
			position:absolute;
			top:102px;
			left:8px;
			width:240px;
			z-index:1001;
			}
			.overlay-wrapper {
				height: 0px;
				font-size:0px;
				line-height:0px;
				position:relative;
				z-index:100;
			}
	</style>
	<div class="overlay-wrapper"><div class="overLay">&nbsp;</div></div><?php }?>
		<div class="sidebar-box">
			<div class="sidebar-holder">
				<div class="sidebar-frame">
					<div class="date">
						<!--
						<ul>
							<li><a href="javascript:void(0);" class="prev">prev</a></li>
							<li><a href="javascript:void(0);" class="next">next</a></li>
						</ul> -->
						<em id="sidebar_date"><?=date('l, F d',strtotime(date("Y-m-d")))?></em>
					</div>
					<div class="sidebar-container">
						<div class="holder">
							<div class="frame">
							<div class="food-lover-branding"><img src="htdocs/images/food-lovers-branding.gif" alt="" /></div>
							 <!--Micro Fat Chart-->
                                        <div id="micro-fat-burning">
                                        	<h2 class="micro-fat-title"><img src="htdocs/images/coach/flat-chart-titile.gif" alt="Fat Burning Optimizer" /></h2>
                                            
											<div class="micro-chart-area">
                                            	<div class="micro-chart-bars micro-chart-scroll">
                                                    <div class="fat-bars-holder">
														<div id="eating_journal_main_chart">														
														<!--start micro Chart-->
															<div class="unit-0 hour06">&nbsp;</div>
															<div class="unit-0 hour07">&nbsp;</div>
															<div class="unit-0 hour08">&nbsp;</div>
															<div class="unit-0 hour09">&nbsp;</div>
															<div class="unit-0 hour10">&nbsp;</div>
															<div class="unit-0 hour11">&nbsp;</div>	
															<div class="unit-0 hour12">&nbsp;</div>
															<div class="unit-0 hour13">&nbsp;</div>
															<div class="unit-0 hour14">&nbsp;</div>
															<div class="unit-0 hour15">&nbsp;</div>
															<div class="unit-0 hour16">&nbsp;</div>
															<div class="unit-0 hour17">&nbsp;</div>	
															<div class="unit-0 hour18">&nbsp;</div>
															<div class="unit-0 hour19">&nbsp;</div>
															<div class="unit-0 hour20">&nbsp;</div>
															<div class="unit-0 hour21">&nbsp;</div>
															<div class="unit-0 hour22">&nbsp;</div>
															<div class="unit-0 hour23">&nbsp;</div>	
															<div class="unit-0 hour00">&nbsp;</div>
															<div class="unit-0 hour01">&nbsp;</div>
															<div class="unit-0 hour02">&nbsp;</div>
															<div class="unit-0 hour03">&nbsp;</div>
															<div class="unit-0 hour04">&nbsp;</div>
															<div class="unit-0 hour05">&nbsp;</div>																
														<!--end micro Chart-->	
														</div>
                                                    </div>
                                                </div>
												<div class="micro-chart-scale micro-chart-scroll">
                                            	<ul class="micro-scale-unit" id="micro_scale_unit_id">                                                	
                                                </ul>
                                            </div>
                                            </div>
                                            
											
                                            <ul class="micro-fat-chart-ind">
                                            	<li>Fat Burning ZONE</li>
                                                <li class="storing-ind">Fat storing ZonE</li>
                                            </ul>
                                        </div>
                                        <!--/Micro Fat Chart-->                            
							<div class="sidebar-fat-burning">
								<div class="sidebar-fat-percent" id="sidebar_fat_percent"></div>
								<p id="feedback_message">You're doing pretty well so far. Your body has been in the Fat Burning Zone for 85% of the time since you woke up. Eat your next snack between 10:30 &amp; 11:00 AM to keep your body's Fat Burning Furnace running on high.</p>
                            </div>
                            <div class="metabolism"><a href="javascript:void(0);">DAY 2</a></div>
							<div class="my-feedback"><a href="fatlosscoach/"><img src="htdocs/images/my-feedback.gif" alt="My Feedback" /></a></div>														
								<div class="messages-holder">
									<h3>My Messages:</h3>
									<div class="scrollable">																		
											<div class="messages-box colored">
												<a href="javascript:void(0);" class="close-opt"><img src="htdocs/images/decline.png" alt="" /></a>
												<div class="image-holder">
													<a href="javascript:void(0);"><img src="htdocs/images/img4.gif" width="38" height="31" alt="" /></a>
												</div>
												<div class="text-box">
													<p>Sleep - Try to get a full 7-8 hours of sleep tonight.  It will help speed weight loss and minimize cravings during the day.</p>
												</div>
											</div>										
									</div>
								</div>
								<?php
								if($this->CI->router->method!="signup_step2")
								{
									$daily=User_model::getDaily();								
								?>
							<div id="edailytracker">	
								<span id="etrackerdate" style="display:none;"><?php echo date('Y-m-d');?></span>
								<div class="tracker-box">									
									<h3>My Daily Tracker:</h3>
									<div class="water-tracker-box">
										<strong>Water:</strong>
										<ul class="list">
											<li><a class="more" href="javascript:void(0);">more</a></li>
											<li><a class="less" href="javascript:void(0);">less</a></li>
										</ul>
										<ul class="cups-list">
											<?php
											for ($x=1; $x <= _MAX_WATER_; $x++)
											{																							
												if($x==9)
												echo '</ul><ul style="padding: 10px 0pt 0pt 35px;" class="cups-list">';
												
												if (@$daily->cups < $x)
												{
													?><li><?=$x?></li><?php
												}
												else
												{
													?><li class="marked"><?=$x?></li><?php
												}												
											}
											?>
										</ul>
									</div>
									<form class="tracker-form">
										<fieldset>
											<strong>Vitamins &amp; Supplements:</strong>
											<div class="form-holder">
												<div class="row" style="width:86px;">
													<input class="checkbox" daily="vitamins"	autocomplete="off" type="checkbox" <?php if (@$daily->vitamins == 1)	{?>CHECKED<?php } ?> />
													<label for="multi-vitamin">Multi-vitamin</label>
												</div>
												<div class="row" style="width:108px;">
													<input class="checkbox" daily="pills"		autocomplete="off" type="checkbox" <?php if (@$daily->pills == 1)		{?>CHECKED<?php } ?> />
													<label for="pills">5 Way Fat Fighter</label>
												</div>
												<div class="row">
													<input class="checkbox" daily="supplements"	autocomplete="off" type="checkbox" <?php if (@$daily->supplements == 1)	{?>CHECKED<?php } ?> />
													<label for="supplement">Supplement</label>
												</div>
											</div>
										</fieldset>
									</form>
								</div>
								<div class="list-box">																		
									<h3>My To-Do List:</h3>
									<form>
										<fieldset>
											<div class="row" id="fatBurning"	<?=(@$daily->fatBurning == 0) ? 'style="display:block;"' : '' ;?>>
												<input class="checkbox clear" daily="fatBurning" <?=(@$daily->fatBurning == 1) ? ' checked' : '' ;?>	type="checkbox" autocomplete="off" />
												<label for="fatBurning">Do 36 mins of fat burning cardio</label>
											</div>
											<div class="row" id="nutrition"		<?=(@$daily->nutrition == 0) ? 'style="display:block;"' : '' ;?>>
												<input class="checkbox clear" daily="nutrition"		type="checkbox" <?=(@$daily->nutrition == 1) ? ' checked' : '' ;?> autocomplete="off" />
												<label for="supplements">Take nutritional supplements</label>
											</div>
											<div class="row" id="sleep"			<?=(@$daily->sleep == 0) ? 'style="display:block;"' : '' ;?>>
												<input class="checkbox clear" daily="sleep"			type="checkbox" <?=(@$daily->sleep == 1) ? ' checked' : '' ;?> autocomplete="off" />
												<label for="sleep">Get 7 to 8 hours sleep</label>
											</div>
											<div class="row" id="choose"		<?=(@$daily->choose == 0) ? 'style="display:block;"' : '' ;?>>
												<input class="checkbox clear" daily="choose"		type="checkbox" <?=(@$daily->choose == 1) ? ' checked' : '' ;?> autocomplete="off" />
												<label for="choose">Choose only healthy breads, sweets and fats. Cut back on sodium.</label>
											</div>
										</fieldset>
									</form>
								</div>
							</div>		
							<?php
							}
							?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
if($this->CI->router->method!="signup_step2")
{
?>	
<!-- call optimizer chart -->
<script type="text/javascript">
doAjax("journal/getadvice",
function(adviceresponse)
{	 
	 $("#twocolumns").append(adviceresponse.display);
	 $('.scrollable').html(adviceresponse.dashboard);
	 VSA_initScrollbars();//for reload div
	//$('').dialog('open');				
});	
</script>
<!-- end call optimizer chart -->
<?php 
}
?>	
	<?php
}
?>