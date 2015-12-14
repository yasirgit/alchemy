var active		= false;

function load_coach(when)
{			
	var str="active="+when;
	//yesterday today week month todate//
	if(when=="week"||when=="month"||when=="todate")
	{
	///////////////////////////////////////
		if(when=="week")
		{
			var refweekstart=$('#ref_weekstart').html();
			
			if(refweekstart.length>0)
			str=str+"&ws="+refweekstart;
			
			doAjax("fatlosscoach/getweekcoach/",
			function(response)
			{
				if (response.error_code == 0)
				{											
					$("#week_chart_view").html(response.display);
					$("#week_chart_view_label").html(response.weekly_chart_view_label);
					$("#fatburning_percentage_green_week").html(response.final_fat_burning+"%");
					$("#fatburning_grade_violate_week").html(response.final_grade);													
					$("#currentweek_fat").html(response.dispalyweeek);																		
					$('#tabset li').eq(1).removeClass('active-in-tab');
					
					$("#positive_feedback").html(response.positivefeedback);
					$("#negative_feedback").html(response.negativefeedback);
				}				
			},str);	
		}
		else if(when=="month")		
		{					
			var refmonthstart=$('#ref_ms').html();
			
			if(refmonthstart.length>0)
			str=str+"&ms="+refmonthstart;
			
			doAjax("fatlosscoach/getmonthcoach/",
			function(response)
			{
				if (response.error_code == 0)
				{											
					$("#month_chart_view").html(response.display);					
					$("#currentmonth_fat").html(response.displaymonth);					
					$("#ref_monthstart").html(response.reference_month);
					$("#fatburning_grade_violate_month").html(response.final_grade);	
					$("#fatburning_percentage_green_month").html(response.final_fat_burning+"%");	

					$("#positive_feedback").html(response.positivefeedback);
					$("#negative_feedback").html(response.negativefeedback);					
				}				
			},str);	
		}
		else if(when=="todate")
		{
			doAjax("fatlosscoach/gettodatecoach/",
			function(response)
			{
				if (response.error_code == 0)
				{																					
					$("#todate_chart_view").html(response.chart);
					$("#todate_chart_label").html(response.label);
					
					$("#fatburning_grade_violate_todate").html(response.final_grade);
					$("#fatburning_percentage_green_todate").html(response.final_fatburning+"%");
					$("#todate_date_box").html(response.interval);
				}				
			},str);
		}	
	/////////////////////////////////	
	}
	else
	{
		doAjax("fatlosscoach/gettodaycoach/",
		function(response)
		{
			if (response.error_code == 0)
			{						
				//alert(response.display);
				$("#fat-big-chart-scroll1").html(response.display);	
				$(".active_day_name").html(response.active);							
				$("#fatburning_grade_violate").html(response.grade);							
				$("#fatburning_percentage_green").html(response.fat_burning_mode+"%");
				$("#currentdate_fat").html(response.active_date);
				
				$("#positive_feedback").html(response.positivefeedback);
				$("#negative_feedback").html(response.negativefeedback);
				//positive_feedback
				//negative_feedback

				////////////activate today yesterday tab
				if(response.active=="Today")		
				{
					$('#tabset li').eq(1).addClass('active-in-tab');				
					$('#tabset li').eq(0).removeClass('active-in-tab');	
				}				
				else if(response.active=="Yesterday")
				{
					$('#tabset li').eq(0).addClass('active-in-tab');				
					$('#tabset li').eq(1).removeClass('active-in-tab');
				}
				else
				{
					$('#tabset li').eq(0).removeClass('active-in-tab');				
					$('#tabset li').eq(1).removeClass('active-in-tab');
				}
				///////////////////////////////////
			}	
		},str);		
	}	
}


$(document).ready(
function()
{
	load_coach('today');
});
