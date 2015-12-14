var sactive		= false;
var sj_startdate= false;
var sj_lastdate=  false;
var direction=	false;


function load_sjournal(when)
{			
		//alert(when);
		var str="active="+when;		
		
		if(sj_startdate)
		str+="&startdate="+sj_startdate;
		
		if(sj_lastdate)
		str+="&lastdate="+sj_lastdate;
		
		if(direction)
		str+="&direction="+direction;
				
		doAjax("successjournal/getpopup/",
		function(response)
		{
			if (response.error_code == 0)
			{																					
				$("#plan_goal_layout").html("");
				$("#plan_goal_layout").html(response.plangoallayout);					
			}				
		},str);	
	
}

function popup_generate()
{			
		//alert(when);		
		var str="flag=1";
		
			doAjax("successjournal/getuserpopup/",
			function(response)
			{
				if (response.error_code == 0)
				{																
					$("#popup-plan-goal").html(response.popup);										
				}				
			},str);		
}



$(document).ready(
function()
{		
		
	$('#popgoal_slect').live('change',
	function (){
	  var str = "";
	  $("#popgoal_slect option:selected").each(function () {
			sactive=$(this).val();
			sj_startdate=false;	
			sj_lastdate=false;
			direction=false;	
			load_sjournal(sactive);			
		  });		
	});	
	
	$('#popup-plan-goal .cancelbtn').live('click',
		function(){	
		disablePlansPopup();
		return false;
	});
	$('#plan_goal_top .close').live('click',
	function(){								
		disablePlansPopup();
		return false;		
	});
	/////////////////////////////
	$('#return-plans').live('click',
	function(){	
		//popup generate
		popup_generate();
		
		//centering with css		
		centerPlansPopup();
		//load popup
		loadPlansPopup();
	});	
	/////////////////////////////
  $('.error').hide();  
  $('#submit_btn').live('click',  
  function() {
      		$('.error').hide();    
		var $b = $('.goal_plan_class');
		if($b.filter(':checked').length != 6 ){
                    var goalplan = $('.goal_plan_class').attr('value');
                    console.log(goalplan);
                  	$(".error").show();
			$(".error").focus();
			return false;
		}

                //$(".goal_plan_class").one('click', function () {
                  /*if ($(this).is(":first-child")) {
                    $("p").text("It's the first div.");
                  }*/
                //});


        	var url="successjournal/save_goal_plan";
		$.ajax({
		  type: "POST",
		  url: url,		  
		  data: $('#goal_plan_form').serialize(),
		  dataType: 'html',
		  beforeSend:function(){
			$("#plangoalloading").show();
		  },
		  success: function() {
				$("#plangoalloading").hide();				
				disablePlansPopup();
				direction=false;
				load_sjournal(sactive);
		  }
		 });
    return false;
    });
	
	////////////for previous date
	$('#plan_goal_date_range .prev_date').live('click',
	function(){			
		sj_startdate=$('#plangoal_start_date').html();
		sj_lastdate=$('#plangoal_last_date').html();
		direction="left";
		load_sjournal(sactive);
	});

	////////////for next date
	$('#plan_goal_date_range .next_date').live('click',
	function(){	
		sj_startdate=$('#plangoal_start_date').html();
		sj_lastdate=$('#plangoal_last_date').html();
		direction="right";
		load_sjournal(sactive);
	});	
			
	sactive="todate";
	load_sjournal('todate');
});
