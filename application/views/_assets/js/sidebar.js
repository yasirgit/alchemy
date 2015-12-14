function setWater(responseCups)
{
	var cups = 0;
	$('.water-tracker-box .cups-list li').each(
		function()
		{
			if (responseCups > cups)
			{
				$(this).addClass('marked');
			}
			else
			{
				$(this).removeClass('marked');
			}
			cups++;
		});
}

function checkDaily(field,set)
{
	if (field == 1)
	{
		$('.tracker-form input:checkbox').eq(set).attr('checked','checked');
	}
	else
	{
		$('.tracker-form input:checkbox').eq(set).attr('checked','');
	}
}

function showDaily(field,set)
{	
	if (field == 1)
	{
		$('.list-box #'+set).hide();
	}
	else
	{
		$('.list-box #'+set).show();
	}
}

$(document).ready(
	function()
	{		
		$('.sidebar-frame .date a').click(
			function()
			{
				if ($(this).is('.prev'))
				{
					var dir = -1;
				}
				else if ($(this).is('.next'))
				{
					var dir = 1;
				}
				else
				{
					var dir = 0;
				}
				doAjax("sidebar/setDailyDate/dir:"+dir,
					function(response)
					{
						if (response.error_code == 0)
						{							
							$('.sidebar-frame #sidebar_date').text(response.date);
							setWater(response.daily.cups, 0);
							checkDaily(response.daily.vitamins, 1);
							checkDaily(response.daily.pills, 2);
							checkDaily(response.daily.supplements, "supplements");
							showDaily(response.daily.fatBurning, "fatBurning");
							showDaily(response.daily.nutrition, "nutrition");
							showDaily(response.daily.sleep, "sleep");
							showDaily(response.daily.choose, "choose");
						}
						else
						{
							//alert(response.error_msg);
						}
					});
			});

		//$('.water-tracker-box .more').click(
		$('.water-tracker-box .more').live('click',
			function()
			{
				var edate=$('#etrackerdate').html();
				doAjax("sidebar/setWaterTracker/mode:more",
					function(response)
					{
						if (response.error_code == 0)
						{
							setWater(response.cups);
						}
						else
						{
							//alert(response.error_msg);
						}
					},"eDate="+edate);
			});
			
		//$('.water-tracker-box .less').click(
		$('.water-tracker-box .less').live('click',
			function()
			{
				var edate=$('#etrackerdate').html();
				doAjax("sidebar/setWaterTracker/mode:less",
						function(response)
						{
							if (response.error_code == 0)
							{
								setWater(response.cups);
							}
							else
							{
								//alert(response.error_msg);
							}
						},"eDate="+edate);
			});

		//$('.sidebar-container .checkbox').click(
		$('.sidebar-container .checkbox').live('click',
			function()
			{
				var edate=$('#etrackerdate').html();
				var clear	= $(this).is('.clear');
				var daily	= $(this).attr('daily');
				if ($(this).attr('checked') == true)
				{
					var checked	= 1;
				}
				else
				{
					var checked	= 0;
				}
				doAjax("sidebar/daily/daily:"+daily+"/checked:"+checked,
					function(response)
					{
						if (response.error_code == 0)
						{
							if (clear && checked == 1)
							{
								//$('.list-box #'+daily).remove();
							}
						}
						else
						{
							//alert(response.error_msg);
						}
					},"eDate="+edate);
			});
	});
