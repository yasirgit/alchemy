<div class="holder">
<p class="succes-title">Your Personalized Fat Loss Assessment</p>
<div class="succes-date">
  <label>for Today:</label>
  <ul>
	<li><a href="#"><img src="htdocs/images/coach/date-next-arrow.gif" alt="next" class="prevdate_fat" width="16" height="15" /></a></li>
	<li id="currentdate_fat"><?php echo date('m/d/Y');?></li>
	<li><a href="#"><img src="htdocs/images/coach/date-prev-arrow.gif" alt="next" class="nextdate_fat" width="16" height="15" /></a></li>
  </ul>
  <div class="success-calender">
	<label>Go to Date</label>
	<input type="hidden" name="" id="mdatepicker" size="100"></div>		
</div>
<div class="fat-optimize">
  <div class="fat-big-wrapper">
<div id="fat-big-chart1" class="fat-big-chart">
	<h2 class="big-chat-title"><img src="htdocs/images/coach/big-fat-title.gif" alt="Fat Burning Optimizer" /></h2>
	<div class="fat-big-chart-bar">
		<div id="fat-big-chart-scroll1" class="fat-big-chart-scroll">
		    <div id="big-fat-unit-holder1" class="big-fat-unit-holder">				
			</div>
			<div class="big-fat-scale">				
			</div>			
		</div>
	</div>
	<ul class="micro-fat-chart-ind">
		<li>Fat Burning ZONE</li>
		<li class="storing-ind">Fat storing ZonE</li>
	</ul>
</div>
</div>
  <div class="fat-opt-right">
	<div class="side-box">
	  <div class="side-box-top"></div>
	  <div class="side-box-mid">
		<h3>% <span class="active_day_name">Today</span> in<br />
		  Fat Burning Mode</h3>
		<div class="btn-green" id="fatburning_percentage_green">82%</div>
	  </div>
	  <div class="side-box-bottom"></div>
	</div>
	<div class="side-box">
	  <div class="side-box-top"></div>
	  <div class="side-box-mid">
		<h3 class="cl-viotale">Overall Grade<br />
		  for <span class="active_day_name">Today</span></h3>
		<div class="btn-violate" id="fatburning_grade_violate">A+</div>
	  </div>
	  <div class="side-box-bottom"></div>
	</div>
  </div>
</div>
</div>