<link media="all" rel="stylesheet" href="application/views/_assets/css/eatingJournal.css" type="text/css" />

<div id="addMeal" style="display:none;">
	<div class="center center-bg">
		<div class="content">
			<form id="addMealForm">
			<!-- <input type="hidden" name="MAX_FILE_SIZE" value="100000" /> -->
  			<input type="hidden" name="date"	value="<?=$date?>" />
			<input type="hidden" name="type"	value="<?=$time[0]->type?>" />
			<input type="hidden" name="clear"	value="<?=@$clear?>" />
			<input type="hidden" name="journalmealname"	/>
			<input type="hidden" name="journalmealdescription"	/>
			<div class="schedule-box schedule-box-modal">
				<div class="holder">
					<div class="hours-box hours-box-modal">
						<div class="choice-box">
							<a href="javascript:void(0);" class="up" time="mealTime">up</a>
							<span><input type="text" name="time" id="mealTime" class="mealTimemainclass" value="<?=@$time[0]->time?>" onkeyup="timeCheck(this)" size="8" /></span>
							<a href="javascript:void(0);" class="down" time="mealTime">down</a>
						</div>
					</div>
					<div class="image-box">						
						<span id="journalType">
							<?php
							if (@$utID)
							{
								?>
								<span id="mealType"><?=$time[0]->type?></span>
								<input type="hidden" name="utID" value="<?=$time[0]->utID?>" />
								<?php
							}
							else
							{
								?>
								<select id="meal" name="utID" autocomplete="off" style="width:108px;" onchange="changeMealType(this);">
								<?php
								foreach ($time AS $jt)
								{
									?><option value="<?=$jt->utID?>"><?=$jt->type?></option><?php
								}
								?>
								</select>
								<?php
							}
							?>
						</span>
						<?php
						if (@$time[0]->image)
						{
							?><img src="<?=_UPLOAD_PATH_?>/<?=$time[0]->image[0]->name?>" width="107" height="70" alt="" /><?php
						}
						else
						{
							?>
							<div style="width:107px;height:auto;"><img src="htdocs/images/breakfast-thumb.jpg" alt="" /></div>
							<?php
						}
						?>
						<div><a href="javascript:void(0);" class="upload">Upload photo</a></div>
						<!-- <div id="testResponse"></div> -->
					</div>
					<div class="info_title_box" id="info_title_box_div">
						<?php
							if (@$utID)
							{
								?>
								My <?php echo $time[0]->type; ?>								
								<?php
							}
							else
							echo "My Breakfast";
						?>						
					</div>
					<div class="info-box" style="width:312px;padding:0px;margin:0px;">
						<div style="clear:both;border:1px solid #000;padding:5px 0 5px 0;min-height:80px">
							<ul id="food_items">
								<?php
								if (@$time[0]->journal && (	$time[0]->type == 'Breakfast'
																||
															$time[0]->type == 'Lunch'
																||
															$time[0]->type == 'Dinner'
																||
															$time[0]->type == 'Snack'))
								{
									?><input type="hidden" name="function" value="edit" /><?php
									foreach ($time[0]->journal AS $journal)
									{
										?>
										<input type="hidden" name="original_ujID[]" value="<?=@$journal->ujID?>" />
										<input type="hidden" name="original_name[]" value="<?=@$journal->name?>" />
										<?php
										if ($journal->items)
										{
											if ($journal->name)
											{
												?><div style="clear:both;" id="mealName_<?=@$journal->ujID?>"><strong><?php echo stripslashes($journal->name);?></strong></div><?php
												$inset	= "5";
												$width	= "190";
											}
											else
											{
												$inset = "0";
												$width	= "195";
											}
											foreach ($journal->items AS $item)
											{
												?>
												<li id="food_<?=$item->food_id?>_<?=@$journal->ujID?>" class="foods ujID_<?=@$journal->ujID?>">
													<div style="clear:both;">
														<input type="hidden" name="food_id[<?=@$journal->ujID?>][]"		value="<?=$item->food_id?>" />
														<input type="hidden" name="qty[<?=@$journal->ujID?>][]"	id="qty_food_id_<?php echo $item->food_id;?>"		value="<?=$item->qty?>" />
														<input type="hidden" name="entryname[<?=@$journal->ujID?>][]"	value="<?=$item->entryname?>" />
														<input type="hidden" name="serving[<?=@$journal->ujID?>][]"	id="servings_food_id_<?php echo $item->food_id;?>"	value='<?php echo stripslashes($item->serving);?>' />
														<div style="float:left;padding-left:<?=$inset?>px;">
															<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;
														</div>														
														<div style="float:left;" id="entryname_<?=$item->food_id?>">
															<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_<?=$item->food_id?>" food_id="<?=$item->food_id?>"><?php echo $item->entryname;?></a>
														</div>														
														<div style="float:left;" id="qty_<?=$item->food_id?>"> - <span><?=$item->qty?></span></div> 
														<div style="float:left;" id="serving_<?=$item->food_id?>"> <span><?php echo stripslashes($item->serving); ?></span> </div> 														
														<div style="float:left;">&nbsp;
															<a href="javascript:void(0);" title="delete this item" id="delete_<?=$item->food_id?>_<?=@$journal->ujID?>" food_id="<?=$item->food_id?>" ujID="<?=@$journal->ujID?>">
																<img src="htdocs/images/delete.gif" align="absmiddle" border="0">
															</a>
														</div>
													</div>
													<div style="clear:both;"></div>
												</li>
												<?php
											}
										}
									}
								?>
								<script>submitaddmealform();</script>
								<?php	
								}
								?>
							</ul>
						</div>
						<div id="buttons" style="clear:both;margin:7px 0 0 0;"><!--display:none;">-->
							<!--
							<input type="button" id="saveItems"	value="Save"		style="font-size:12px;width:80px;height:25px;" />
							<input type="button" id="saveMeal"	value="Save Meal"	style="font-size:12px;width:80px;height:25px;" />
							<input type="button" id="copy"		value="Copy"		style="font-size:12px;width:80px;height:25px;" />-->
							<a href="javascript:void(0);" id="saveItems"	class="sexybutton sexyorange"><span><span>Save</span></span></a>
							<a href="javascript:void(0);" id="saveMeal"		class="sexybutton sexyorange"><span><span>Name this Meal</span></span></a>
							<a href="javascript:void(0);" id="copy"	 style="display:none;"		class="sexybutton sexyorange"><span><span>Copy</span></span></a>
						</div>
						<div class="datepicker" id="copyDateDiv" style="display:none;position:absolute;z-index:32000;"></div>
						<div style="position:absolute;z-index:32000;display:none;" id="upload">
							<input type="file" name="upload" size="30" />
						</div>
						<div id="msg" style="display:none;"></div>
					</div>
					<div class="status-box" id="popup_status-box_p" style="width:50px;padding:0px;margin:0px;"><img src="htdocs/images/modal-add-circle.jpg" class="png" alt="" /></div>
				</div>
			</div>
			</form>
			<h2 class="foodmade-level">Add a Food, Beverage or Meal</h2>

			<input type="text" class="add-brk-modal" id="search_value" value="Enter a food, beverage, restaurant, fat loss recipe by name" size="80" onkeyup="foodsearchEvent(event)" />
        <button class="sexybutton sexyorange two-sidepadding" id="search_button"><span><span>Search</span></span></button>

			<div id="foodSearchResults" style="display:none;padding:5px;padding-bottom:none;"></div>
			<div id="getQuantity" style="display:none;padding:5px;padding-bottom:none;"></div>
			<br /><br />

			<div id="addMealTabs" class="tabs-holder">
				<ul class="tabset">
					<li id="recentFavs_tab"><div><span><a href="javascript:void(0);"	class="tab" tab="recentFavs">Recent &amp; Favorites</a></span></div></li>
					<!--
					<li id="recentEaten_tab"><div><span><a href="javascript:void(0);"	class="tab" tab="recentEaten">Recently Eaten Foods</a></span></div></li>
					<li id="findFood_tab"><div><span><a href="javascript:void(0);"		class="tab" tab="findFood">Find Something to Eat</a></span></div></li> -->
					<li id="suggest_tab"><div><span><a href="javascript:void(0);"		class="tab" tab="suggest">Suggestions</a></span></div></li>
				</ul>
				<div id="recentFavs"	class="tab-content" style="display:none;">
					<div class="columns-holder">
						<div class="column"><?=$favoriteMeals?></div>
						<div class="column"><?=$recentMeals?></div>
						<div class="column"><?=$recentItems?></div>
					</div>
				</div>
				<!--
				<div id="recentEaten"	class="tab-content" style="display:none;">
					Recent Eaten
				</div>
				<div id="findFood"		class="tab-content" style="display:none;">
					Find
				</div> -->
				<div id="suggest"		class="tab-content" style="display:none;height:304px;">
					Suggest
				</div>
			</div>
		</div>
	</div>
	<div class="b b2">
		<div class="add-popup-bottomleft">
		  <div>&nbsp;</div>
		</div>
	  </div>
</div>

<div id="addExercise" style="display:none;">
	<?php
	//var_dump($time[0]);
	function checkExercise($items=false, $type)
	{
		if (@$items)
		{
			foreach ($items AS $exercise)
			{
				if ($exercise->entryname == $type)
				{
					return true;
				}
			}
		}
		return false;
	}
	?>
	<div class="look-control look-control-bed">
	<div class="center">
		<div class="content">
			<form id="addExerciseForm">
			<input type="hidden" name="date" value="<?=$date?>" />
			<!-- <input type="hidden" name="type" value="Exercise" /> --><!-- "<?=$time[0]->type?>" /> -->
			<input type="hidden" name="utID" value="<?=$time[0]->utID?>" />
			<?php
			if (@$time[0]->journal && $time[0]->type == 'Exercise')
			{
				?>
				<input type="hidden" name="function" value="edit" />
				<input type="hidden" name="original_ujID[]" value="<?=@$time[0]->journal[0]->ujID?>" />
				<?php
			}
			?>
			<div>
				<div class="select-option"><b>Exercise Type:</b>
					<!--
					<input type="checkbox" name="entryname[<?=@$time[0]->journal[0]->ujID?>][]" <?php if (checkExercise(@$time[0]->journal[0]->items, "Cardio")) { ?>CHECKED<?php } ?>		value="Cardio" /> Cardio
					<input type="checkbox" name="entryname[<?=@$time[0]->journal[0]->ujID?>][]" <?php if (checkExercise(@$time[0]->journal[0]->items, "Resistance")) { ?>CHECKED<?php } ?>	value="Resistance" /> Resistance -->
					<input type="radio" name="entryname[<?=@$time[0]->journal[0]->ujID?>][0]" <?php if (checkExercise(@$time[0]->journal[0]->items, "Cardio")) { ?>CHECKED<?php } ?>	id="cardioexercise"	value="Cardio" /> Cardio
					<input type="radio" name="entryname[<?=@$time[0]->journal[0]->ujID?>][0]" <?php if (checkExercise(@$time[0]->journal[0]->items, "Resistance")) { ?>CHECKED<?php } ?> id="resistanceexercise" value="Resistance" /> Resistance
				</div>				
				<div class="display-oneline" style="padding:15px 0;">
					<div class="titme-title">Time : </div>
					<div class="hours-box">
						<div class="choice-box">
							<a href="javascript:void(0);" class="up" time="exerciseTime">up</a>
							<span><input type="text" name="time" id="exerciseTime" value="" size="8" style="background:#FFF;"  /></span>
							<a href="javascript:void(0);" class="down" time="exerciseTime">down</a>
						</div>						
					</div>
				<div style="float:right;padding:08px 80px;">		
					<input type="text" id="duration" size="5" value="<?=@str_replace(" minutes","",$time[0]->journal[0]->name)?>" /> Minutes					
				</div>	
				</div>				
			</div>
			</form>
		</div>
		</div>
	</div>
</div>
