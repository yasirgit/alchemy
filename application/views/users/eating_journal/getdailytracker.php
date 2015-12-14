<?php
 @$daily=$dailyData;
?>
<div id="edailytracker">	
	<span id="etrackerdate" style="display:none;"><?php echo $eDate;?></span>
	<div class="tracker-box">									
		<h3>My Daily Tracker:</h3>
		<div class="water-tracker-box">
			<strong>Water:</strong>
			<ul class="list">
				<li><a class="more" href="javascript:void(0);">more</a></li>
				<li><a class="less" href="javascript:void(0);">less</a></li>
			</ul>
			<ul class="cups-list">
				<?php
				for ($x=1; $x <= _MAX_WATER_; $x++)
				{																							
					if($x==9)
					echo '</ul><ul style="padding: 10px 0pt 0pt 35px;" class="cups-list">';
					
					if (@$daily->cups < $x)
					{
						?><li><?=$x?></li><?php
					}
					else
					{
						?><li class="marked"><?=$x?></li><?php
					}												
				}
				?>
			</ul>
		</div>
		<form class="tracker-form">
			<fieldset>
				<strong>Vitamins &amp; Supplements:</strong>
				<div class="form-holder">
					<div class="row" style="width:86px;">
						<input class="checkbox" daily="vitamins"	autocomplete="off" type="checkbox" <?php if (@$daily->vitamins == 1)	{?>CHECKED<?php } ?> />
						<label for="multi-vitamin">Multi-vitamin</label>
					</div>
					<div class="row" style="width:108px;">
						<input class="checkbox" daily="pills"		autocomplete="off" type="checkbox" <?php if (@$daily->pills == 1)		{?>CHECKED<?php } ?> />
						<label for="pills">5 Way Fat Fighter</label>
					</div>
					<div class="row">
						<input class="checkbox" daily="supplements"	autocomplete="off" type="checkbox" <?php if (@$daily->supplements == 1)	{?>CHECKED<?php } ?> />
						<label for="supplement">Supplement</label>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="list-box">																		
		<h3>My To-Do List:</h3>
		<form>
			<fieldset>
				<div class="row" id="fatBurning"	<?=(@$daily->fatBurning == 0) ? 'style="display:block;"' : '' ;?>>
					<input class="checkbox clear" daily="fatBurning" <?=(@$daily->fatBurning == 1) ? ' checked' : '' ;?>	type="checkbox" autocomplete="off" />
					<label for="fatBurning">Do 36 mins of fat burning cardio</label>
				</div>
				<div class="row" id="nutrition"		<?=(@$daily->nutrition == 0) ? 'style="display:block;"' : '' ;?>>
					<input class="checkbox clear" daily="nutrition"		type="checkbox" <?=(@$daily->nutrition == 1) ? ' checked' : '' ;?> autocomplete="off" />
					<label for="supplements">Take nutritional supplements</label>
				</div>
				<div class="row" id="sleep"			<?=(@$daily->sleep == 0) ? 'style="display:block;"' : '' ;?>>
					<input class="checkbox clear" daily="sleep"			type="checkbox" <?=(@$daily->sleep == 1) ? ' checked' : '' ;?> autocomplete="off" />
					<label for="sleep">Get 7 to 8 hours sleep</label>
				</div>
				<div class="row" id="choose"		<?=(@$daily->choose == 0) ? 'style="display:block;"' : '' ;?>>
					<input class="checkbox clear" daily="choose"		type="checkbox" <?=(@$daily->choose == 1) ? ' checked' : '' ;?> autocomplete="off" />
					<label for="choose">Choose only healthy breads, sweets and fats. Cut back on sodium.</label>
				</div>
			</fieldset>
		</form>
	</div>
</div>