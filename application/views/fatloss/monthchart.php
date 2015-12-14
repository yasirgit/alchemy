<?php
$firstdate ="";
$firstvalue="";
foreach($fat_burning_mode as $key=>$value)
{
	$firstdate=$key;
	$firstvalue=$value;
	break;
}
$countstart=date("w",strtotime($firstdate));
$daycount=1;
$count=0;
?>
<ul class="days-in-weekchart">
	<li>Sun</li>
	<li>Mon</li>
	<li>Tue</li>
	<li>Wed</li>
	<li>Thu</li>
	<li>Fri</li>
	<li class="days-inweek-last">Sat</li>
</ul>
		<ul class="day-block-holder">
			<?php
			for($i=0;$i<$countstart;$i++)
			{
			?>
			 <li>&nbsp;</li>
			<?php
			$count++;
			}
			foreach($fat_burning_mode as $key=>$value)
			{
				$day=date("D",strtotime($key));
				$storing=round((46/100)*(100-$value));;
				
			?>
			<li<?php echo $day=="Sat"?' class="lasdt-dayin-row"':""; ?>>
				<div class="burning-mode-part">
					<div class="string-mode-part" style="height:<?php echo $storing;?>px;">&nbsp;</div>
					<label class="burning-storing-grade"><?php echo $grade[$key];?></label>
				</div>
				<span class="date-number-place"><?php echo $daycount;?></span>
			</li>
			<?php
				$daycount++;
				$count++;
			}
			for($i=$daycount;$i<=$total_day;$i++)
			{
			?>
			<li<?php echo $count%7==6?' class="lasdt-dayin-row"':""; ?>>&nbsp;
			<span class="date-number-place"><?php echo $i;?></span>
			</li>
			<?php
			$count++;
			}
			?>
		</ul>