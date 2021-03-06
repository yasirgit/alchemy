var active		= false;
var weekstart   ="";
var weekend   	="";
var currentmonth="";
var maintoday="";

function load_journal(when)
{		
	$('#saveMealDiv').dialog('close');
	$('#addToJournalDiv').dialog('close');		
	/////////////////////
	if(when=="week")
	var mainparam="when="+when+"&weekstart="+weekstart+"&weekend="+weekend;
	else if(when=="month")
	var mainparam="when="+when+"&currentmonth="+currentmonth;
	else
	var mainparam="when="+when;
	////////////////////////////	
	//get main today////
	doAjax("journal/getToday/",
	function(response)
	{
		if (response.error_code == 0)
		{
			maintoday=response.display;		
			setdefaulttime(when);
		}	
	});
	/////////////////// 		
	$('#bigjornalloading').show();
	/////////////////////////
	doAjax("journal/get",
		function(response)
		{
			$('#bigjornalloading').hide();
			if (response.error_code == 0)
			{																																
				if(when=="week")
				{
					$('#calj_daily').hide();
					$('#calj_monthly').hide();
					$('#calj_weekly').show();
				}
				else if(when=="month")
				{
					$('#calj_daily').hide();					
					$('#calj_weekly').hide();
					$('#calj_monthly').show();
				}
				else
				{					
					$('#calj_weekly').hide();
					$('#calj_monthly').hide();
					$('#calj_daily').show();
				}
				
				
				////////////////////////////////////weekly calendar view///////
				if(when=="week")
				{					
					$('#jumpjournalselected_weekly').html(response.displaytext);					
					$('#jumpexistWeekstart').html(response.weekstart);
					$('#jumpexistWeekend').html(response.weekend);
				}
				else if(when=="month")
				{
					$('#jumpjournalselected_monthly').html(response.displaytext);					
					$('#jumpexistmonth').html(response.currentmonth);					
				}	
				/////////////////////////////////////
				$('#journal_content').empty();
				$('#journal_content').html(response.display);
				$('#nav li').attr('class','');
				$('#nav #' + response.active).attr('class','active');
				active = response.active;
				$('.schedule-box').mouseover(
					function()
					{
						$(this).find('.edit-box').eq(0).show();
					});
				$('.schedule-box').mouseout(
					function()
					{
						$(this).find('.edit-box').hide();
					});
				$('.schedule-box .add').click(
					function()
					{																		
						$('#copyDateDiv').hide();
						$('#addToJournalDiv').empty();
						var clear	= $(this).hasClass('clear');
						var utID	= $(this).attr('utID');						
						doAjax("journal/getAddToJournal/active:"+active+"/utID:"+utID+"/clear:"+clear,
							function(response)
							{
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);									
									switch (response.type)
									{
									default:
										break;
									case "Breakfast":
									case "Lunch":
									case "Dinner":
									case "Snack":
										addMeal(response.time, response.type, "Add");
									break;
									case "Exercise":
										addExercise(response.time);//, response.type);
									break;
									}
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							});
					});
				$('.schedule-box .ate').click(
					function()
					{						
						$('#copyDateDiv').hide();
						var utID = $(this).attr('utID');
						var ujID	= $(this).attr('ujID');
						var date = $(this).attr('date');
						//var str = $('#journalForm_'+utID+'_'+date).serialize();
						var str		= $('#journalForm_'+utID+'_'+ujID+'_'+date).serialize();
						//alert('#journalForm_'+utID+'_'+ujID+'_'+date);						
						doAjax("journal/ate/utID:"+utID+"/date:"+date,
							function(response)
							{
								if (response.error_code == 0)
								{
									load_journal(active);
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);
						
					});
				$('.schedule-box .skipped').click(
					function()
					{
						$('#copyDateDiv').hide();
						if (confirm("Are you sure you want to skip this planned meal"))
						{
							var utID = $(this).attr('utID');
							var ujID	= $(this).attr('ujID');
							var date = $(this).attr('date');							
							var str	= $('#journalForm_'+utID+'_'+ujID+'_'+date).serialize();
							doAjax("journal/skipped/utID:"+utID+"/date:"+date,
								function(response)
								{
									if (response.error_code == 0)
									{
										load_journal(active);
									}
									else
									{
										//alert(response.error_msg);
									}
								},str);
						}
					});
				$('.editJournal').click(				
					function()
					{												
						$('#copyDateDiv').hide();
						$('#addToJournalDiv').empty();
						if ($(this).attr('ujID'))
						{
							var utID	= $(this).attr('utID');
							var ujID	= $(this).attr('ujID');
							var date	= $(this).attr('date');
							//var str		= $('#journalForm_'+utID+'_'+ujID).serialize();							
							var str		= $('#journalForm_'+utID+'_'+ujID+'_'+date).serialize();							
						}
						else
						{
							var utID	= $(this).attr('utID');
							var date	= $(this).attr('date');
							var time	= $(this).attr('time');
							var str		= $('#journalForm_'+utID+'_'+date).serialize();
						}																	
//		alert(utID+" "+date+" "+time)
//		alert(str);return false;
						//doAjax("journal/getEditJournal/utID:"+utID,						
						doAjax("journal/getEditJournal/utID:"+utID+"/ujID:"+ujID,
							function(response)
							{
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);
									switch (response.type)
									{
									default:
										break;
									case "Breakfast":
									case "Lunch":
									case "Dinner":
									case "Snack":
										addMeal(response.time, response.type, "Edit");
									break;
									case "Exercise":
										addExercise(response.time);//, response.type);
									break;
									}
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);
					});
				$('.schedule-box .delete').click(
					function()
					{
						$('#copyDateDiv').hide();
						
						var formname='';
						if ($(this).attr('ujID'))
						{
							var utID	= $(this).attr('utID');
							var ujID	= $(this).attr('ujID');
							var date	= $(this).attr('date');
							formname='journalForm_'+utID+'_'+ujID+'_'+date;
						}
						else
						{
							var utID	= $(this).attr('utID');
							var date	= $(this).attr('date');
							formname='journalForm_'+utID+'_'+date;
						}
					
						/////////////////////////////////delete form modal
						var deletemealform='<div class="alert-box"><div class="alert-box-rptr"><div class="alert-icon-para">Are you sure you want to <br />delete this journal entry?</div><div class="alert-buttons"><a class="sexybutton sexyorange" deleteform="'+formname+'" utID="'+utID+'" id="deletemealok"><span><span>Ok</span></span></a><a class="alert-cancel" id="skipmealcancel">Cancel</a></div></div></div>';									
						$('#addToJournalDiv').html(deletemealform);
						///////////////////////////////////////
						$('#addToJournalDiv').dialog(
						{
							modal:		true,
							title:		"",
							width:		258,
							dialogClass: 'alertbox-wrapper',										
							resizable: false,
							position:	"middle",
							buttons:	{}
						});
						$('#addToJournalDiv').dialog('open');						
					});
				
				//////////////////////////omarbglobal/////edit wake time bed time//////				
				$('.schedule-box .editBedtime').click(
					function()
					{												
						var utID	= $(this).attr('utID');
						var type	= $(this).attr('type');						
						var str		="type="+type;
						doAjax("journal/getEditBedtime/active:"+active+"/utID:"+utID,
							function(response)
							{								
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);
								///////////////////////////////////////
									$('#addToJournalDiv').dialog(
									{
										modal:		true,
										title:		"Edit Bedtime",
										width:		417,
										dialogClass: 'small-scale',
										resizable: false,
										position:	"middle",
										buttons:	{}
									});
								////////////////////////////////////////								
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);						
					});
				
				
				
				$('.schedule-box .editWaketime').click(
					function()
					{
						var utID	= $(this).attr('utID');
						var type	= $(this).attr('type');						
						var str		="type="+type;
						doAjax("journal/getEditWaketime/active:"+active+"/utID:"+utID,
							function(response)
							{								
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);
								///////////////////////////////////////
									$('#addToJournalDiv').dialog(
									{
										modal:		true,
										title:		"Confirm Your Bedtime & Wake Time",
										width:		417,
										dialogClass: 'small-scale',
										resizable: false,
										position:	"middle",
										buttons:	{}
									});
								////////////////////////////////////////								
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);						
					});										
				/////////////////////////////////////////////////////////////////////	
				$('.schedule-box .share').click(
					function()
					{
						alert('share');return false;
						doAjax("journal/twitter",
					//	doAjax("home",
								function(response)
								{
									if (response.error_code == 0)
									{
										load_journal(active);
									}
									else
									{
										//alert(response.error_msg);
									}
								});

			//			$('#shareMealDiv').dialog('open');
						$('#copyDateDiv').hide();
					});
				$('.schedule-box .skip').click(
					function()
					{
						$('#copyDateDiv').hide();
						var utType=$(this).attr('utType');
							//utType=utType!="Exercise"?"meal":utType;
						if(utType!="Exercise"&&utType!="Snack")
						utType="Meal";
						
						var now = $(this).attr('now');
						var crtime=$(this).attr('crtime');
																														
						
						var utID	= $(this).attr('utID');	
						var skstr="utid="+utID;
						/////////////////////////////////skip meal form modal
						if(crtime<now)//past
						{
						  var skipmealform='<div class="alert-box"><div class="alert-box-rptr"><div class="alert-icon-para">Did you really miss your '+utType+'? Try to eat something every 2-3 hours to stay in Fat Burning Mode.</div><div class="alert-buttons"><a class="sexybutton sexyorange" utid="'+utID+'" id="skipmealok"><span><span>Ok</span></span></a><a class="alert-cancel" id="skipmealcancel">Cancel</a></div></div></div>';									
						}
						else//future
						{
						  var skipmealform='<div class="alert-box"><div class="alert-box-rptr"><div class="alert-icon-para">Do you really want to skip your '+utType+'? It\'s important to eat something every 2-3 hours to stay in Fat Burning Mode.</div><div class="alert-buttons"><a class="sexybutton sexyorange" utid="'+utID+'" id="skipmealok"><span><span>Ok</span></span></a><a class="alert-cancel" id="skipmealcancel">Cancel</a></div></div></div>';									
						}
						
						$('#addToJournalDiv').html(skipmealform);
						///////////////////////////////////////
						$('#addToJournalDiv').dialog(
						{
							modal:		true,
							title:		"",
							width:		258,
							dialogClass: 'alertbox-wrapper',										
							resizable: false,
							position:	"middle",
							buttons:	{}
						});
						////////////////////////////////////////								
						$('#addToJournalDiv').dialog('open');
							
					});
			//////////////////////////////////omar bglobal////firsttime login popup
			var isFirstTime=document.getElementById('firsttime_check').innerHTML;			
			if(isFirstTime==1&&when=="today")
			{				
						
						var str		="type=Wakeup&isFirstTime=1";
						doAjax("journal/getEditWaketime/active:"+active,
							function(response)
							{								
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);
								///////////////////////////////////////
									$('#addToJournalDiv').dialog(
									{
										modal:		true,
										title:		"Confirm Your Bedtime & Wake Time",
										width:		419,
										dialogClass: 'small-scale',
										resizable: false,
										position:	"middle",
										buttons:	{}
									});
								////////////////////////////////////////								
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);					
			}							
			////////////////////////////////////////get fatburnig optimizer
			doAjax("journal/getadvice",
			function(adviceresponse)
			{
				//alert(adviceresponse.display);
				$("#twocolumns").append(adviceresponse.display);
				$('.scrollable').html(adviceresponse.dashboard);
				VSA_initScrollbars();//for reload div	
				if(when!="week"&&when!="month")
				{					 
				 $("#edailytracker").html(adviceresponse.lefttracker);				 
				} 
				//$('').dialog('open');				
			},mainparam);						
			////////////////////////////////////////
		}
		else
		{
			//alert(response.error_msg);
		}
	},mainparam);
}

/////////////////////omar bglobal///////check sleep//////
function checkSleep(journeltype)
{
	if(journeltype=="Sleep")
	{
		document.getElementById('typecontenttimearea').style.display="none";
		document.getElementById('contentsleeptime').style.display="block";
	}
	else
	{
		document.getElementById('typecontenttimearea').style.display="block";
		document.getElementById('contentsleeptime').style.display="none";
	}
	//alert(isSleep);
}

function stripslashes (str) 
{
	return (str + '').replace(/\\(.?)/g, function (s, n1)
	{
        switch (n1) {
        case '\\':
            return '\\';
        case '0':  return '\u0000';
        case '':
            return '';
        default:
            return n1;        }
    });
}
function doFoodSearch(nextPage)
{
	var ingredient = $('#search_value').val();
	ingredient=ingredient.replace("&", "~");		
	if (ingredient.length > 0)
	{
		doAjax("journal/fsapi/method:foods.search",
			function(response)
			{
				if (response.error_code == 0)
				{
					$('#foodSearchResults').html(response.foods);
					$('#foodSearchResults').show();
					$('.paging a').click(
						function()
						{
							$('#copyDateDiv').hide();
							var pageNum = $(this).text();
							switch (pageNum)
							{
							default:
								--pageNum;
								break;
							case "NEXT":
								pageNum = nextPage + 1;
								break;
							case "PREV":
								pageNum = nextPage - 1;
								break;
							}
							doFoodSearch( pageNum );
						});
					$('.getQuantity').click(
						function()
						{
							$('#copyDateDiv').hide();
							var food_id = $(this).attr('food_id');
							if ($('#food_'+food_id).length != 0)
							{
								alert("This food item has already been added, please edit the existing item");
								return false;
							}
							doAjax("journal/fsapi/method:food.get/type:add", function(response) { buildServing(response,food_id,'add'); }, "food_id=" + $(this).attr('food_id')+"&pdetails="+$(this).attr('details'));
						});
					////////////////////////////////#ombglobal
					$('.viewDetails').click(
						function()
						{
							$('#copyDateDiv').hide();
							var food_id = $(this).attr('food_id');
							if ($('#food_'+food_id).length != 0)
							{
								alert("This food item has already been added, please edit the existing item");
								return false;
							}
							doAjax("journal/fsapi/method:food.get/type:add", function(response) { buildServing(response,food_id,'add'); }, "food_id=" + $(this).attr('food_id')+"&pdetails="+$(this).attr('details'));
						});
					////////////////////////////////					
				}
				else
				{
					//alert(response.error_msg);
				}
			},
			"page="+nextPage+"&ingredient="+ingredient);
	}
	else
	{
		alert("Please enter a food to search for");
	}
}

//omar----bglobal
function foodsearchEvent(event)
{
	if (!event.which && ((event.charCode || event.charCode === 0) ? event.charCode: event.keyCode)) 
	event.which = event.charCode || event.keyCode;	
	var pK = event.which;                 	
	if(pK==13)
	doFoodSearch(0);	 
}
/////////////////////

function addFood(food_id,qty,entryname,serving)//,nutrition)
{
//	var calories	= (nutrition[1] * qty).toFixed(0);
//	var carbs		= (nutrition[2] * qty).toFixed(2);
//	var protein		= (nutrition[3] * qty).toFixed(2);
//	var fat			= (nutrition[4] * qty).toFixed(2);
	$('#food_items').append(
		'<li id="food_'+food_id+'_0" class="foods">'+
			'<div>'+
				'<input type="hidden" name="food_id[0][]"		value="'+food_id+'" />'+
				'<input type="hidden" name="qty[0][]" id="qty_food_id_'+food_id+'"			value="'+qty+'" />'+
				'<input type="hidden" name="entryname[0][]"		value="'+entryname+'" />'+
				'<input type="hidden" name="serving[0][]"		value="'+escape(serving)+'" />'+
				'<div style="float:left;">'+
					'<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;'+
				'</div>'+	
				'<div style="float:left;" id="entryname_'+food_id+'">'+
					'<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_'+food_id+'" food_id="'+food_id+'">'+entryname+'</a>'+
				'</div>'+
				'<div style="float:left;" id="qty_'+food_id+'"> - <span>'+qty+'</span> </div>'+
				'<div style="float:left;" id="serving_'+food_id+'"> <span>'+serving+'</span> </div>'+
				'<div style="float:left;">&nbsp;'+
					'<a href="javascript:void(0);" title="delete this item" id="delete_'+food_id+'_0" food_id="'+food_id+'" ujID="0">'+
						'<img src="htdocs/images/delete.gif" align="absmiddle" border="0">'+
					'</a>'+
				'</div>'+
			'</div>'+
			'<div style="clear:both;"></div>'+
		'</li>');
	foodControl(food_id,0);
}

function foodControl(food_id,ujID) 
{
	$('.foods #delete_'+food_id+'_'+ujID).click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#food_' + $(this).attr('food_id') + '_' + $(this).attr('ujID')).remove();
			if ($('#food_items li').size() == 0)
			{
				$('#addMealForm #msg').hide();
			}
			if ($(this).attr('ujID'))
			{
				var ujID = $(this).attr('ujID');
				if ( $('.ujID_' + ujID).size() == 0)
				{
					$('#mealName_' + ujID).remove();
				}
			}
			/////////////////////for auto update image journal popup
			submitaddmealform();
		});
	$('.foods #edit_'+food_id).click(
		function()
		{
			$('#copyDateDiv').hide();
			doAjax("journal/fsapi/method:food.get", function(response) { buildServing(response,food_id,'edit'); }, "food_id=" + $(this).attr('food_id'));
		});
}

function buildServing(response, food_id, type)
{
	if (response.error_code == 0)
	{
		$('#getQuantity').html(response.foods);

		if (type == "add")
		{
			$('#getQuantity #add').click(
				function()
				{
					var food_id		= $('#getQuantity #food_id').val();
					var qty			= getQtyValue($('#getQuantity #qty').val());
					var entryname	= $('#getQuantity_table #name').text();
					var serving		= $('#getQuantity #portionid option:selected').text();
					addFood(food_id,qty,entryname,serving);
				//	foodControl(food_id,0);

					$('#copyDateDiv').hide();
					$('#upload').hide();
					$('#buttons [name=save]').show();
					$('#foodSearchResults').hide();
					$('#getQuantity').hide();
					$('#addMealForm #msg').hide();
					/////////////////////for auto update image journal popup
					submitaddmealform();
				});
			$('#getQuantity #cancel').click(
				function()
				{
					$('#copyDateDiv').hide();
					$('#upload').hide();
					$('#foodSearchResults').hide();
					$('#getQuantity').hide();
					$('#addMealForm #msg').hide();
				});
		}
		else
		{			
			//$('#getQuantity_table #qty').val($('#food_'+food_id+' #qty_'+food_id).text());			
			$('#getQuantity_table #qty').val($('#qty_'+food_id+' span').text());
			//var serving = $('#food_'+food_id+' #serving_'+food_id+' span').text();
			var serving = $('#serving_'+food_id+' span').text();			
			$('#getQuantity_table #portionid option').each(
				function()
				{
					if ($(this).text() == serving)
					{
						$(this).attr("selected","selected");
					}
				});

			$('#getQuantity #edit').click(
				function()
				{															
					var qty		= $('#getQuantity #qty').val();						
					var serving	= $('#getQuantity #portionid :selected').text();
					$('#qty_'+food_id).html( " - <span>"+getQtyValue(qty)+"</span> ");
					$('#ingredient_'+food_id+' [name=qty[]]').val(getQtyValue(qty));
					$('#food_'+food_id+' input').eq(1).val(getQtyValue(qty));
					
					//$('#serving_'+food_id).text( serving +")");
					$('#serving_'+food_id).html( " <span>"+serving +"</span> ");
					$('#ingredient_'+food_id+' [name=serving[]]').val( serving );
					$('#food_'+food_id+' input').eq(3).val( serving );
					///////////////////////////////////////for active edit//
					$('#qty_food_id_'+food_id).val( getQtyValue(qty));					
					$('#servings_food_id_'+food_id).val( serving );					
					////////////////////////////////////////
					$('#copyDateDiv').hide();
					$('#upload').hide();
					$('#foodSearchResults').hide();
					$('#getQuantity').hide();
					$('#addMealForm #msg').hide();					
					/////////////////////for auto update image journal popup					
					submitaddmealform();
				});
			$('#getQuantity #cancel').click(
				function()
				{
					$('#copyDateDiv').hide();
					$('#upload').hide();
					$('#foodSearchResults').hide();
					$('#getQuantity').hide();
					$('#addMealForm #msg').hide();
				});
		}

		$('#foodSearchResults').hide();
		$('#getQuantity').show();
		$('#addMealForm #msg').hide();		
	}
	else
	{
		//alert(response.error_msg);
	}
}

/*
 * journal => array
 * 			ujID:9,
 * 			utID:5,
 * 			date:2010-08-18,
 * 			time:07:30:00,
 * 			skipped:0,
 * 			name:test breakfast,
 * 			user_id:46,
 * 			type:Breakfast,
 * 			week_period:weekdays,
 * 			items => array
 * 				ujiID:9,
 * 				ujID:9,
 * 				food_id:33799,
 * 				qty:1,
 * 				entryname:Egg Omelet,
 * 				serving:tbsp,
*/
function addItems(items,ujID)
{
//	var append = '';
	for (x=0; x < items.length; x++)
	{
//		append += '<li id="food_'+items[x].food_id+'" class="foods ujID_'+ujID+'">'+
		$('#food_items').append(
				'<li id="food_'+items[x].food_id+'_'+ujID+'" class="foods ujID_'+ujID+'">'+
					'<div style="clear:both;">'+
						'<input type="hidden" name="food_id['+ujID+'][]"	value="'+items[x].food_id+'" />'+
						'<input type="hidden" name="qty['+ujID+'][]" id="qty_food_id_'+items[x].food_id+'"		value="'+items[x].qty+'" />'+
						'<input type="hidden" name="entryname['+ujID+'][]"	value="'+items[x].entryname+'" />'+
						'<input type="hidden" name="serving['+ujID+'][]"	value="'+escape(stripslashes(items[x].serving))+'" />'+
						'<div style="float:left;">'+
							'<img src="htdocs/images/myfs_cir.gif" style="vertical-align: middle;" width="6" border="0" height="6">&nbsp;'+
						'</div>'+
						'<div style="float:left;" id="entryname_'+items[x].food_id+'">'+
							'<a href="javascript:void(0);" title="edit this item" class="edit" id="edit_'+items[x].food_id+'" food_id="'+items[x].food_id+'">'+items[x].entryname+'</a>'+
						'</div>'+
						'<div style="float:left;" id="qty_'+items[x].food_id+'">- <span>'+items[x].qty+'</span> </div>'+ 
						'<div style="float:left;" id="serving_'+items[x].food_id+'"> <span>'+stripslashes(items[x].serving)+'</span> </div>'+ 
						'<div style="float:left;">&nbsp;'+
							'<a href="javascript:void(0);" title="delete this item" id="delete_'+items[x].food_id+'_'+ujID+'" food_id="'+items[x].food_id+'" ujID="'+ujID+'">'+
								'<img src="htdocs/images/delete.gif" align="absmiddle" border="0">'+
							'</a>'+
						'</div>'+
					'</div>'+
					'<div style="clear:both;"></div>'+
				'</li>');
//				'</li>';
		foodControl(items[x].food_id,ujID);
	}
/////////////////////for auto update image journal popup
submitaddmealform();
//	return append;
}

// helper
function objToString(o)
{
	var s = '{\n';
	for (var p in o)
	{
		s += '	"' + p + '": "' + o[p] + '"\n';
	}
	return s + '}';
}

// helper
function elementToString(n, useRefs)
{
	var attr = "", nest = "", a = n.attributes;

	for (var i=0; a && i < a.length; i++)
	{
		attr += ' ' + a[i].nodeName + '="' + a[i].nodeValue + '"';
	}

	if (n.hasChildNodes == false)
	{
		return "<" + n.nodeName + "\/>";
	}

	for (var i=0; i < n.childNodes.length; i++)
	{
		var c = n.childNodes.item(i);
		if (c.nodeType == 1)	   nest += elementToString(c);
		else if (c.nodeType == 2)  attr += " " + c.nodeName + "=\"" + c.nodeValue + "\" ";
		else if (c.nodeType == 3)  nest += c.nodeValue;
	}

	var s = "<" + n.nodeName + attr + ">" + nest + "<\/" + n.nodeName + ">";
//	return useRefs ? s.replace(/</g,'&lt;').replace(/>/g,'&gt;') : s;
	return s;
};

function addMeal(time, type, title)
{
	$('#addMealTabs #recentFavs_tab').addClass('active');
	$('#addMealTabs #recentFavs').show();
	$('#addMealTabs .tab').click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#addMealTabs li').removeClass('active');
			$('#addMealTabs .tab-content').hide();
			var tab = $(this).attr('tab');
			$('#addMealTabs #'+tab+'_tab').addClass('active');
			$('#addMealTabs #'+tab).show();
		});
	$('#search_value').click(
			function()
			{
				$(this).val('');
				$('#foodSearchResults').hide();
				$('#copyDateDiv').hide();
			});
	$('.upload').click(
			function()
			{
				$('#upload').show();
			});
	$('#addToJournalDiv').dialog(
		{
			modal:		true,
			title:		title+" "+type,
			width:		650,
			dialogClass: false,
			resizable: false,
			height:		"auto",
			position:	"center",
			buttons:	{}
		});
	$('.hours-box .choice-box span input').val( time.toUpperCase() );
	$('.hours-box .choice-box .up').click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#'+$(this).attr('time')).val( addTime($('#'+$(this).attr('time')).val(), 30) );
		});
	$('.hours-box .choice-box .down').click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#'+$(this).attr('time')).val( addTime($('#'+$(this).attr('time')).val(), -30) );
		});
	$('#food_items .foods').each(
		function()
		{
			var food_id = $(this).attr('id').split("_");
			foodControl(food_id[1],food_id[2]);
		});
	
	$('#addMealForm [name=type]').val(type);

	$('#addMealForm #buttons #saveMeal').click(
			function()
			{
				$('#saveMealDivBox').show();					
				$('#copyDateDiv').hide();
				$('#upload').hide();
				$('#addMealForm #msg').html('');
				$('#addMealForm #msg').hide();

				if ($('#food_items li').size() > 0)
				{
					$('#saveMealDiv').dialog('open');
					$('#saveMealDiv [name=saveMealName]').val('');
				}
				else
				{
					$('#addMealForm #msg').html("Please enter a food item");
					$('#addMealForm #msg').show();
					return false;
				}
			});

	$('#addMealForm #buttons #saveItems').click(
		function()
		{
			$('#copyDateDiv').hide();
		//	$('#upload').hide();
			$('#addMealForm #msg').html('');
			$('#addMealForm #msg').hide();
			if ($('#food_items li').size() > 0)
			{
				$('#addMealForm').ajaxSubmit(
					{
						url:			"journal/journalEntry",
						type:			'post',
						dataType:		'xml',//'json',
						beforeSubmit:	function()
										{
											return true;
										},
						success:		function (data)
										{
											if (typeof data == 'object' && data.nodeType)
											{
												var response = elementToString(data.documentElement, true);
											}
											else if (typeof data == 'object')
											{
												var response = objToString(data);
											}
											response = eval ( "(" + response.replace(/(<([^>]+)>)/ig,"") + ")" );
											if (response.trace)
											{
												//alert(response.trace);
											}
											if (response.error_code == 0)
											{
												load_journal(active);
											}
											else
											{
												$('#addMealForm #msg').html(response.error_msg);
												$('#addMealForm #msg').show();
											}
											return false;
										}
					});
				return false;

				// other available options: 
				//target:			'#output1',   // target element(s) to be updated with server response 
				//clearForm: true		// clear all form fields after successful submit 
				//resetForm: true		// reset the form after successful submit 
		 
				// $.ajax options can be used here too, for example: 
				//timeout:   3000 

				
//				var str = $('#addMealForm').serialize();
////alert(str);return false;
//				doAjax("journal/journalEntry",
//					function(response)
//					{
//						if (response.error_code == 0)
//						{
//							load_journal(active);
//						}
//						else
//						{
//							$('#addMealForm #msg').html(response.error_msg);
//							$('#addMealForm #msg').show();
//							return false;
//						}
//					},str);
			}
			else
			{
				$('#addMealForm #msg').html("Please enter a food item");
				$('#addMealForm #msg').show();
				return false;
			}
		});

	$('#addMealForm #buttons #copy').click(
		function()
		{
			$('#addMealForm #msg').html('');
			$('#addMealForm #msg').hide();
			
			if ( $('#copyDateDiv').is(":visible") )
			{
				$('#copyDateDiv').hide();
			}
			else
			{
				$('#copyDateDiv').show();
			}
		});

	$('.datepicker').datepicker(
		{
			onSelect:	function(dateText, inst)
						{
							$('#copyDateDiv').hide();
							$('#upload').hide();
							$('#addMealForm #msg').html('');
							$('#addMealForm #msg').hide();
							if ($('#food_items li').size() > 0)
							{
								var date = dateText.split('/');
								$('#addMealForm [name=date]').val(date[2]+'-'+date[0]+'-'+date[1]);
								$('#addMealForm [name=function]').val('copy');
								var str = $('#addMealForm').serialize();
								doAjax("journal/journalEntry",
									function(response)
									{
										if (response.error_code == 0)
										{
											load_journal(active);
										}
										else
										{
											$('#addMealForm #msg').html(response.error_msg);
											$('#addMealForm #msg').show();
											return false;
										}
									},str);
							}
							else
							{
								$('#addMealForm #msg').html("Please enter a food item");
								$('#addMealForm #msg').show();
								return false;
							}
						}
		});

	$('#addToJournalDiv #addMeal #search_button').click( function() { doFoodSearch(0); });
//	$('#addToJournalDiv #journalEntry').hide();
	$('#addToJournalDiv #addMeal').show();
	$('#addToJournalDiv #addExercise').hide();
	$('#addMealForm #msg').hide();
}

function addExercise(time)//, type)
{		
	$('#addToJournalDiv').dialog(
		{
			modal:		true,
			title:		'Add an Exercise',
			width:		417,
			dialogClass: 'small-scale',			
			position:	"middle",
			resizable: false,
			buttons:	{
							"Save":		function()
										{
											if ($('#addExerciseForm #duration').val() == '')
											{
												alert("Please enter a duration for this exercise");
												return false;
											}
											else
											{
												var name = $('#addExerciseForm #duration').val()+" minutes";
											}
											if ($('#addExerciseForm #cardioexercise').attr('checked') == false
														&&
												$('#addExerciseForm #resistanceexercise').attr('checked') == false)
											{
												alert("Please enter an exercise type");
												return false;
											}
											var str = $('#addExerciseForm').serialize();											
											doAjax("journal/journalEntry/name:"+name,
												function(response)
												{
													if (response.error_code == 0)
													{
														load_journal(active);
													}
													else
													{
														$('#addExerciseForm #msg').html(response.error_msg);
														$('#addExerciseForm #msg').show();
														return false;
													}
												},str);
											$('#addToJournalDiv').dialog('close');
										},
							"Cancel":	function()
										{
											$('#addToJournalDiv').dialog('close');
										}
						}
		});
	$('.hours-box .choice-box span input').val( time.toUpperCase() );
	$('.hours-box .choice-box .up').click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#'+$(this).attr('time')).val( addTime($('#'+$(this).attr('time')).val(), 30) );
		});
	$('.hours-box .choice-box .down').click(
		function()
		{
			$('#copyDateDiv').hide();
			$('#'+$(this).attr('time')).val( addTime($('#'+$(this).attr('time')).val(), -30) );
		});

//	$('#addExerciseForm [name=type]').val(type);

//	$('#addToJournalDiv #journalEntry').hide();
	$('#addToJournalDiv #addMeal').hide();
	$('#addToJournalDiv #addExercise').show();
	$('#addMealForm #msg').hide();
}

function addToJournal(response)
{
	if (response.error_code == 0)
	{
		$('#addToJournalDiv').empty();
		$('#addToJournalDiv').html(response.display);

		$('#search_value').click(
			function()
			{
				$('#foodSearchResults').hide();
				$(this).val('');
			});
	}
	else
	{
		//alert(response.error_msg);
	}
}


function getDisplayDate(when,date,flag)
{
//////////////////////////////////////////////////////test everything////
			var theyear=date.substring(0,4);
			var themonth=date.substring(5,7);
			var thetoday=date.substring(8,10);			
						
			var tempDate=new Date(theyear+","+themonth+","+thetoday);						
			var formatDate;
			
			if(when=="today"&&flag==1)	//1 for next date
			{
				tempDate.setDate(tempDate.getDate() + 1);
				formatDate=$.datepicker.formatDate("M. dd, yy", tempDate);
			}
			else if(when=="today"&&flag==2)	//2 for previous date
			{
				tempDate.setDate(tempDate.getDate() - 1);
				formatDate=$.datepicker.formatDate("M. dd, yy", tempDate);
			}
			else if(when=="week"&&flag==1)	//1 for next week
			{
				tempDate.setDate(tempDate.getDate() + 1);
				formatDate=$.datepicker.formatDate("M. dd, y", tempDate);
				tempDate.setDate(tempDate.getDate() + 6);
				formatDate+=" - "+$.datepicker.formatDate("M. dd, y", tempDate);
			}			
			else if(when=="week"&&flag==2)	//2 for prev week
			{
				tempDate.setDate(tempDate.getDate() - 7);
				formatDate=$.datepicker.formatDate("M. dd, y", tempDate);
				tempDate.setDate(tempDate.getDate() + 6);
				formatDate+=" - "+$.datepicker.formatDate("M. dd, y", tempDate);
			}
			else if(when=="month"&&flag==1)	//1 for next month
			{
				var temp=tempDate.getMonth()+1;
				tempDate.setMonth(temp);
				tempDate.setDate(tempDate.getDate());
				formatDate=$.datepicker.formatDate("MM, yy", tempDate);								
			}
			else if(when=="month"&&flag==2)	//2 for prev month
			{
				var temp=tempDate.getMonth()-1;
				tempDate.setMonth(temp);
				tempDate.setDate(tempDate.getDate());
				formatDate=$.datepicker.formatDate("MM, yy", tempDate);								
			}
			////////////////////////////////////////
			return formatDate;
}

function timeCheck(tempvalue)
{
	var re = /^(\d{1,2}):(\d{2})( [ap]m)?$/i;
	if (!tempvalue.value.match(re))
	{
		  $("."+tempvalue.className).css("color","red");
	}
	else
	{
		$("."+tempvalue.className).css("color","black");
	}
	 
}

function setdefaulttime(tytDate)
{
		var myDate;
		var newFormat;
		var existdate;		
		if(tytDate=="today")
		{
			myDate = new Date(maintoday);							
			newFormat = $.datepicker.formatDate("M. dd, yy", myDate);		
			existdate=$.datepicker.formatDate("yy-mm-d", myDate);
			$('#jumpexistDate').html(existdate);		
			$("#jumpjournalselected").html(newFormat);	
		}
		else if(tytDate=="yesterday")
		{
			myDate=new Date(maintoday);								
			myDate.setDate(myDate.getDate() - 1);
			newFormat = $.datepicker.formatDate("M. dd, yy", myDate);		
			existdate=  $.datepicker.formatDate("yy-mm-d", myDate);
			$('#jumpexistDate').html(existdate);		
			$("#jumpjournalselected").html(newFormat);	
		}		
		else if(tytDate=="tomorrow")
		{
			myDate=new Date(maintoday);								
			myDate.setDate(myDate.getDate() + 1);
			newFormat = $.datepicker.formatDate("M. dd, yy", myDate);		
			existdate=  $.datepicker.formatDate("yy-mm-d", myDate);
			$('#jumpexistDate').html(existdate);		
			$("#jumpjournalselected").html(newFormat);	
		}				
}

////////////on change portion size add to journal ////////
function portionchnage(sText,tempqty,food_id)
{								
	var qty=getQtyValue(tempqty);
	if(qty>0)
	{
		var temp="qty="+qty+"&sid="+sText+"&serving="+$('#portionid').attr('allservings');
		doAjax("journal/getNutritionBox/",
		function(response)
		{
			$('#nutritionchart').html('<img src="htdocs/images/ajax-loader.gif" alt="Loading">');		
			if (response.error_code == 0)
			{
				$('#nutritionchart').html(response.display)
			}					
		},temp);				
	}
}
///////////////////end /////////////////////////////
function changeMealType(obj)
{	
	document.getElementById('info_title_box_div').innerHTML='My '+obj.options[obj.selectedIndex].text;
	var temp="type="+obj.options[obj.selectedIndex].text;
	
	doAjax("journal/getFavourite/",
	function(response)
	{			
		if (response.error_code == 0)
		{
			$('#recentFavs').html(response.display);
		}					
	},temp);	
}
/////////////auto update eating journal popup image/////
function submitaddmealform()
{	
	$('#addMealForm').ajaxSubmit(
	{
		url:			"journal/autoupdatepopup", 
		type:			'post',
		dataType:		'xml',//'json''xml',
		beforeSubmit:	function()
						{},
		success:		function (data)
						{
							if (typeof data == 'object' && data.nodeType)
							{
								var response = elementToString(data.documentElement, true);
							}
							else if (typeof data == 'object')
							{
								var response = objToString(data);
							}
							response = eval ( "(" + response.replace(/(<([^>]+)>)/ig,"") + ")" );
							if (response.error_code == 0)
							{							
								if(response.flag==0)
								{
									$('#popup_status-box_p').html('<img src="htdocs/images/img13.png" id="errorpopupplate" class="png" alt="" />');							
									$('#errorpopupplate').tooltip({
										delay: 0,
										showURL: false,
										bodyHandler: function() {										
											return decodeBase64(response.message);
										}
									});
								}
								else if(response.flag==1)								
								$('#popup_status-box_p').html('<img src="htdocs/images/img15.png" class="png" alt="" />');							
								else
								$('#popup_status-box_p').html('<img src="htdocs/images/modal-add-circle.jpg" class="png" alt="" />');																						
							}
						}
	});
}
/////////////end eating journal popup image/////
$(document).ready(
	function()
	{													
		
		///////////////////favourite recent ////////////////////////	
	$('.favorites .radio').live('click',
		function()
		{						
			$('#copyDateDiv').hide();
			var ujID = $(this).attr('ujID');
			doAjax("journal/getJournal/ujID:"+ujID,
				function(response)
				{
					if (response.error_code == 0)
					{					
						$('#food_items').append('<div style="clear:both;" id="mealName_'+response.journal[0].ujID+'"><strong>'+stripslashes(response.journal[0].name)+'</strong></div>');
						addItems(response.journal[0].items, response.journal[0].ujID);
					}
					else
					{
						//alert(response.error_msg);
					}						
				});
		});
	$('.recentMeals a').live('click',
		function()
		{
			$('#copyDateDiv').hide();
			var ujID = $(this).attr('ujID');
			doAjax("journal/getJournal/ujID:"+ujID,
				function(response)
				{
					if (response.error_code == 0)
					{
						$('#food_items').append('<div style="clear:both;" id="mealName_'+response.journal[0].ujID+'"><strong>'+stripslashes(response.journal[0].name)+'</strong></div>');
						addItems(response.journal[0].items, response.journal[0].ujID);
					}
					else
					{
						//alert(response.error_msg);
					}						
				});
		});
	$('.recentItems .radio').live('click',
		function()
		{			
			$('#copyDateDiv').hide();
			var ujiID = $(this).attr('ujiID');
			doAjax("journal/getItem/ujiID:"+ujiID,
				function(response)
				{
					if (response.error_code == 0)
					{					
						addItems(response.item, 0);
					}
					else
					{
						//alert(response.error_msg);
					}						
				});
		});
		/////////////////////////end favourite recent//////////////
				
		
		////////////////////////////////check up and arrow/////////			
			$('.messages-box .close-opt').live('click',
			function()
			{				
				$('#'+$(this).attr('delid')).hide('slow');
			});
			
			$('.hoursall-box .choice-box .up').live('click',
			function()
			{				
				$('.'+$(this).attr('time')).val( addTime($('.'+$(this).attr('time')).val(), 30) );
			});
			$('.hoursall-box .choice-box .down').live('click',
			function()
			{								
				$('.'+$(this).attr('time')).val( addTime($('.'+$(this).attr('time')).val(), -30) );
			});
		//////////////////////////////////////////////////////////
		
		///////////////////////////////////////				
		$('.calendar-user .jump-to-day a.quick-jump-link').click(
		function()
		{						
			if ( $('#jumpDateDiv').is(":visible") )
			{
				$('#jumpDateDiv').hide();				
			}
			else
			{
				$('#jumpDateDiv').show();				
			}
		});
		
		$('.close-calendar').live('click',
		function()
		{	
			$('#jumpDateDiv').hide();
			$("#asdfds").hide();
			return false;
		});
	//////////////////////////////////skipmealok///////
			$('#skipmealok').live('click',
			function()
			{				
				var utID	= $(this).attr('utID');				
				doAjax("journal/skip/active:"+active+"/utID:"+utID,
				function(response)
				{
					if (response.error_code == 0)
					{
						load_journal(active);
					}						
				});					
			});
			
			$('#deletemealok').live('click',
			function()
			{				
				var deleteformid	= $(this).attr('deleteform');
				var utID=$(this).attr('utID');
				var str=$('#'+deleteformid).serialize();					
				doAjax("journal/delete/utID:"+utID,
				function(response)
				{
					if (response.error_code == 0)
					{
						load_journal(active);
					}					
				},str);					
			});
			
			$('#skipmealcancel').live('click',
			function()
			{
				$('#addToJournalDiv').dialog('close');					
			});	
		//////////////////////////////////next month///////////////
		$('#calj_monthly a.calander-next').click(
		function()
		{									
			var cmonth=$('#jumpexistmonth').html();			
			currentmonth=cmonth;				
			
			$('#jumpjournalselected_monthly').hide("slide", { direction: "left" }, 100);					
			$('#jumpjournalselected_monthly').html(getDisplayDate("month",currentmonth,1));
			$('#jumpjournalselected_monthly').show("slide", { direction: "right" }, 100);
		    
			str="cmonth="+cmonth;	
			doAjax("journal/getNextMonth",
			function(response)
			{
				if (response.error_code == 0)
				{										
					currentmonth   =response.nextmonth;										
					$('#jumpexistmonth').html(currentmonth);		
					$('#jumpjournalselected_monthly').html(response.display);			
					load_journal("month");		
				}				
			},str);			
		});	
		////////////////////////prev month///////////////////////////
		$('#calj_monthly a.calender-prev').click(
		function()
		{									
			var cmonth=$('#jumpexistmonth').html();			
			currentmonth=cmonth;
			
			$('#jumpjournalselected_monthly').hide("slide", { direction: "right" }, 100);					
			$('#jumpjournalselected_monthly').html(getDisplayDate("month",currentmonth,2));	
			$('#jumpjournalselected_monthly').show("slide", { direction: "left" }, 100);	
			
		    str="cmonth="+cmonth;	
			doAjax("journal/getPrevMonth",
			function(response)
			{
				if (response.error_code == 0)
				{										
					currentmonth   =response.nextmonth;										
					$('#jumpexistmonth').html(currentmonth);
					$('#jumpjournalselected_monthly').html(response.display);	
					load_journal("month");	
				}				
			},str);			
		});		
		/////////////////////////next week/////////////////////////
		$('#calj_weekly a.calander-next').click(
		function()
		{						
			
			var we=$('#jumpexistWeekend').html();			
			weekend=we;
			
			$('#jumpjournalselected_weekly').hide("slide", { direction: "left" }, 100);
			$('#jumpjournalselected_weekly').html(getDisplayDate("week",weekend,1));					
			$('#jumpjournalselected_weekly').show("slide", { direction: "right" }, 100);											

		    str="weekend="+weekend;	
			doAjax("journal/getNextWeek",
			function(response)
			{
				if (response.error_code == 0)
				{					
					
					weekstart   =response.weekstart;
					weekend   	=response.weekend;
					
					$('#jumpexistWeekstart').html(response.weekstart);
					$('#jumpexistWeekend').html(response.weekend);
					$('#jumpjournalselected_weekly').html(response.display);															
					load_journal("week");							
					
				}				
			},str);			
		});
		///////////////////////////////////////prev week//////////////////////	
		$('#calj_weekly a.calender-prev').click(
		function()
		{						
			
			var ws=$('#jumpexistWeekstart').html();			
			weekend=ws;
			
			$('#jumpjournalselected_weekly').hide("slide", { direction: "right" }, 100);
			$('#jumpjournalselected_weekly').html(getDisplayDate("week",weekend,2));					
			$('#jumpjournalselected_weekly').show("slide", { direction: "left" }, 100);						
		
		    str="weekend="+weekend;	
			doAjax("journal/getPrevWeek",
			function(response)
			{
				if (response.error_code == 0)
				{					
					
					weekstart   =response.weekstart;
					weekend   	=response.weekend;
					
					$('#jumpexistWeekstart').html(response.weekstart);
					$('#jumpexistWeekend').html(response.weekend);					
					$('#jumpjournalselected_weekly').html(response.display);					
					load_journal("week");							
					
				}				
			},str);			
		});
		/////////////////////////////////////next date/////////////
		$('#calj_daily a.calander-next').click(
		function()
		{						
			var currentdate=$('#jumpexistDate').html();									
		    str="currentdate="+currentdate;	
			
			$('#jumpjournalselected').hide("slide", { direction: "left" }, 100);
			$('#jumpjournalselected').html(getDisplayDate("today",currentdate,1));
			$('#jumpjournalselected').show("slide", { direction: "right" }, 100);
			
			
			doAjax("journal/getNextDate",
			function(response)
			{
				if (response.error_code == 0)
				{										
					$('#jumpjournalselected').html(response.display);						
					$('#jumpexistDate').html(response.nextday);
					load_journal(response.main);							
				}				
			},str);			
		});
		////////////////////////////////////////prev date
		$('#calj_daily a.calender-prev').click(
		function()
		{						
			var currentdate=$('#jumpexistDate').html();			
			
			$('#jumpjournalselected').hide("slide", { direction: "right" }, 100);
			$('#jumpjournalselected').html(getDisplayDate("today",currentdate,2));
			$('#jumpjournalselected').show("slide", { direction: "left" }, 100);	
			
		    str="currentdate="+currentdate;	
			doAjax("journal/getPrevDate",
			function(response)
			{
				if (response.error_code == 0)
				{										
					$('#jumpjournalselected').html(response.display);					
					$('#jumpexistDate').html(response.nextday);
					load_journal(response.main);					
				}				
			},str);											
		});
//////////////////////////////////////////////////////////// all live function /////////////////////
				$('#editBedFormSubmit').live('click', 
				function()					
				{												
					str=$('#editBedForm').serialize();							
					doAjax("journal/saveEditBedtime/active:"+active,
						function(response)
						{								
							if (response.error_code == 0)
							{
								load_journal(active);									
							}
							else
							{
								//alert(response.error_msg);
							}
						},str);
						
				});
				
				$('#editWakeFormSubmit').live('click',
				function()					
				{												
					str=$('#editWakeForm').serialize();						
					doAjax("journal/saveEditWaketime/active:"+active,
						function(response)
						{								
							if (response.error_code == 0)
							{									
								load_journal(active);
								document.getElementById('firsttime_check').innerHTML=0;	
							}
							else
							{
								//alert(response.error_msg);
							}
						},str);
						
				});
				/*****************************************************/														
				$('#addToJournalDiv .submitsleepjournel').live('click',			
					function()
					{
						//var utID		= $(this).attr('utID');																
						var timefrom	= $('[name=journalfromTime]').val();									
						var timeto	= $('[name=journaltoTime]').val();
						
						var dayspecifitime="";
						
						if($('#contentsleeptime [name=daynameweek] :selected').val())
						var dayspecifitime= $('#contentsleeptime [name=daynameweek] :selected').val();									
															
						if($('#editsleepid').val())
						var str="timefrom="+timefrom+"&timeto="+timeto+"&sleepid="+$('#editsleepid').val();
						else
						var str="timefrom="+timefrom+"&timeto="+timeto+"&daynameweekmonth="+dayspecifitime;						
						doAjax("journal/saveSleepJournal/active:"+active+"/timefrom:"+timefrom+"/timeto:"+timeto,
							function(response)
							{
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').dialog('close');
									
									load_journal(active);
									//$('#addToJournalDiv').html(response.display);												
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);
				});	
				/*****************************************************/
				$('#submiteditsleepjournel').live('click',			
						function()
						{
							//var utID		= $(this).attr('utID');																
							var timefrom	= $('[name=journalfromTime]').val();									
							var timeto	= $('[name=journaltoTime]').val();									
																
							if($('#editsleepid').val())
							var str="timefrom="+timefrom+"&timeto="+timeto+"&sleepid="+$('#editsleepid').val();
							else
							var str="timefrom="+timefrom+"&timeto="+timeto;
																					
							doAjax("journal/saveSleepJournal/active:"+active+"/timefrom:"+timefrom+"/timeto:"+timeto,
								function(response)
								{
									if (response.error_code == 0)
									{
										$('#addToJournalDiv').dialog('close');								
										load_journal(active);
										//$('#addToJournalDiv').html(response.display);												
									}
									else
									{
										//alert(response.error_msg);
									}
								},str);
						});
				
//////////////////////////omarbglobal/////edit sleep time//////					
				//$('.schedule-box .editSleeptime').click(
				$('.schedule-box .editSleeptime').live('click',
					function()
					{
						var ujsid	= $(this).attr('ujsid');						
						var str		="ujsid="+ujsid;
						doAjax("journal/editSleeptime/active:"+active,
							function(response)
							{								
								if (response.error_code == 0)
								{
									$('#addToJournalDiv').html(response.display);
								///////////////////////////////////////
									$('#addToJournalDiv').dialog(
									{
										modal: true,
										title:		"Edit Sleeptime",
										width:		417,										
										resizable: false,
										dialogClass: "small-scale",
										position:	"middle",
										buttons:	{}
									});
								////////////////////////////////////////								
									$('#addToJournalDiv').dialog('open');
								}
								else
								{
									//alert(response.error_msg);
								}
							},str);						
					});	
///////////////////////////////////////////////////////////////////////////////////////
		$('.jumppicker').datepicker(
		{			
			onSelect:	function(dateText, inst)
						{							
							$('#jumpDateDiv').hide();
							var myDate = new Date(dateText);							
							var newFormat = $.datepicker.formatDate("M. dd, yy", myDate);
							//
							var testnewformat=$.datepicker.formatDate("yy-mm-d", myDate);
							//
							var original =  $.datepicker.formatDate("yy-m-d", myDate);
							$('#jumpexistDate').html(original);
							
							var tempDate=new Date(maintoday);						
							var today=$.datepicker.formatDate("yy-m-d", tempDate);														
							
							tempDate.setDate(tempDate.getDate() - 1);							
							var yesterday=$.datepicker.formatDate("yy-m-d", tempDate);
							
							tempDate=new Date(maintoday);						
							tempDate.setDate(tempDate.getDate() + 1);
							var tommorow=$.datepicker.formatDate("yy-m-d", tempDate);													
																				
							$("#jumpjournalselected").html(newFormat);
														
							if(original==today)
							newFormat="today";
							else if(original==yesterday)
							newFormat="yesterday";
							else if(original==tommorow)
							newFormat="tomorrow";
							else
							newFormat=testnewformat;	
							
							load_journal(newFormat);
						}
		});
		///////////////////////////////////////
		$('.links-block .add').click(		
			function()
			{												
				$('#copyDateDiv').hide();
				$('#upload').hide();
				$('#addToJournalDiv').empty();
				doAjax("journal/addToJournal/active:"+active,
					function(response)
					{					
						addToJournal(response);						
						if (response.error_code == 0)
						{
							$('#addToJournalDiv').empty();
							$('#addToJournalDiv').html(response.display);
							
							if(active=="month"||active=="week")
							{
								$('#addToJournalDiv').dialog(
								{
									modal:		true,
									title:		'Add Meal, Exercise or Snack',
									width:		417,
									position:	"middle",
									resizable: false,
									dialogClass:	"small-scale",
									buttons:	{}
								});							
							}
							else
							{
							$('#addToJournalDiv').dialog(
								{
									
									modal:		true,
									title:		'Add Meal, Exercise or Snack',
									width:		417,
									position:	"middle",
									resizable: false,
									dialogClass:	"small-scale",
									buttons:	{}
								});
							}	
							$('#addToJournalDiv').dialog('open');

							$('#journalEntry #'+response.ampm).attr('checked', 'true');							
							
							$("#journalTime option[value='"+response.hour+response.minutes+"']").attr("selected", "selected");							

														
							$('#addToJournalDiv .submitjournel').click(
								function()
								{
									//var utID		= $(this).attr('utID');
									///////////////////////weekly and monthly view//////
									if(active=="week"||active=="month")
									{
									/////////////////////										
										var utValue= $('[name=journalType]:checked').val();
										var dayt="dayname="+$('#journalEntry [name=dayname]').val()+"&utValue="+utValue;										
										doAjax("journal/getUtidValue/active:"+active,
												function(response)
												{
													if (response.error_code == 0)
													{
														var utID		= 	response.display;
														/*//////////////////previous work//////////////////
														var time		= $('#journalEntry [name=journalTime] :selected').text();
														var meridiem	= $('#journalEntry [name=meridiem]:checked').val();
														********/
														/////////////new york/////////////////
														var time		= $('[name=journalTime]').val().substring(0,5);									
														var meridiem	= $('[name=journalTime]').val().substring(6);																		
														/////////////end york/////////////////
														var dayname		= $('#journalEntry [name=dayname]').val();										
														doAjax("journal/getAddToJournal/active:"+active+"/utID:"+utID+"/dayname:"+dayname,
															function(response)
															{
																if (response.error_code == 0)
																{
																	$('#addToJournalDiv').html(response.display);																	
																	switch (response.type)
																	{
																	default:
																		break;
																	case "Breakfast":
																	case "Lunch":
																	case "Dinner":
																	case "Snack":
																		//addMeal(time+" "+meridiem, response.type, "Add");
																		addMeal(time+" "+meridiem, response.type, "Add");
																	break;
																	case "Exercise":
																		addExercise(time+" "+meridiem);
																	break;
																	}
																	$('#addToJournalDiv').dialog('open');
																}
																else
																{
																	//alert(response.error_msg);
																}
															});
													}
													else
													{
														//alert(response.error_msg);
													}
												},dayt);										
																		
									/////////////////////////////////////////////////////	
								}
								else
								{											
									var utID		= $('[name=journalType]:checked').attr('utID');																	
									/*  ///////////////previous work/////////////////
									var time		= $('#journalEntry [name=journalTime] :selected').text();
									var meridiem	= $('#journalEntry [name=meridiem]:checked').val();
									*/
									/////////////new york/////////////////
									var time		= $('[name=journalTime]').val().substring(0,5);									
									var meridiem	= $('[name=journalTime]').val().substring(6);																		
									/////////////end york/////////////////
									
									
									var dayname		= $('#journalEntry [name=dayname]').val();										
									doAjax("journal/getAddToJournal/active:"+active+"/utID:"+utID+"/dayname:"+dayname,
										function(response)
										{
											if (response.error_code == 0)
											{
												$('#addToJournalDiv').html(response.display);												
												switch (response.type)
												{
												default:
													break;
												case "Breakfast":
												case "Lunch":
												case "Dinner":
												case "Snack":
													//addMeal(time+" "+meridiem, response.type, "Add");
													addMeal(time+" "+meridiem, response.type, "Add");
												break;
												case "Exercise":
													addExercise(time+" "+meridiem);
												break;
												}
												$('#addToJournalDiv').dialog('open');
											}
											else
											{
												//alert(response.error_msg);
											}
										});
								}
							});
							
						}
					});
			});

		$('#addToJournalDiv').dialog(
			{
				autoOpen:		false,
				beforeClose:	function()
								{
									$('#saveMealDiv').dialog('close');
								}
			});

		$('#shareMealDiv').dialog(
			{
				modal:		true,
				title:		"SHARE MEAL",
				autoOpen:	false
			});

		$('#saveMealDiv').dialog(
			{
				modal:		true,
				title:		"SAVE AS MEAL",
				autoOpen:	false,
				buttons:	{
								"Save":		function()
											{
												if ($('#saveMealDiv [name=saveMealName]').val() == '')
												{
													alert("Please enter a name for this meal");
													return false;
												}
												var name	= $('#saveMealDiv [name=saveMealName]').val();
												var description	= $('#saveMealDiv [name=saveMealDescription]').val();
												$('#addMealForm [name=journalmealname]').val(name);												
												$('#addMealForm [name=journalmealdescription]').val(description);												
												$('#saveMealDiv [name=saveMealName]').val('');
												$('#addMealForm').ajaxSubmit(
													{
														url:			"journal/journalEntry/name:5", //5 for null, it's only tag
														type:			'post',
														dataType:		'xml',//'json''xml',
														beforeSubmit:	function()
																		{
																			return true;
																		},
														success:		function (data)
																		{
																			if (typeof data == 'object' && data.nodeType)
																			{
																				var response = elementToString(data.documentElement, true);
																			}
																			else if (typeof data == 'object')
																			{
																				var response = objToString(data);
																			}
																			response = eval ( "(" + response.replace(/(<([^>]+)>)/ig,"") + ")" );
																			if (response.trace)
																			{
																				//alert(response.trace);
																			}
																			if (response.error_code == 0)
																			{
																				load_journal(active);
																			}
																			else
																			{
																				$('#addMealForm #msg').html(response.error_msg);
																				$('#addMealForm #msg').show();
																				$('#saveMealDiv').dialog('close');
																			}
																			return false;
																		}
													});
													return false;
										//		doAjax("journal/journalEntry/name:"+name,
										//			function(response)
										//			{
										//				if (response.error_code == 0)
										//				{
										//					load_journal(active);
										//				}
										//				else
										//				{
										//					$('#addMealForm #msg').html(response.error_msg);
										//					$('#addMealForm #msg').show();
										//					$('#saveMealDiv').dialog('close');
										//				}
										//			},
										//			str);
											},
								"Cancel":	function()
											{
												$('#saveMealDiv [name=saveMealName]').val('');
												$('#saveMealDiv').dialog('close');
											}
							},
				width:		258,
				minHeight:  12,
				dialogClass: 'alert-holder',
				resizable:	false
			});
		
		$('.week_every_day').live('click',
		function()
		{									
		////////////////////////////////////////////////
				var myDate = new Date($(this).attr('activedate'));							
				var newFormat = $.datepicker.formatDate("M. dd, yy", myDate);				
				var testnewformat=$.datepicker.formatDate("yy-mm-d", myDate);
				
				var original =  $.datepicker.formatDate("yy-m-d", myDate);
				$('#jumpexistDate').html(original);
				
				var tempDate=new Date(maintoday);						
				var today=$.datepicker.formatDate("yy-m-d", tempDate);														
				
				tempDate.setDate(tempDate.getDate() - 1);							
				var yesterday=$.datepicker.formatDate("yy-m-d", tempDate);
				
				tempDate=new Date(maintoday);						
				tempDate.setDate(tempDate.getDate() + 1);
				var tommorow=$.datepicker.formatDate("yy-m-d", tempDate);													
																	
				$("#jumpjournalselected").html(newFormat);
											
				if(original==today)
				newFormat="today";
				else if(original==yesterday)
				newFormat="yesterday";
				else if(original==tommorow)
				newFormat="tomorrow";
				else
				newFormat=testnewformat;					
				load_journal(newFormat);	
		//////////////////////////////////////////////////////		
					
		});	
			

		//$('.header-block #calendar').click( function() { alert(1); load_journal( $(this).attr('class') ); });
		$('.header-block #nav li a').click( function() { load_journal( $(this).attr('class') ); });
		load_journal('today');
	});
