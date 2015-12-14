<select name="<?=$day?>[<?=$event?>]" id="<?=$day?>_<?=$event?>" class="<?php echo $class; ?>">


	<? if (timeRange(@$start,@$end,'12:00')) { ?><option value="12:00:00">12:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'12:30')) { ?><option value="12:30:00">12:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'13:00')) { ?><option value="13:00:00">01:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'13:30')) { ?><option value="13:30:00">01:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'14:00')) { ?><option value="14:00:00">02:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'14:30')) { ?><option value="14:30:00">02:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'15:00')) { ?><option value="15:00:00">03:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'15:30')) { ?><option value="15:30:00">03:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'16:00')) { ?><option value="16:00:00">04:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'16:30')) { ?><option value="16:30:00">04:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'17:00')) { ?><option value="17:00:00">05:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'17:30')) { ?><option value="17:30:00">05:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'18:00')) { ?><option value="18:00:00">06:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'18:30')) { ?><option value="18:30:00">06:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'19:00')) { ?><option value="19:00:00">07:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'19:30')) { ?><option value="19:30:00">07:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'20:00')) { ?><option value="20:00:00">08:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'20:30')) { ?><option value="20:30:00">08:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'21:00')) { ?><option value="21:00:00">09:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'21:30')) { ?><option value="21:30:00">09:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'22:00')) { ?><option value="22:00:00">10:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'22:30')) { ?><option value="22:30:00">10:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'23:00')) { ?><option value="23:00:00">11:00 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'23:30')) { ?><option value="23:30:00">11:30 PM</option><?}?>
	<? if (timeRange(@$start,@$end,'00:00')) { ?><option value="00:00:00">12:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'00:30')) { ?><option value="00:30:00">12:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'01:00')) { ?><option value="01:00:00">01:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'01:30')) { ?><option value="01:30:00">01:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'02:00')) { ?><option value="02:00:00">02:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'02:30')) { ?><option value="02:30:00">02:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'03:00')) { ?><option value="03:00:00">03:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'03:30')) { ?><option value="03:30:00">03:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'04:00')) { ?><option value="04:00:00">04:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'04:30')) { ?><option value="04:30:00">04:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'05:00')) { ?><option value="05:00:00">05:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'05:30')) { ?><option value="05:30:00">05:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'06:00')) { ?><option value="06:00:00">06:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'06:30')) { ?><option value="06:30:00">06:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'07:00')) { ?><option value="07:00:00">07:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'07:30')) { ?><option value="07:30:00">07:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'08:00')) { ?><option value="08:00:00">08:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'08:30')) { ?><option value="08:30:00">08:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'09:00')) { ?><option value="09:00:00">09:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'09:30')) { ?><option value="09:30:00">09:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'10:00')) { ?><option value="10:00:00">10:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'10:30')) { ?><option value="10:30:00">10:30 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'11:00')) { ?><option value="11:00:00">11:00 AM</option><?}?>
	<? if (timeRange(@$start,@$end,'11:30')) { ?><option value="11:30:00">11:30 AM</option><?}?>
</select>
<?php 
if(isset($value)&&strlen($value)>0)
{
?>
<script type="text/javascript">
	document.getElementById("<?=$day?>_<?=$event?>").value="<?php echo $value; ?>";
</script>
<?php 
}
?>