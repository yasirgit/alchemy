<script language="javascript">
<?php
if (@$user_times)
{
	?>
	var user_times = <?=json_encode($user_times)?>;
	<?
}
else
{
	?>
	var user_times = Array();
	<?
}
?>
</script>
<div id="setup">
	<div id="header">
		<span>Setup</span> &nbsp; &nbsp;
		<a href="javascript:void(0);" class="step" id="a1" step="1">Step 1</a> &nbsp; &nbsp;
		<a href="javascript:void(0);" class="step" id="a2" step="2">Step 2</a> &nbsp; &nbsp;
		<a href="javascript:void(0);" class="step" id="a3" step="3">Step 3</a>
	</div>
	<hr style="width:90%;" />
	<div class="clear"></div>
	<form id="userSetupForm">
		<div id="step1">
			We're going to walk you through setting up your account. Setting defaults will make your daily tracking easier.<br /><br />
			<div class="heading">When do you usually wake up?</div>
			<div class="schedule">
				<?
				$this->load->view('users/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Wakeup',	'start' => false, 'end' => false));//'start' => '06:00', 'end' => '11:00'));
				$this->load->view('users/time',array('title' => 'Weekends',	'day' => 'weekends', 'event' => 'Wakeup',	'start' => false, 'end' => false));//'start' => '06:00', 'end' => '11:00'));
				?>
				<div class="heading">When do you usually go to bed?</div>
				<?
				$this->load->view('users/time',array('title' => 'Weekdays',	'day' => 'weekdays', 'event' => 'Bed',		'start' => false, 'end' => false));//'start' => '18:00', 'end' => '23:30'));
				$this->load->view('users/time',array('title' => 'Weekends',	'day' => 'weekends', 'event' => 'Bed',		'start' => false, 'end' => false));//'start' => '18:00', 'end' => '23:30'));
				?>
			</div>
			<div class="button">
				<a class="sexybutton sexyorange">
					<span><span><span class="next">Next</span></span></span>
				</a>
				<a class="sexybutton sexyorange">
					<span><span><span class="save">Save</span></span></span>
				</a>
			</div>
		</div>
		<div class="clear"></div>
		<div id="step2">
			Based on your wake time, we suggest the following eating schedule. Please feel free to make any adjustments before saving this as your template.
			<div class="heading">Eating Schedule?</div>
			<div class="schedule">
				<div class="subHeading">Weekdays</div>
				<?
				$this->load->view('users/time',array('title' => 'Breakfast',	'day' => 'weekdays', 'event' => 'Breakfast',	'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Lunch',		'day' => 'weekdays', 'event' => 'Lunch',		'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Dinner',		'day' => 'weekdays', 'event' => 'Dinner',		'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Snack',		'day' => 'weekdays', 'event' => 'Snack',		'start' => false, 'end' => false));
				?>
			</div>
			<div class="schedule">
				<div class="subHeading">Weekends</div>
				<?
				$this->load->view('users/time',array('title' => 'Breakfast',	'day' => 'weekends', 'event' => 'Breakfast',	'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Lunch',		'day' => 'weekends', 'event' => 'Lunch',		'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Dinner',		'day' => 'weekends', 'event' => 'Dinner',		'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Snack',		'day' => 'weekends', 'event' => 'Snack',		'start' => false, 'end' => false));
				?>
			</div>
			<div class="button">
				<a class="sexybutton sexyorange">
					<span><span><span class="prev">Previous</span></span></span>
				</a>
				<a class="sexybutton sexyorange">
					<span><span><span class="next">Next</span></span></span>
				</a>
				<a class="sexybutton sexyorange">
					<span><span><span class="save">Save</span></span></span>
				</a>
			</div>
		</div>
		<div class="clear"></div>
		<div id="step3">
			Daily exercise times.
			<div class="heading">Exercise Schedule?</div>
			<div class="schedule">
				<?
				$this->load->view('users/time',array('title' => 'Weekdays', 'day' => 'weekdays', 'event' => 'Exercise',	'start' => false, 'end' => false));
				$this->load->view('users/time',array('title' => 'Weekends', 'day' => 'weekends', 'event' => 'Exercise',	'start' => false, 'end' => false));
				?>
			</div>
			<div class="button">
				<a class="sexybutton sexyorange">
					<span><span><span class="prev">Previous</span></span></span>
				</a>
				<a class="sexybutton sexyorange">
					<span><span><span class="save">Save</span></span></span>
				</a>
			</div>
		</div>
		<div id="step4">
			Your preferences have been saved. What would you like to do now?
			<div class="schedule">
				<a href="users/eating_journal/active:today" class="sexybutton sexyorange">
					<span><span>Enter a meal I've eaten</span></span>
				</a><br />
				<a href="users/recipe_finder" class="sexybutton sexyorange">
					<span><span>Find something to eat</span></span>
				</a><br />
				<a href="users/eating_journal/active:today" class="sexybutton sexyorange">
					<span><span>Plan meals and snacks for this day</span></span>
				</a><br />
				<a href="users/eating_journal/active:week" class="sexybutton sexyorange">
					<span><span>Plan meals and snacks for the week</span></span>
				</a><br />
				<a href="users/eating_journal/active:month" class="sexybutton sexyorange">
					<span><span>Plan meals and snacks for the month</span></span>
				</a><br />
			</div>
			<br />
			<div class="button">
				<a class="sexybutton sexyorange">
					<span><span><span class="prev">Previous</span></span></span>
				</a>
			</div>
		</div>
	</form>
	<div style="font-weight:bold;color:#CC0000;">
		<?php
		if(!empty($error)) { echo "<br />".$error."<br />"; }
		echo validation_errors();
		?>
	</div>
</div>
