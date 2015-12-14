<link media="all" rel="stylesheet" href="application/views/_assets/tooltip/jquery.tooltip.css" type="text/css" />
<script type="text/javascript" src="application/views/_assets/tooltip/jquery.tooltip.js"></script>
<script type="text/javascript" src="application/views/_assets/tooltip/encodedecode.js"></script>
<div id="calendaralljournal_daily" style="position:relative; z-index:10;">
	<div class="calendar-user" style="height:20px;">
		<div class="steping-calender">
			<div id="calj_daily">
				<a href="javascript:void(0)" class="calender-prev">&nbsp;</a>
				<h2 class="staping-calender-text" id="jumpjournalselected"><?php echo date("M. d, Y");?></h2>
				<a href="javascript:void(0)" class="calander-next">&nbsp;</a>
			</div>
			<div id="calj_weekly" style="display:none;">
				<a href="javascript:void(0)" class="calender-prev">&nbsp;</a>
				<h2 class="staping-calender-text" id="jumpjournalselected_weekly"><?php echo date("M. d, Y");?></h2>
				<a href="javascript:void(0)" class="calander-next">&nbsp;</a>
				<span id="jumpexistWeekstart" style="display:none;"><?php echo date("Y-m-d");?></span>
				<span id="jumpexistWeekend" style="display:none;"><?php echo date("Y-m-d");?></span>
			</div>
			<div id="calj_monthly" style="display:none;">
				<a href="javascript:void(0)" class="calender-prev">&nbsp;</a>
				<h2 class="staping-calender-text" id="jumpjournalselected_monthly"><?php echo date("F, Y");?></h2>
				<a href="javascript:void(0)" class="calander-next">&nbsp;</a>
				<span id="jumpexistmonth" style="display:none;"><?php echo date("Y-m-d");?></span>				
			</div>
		</div>
		<div class="jump-to-day"><a href="javascript:void(0)" class="quick-jump-link">Jump to A Day</a></div>	
		<div class="clear">&nbsp;</div>
		<span id="jumpexistDate" style="display:none;"><?php echo date("Y-m-d");?></span>
		<div class="jumppicker" id="jumpDateDiv"></div>
	</div>
</div>
<ul class="tools">
	<!--<li><a class="save" href="javascript:void(0);">SAVE AS TEMPLATE</a></li>-->
	<li><a class="print" href="javascript:void(0);">PRINT</a></li>
</ul>
<div class="links-block">
	<a class="add" id="add_to_journal" href="javascript:void(0);">Add to Journal</a>
	<a class="journal" href="javascript:void(0);">My Eating Journal</a>
</div>

<div class="schedule-block" style="position:relative; z-index:9;">
	<div id="bigjornalloading" style="position:fixed;z-index: 215;display:none;margin: 65px 0 0 215px;"><img src="htdocs/images/final_loading_big.gif"></div>
	<div id="journal_content"></div>
	<div id="add_to_journal_wrapper"></div>
</div>

<div id="addToJournalDiv"></div>

<div id="saveMealDiv">
<div class="alert-box-rptr" id="saveMealDivBox" style="display:none;">
	<div>Name: <input type="text" name="saveMealName" value="" size="30" /></div>
	<div style="padding:10px 0 0 0;">Descrition: <textarea name="saveMealDescription" style="width: 200px;"></textarea></div>
</div>
</div>
<span id="firsttime_check" style="display:none;"><?php
	$logindate=date('Y-m-d',strtotime($user['last_login']));
	$login_flag=$user['first_time_flag'];
	$today=date('Y-m-d');
	if($logindate==$today&&$login_flag==0)
	echo "1";
	else
	echo "0";		
	?>
</span>