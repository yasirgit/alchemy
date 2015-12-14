<?php

function daysToDate($days) {
	$today = time();
	$daysUnix = $days * 24 * 60 * 60;
	$diff = $today - $daysUnix;
	$dateUnix = $today - $diff;
	return date("F m, Y", $dateUnix);
}

function timeRange($t1=false, $t2=false, $t3)
{
	if (!$t1 || !$t2)
	{
		return true;
	}
	$x1 = explode(":",$t1);
	$y1 = ($x1[0] * 60) + $x1[1];
	$x2 = explode(":",$t2);
	$y2 = ($x2[0] * 60) + $x2[1];
	$x3 = explode(":",$t3);
	$y3 = ($x3[0] * 60) + $x3[1];
	if ($y3 >= $y1 && $y3 <= $y2)
	{
		return true;
	}
	return false;
}
?>