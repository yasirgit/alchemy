var step = 1;

/*
 * function addTime
 * 				adds 30 minutes to the given string time - 'HH:MM'
 * 				return string time - 'HH:MM'
 */
function addTime(time)
{
	time[0] = parseInt(time[0],10);
	time[1] = parseInt(time[1],10);
	time[1] += 30;
	if (time[1] != 30)
	{
		time[0]++;
		if (time[0] > 24)
		{
			time[0] = 1;
		}
		time[1] = '00';
	}
	if (time[0] < 10)
	{
		return '0'+time[0]+":"+time[1]+":00";
	}
	else
	{
		return time[0]+":"+time[1]+":00";
	}
}
function initStep()
{
	$('#weekdays_Breakfast').val( addTime($('#weekdays_Wakeup :selected').val().split(":")) );
	$('#weekends_Breakfast').val( addTime($('#weekends_Wakeup :selected').val().split(":")) );

	$("#step1").hide();
	$("#step2").hide();
	$("#step3").hide();
	$("#step4").hide();
	$('.step').removeClass('active');
	$("#step"+step).show();
	$('#header #a'+step).addClass('active');
}

/*
var user_times = [	{"utID":"1","user_id":"46","type":"Wakeup","week_period":"weekdays","time":"07:00:00"},
					{"utID":"5","user_id":"46","type":"Breakfast","week_period":"weekdays","time":"07:30:00"},
					{"utID":"2","user_id":"46","type":"Wakeup","week_period":"weekends","time":"08:00:00"},
					{"utID":"6","user_id":"46","type":"Breakfast","week_period":"weekends","time":"08:30:00"},
					{"utID":"13","user_id":"46","type":"Exercise","week_period":"weekdays","time":"09:30:00"},
					{"utID":"14","user_id":"46","type":"Exercise","week_period":"weekends","time":"10:00:00"},
					{"utID":"11","user_id":"46","type":"Snack","week_period":"weekdays","time":"10:00:00"},
					{"utID":"12","user_id":"46","type":"Snack","week_period":"weekends","time":"10:30:00"},
					{"utID":"7","user_id":"46","type":"Lunch","week_period":"weekdays","time":"12:00:00"},
					{"utID":"8","user_id":"46","type":"Lunch","week_period":"weekends","time":"12:30:00"},
					{"utID":"9","user_id":"46","type":"Dinner","week_period":"weekdays","time":"18:00:00"},
					{"utID":"10","user_id":"46","type":"Dinner","week_period":"weekends","time":"19:00:00"},
					{"utID":"3","user_id":"46","type":"Bed","week_period":"weekdays","time":"22:30:00"},
					{"utID":"4","user_id":"46","type":"Bed","week_period":"weekends","time":"23:00:00"}];
*/
function setUserTimes()
{
	for(x=0; x < user_times.length; x++)
	{
		$('#'+user_times[x].week_period+"_"+user_times[x].type).val(user_times[x].time);
	}
}

$(document).ready(
	function()
	{
		$('.step').click(
				function()
				{
					step = $(this).attr('step');
					initStep();
				});

		$('.next').click(
				function()
				{
					step++;
					initStep();
				});

		$('.prev').click(
				function()
				{
					step--;
					initStep();
				});

		$('.save').click(
				function()
				{
					var str = $('#userSetupForm').serialize();
					doAjax("users/setup/init:no",
						function(response)
						{
							if (response.error_code == 0)
							{
		//alert(user_times.length);
								if (user_times.length == 0)
								{
									$("#step1").hide();
									$("#step2").hide();
									$("#step3").hide();
									$("#step4").show();
									step = 4;
								}
								else
								{
									alert('your settings have been updated');
								}
							}
							else
							{
								alert(response.error_msg);
							}
						},str);
				});

		// make the first step active
		$("#step1").show();
		$('#header #a1').addClass('active');

		setUserTimes();
	});
