<script type="text/javascript" src="htdocs/js/jquery.metadata.js"></script>
<script type="text/javascript" src="htdocs/js/jquery.validate.js"></script>
<style>
/*.signup-recipe .text-box label.error{ width:250px;padding:8px;} */
</style>

<script type="text/javascript"> 
	/*$(document).ready(function() { 
	  /*$("#recipeform").validate({ 
		
	  });*/ 
		/*$('#saveRecipe').click(function(){
			$("#recipeform").validateMyForm();
		});
	}); */
	
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#recipeform").validate();
	});
		
</script> 
<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>
<div class="how-do-use"><a class="about-page" href="#">How do I use this page</a><a href="recipefinder/" class="return-to">&lt; Return to Recipe Finder</a></div>

<h2 class="new-reciepe-head">New Recipe</h2>
<form id="recipeform"  enctype="multipart/form-data" method="post" action="recipes/recipeSubmit" class="signup-form signup-form-update">
	<fieldset><input type="hidden" name="rID" value="<?php echo @$recipe[0]->rID;?>" />
		<div class="block-in-blue block-in-blue-light">
			<div class="block-in-holder-blue">
				<div class="block-in-frame-blue">
					<div class="block-in-title-blue">
						<h2>Create a new recipe</h2>
					</div>
					<div class="signup-recipe">
						<div class="row row-indent">
							<label for="title">Recipe Title:</label>
							<div class="text-box">
								<div class="row">
									<span class="text">
									<input type="text" name="title" id="title" value="<?php echo @$recipe[0]->title;?>" validate="required:true" />
									</span>
								</div>
								<p><label for="title" class="error" style="display:none;">Please enter title!</label></p>
								<p>(Enter an accurate name for your recipe: e.g.: &quot;Chicken Gumbo with Lentils&quot;,<br />&quot;Creamy Mustard Horseradish&quot;, &quot;Mango Fruit Salad&quot;; don't use your member name)</p>
							</div>
						</div>
						<div class="row row-indent row-indent-up">
							<label for="description" class="label">Recipe Description:</label>
							<div class="text-box">
								<div class="row">
									<span class="textarea">
										<textarea name="description"  id="description" validate="required:true" rows="2" style="width:99%"><?php echo @$recipe[0]->desc;?></textarea>
									</span>
								</div>
								<p><label for="description" class="error" style="display:none;">Please enter description!</label></p>
								<p>(Enter a brief description of your recipe only, ingredients and directions will be added later. e.g. A versatile Thai beef salad using fresh vegetables and lean beef with a spicy chili lime dressing.)</p>
							</div>
						</div>
						<div class="row row-indent">
							<div class="text-box">
								<label for="number">Number of Servings*:</label>
								<div class="text-area">
									<div class="row">										
										<select name="portions" class="serving-options" style="width:200px;" id="number">
											<?php
											for($i=1;$i<=12;$i++)
											{
											?>
											<option value="<?php echo $i;?>" <?php if(!empty($recipe[0]->portions) && $recipe[0]->portions==$i){?>Selected<?}?>><?php echo $i;?></option>
											<?php
											}
											?>											
										</select>
									</div>
									<p>(Enter the number of servings this recipe dishes up)</p>
								</div>
							</div>
						</div>
							<div class="row row-indent">
							<div class="text-box preparation">
								<label for="preperation">Preperation Time*:</label>
								<div class="text-area">
									<div class="row">
										<strong style="font-weight: bold">Active Time:</strong>
										<span class="text">
										<input type="text" id="prepActiveTime" name="prepActiveTime" value="<?php if(!empty($recipe[0]->prepActiveTime))echo $recipe[0]->prepActiveTime;//else echo 0;?>" validate="required:true" /></span>
                                                                               	<strong>mins</strong>
										<strong style="font-weight: bold">Inactive Time:</strong>
										<span class="text">
										<input type="text" id="prepInactiveTime" name="prepInactiveTime" value="<?php if(!empty($recipe[0]->prepInactiveTime))echo $recipe[0]->prepInactiveTime;//else echo 0;?>" validate="required:true" style="width:30px" /></span>
                                                                                <strong>mins</strong>
									</div>
									<p><label for="prepActiveTime" class="error" style="display:none;">Please enter active time!</label></p>
									<p><label for="prepInactiveTime" class="error" style="display:none;">Please enter inactive time!</label></p>
									<p>(Enter the total number of minutes required for preparation)</p>
								</div>
							</div>
						</div>
						<div class="row row-indent">
							<div class="text-box preparation">
								<label for="cooking">Cooking Time*:</label>
								<div class="text-area">
									<div class="row">
										<span class="text"><input type="text" name="cookTime" id="cooking_time" value="<?php if(!empty($recipe[0]->cookTime))echo $recipe[0]->cookTime; //else echo 0;?>" validate="required:true" style="width:30px" /></span>
                                                                                <strong>mins</strong>
										<?php $total_time=0;if(!empty($recipe[0]->prepActiveTime)){$total_time+=$recipe[0]->prepActiveTime;} if(!empty($recipe[0]->prepInactiveTime)){$total_time+=$recipe[0]->prepInactiveTime;} if(!empty($recipe[0]->cookTime)){$total_time+=$recipe[0]->cookTime;}?>
										<strong style="font-weight: bold">Total Time: <span id="total_time"><?php echo $total_time;?></strong>
									</div>
									<p><label for="cooking_time" class="error" style="display:none;">Please enter cooking time!</label></p>
									<p>(Enter the total number of minutes required for cooking)</p>
								</div>
							</div>
						</div>
						<div class="row row-indent meal-type">
							<div class="text-box preparation">
								<label for="cooking">Meal Type:</label>
								<div class="text-area">
									<div class="row">
										<?php 
										if (!empty($recipeTypes))
										{											
										$icon=0;$fcount=count($recipeTypes);
										?>	
											<?php   
											foreach ($recipeTypes AS $ind=>$rType)
											{												
											?>												
												<input type="checkbox" name="recipe_mealType_selections[]" value="<?php echo $rType->id;?>" id="<?php echo $rType->name;?>" 
												<?php
												if(count($recipe_mlType_slc)>0)
												{
													foreach($recipe_mlType_slc as $mt)
													{
														if($mt->name == $rType->name)
														echo "checked";
													}
												}
												?> /> <?php echo $rType->name;?>
											<?php											
											}
										}
										?>										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="block-in-blue block-in-blue-light-green">
			<div class="block-in-holder-blue">
				<div class="block-in-frame-blue">
					<div class="block-in-title-blue">
						<h2>Ingredients <span>(Use item name, e.g.: "white flour (all purpose)", not "flour")</span></h2>
					</div>
					<div class="signup-type">
						<!--Ingredients area START-->
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
												<td style="padding-right:3px;color:#666362;" title="Calories">Cals</td>
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
													$totalFat	+= @$nutrition[4] * $serving->qty;
													$totalCarbs	+= @$nutrition[2] * $serving->qty;
													$totalProtein	+= @$nutrition[3] * $serving->qty;
													$totalCalories	+= @$nutrition[1] * $serving->qty;
													$checked	= ($serving->optional == 1) ? "CHECKED" : "";
													$html .=
														'<tr id="ingredient_'.$serving->food_id.'" class="ingredients">
															<input type="hidden" name="food_id[]"	value="'.$serving->food_id.'" />
															<input type="hidden" name="qty[]"	value="'.$serving->qty.'" />
															<input type="hidden" name="entryname[]"	value="'.$serving->entryname.'" />
															<input type="hidden" name="serving[]"	value="'.stripslashes(htmlspecialchars($serving->serving)).'" />
															<input type="hidden" name="nutrition[]"	value="'.$serving->nutrition.'" />															
															<td>
																<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;
																<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_'.$serving->food_id.'" food_id="'.$serving->food_id.'">
																	<span id="qty_'.$serving->food_id.'">'.$serving->qty.'</span>
																	<span id="serving_'.$serving->food_id.'">'.stripslashes($serving->serving).'</span> -
																	<span id="entryname_'.$serving->food_id.'">'.$serving->entryname.'</span>
																</a>
															</td>															
															<td><input type="checkbox" class="optional" value="1" '.$checked.' style="width:50px;" /></td>
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
												<td title="Total Recipe Fat: -g"		align="right" id="totalFat"><?=@number_format($totalFat,2)?></td>
												<td title="Total Recipe Carbohyrates: -g"	align="right" id="totalCarbs"><?=@number_format($totalCarbs,2)?></td>
												<td title="Total Recipe Protein: -g"		align="right" id="totalProtein"><?=@number_format($totalProtein,2)?></td>
												<td title="Total Recipe Calories: -kcal"	align="right" id="totalCalories"><?=@number_format($totalCalories,0)?></td>
												<td width="10px">&nbsp;</td>
											</tr>
											<?php echo $html?>
										</table>
									</td>
								</tr>
								<tr class="row">
									<td>
										<div id="addItem" style="padding:5px;">
											<div class="row"><div class="add-area"><a href="javascript:void(0);" id="ingredientAdd" class="btn-add">Add ingredient</a></div></div>
											<!--a href="javascript:void(0);" id="ingredientAdd">
												<img src="htdocs/images/add_b.gif" style="vertical-align:middle"/> <b>Add Ingredient</b>
											</a-->
											<div id="ingredientSearch" style="display:none;padding:5px;padding-bottom:none;">
												<div style="margin:40px;margin-bottom:0px;margin-top:10px;display:table;font-size:12px;">
													<b>Find an ingredient:</b>&nbsp;&nbsp;
													<input type="text" id="ingredient" onkeydown="return recipefoodsearchEvent(event);"  size="15" />&nbsp;
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
						<!--Ingredients area END-->
					</div>
				</div>
			</div>
		</div>
		<div class="block-in-blue block-in-light-blue light-blue-up">
			<div class="block-in-holder-blue">
				<div class="block-in-frame-blue">
					<div class="block-in-title-blue">
						<h2>Directions</h2>
					</div>
					<div class="signup-step" id="directions">
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
						
					</div>
					<p><label for="directions[]" class="error" style="display:none;">Please enter direction!</label></p>
					
					<div class="row">
						<div class="add-area signup-step" id="shift-right">
							<a href="javascript:void(0);" id="directionAdd" class="btn-add">Add more steps</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="block-in-blue block-in-blue-light-green additional-reciep-box">
			<div class="block-in-holder-blue">
				<div class="block-in-frame-blue">
					<div class="block-in-title-blue">
						<h2>Additional recipe information</h2>
					</div>
					<div class="signup-type">
						<div class="row">
							<div class="insFieldset">
								<label class="rectype">Recipe Type:</label>
								<div>
									<span class="text">										
										<select name="rtID" id="rtID" class="select-recipe" validate="required:true">
											<option value="">Select a recipe type....</option>
											<?php
											if(count($only_rcpTps)>0){
												foreach($only_rcpTps as $rtype)
												{
												?>
												<option value="<?php echo $rtype->rtID; ?>" 
												<?php
													if(count($recipe_Type_slc)>0)
													{
														foreach($recipe_Type_slc as $rcsel)
														{
															if($rcsel->recipeTypeId == $rtype->rtID)
															echo "selected";
														}
													}
												?> > <?php echo $rtype->type; ?> </option>
												<?php
												}
											}
											?>
										</select>										
									</span>
								</div>
								<br class="clear" />
							</div>
							<p><label for="rtID" class="error" style="display:none;">Please select a recipe type!</label></p>
							
							<div class="insFieldset">
								<label>Cuisine Type:</label>
								<div><span class="text"><input type="text" name="cuisineType" id="cuisineType" value="<?=@$recipe[0]->cuisineType?>" class="" /></span></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Main Protein:</label>
								<div><span class="text"><input type="text" name="mainProtein" id="mainProtein" value="<?=@$recipe[0]->mainProtein?>" class="" /></span></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Main Vegetable:</label>
								<div><span class="text"><input type="text" name="mainVegetable" id="mainVegetable" value="<?=@$recipe[0]->mainVegetable?>" /></span></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Main Carb:</label>
								<div><span class="text"><input type="text" name="mainCarb" id="mainCarb" value="<?=@$recipe[0]->mainCarb?>" class="" /></span></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Adventurous Dish:</label>
								<div class="check-input"><input type="checkbox" name="adventurous" id="adventurous" value="1" <?php if (@$recipe[0]->adventurous == 1) { ?> checked <?php } ?> /></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Substitution:</label>
								<div><span class="text"><input type="text" name="substitution" id="substitution" value="<?=@$recipe[0]->substitution?>"  class="" /></span></div>
								<br class="clear" />
							</div>
							<div class="insFieldset">
								<label>Dietary Considerations:</label>
								<div class="check-input">
								<?php
								if(count($dietary)>0){
									foreach($dietary as $dtry){
									?>
										<input type="checkbox" name="rcID[]" value="<?php echo $dtry->rcID; ?>" 
										<?php
										if(count($dietary_sel)>0)
										{
											foreach($dietary_sel as $dsel){
												if($dsel->rcID == $dtry->rcID)
												echo "checked";
											}
										}
										?>/>
										&nbsp;&nbsp;<?php echo $dtry->name; ?>&nbsp;&nbsp;&nbsp
									<?php
									if($dtry->rcID%4 == 0)
									echo "<br>";
									}
								}
								?>
								</div>
								<br class="clear" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="block-in-blue block-in-blue-light-green additional-reciep-box">
			<div class="block-in-holder-blue">
				<div class="block-in-frame-blue">
					<div class="block-in-title-blue">
						<h2>Notes or serving suggestions</h2>
					</div>
					<div class="signup-type">
						<div class="row">
							<div class="serving-suggestion"><textarea rows="" name="serving_suggestion" id="serving_suggestion" cols=""><?=@$recipe[0]->note_servSugg?></textarea></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="upload-area">
			<div class="row upload-holder">
				<label>Upload Image: </label>				
				<input type="file" name="recipe_image" id="recipe_image" class="file"/>
				<!-- <div class="sexybutton-area">
					<button type="submit" class="sexybutton sexysimple sexygreen btn-submit">Upload Picture</button>
				</div> -->
			</div>
			<p>People love to see photos of great tasting recipes so why not add some &quot;visual flavor&quot; to your recipe with an image. Click 'Browse&hellip;' to choose your picture from your computer, then press 'upload picture' to change the image. </p>
		</div>
		<div class="btn-area-form">
			<div class="sexybutton-area">
				<button type="submit" class="sexybutton sexysimple sexygreen btn-submit" id="saveRecipe" ><span class="save">Save recipe</span></button>				
			</div>
			<input type="submit" class="btn-cancel" value="Cancel"/>
			<strong>or</strong>
		</div>
	</fieldset>
</form>
<div class="footer-banner"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>


