<ul class="side-nav">
	<li <?php if($eating === true)	{ echo 'class="active"'; }?>><a class="journal"	href="users/eating_journal">EATING JOURNAL</a></li>
	<li <?php if($recipe === true)	{ echo 'class="active"'; }?>><a class="recipe"	href="recipefinder/">RECIPE FINDER</a></li>
	<li <?php if($success === true)	{ echo 'class="active"'; }?>><a class="success"	href="successjournal/">SUCCESS JOURNAL</a></li>	
	<li <?php if($fatloss === true)	{ echo 'class="active"'; }?>><a class="flatloss"	href="fatlosscoach/">MY FAT LOSS COACH</a></li>	
</ul>