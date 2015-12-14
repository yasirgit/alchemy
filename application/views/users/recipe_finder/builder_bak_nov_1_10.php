<link media="all" rel="stylesheet" href="application/views/_assets/css/recipeBuilder.css" type="text/css" />
<script type="text/javascript" src="application/views/_assets/js/recipeBuilder.js"></script>

<ul class="tools">
	<li><a class="save" href="javascript:void(0);">SAVE AS TEMPLATE</a></li>
	<li><a class="print" href="javascript:void(0);">PRINT</a></li>
</ul>
<div class="links-block">
	<a class="journal" href="users/recipe_finder">My Recipe Builder</a>
	<a class="add" href="recipes/listAll">Submitted Recipes</a>
</div>
<div class="schedule-block">
	<table>
		<tr>
			<td class="leftCell">
				<div class="leftCellContent">
					<form id="recipeform" autocomplete="off">
					<input type="hidden" name="rID" value="<?=@$recipe[0]->rID?>" />
						<div class="breakout">
							<div style="margin:10px;">
								<table>
									<col width="90"/>
									<col width="*"/>
									<tr valign="top">
										<td><b>Recipe Title: <span class="rec"> *</span></b></td>
										<td>
											<input type="text" name="title" value="<?=@$recipe[0]->title?>" class="required" /><br/>
											(Enter an accurate name for your recipe: e.g.: "Chicken Gumbo with Lentils", "Creamy Mustard Horseradish", "Mango Fruit Salad"; don't use your member name)
											<hr/>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Recipe Description: <span class="rec"> *</span></b></td>
										<td>
											<textarea name="description" class="required" rows="2" style="width:99%"><?=@$recipe[0]->desc?></textarea><br/>
											(Enter a brief description of your recipe only, ingredients and directions will be added later. e.g. A versatile Thai beef salad using fresh vegetables and lean beef with a spicy chili lime dressing.)
											<hr/>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Number of Servings: <span class="rec"> *</span></b></td>
										<td>
											<input type="text" name="portions" value="<?=@$recipe[0]->portions?>" class="required" />
											<br />
											(Enter the number of servings this recipe dishes up)
											<hr/>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Preparation Time: <span class="rec"> *</span></b></td>
										<td>
											<input type="text" name="prepTime" id="prepTime" value="<?=@$recipe[0]->prepTime?>" class="required" style="width:30px" />
											<br />
											(Enter the total number of minutes required for preparation)
											<hr/>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Cooking Time: <span class="rec"> *</span></b></td>
										<td>
											<input type="text" name="cookTime" id="cookTime" value="<?=@$recipe[0]->cookTime?>" class="required" style="width:30px" />
											<br />
											(Enter the total number of minutes required for cooking)
										</td>
									</tr>
									<tr valign="top">
										<td><b>Recipe Type: </b></td>
										<td>
											<select name="rtID" style="width:200px;">
												<option value="">Select a recipe type....</option>
												<?php
												if (@$recipeTypes)
												{
													foreach ($recipeTypes AS $recipeType)
													{
														if (@$recipe[0]->rtID == $recipeType->rtID)
														{
															?><option value="<?=$recipeType->rtID?>" SELECTED><?=$recipeType->type?></option><?php
														}
														else
														{
															?><option value="<?=$recipeType->rtID?>"><?=$recipeType->type?></option><?php
														}
													}
												}
												?>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Cuisine Type: </b></td>
										<td>
											<input type="text" name="cuisineType" id="cuisineType" value="<?=@$recipe[0]->cuisineType?>" size="40" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Main Protein: </b></td>
										<td>
											<input type="text" name="mainProtein" id="mainProtein" value="<?=@$recipe[0]->mainProtein?>" size="40" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Main Vegetable: </b></td>
										<td>
											<input type="text" name="mainVegetable" id="mainVegetable" value="<?=@$recipe[0]->mainVegetable?>" size="40" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Main Carb: </b></td>
										<td>
											<input type="text" name="mainCarb" id="mainCarb" value="<?=@$recipe[0]->mainCarb?>" size="40" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Adventurous Dish: </b></td>
										<td>
											<input type="checkbox" name="adventurous" id="adventurous" value="1" <?php if (@$recipe[0]->adventurous == 1) { ?>CHECKED<?php } ?> />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Substitution: </b></td>
										<td>
											<input type="text" name="substitution" id="substitution" value="<?=@$recipe[0]->substitution?>" size="40" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Classification: </b></td>
										<td>
											<?php
											if (@$classification)
											{
												foreach ($classification AS $class)
												{
													if (@$class->rcxID)
													{
														?><input type="checkbox" name="rcID[]" value="<?=$class->rcID?>" CHECKED /><?=$class->name?> &nbsp; <?php
													}
													else
													{
														?><input type="checkbox" name="rcID[]" value="<?=$class->rcID?>" /><?=$class->name?> &nbsp; <?php
													}
												}
											}
											?>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Health Issues: </b></td>
										<td>
											<?php
											if (@$healthIssues)
											{
												foreach ($healthIssues AS $issue)
												{
													if (@$issue->rhixID)
													{
														?><input type="checkbox" name="rhiID[]" value="<?=$issue->rhiID?>" CHECKED /><?=$issue->issue?> &nbsp; <?php
													}
													else
													{
														?><input type="checkbox" name="rhiID[]" value="<?=$issue->rhiID?>" /><?=$issue->issue?> &nbsp; <?php
													}
												}
											}
											?>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Body Type: </b></td>
										<td>
											<select name="bodyType" style="width:200px;">
												<option value="">Select a body type....</option>
												<option value="A" <?php if (@$recipe[0]->bodyType == "A") { ?>SELECTED<?php } ?>>A</option>
												<option value="B" <?php if (@$recipe[0]->bodyType == "B") { ?>SELECTED<?php } ?>>B</option>
												<option value="C" <?php if (@$recipe[0]->bodyType == "C") { ?>SELECTED<?php } ?>>C</option>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<br/>
						<div style="width:100%;display:table">
							<h3>Meal types (e.g.: main meals, desserts, beverages)</h3>
							<hr />
							<div style="margin:10px;">
								<table id="mealTypes" width="100%">
									<tr>
										<td>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[appetizers]"	value="1" >Appetizers</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[soups]"		value="2" >Soups</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[mainDish]"		value="3" >Main Dishes</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[sideDish]"		value="4" >Side Dishes</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[breadsBakes]"	value="5" >Breads & Baked Products</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[salads]"		value="6" >Salads and Salad Dressings</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[sauces]"		value="7" >Sauces and Condiments</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[deserst]"		value="8" >Desserts</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[snacks]"		value="9" >Snacks</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[beverages]"	value="10" >Beverages</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[breakfast]"	value="12" >Breakfast</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[lunch]"		value="13" >Lunch</div>
											<div style="float:left; width:190px;"><input type="checkbox" name="meal_type[other]"		value="11" >Other</div>
										</td>
									</tr>
								</table>
								<?php
								if (@$recipe[0]->mealTypes)
								{
									foreach ($recipe[0]->mealTypes AS $mealType)
									{
										?>
										<script language="javascript">
											$('#mealTypes').find('[value="<?=$mealType->mealType?>"]').attr('checked', true);
										</script>
										<?php
									}
								}
								?>
							</div>
						</div>
						<br />
						<div style="width:100%;display:table">
							<table>
								<tr>
									<td>
										<table class="ingredient">
											<tr>
												<td rowspan="2" valign="middle" width="400"><h3 style="margin-left:-5px;">Ingredients</h3></td>
												<td style="padding-right:3px;color:#666362;" title="Optional">Optional</td>
												<td></td>
												<td style="padding-right:3px;color:#666362;" title="Fat">Fat(g)</td>
												<td style="padding-right:3px;color:#666362;" title="Carbohydrate">Carbs(g)</td>
												<td style="padding-right:3px;color:#666362;" title="Protein">Prot(g)</td>
												<td style="padding-right:3px;color:#666362;" title="Calories">KCals</td>
												<td></td>
											</tr>
											<?php
											$html = '';
											if (@$recipe[0]->servings)
											{
												$totalFat		= 0;
												$totalCarbs		= 0;
												$totalProtein	= 0;
												$totalCalories	= 0;
												foreach ($recipe[0]->servings AS $serving)
												{
													$nutrition = explode("~", $serving->nutrition);
													$totalFat		+= @$nutrition[4] * $serving->qty;
													$totalCarbs		+= @$nutrition[2] * $serving->qty;
													$totalProtein	+= @$nutrition[3] * $serving->qty;
													$totalCalories	+= @$nutrition[1] * $serving->qty;
													$checked		= ($serving->optional == 1) ? "CHECKED" : "";
													$html .=
														'<tr id="ingredient_'.$serving->food_id.'" class="ingredients">
															<input type="hidden" name="food_id[]"	value="'.$serving->food_id.'" />
															<input type="hidden" name="qty[]"		value="'.$serving->qty.'" />
															<input type="hidden" name="entryname[]"	value="'.$serving->entryname.'" />
															<input type="hidden" name="serving[]"	value="'.$serving->serving.'" />
															<input type="hidden" name="nutrition[]"	value="'.$serving->nutrition.'" />
															<td>
																<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;
																<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_'.$serving->food_id.'" food_id="'.$serving->food_id.'">
																	<span id="qty_'.$serving->food_id.'">'.$serving->qty.'</span>
																	<span id="serving_'.$serving->food_id.'">'.$serving->serving.'</span> -
																	<span id="entryname_'.$serving->food_id.'">'.$serving->entryname.'</span>
																</a>
															</td>
															<td><input type="checkbox" class="optional" value="1" '.$checked.' />	</td>
															<td><a href="javascript:void(0);" title="delete this item" id="delete_'.$serving->food_id.'" food_id="'.$serving->food_id.'"><img src="htdocs/images/delete.gif" border="0"></a></td>
															<td align="right" class="fat">'.@number_format($nutrition[4] * $serving->qty,2).'</td>
															<td align="right" class="carbs">'.@number_format($nutrition[2] * $serving->qty,2).'</td>
															<td align="right" class="protein">'.@number_format($nutrition[3] * $serving->qty,2).'</td>
															<td align="right" class="calories">'.@number_format($nutrition[1] * $serving->qty,0).'</td>
															<td width="10px">&nbsp;</td>
														</tr>
														<script language="javascript">
														$(".ingredient #edit_'.$serving->food_id.'").click(
															function()
															{
																doAjax("recipes/fsapi/method:food.get", function(response) { buildServing(response,'.$serving->food_id.',"edit"); }, "food_id=" + '.$serving->food_id.');
															});

														$(".ingredient #delete_'.$serving->food_id.'").click(
															function()
															{
																ingredientAdd = false;
																$("#addItem").css("background","#FFFFFF");
																$("#ingredientSearch").hide();
																$("#ingredientSearchResults").hide();
																$("#getQuantity").hide();

																$("#ingredient_" + '.$serving->food_id.') . remove();
																calcNutrition();
															});
														</script>
														';
												}
											}
											?>
											<tr>
												<td></td>
												<td></td>
												<td title="Total Recipe Fat: -g"			align="right" id="totalFat"><?=@number_format($totalFat,2)?></td>
												<td title="Total Recipe Carbohyrates: -g"	align="right" id="totalCarbs"><?=@number_format($totalCarbs,2)?></td>
												<td title="Total Recipe Protein: -g"		align="right" id="totalProtein"><?=@number_format($totalProtein,2)?></td>
												<td title="Total Recipe Calories: -kcal"	align="right" id="totalCalories"><?=@number_format($totalCalories,0)?></td>
												<td width="10px">&nbsp;</td>
											</tr>
											<?=$html?>
										</table>
									</td>
								</tr>
								<tr class="row">
									<td>
										<div id="addItem" style="padding:5px;">
											<a href="javascript:void(0);" id="ingredientAdd">
												<img src="htdocs/images/add_b.gif" style="vertical-align:middle"/> <b>Add Ingredient</b>
											</a>
											<div id="ingredientSearch" style="display:none;padding:5px;padding-bottom:none;">
												<div style="margin:40px;margin-bottom:0px;margin-top:10px;display:table;font-size:12px;">
													<b>Find an ingredient:</b>&nbsp;&nbsp;
													<input type="text" id="ingredient" size="15" />&nbsp;
													<input type="button" id="submit" value="Search" />
													or
													<input type="button" id="cancel" value="Cancel" />
												</div>
											</div>

											<div id="ingredientSearchResults" style="display:none;padding:5px;padding-bottom:none;">
											</div>
	
											<div id="getQuantity" style="display:none;padding:5px;padding-bottom:none;">
												<input type="hidden" id="food_id" value="" />
												<table id="getQuantity_table">
													<tbody>
														<tr>
															<td width="70">Item: </td>
															<td id="name"></td>
														</tr>
														<tr>
															<td>Description: </td>
															<td><input id="entryname" value="" style="width:280px;" type="text" /></td>
														</tr>
														<tr>
															<td>Quantity: </td>
															<td>
																<input id="qty" value="1" style="padding-top:1px; height:14px; width:30px; font-size:8pt; vertical-align:middle;" type="text" />
																<select id="portionid" autoformat="off" style="height:20px; padding-bottom:0px; vertical-align:middle;"></select>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<br />
						<div>
							<h3>Directions</h3>
							<hr />
							<div style="margin:10px;">
								<table class="generic" width="100%" id="directions">
									<?php
									if (@$recipe[0]->directions)
									{
										for ($x=0; $x < count($recipe[0]->directions); $x++)
										{
											?>
											<script language="javascript">
												directionText[<?=$x?>] = "<?=$recipe[0]->directions[$x]->direction?>";
											</script>
											<?php
										}
										?>
										<script language="javascript">
											numDirections = "<?=count($recipe[0]->directions)?>";
										</script>
										<?php
									}
									?>
								</table>
							</div>
							<div>
								<a href="javascript:void(0);" id="directionAdd">
									<img src="htdocs/images/add_b.gif" style="vertical-align:middle"/> <b>Add more directions</b>
								</a>
							</div>
						</div>
						<br />
					</div>
					<div align="right">
						<input type="submit"	id="saveRecipe"		value="Save Recipe"	name="saveRecipe" />
						or
						<input type="button"	id="cancelRecipe"	value="Cancel" />
					</div>
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>
<div id="getRecipes">
</div>

