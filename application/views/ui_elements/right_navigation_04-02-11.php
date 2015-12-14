<ul class="side-nav">
	<li <?php if($eating === true)	{ echo 'class="active"'; }?>><a class="journal"	href="users/eating_journal">EATING JOURNAL</a></li>
	<li <?php if($recipe === true)	{ echo 'class="active"'; }?>><a class="recipe"	href="recipefinder/">RECIPE FINDER</a></li>
	<li <?php if($success === true)	{ echo 'class="active"'; }?>><a class="success"	href="users/success_journal">SUCCESS JOURNAL</a></li>
	<?php /*
	<li <?php if($advisor === true)	{ echo 'class="active"'; }?>><a class="advisor"	href="eatingout/">EATING OUT ADVISOR</a></li>
	<li <?php if($snack === true)	{ echo 'class="active"'; }?>><a class="snack"	href="users/snack_treat_guide">SNACK &amp; TREAT GUIDE</a></li>
	<li <?php if($planner === true)	{ echo 'class="active"'; }?>><a class="planner"	href="users/menu_planner">MENU PLANNER</a></li>	
	<?php
		*/
	?>
</ul>