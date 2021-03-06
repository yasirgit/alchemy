function nl2br (str)
{
	return (str + '').replace(/(\\)/g, "").replace(/(\r\n|\n\r|\r|\n)/g, "<br />");
}

function getQtyValue(qty)
{
  var acQty;
  var rtqty;  
  var temp="";
  acQty = $.trim(qty);   
  acQty = acQty.replace(' ', '+');        
  
  for(i=0;i<acQty.length;i++)	
  {
	if(acQty.charAt(i)!=' ')
	temp+=acQty.charAt(i);
  }
  
  try
  {
	rtqty=eval(temp).toFixed(2);
  }
  catch(err)
  {}  
  return rtqty;	
}
function doAjax(ajaxFunction,successCallback,str)
{
	if (ajaxFunction)
	{
		$.ajax(
			{
				type:		"POST",
				url:		ajaxFunction+"/data:json",
				data:		str,
				dataType:	"json",
				success:	function(Response)
							{
								if (Response.trace)
								{
									//alert(Response.trace)
								}
								if (Response.error_code < 0)
								{
								//	alert("-----not logged in");
									location.href = 'logout';
								}
								if (successCallback != null)
								{
									successCallback(Response);
								}
								else
								{
									//alert(Response);
								}
							},
                error:		function (xhr, ajaxOptions, thrownError)
							{
								//alert(xhr.status);
								//alert(thrownError);
							}
				});
	}
}

$.fn.clearForm = function()
	{
		// iterate each matching form
		return this.each(
			function()
			{
				// iterate the elements within the form
				$(':input', this).each(
					function()
					{
						var type = this.type, tag = this.tagName.toLowerCase();
						if (type == 'text' || type == 'password' || tag == 'textarea')
							this.value = '';
						else if (type == 'checkbox' || type == 'radio')
							this.checked = false;
						else if (tag == 'select')
							this.selectedIndex = -1;
					});
			});
	};

function addTime(time,interval)
{
	var meridiem	= time.split(' ');
	var clock		= meridiem[0].split(':');

	hours	= parseInt(clock[0],10);
	
	if (meridiem[1] == "PM" && hours < 12) { hours += 12; }
	
	if (meridiem[1] == "AM" && hours >= 12) { hours -= 12; }
		
	minutes	= parseInt(clock[1],10) + interval;

	if (minutes >= 60 )	{ minutes = -(60 - minutes);	hours = parseInt(hours,10) + 1; }
	if (minutes < 0 )	{ minutes = -minutes;			hours = parseInt(hours,10) - 1; }
	if (hours >=24)// && minutes == 0)
	{
		hours = 0;;
	}
	if (hours < 0)// && minutes == 0)
	{
		hours = 23;
	}

	if (hours >= 12)
	{
		meridiem[1] = "PM";
		if (hours > 12) { hours -= 12; }
	}
	else
	{
		meridiem[1] = "AM";
	}
	
	if(hours==0)
	hours=12;

	if (minutes <= 9)	{ minutes	= "0" + minutes; }
	if (hours <= 9)		{ hours		= "0" + hours; }

	return hours+":"+minutes+" "+meridiem[1];
}
