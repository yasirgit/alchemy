<ul id="nav">
	<li id="yesterday"	<?php if ($active=="yesterday")	{?> class="active" <?php }?>><a id="calendar" class="yesterday"	href="javascript:void(0);">Yesterday</a></li>
	<li id="today"		<?php if ($active=="today")		{?> class="active" <?php }?>><a id="calendar" class="today"		href="javascript:void(0);">Today</a></li>
	<li id="tomorrow"	<?php if ($active=="tomorrow")	{?> class="active" <?php }?>><a id="calendar" class="tomorrow"	href="javascript:void(0);">Tomorrow</a></li>
	<li id="week"		<?php if ($active=="week")		{?> class="active" <?php }?>><a id="calendar" class="week"		href="javascript:void(0);">Week</a></li>
	<li id="month"		<?php if ($active=="month")		{?> class="active" <?php }?>><a id="calendar" class="month"		href="javascript:void(0);">Month</a></li>
</ul>