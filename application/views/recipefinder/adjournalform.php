<style>
.small-scale .look-control { background:url(htdocs/images/add-meal-body-rptr.png) repeat-y right; display:block; padding:40px 20px 15px 20px;}
.b2 {
    background: url("htdocs/images/modal-right-bottom.png") no-repeat scroll right top transparent;
    height: 38px;
    padding: 0 22px 0 0;
}
.small-scale .add-popup-bottomleft {
    background-position: 0 0;
}
.add-popup-bottomleft {
    background: url("htdocs/images/modal-bottom-left.png") no-repeat scroll 1px 0 transparent;
    padding: 0 0 0 17px;
}
.add-popup-bottomleft div {
    background: url("htdocs/images/modal-bottom-rptr.png") repeat-x scroll center top transparent;
    display: block;
    height: 38px;
    padding: 0;
}
.mealjournal { width:auto; padding:5px 0;}
.mealjournal label,.mealjournal select,.mealjournal input,.cal-ico { float:left;}
.mealjournal label{ width:120px;}
.mealjournal select{width:153px;}
.mealjournal input{ width:150px;}
.cal-ico{ margin:5px 0 0 5px; display:inline;}
.table-control .close-calendar{display:none;}
/*
.ui-datepicker .ui-datepicker-prev,.ui-datepicker .ui-datepicker-prev-hover {
	background: url("application/views/_assets/css/ui-lightness/images/ui-icons_222222_256x240.png") no-repeat -80px -192px;
}
.ui-datepicker .ui-datepicker-next
*/
</style>
<script type="text/javascript">
$(function() {
$("#mdatepicker").datepicker({
	showOn: 'button', buttonImage: 'htdocs/images/coach/icon-calender.gif',
	buttonImageOnly: true,
	onSelect: function(dateText, inst)
	{},
	dateFormat:"yy-mm-dd"
});
});
</script>
<?php
$dailytime=array(
"00:00:00"=>"12:00 AM",
"00:30:00"=>"12:30 AM",
"01:00:00"=>"01:00 AM",
"01:30:00"=>"01:30 AM",
"02:00:00"=>"02:00 AM",
"02:30:00"=>"02:30 AM",
"03:00:00"=>"03:00 AM",
"03:30:00"=>"03:30 AM",
"04:00:00"=>"04:00 AM",
"04:30:00"=>"04:30 AM",
"05:00:00"=>"05:00 AM",
"05:30:00"=>"05:30 AM",
"06:00:00"=>"06:00 AM",
"06:30:00"=>"06:30 AM",
"07:00:00"=>"07:00 AM",
"07:30:00"=>"07:30 AM",
"08:00:00"=>"08:00 AM",
"08:30:00"=>"08:30 AM",
"09:00:00"=>"09:00 AM",
"09:30:00"=>"09:30 AM",
"10:00:00"=>"10:00 AM",
"10:30:00"=>"10:30 AM",
"11:00:00"=>"11:00 AM",
"11:30:00"=>"11:30 AM",
"12:00:00"=>"12:00 PM",
"12:30:00"=>"12:30 PM",
"13:00:00"=>"01:00 PM",
"13:30:00"=>"01:30 PM",
"14:00:00"=>"02:00 PM",
"14:30:00"=>"02:30 PM",
"15:00:00"=>"03:00 PM",
"15:30:00"=>"03:30 PM",
"16:00:00"=>"04:00 PM",
"16:30:00"=>"04:30 PM",
"17:00:00"=>"05:00 PM",
"17:30:00"=>"05:30 PM",
"18:00:00"=>"06:00 PM",
"18:30:00"=>"06:30 PM",
"19:00:00"=>"07:00 PM",
"19:30:00"=>"07:30 PM",
"20:00:00"=>"08:00 PM",
"20:30:00"=>"08:30 PM",
"21:00:00"=>"09:00 PM",
"21:30:00"=>"09:30 PM",
"22:00:00"=>"10:00 PM",
"22:30:00"=>"10:30 PM",
"23:00:00"=>"11:00 PM",
"23:30:00"=>"11:30 PM"
);
?>
<div class="look-control look-control-bed"> 
	<form id="addmealjournal">
			<fieldset class="mealjournal">
			<label>Meal type</label>
			<select name="jmealtype">
				<option value="Breakfast">Breakfast</option>
				<option value="Snack">Snack</option>
				<option value="Lunch">Lunch</option>
				<option value="Dinner">Dinner</option>
			</select>
			</fieldset>
			<fieldset class="mealjournal">
				<label>Date </label><input type="text" readonly name="jdate" value="<?php echo date("Y-m-d");?>" id="mdatepicker" /><a href="" class="cal-ico"></a>
		    </fieldset>						
			<fieldset class="mealjournal">
				<label>Time </label>
				<select name="jmealttime">
						<?php
						 foreach($dailytime as $key=>$value)
						 {
						 ?>
							<option value="<?php echo $key;?>"><?php echo $value;?></option>
						 <?php
						 }
						?>
				</select>
		    </fieldset>
		<input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>" />
		<div class="right-align-button" style="text-align:right;padding:5px 105px 0 0;">
				<a class="sexybutton sexyorange" id="addrecipejournal" href="javascript:void(0);"><span><span class="editWakeFormSubmit">Submit</span></span></a>
		</div>
	</form>
</div>
<div class="b b2">
<div class="add-popup-bottomleft">
  <div>&nbsp;</div>
</div>
</div>