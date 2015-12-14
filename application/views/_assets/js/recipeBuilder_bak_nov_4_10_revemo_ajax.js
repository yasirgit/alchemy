var ingredientAdd	= false;
var ingredient		= '';
var numDirections	= 3;
var directionText	= Array();
var totalFat		= 0;
var totalCarbs		= 0;
var totalProtein	= 0;
var totalCalories	= 0;

function buildDirections()
{
	$('#directions').empty();
	for (x=1; x <= numDirections; x++)
	{
		var text = '';
		if (directionText[x-1])
		{
			text = directionText[x-1];
		}
		var direction = '<tr id="direction_'+x+'">'+
							'<td>Step '+x+':</td>'+
							'<td><textarea rows="3" style="width:450px;" name="directions[]" class="required">'+text+'</textarea></td>'+
							'<td>'+
								'<a href="javascript:void(0);" class="directionRemove" directionNum="'+x+'">';
		if (x > 1) direction +=		'<img src="htdocs/images/dialog-close.png" alt="Remove this direction" title="Remove this direction" /></td>';
		direction +=			'</a>'+
							'</td>'+
						'</tr>';
		$('#directions').append(direction);
	}

	$('.directionRemove').click(
			function()
			{
				if (numDirections <= 1)
				{
					alert("You must have at least one step");
					return false;
				}
				directionText = Array();
				for (x=1, y=0; x <= numDirections; x++)
				{
					if (x != $(this).attr('directionNum'))
					{
						directionText[y] = $('#direction_'+x+' textarea').val();
						y++;
					}
				}

				numDirections--;
				buildDirections();
			});
}

function buildServing(response, food_id, type)
{
	if (response.error_code == 0)
	{
		$('#getQuantity #portionid').empty();
		$('#getQuantity #name').text(response.foods.food_name);
		$('#getQuantity #food_id').val(food_id);
		if (response.foods.servings[0].serving.length)
		{
			for (x=0; x < response.foods.servings[0].serving.length; x++)
			{
				var description = response.foods.servings[0].serving[x].measurement_description;
				if (description == "Quantity not specified")
				{
					description = Number(response.foods.servings[0].serving[x].metric_serving_amount) + response.foods.servings[0].serving[x].metric_serving_unit;
				}
				id =	response.foods.servings[0].serving[x].serving_id+'~'+
						+response.foods.servings[0].serving[x].calories+'~'+
						+response.foods.servings[0].serving[x].carbohydrate+'~'+
						+response.foods.servings[0].serving[x].protein+'~'+
						+response.foods.servings[0].serving[x].fat;

				var selected = '';
				if ($('.ingredient #serving_'+food_id).text() == description)
				{
					selected = "SELECTED";
				}
				$('#getQuantity #portionid').append('<option value="'+id+'" '+selected+'>'+description+'</option>');
			}
		}
		else
		{
			var description = response.foods.servings[0].serving.measurement_description;
			if (description == "Quantity not specified")
			{
				description = Number(response.foods.servings[0].serving.metric_serving_amount) + response.foods.servings.serving.metric_serving_unit;
			}
			id =	response.foods.servings[0].serving.serving_id+'~'+
					+response.foods.servings[0].serving.calories+'~'+
					+response.foods.servings[0].serving.carbohydrate+'~'+
					+response.foods.servings[0].serving.protein+'~'+
					+response.foods.servings[0].serving.fat;
			$('#getQuantity #portionid').append('<option value="'+id+'">'+description+'</option>');
		}

		if (type == "add")
		{
			//SHAHED to set food name
			//$('#getQuantity #entryname').val(ingredient);
			if(response.foods.food_name!="")
			$('#getQuantity #entryname').val(response.foods.food_name);
			//SHAHED			
			$('#getQuantity #qty').val( 1 );
			$('#getQuantity_table #add_quantity').remove();
			$('#getQuantity_table #edit_quantity').remove();
			$('#getQuantity_table').append(
				'<tr id="add_quantity">'+
					'<td colspan="2">'+
						'<input type="button" id="add" value="Add" /> or <input type="button" id="cancel" value="Cancel" />'+
					'</td>'+
				'</tr>');
			$('#getQuantity #add').click(
				function()
				{
					var food_id		= $('#getQuantity #food_id').val();
					var qty			= $('#getQuantity #qty').val();
					var entryname	= $('#getQuantity #entryname').val();
					var serving		= $('#getQuantity #portionid option:selected').text();
					var nutrition	= $('#getQuantity #portionid option:selected').val();
					addIngredient(food_id,qty,entryname,serving,nutrition)
					calcNutrition();
					ingredientAdd = false;
					$('#addItem').css('background','#FFFFFF');
					$('#ingredientSearch').hide();
					$('#ingredientSearchResults').hide();
					$('#getQuantity').hide();
				});
			$('#getQuantity #cancel').click(
				function()
				{
					ingredientAdd = false;
					$('#addItem').css('background','#FFFFFF');
					$('#ingredientSearch').hide();
					$('#ingredientSearchResults').hide();
					$('#getQuantity').hide();
				});
		}
		else
		{
			$('#getQuantity #entryname').val( $('.ingredient #entryname_'+food_id).text() );
			$('#getQuantity #qty').val( $('.ingredient #qty_'+food_id).text() );
			$('#getQuantity_table #add_quantity').remove();
			$('#getQuantity_table #edit_quantity').remove();
			$('#getQuantity_table').append(
				'<tr id="edit_quantity">'+
					'<td colspan="2">'+
						'<input type="button" id="edit" value="Edit" /> or <input type="button" id="cancel" value="Cancel" />'+
					'</td>'+
				'</tr>');
			$('#getQuantity #edit').click(
				function()
				{
					var food_id		= $('#getQuantity #food_id').val();
					var qty			= $('#getQuantity #qty').val();
					var entryname	= $('#getQuantity #entryname').val();
					var serving		= $('#getQuantity #portionid option:selected').text();
					var nutrition	= $('#getQuantity #portionid option:selected').val();
					editIngredient(food_id,qty,entryname,serving,nutrition)
				//	editIngredient();

				//	$('#qty_'+food_id).text( qty );				$('#ingredient_'+food_id+' [name=qty[]]').val( qty );
				//	$('#serving_'+food_id).text( serving );		$('#ingredient_'+food_id+' [name=serving[]]').val( serving );
				//	$('#entryname_'+food_id).text( entryname );	$('#ingredient_'+food_id+' [name=entryname[]]').val( entryname );

					calcNutrition();
					ingredientAdd = false;
					$('#addItem').css('background','#FFFFFF');
					$('#ingredientSearch').hide();
					$('#ingredientSearchResults').hide();
					$('#getQuantity').hide();
				});
			$('#getQuantity #cancel').click(
				function()
				{
					ingredientAdd = false;
					$('#addItem').css('background','#FFFFFF');
					$('#ingredientSearch').hide();
					$('#ingredientSearchResults').hide();
					$('#getQuantity').hide();
				});
			$('#addItem').css('background','#FDF7E8');
		}

		$('#ingredientSearch').hide();
		$('#ingredientSearchResults').hide();
		$('#getQuantity').show();
	}
	else
	{
		alert(response.error_msg);
	}
}

function showIngredient(food)
{
	brand = '';
	if (food.food_type == "Brand")
	{
		brand = '<span style="font-size:11px;">(' + food.brand_name + ')</span>';
	}
	$('#ingredientSearchResults').append(
		'<div>'+
			'<a href="javascript:void(0);" class="getQuantity" style="font-weight:bold;" title="add.." food_id="'+food.food_id+'" food_name="'+food.food_name+'">'+
				'<img src="htdocs/images/myfs_tri.gif">&nbsp;'+food.food_name+
			'</a>&nbsp;'+brand+
			'<div>'+
				'<div class="smallText">'+food.food_description+'</div>'+							
				'<span class="smallText"><a href="javascript:void(0);" class="getQuantity" title="add..." food_id="'+food.food_id+'" food_name="'+food.food_name+'">add item</a> | <a href="javascript:void(0);" class="viewDetails" url="'+food.food_url+'" title="view food details..." alt="view food details...">view details</a></span>'+
			'<hr />'+
			'</div>'+
		'</div>');
}

function calcNutrition()
{
	var totalFat = 0;
	$('.fat').each( function() { totalFat += Number( $(this).text().replace(",","") ); });
	$('.ingredient #totalFat').text(totalFat.toFixed(2));
	var totalCarbs = 0;
	$('.carbs').each( function() { totalCarbs += Number( $(this).text().replace(",","") ); });
	$('.ingredient #totalCarbs').text(totalCarbs.toFixed(2));
	var totalProtein = 0;
	$('.protein').each( function() { totalProtein += Number( $(this).text().replace(",","") ); });
	$('.ingredient #totalProtein').text(totalProtein.toFixed(2));
	var totalCalories = 0;
	$('.calories').each( function() { totalCalories += Number( $(this).text().replace(",","") ); });
	$('.ingredient #totalCalories').text(totalCalories.toFixed(0));
}

function editIngredient(food_id,qty,entryname,serving,nutrition)
{
//	var food_id		= $('#getQuantity #food_id').val();
//	var qty			= $('#getQuantity #qty').val();
//	var entryname	= $('#getQuantity #entryname').val();
//	var serving		= $('#getQuantity #portionid option:selected').text();

	$('#qty_'+food_id).text( qty );				$('#ingredient_'+food_id+' [name=qty[]]').val( qty );
	$('#serving_'+food_id).text( serving );		$('#ingredient_'+food_id+' [name=serving[]]').val( serving );
	$('#entryname_'+food_id).text( entryname );	$('#ingredient_'+food_id+' [name=entryname[]]').val( entryname );
												$('#ingredient_'+food_id+' [name=nutrition[]]').val( nutrition );

	var nutrition	= $('#getQuantity #portionid option:selected').val().split('~');
	var calories	= (nutrition[1] * qty).toFixed(0);	$('#ingredient_'+food_id+' .calories').text( calories );
	var carbs		= (nutrition[2] * qty).toFixed(2);	$('#ingredient_'+food_id+' .carbs').text( carbs );
	var protein		= (nutrition[3] * qty).toFixed(2);	$('#ingredient_'+food_id+' .protein').text( protein );
	var fat			= (nutrition[4] * qty).toFixed(2);	$('#ingredient_'+food_id+' .fat').text( fat );
}

function addIngredient(food_id,qty,entryname,serving,nutrition)
{
	var nutritiants	= nutrition.split('~');
	var calories	= (nutritiants[1] * qty).toFixed(0);
	var carbs		= (nutritiants[2] * qty).toFixed(2);
	var protein		= (nutritiants[3] * qty).toFixed(2);
	var fat			= (nutritiants[4] * qty).toFixed(2);

	$('.ingredient').append(
		'<tr id="ingredient_'+food_id+'" class="ingredients">'+
			'<input type="hidden" name="food_id[]"		value="'+food_id+'" />'+
			'<input type="hidden" name="qty[]"			value="'+qty+'" />'+
			'<input type="hidden" name="entryname[]"	value="'+entryname+'" />'+
			'<input type="hidden" name="serving[]"		value="'+serving+'" />'+
			'<input type="hidden" name="nutrition[]"	value="'+nutrition+'" />'+
			'<td>'+
				'<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;'+
				'<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_'+food_id+'" food_id="'+food_id+'">'+
					'<span id="qty_'+food_id+'">'+qty+'</span> '+
					'<span id="serving_'+food_id+'">'+serving+'</span> - '+
					'<span id="entryname_'+food_id+'">'+entryname+'</span>'+
				'</a>'+
			'</td>'+
			'<td><input type="checkbox" class="optional" value="1" /></td>'+
			'<td><a href="javascript:void(0);" title="delete this item" id="delete_'+food_id+'" food_id="'+food_id+'"><img src="htdocs/images/delete.gif" border="0"></a></td>'+
			'<td align="right" class="fat">' + fat + '</td>'+
			'<td align="right" class="carbs">' + carbs + '</td>'+
			'<td align="right" class="protein">' + protein + '</td>'+
			'<td align="right" class="calories">' + calories + '</td>'+
			'<td width="10px">&nbsp;</td>'+
		'</tr>');
	$('.ingredient #delete_'+food_id).click(
		function()
		{
			ingredientAdd = false;
			$('#addItem').css('background','#FFFFFF');
			$('#ingredientSearch').hide();
			$('#ingredientSearchResults').hide();
			$('#getQuantity').hide();

			$('#ingredient_' + $(this).attr('food_id')) . remove();
			calcNutrition();
			});
	$('.ingredient #edit_'+food_id).click(
		function()
		{
			doAjax("recipes/fsapi/method:food.get", function(response) { buildServing(response,food_id,'edit'); }, "food_id=" + $(this).attr('food_id'));
//			calcNutrition();
		});
//	calcNutrition();
}

function buildFoods(response)
{
	if (response.error_code == 0)
	{
		$('#ingredientSearchResults').empty();

		var r				= response.foods;
		var nextPage		= Number(r.page_number) + 1;
		var previousPage	= Number(r.page_number) - 1;
		var topRange = (r.max_results * nextPage);

		if (topRange > r.total_results)
		{
			topRange = r.total_results;
		}
		var bottomRange	=	((r.max_results * nextPage)-r.max_results+1);
		$('#ingredientSearchResults').append('<span>Showing ' + bottomRange + '-' + topRange + ' of ' + r.total_results+' &nbsp; </span>');

		if (previousPage < 0)
		{
			$('#ingredientSearchResults').append(' &nbsp; <input type="button" id="more" value="More Results" />');
			$('#ingredientSearchResults #more').click(
				function()
				{
					doAjax("recipes/fsapi/method:foods.search", function(response) { buildFoods(response); }, "page="+nextPage+"&ingredient="+ingredient);
				});
		}
		else if ( (r.max_results * nextPage) > r.total_results)
		{
			$('#ingredientSearchResults').append(' &nbsp; <input type="button" id="previous" value="Previous Results" />');
			$('#ingredientSearchResults #previous').click(
				function()
				{
					doAjax("recipes/fsapi/method:foods.search", function(response) { buildFoods(response); }, "page="+previousPage+"&ingredient="+ingredient);
				});
		}
		else
		{
			$('#ingredientSearchResults').append(' &nbsp; <input type="button" id="previous" value="Previous Results" />');
			$('#ingredientSearchResults #previous').click(
				function()
				{
					doAjax("recipes/fsapi/method:foods.search", function(response) { buildFoods(response); }, "page="+previousPage+"&ingredient="+ingredient);
				});
			$('#ingredientSearchResults').append(' &nbsp; <input type="button" id="more" value="More Results" />');
			$('#ingredientSearchResults #more').click(
				function()
				{
					doAjax("recipes/fsapi/method:foods.search", function(response) { buildFoods(response); }, "page="+nextPage+"&ingredient="+ingredient);
				});
		}
		$('#ingredientSearchResults').append('<hr />');

		if (r.food.length)
		{
			for (x=0; x < r.food.length; x++)
			{
				showIngredient(r.food[x]);
			}
		}
		else
		{
			showIngredient(r.food);
		}
	//	$('.viewDetails').click(
	//		function()
	//		{
	//			alert('show details - '+ $(this).attr('url') );
	//		});
		$(function() {
			$('.viewDetails').click(
				function(e)
				{
					e.preventDefault();
					var $this = $(this);
					var horizontalPadding = 30;
					var verticalPadding = 30;
					$('<iframe id="externalSite" class="externalSite" src="' + $(this).attr('url') + '" />').dialog({
						title:		($this.attr('title')) ? $this.attr('title') : 'External Site',
						autoOpen:	true,
						width:		1040,
						height:		500,
						modal:		true,
						resizable:	true,
						autoResize:	true,
						overlay:	{
										opacity: 0.5,
										background: "black"
									}
					}).width(1040 - horizontalPadding).height(500 - verticalPadding);
				});
			});

		$('#ingredientSearchResults').show();

		$('.getQuantity').click(
			function()
			{
				var food_id = $(this).attr('food_id');
				if ($('#ingredient_'+food_id).length != 0)
				{
					alert("This ingredient has already been added, please edit the existing ingredient");
					return false;
				}
				doAjax("recipes/fsapi/method:food.get", function(response) { buildServing(response,food_id,'add'); }, "food_id=" + $(this).attr('food_id'));
			});
	}
	else
	{
		alert(response.error_msg);
	}
}

$(document).ready(
	function()
	{
		$('#ingredientAdd').click(
			function()
			{
				if (!ingredientAdd)
				{
					ingredientAdd = true;
					$('#addItem').css('background','#FDF7E8');
					$('#ingredientSearch').show();
				}
				else
				{
					ingredientAdd = false;
					$('#addItem').css('background','#FFFFFF');
					$('#ingredientSearch').hide();
					$('#ingredientSearchResults').hide();
					$('#getQuantity').hide();
				}
			});

		$('#directionAdd').click(
			function()
			{
				directionText = Array();
				for (x=1; x <= numDirections; x++)
				{
					directionText[x-1] = $('#direction_'+x+' textarea').val();
				}
				numDirections++;
				buildDirections();
			});

		buildDirections();

		$('#ingredientSearch #submit').click(
			function()
			{
				ingredient = $('#ingredientSearch #ingredient').val();
				if (ingredient.length == 0)
				{
					alert("Please enter an ingredient");
					return false;
				}
				doAjax("recipes/fsapi/method:foods.search", function(response) { buildFoods(response); }, "page=0&ingredient="+ingredient);
			});

		$('#ingredientSearch #cancel').click(
			function()
			{
				ingredientAdd = false;
				$('#addItem').css('background','#FFFFFF');
				$('#ingredientSearch').hide();
				$('#ingredientSearchResults').hide();
			});

		$('#ingredientSearch').hide();

		$('#recipeform').validate(
			{
				submitHandler:	function()
								{
									var str = $('#recipeform').serialize();
									$('#recipeform .optional').each(
									function()
									{
												if($(this).attr('checked'))
												{
													str += "&optional%5B%5D=1";
												}
												else
												{
													str += "&optional%5B%5D=0";
												}
									});
		//alert(str);return false;
									doAjax("recipes/recipeSubmit",
										function(response)
										{
											if (response.error_code == 0)
											{
												//alert('Your recipe has been saved');
												location.href = "recipes/listAll";
											}
											else
											{
												alert(response.error_msg);
											}
										},
										str);
								}
			});

		$('#cancelRecipe').click(
			function()
			{
				$('#recipeform').clearForm()
			});

/*		$('#getRecipes').dialog(
			{
				autoOpen:	false,
				width:		340
			});

		$('.links-block .add').click(
			function()
			{
				doAjax("recipes/getRecipes",
					function(response)
					{
						$('#getRecipes').empty();
						if (response.error_code == 0)
						{
							for (x=0; x < response.recipes.length; x++)
							{
								if (bgColor == "ECD672")
								{
									var bgColor = "C9C299";
								}
								else if (bgColor = "C9C299")
								{
									var bgColor = "ECD672";
								}
								$('#getRecipes').append(
									'<div class="getRecipes" rid="'+response.recipes[x].rID+'" alt="Click to select menu" title="Click to select menu">'+
										'<div style="background:#'+bgColor+';">'+response.recipes[x].title+'</div>'+
										'<div style="background:#'+bgColor+';">'+response.recipes[x].createdOn+'</div>'+
									'</div>');
							}
							$('#getRecipes .getRecipes').click(
								function()
								{
									doAjax("recipes/getRecipes/rID:"+$(this).attr('rID'),
										function(response)
										{
											if (response.error_code == 0)
											{
												$('#recipeform [name=title]')		.val(response.recipes[0].title);
												$('#recipeform [name=description]')	.val(response.recipes[0].desc);
												$('#recipeform [name=portions]')	.val(response.recipes[0].portions);
												$('#recipeform [name=prepTime]')	.val(response.recipes[0].prepTime);
												$('#recipeform [name=cookTime]')	.val(response.recipes[0].cookTime);
												if (response.recipes[0].mealTypes.length)
												{
													for (x=0; x < response.recipes[0].mealTypes.length; x++)
													{
														$('#mealTypes').find('[value="'+response.recipes[0].mealTypes[x].mealType+'"]').attr('checked', true);
													}
												}
												directionText = Array();
												numDirections = response.recipes[0].directions.length;
												if (numDirections)
												{
													for (x=0; x < numDirections; x++)
													{
														directionText[x+1] = response.recipes[0].directions[x].direction;
													}
													buildDirections();
												}
												if (response.recipes[0].servings.length)
												{
													$('.ingredients').empty();
													for (x=0; x < response.recipes[0].servings.length; x++)
													{
														var food_id		= response.recipes[0].servings[x].food_id;
														var qty			= response.recipes[0].servings[x].qty;
														var entryname	= response.recipes[0].servings[x].entryname;
														var serving		= response.recipes[0].servings[x].serving;
														var nutrition	= response.recipes[0].servings[x].nutrition;
														addIngredient(food_id,qty,entryname,serving,nutrition)
													}
													calcNutrition();
												}
												$('#recipeform [name=rID]').val( response.recipes[0].rID );
												$('#saveRecipe').val('Update Recipe');
											}
											else
											{
												alert(response.error_msg);
											}

											$('#getRecipes').dialog('close');
										});
								});
						}
						else
						{
							alert(response.error_msg);
						}
					});
				$('#getRecipes').dialog('open');
			});
*/
		$('.searchResult tr').dblclick(
			function()
			{
				location.href = "users/recipe_finder/rID:" + $(this).attr('rID');
			});

		$('.searchResult .delete').click(
			function()
			{
				if (confirm("Are you sure you want to delete this recipe"))
				{
					location.href = "recipes/delete/rID:" + $(this).attr('rID');
				}
				return false;
			});

	});
