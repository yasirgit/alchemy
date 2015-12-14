<link media="all" rel="stylesheet" href="htdocs/css/bigscrollchart.css" type="text/css" />
<script type="text/javascript" src="htdocs/js/bigchartscroll.js"></script>
<script type="text/javascript" src="htdocs/js/fatloss.js"></script>
<script type="text/javascript">
  $(function() {
    $("#mdatepicker").datepicker({
		showOn: 'button', buttonImage: 'htdocs/images/coach/icon-calender.gif',
		buttonImageOnly: true,
		onSelect: function(dateText, inst)
		{						
			var tempDate=new Date(dateText);
			tempDate.setDate(tempDate.getDate());			
			/////////////////check future date///////
			var todaydate=new Date();
			if(tempDate<=todaydate)
			{
			 ////////////////////////////////////////
			 $('#currentdate_fat').html(dateText);
			 formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
                         load_coach(formatDate);
			}
		}	
	});

        $('ul.day-block-holder li').live('click', function(){
            var dt = $('#ref_monthstart').text();			
            var pd = dt.split('/');
            var cd = $(this).children('span').text();
            var ncd;
            if(cd.length == 1){
                ncd = 0+cd;
            }
            else{
                ncd = cd;
            }
            var fdata = pd[2]+'-'+pd[0]+'-'+ncd;
            var d = new Date();
            var curr_date = d.getDate();
            var curr_month = d.getMonth() + 1;
            var curr_year = d.getFullYear();
            var yes_date = curr_date - 1;
            //alert(curr_month.length);

            if(curr_date < 10){
                cdate = '0'+curr_date;
            }
            else{
                cdate = curr_date;
            }

            if(curr_month < 10){
                cmonth = '0'+curr_month;
            }
            else{
                cmonth = curr_month;
            }

            if(yes_date < 10){
                ydate = '0'+yes_date;
            }
            else{
                ydate = yes_date;
            }

            var today = curr_year+'-'+cmonth+'-'+cdate;
            var yesterday = curr_year+'-'+cmonth+'-'+ydate;

			if(fdata<=yesterday)
			{	
				$('#tab-1').css('display', 'block');
				$('#tab-4').css('display', 'none');
				if(fdata == yesterday){
					$('#tabset li:eq(3)').removeClass('active-in-tab');
				}
				else{
					$('#tabset li:eq(3)').removeClass('active-in-tab');
				}								
				load_coach(fdata);
			}	
			
        });

  });
  </script>

<?php $this->load->view('fatloss/fatlosscoah_header');?>
<div class="how-do-use"><a class="about-page" href="#">How do I use this page</a><a href="users/myAccount" class="return-to">Show/Edit My Account</a></div>
<div class="success-journal-wrap success-content-holder">
  <ul class="lost-tabbing lost-tabbing-click top-success" id="tabset">
	<li><a class="tab" href="#tab-1" active="yesterday">Yesterday</a><span>&nbsp;</span></li>
	<li><a class="tab" href="#tab-2" active="today">Today</a><span>&nbsp;</span></li>	
	<li><a class="tab" href="#tab-3" active="week">Week</a><span>&nbsp;</span></li>
	<li><a class="tab" href="#tab-4" active="month">Month</a><span>&nbsp;</span></li>
	<li><a class="tab" href="#tab-5" active="todate">To Date</a><span>&nbsp;</span></li>
  </ul>
  <div class="tab-content-holder">
  <?php //start yesterday tab//////////////?>
	<div id="tab-1" class="lost-boxes-tab tab-content">
	<?php	
		$this->load->view('fatloss/today');
	?>
	</div>
	<?php //end yesterday tab//////////////?>
	<?php //start yesterday tab//////////////?>
	<div id="tab-2" class="lost-boxes-tab tab-content">	
	</div>
	<?php //end yesterday tab//////////////?>	
	<?php //start week tab//////////////?>
	<div id="tab-3" class="lost-boxes-tab tab-content" >
		<?php
			$today=array();
			$this->load->view('fatloss/week',$today);
		?>
	</div>
	<?php //end week tab//////////////?>
	<?php //start month tab//////////////?>
	<div id="tab-4" class="lost-boxes-tab tab-content" >
		<?php
			$today=array();
			$this->load->view('fatloss/month',$today);
		?>
	</div>
	<?php //end month tab//////////////?>
	<?php //start month tab//////////////?>
	<div id="tab-5" class="lost-boxes-tab tab-content" >
		<?php
			$today=array();
			$this->load->view('fatloss/todate',$today);
		?>
	</div>
	<?php //end month tab//////////////?>
	
	<div class="clear">&nbsp;</div>
  </div>
  <div class="tab-content-holder">
	<div class="feedback-box">
	  <div class="feedback-top">
		<div class="meter-title">Feedback</div>
	  </div>
	  <div class="feedback-mid">
		<div class="feedback-left">
		  <img src="htdocs/images/coach/FatLossCoach_Image.jpg" alt="FatLossCoach_Image.jpg" />
                </div>
		<div class="feedback-right">
		  <div class="tips-module">
			<div class="title-icon"><img src="htdocs/images/coach/icon-cheer.png" alt="" width="50" height="50" /></div>
			<div class="tips-title">
			  <h2>Here are some things you did well:</h2>
			</div>
                        <p class="cls" style="display: none;padding:0 0 0 20px;">Check back tomorrow for a detailed review of your progress today</p>
			<div id="positive_feedback">
                             <?php $this->load->view('fatloss/pfeedback');?>
                        </div>
		  </div>
		  <div class="tips-module tips-module-01">
			<div class="title-icon"><img src="htdocs/images/coach/icon-flag.png" alt="" width="50" height="50" /></div>
			<div class="tips-title">                                    
			  <h2>And, here are some areas for improvement:</h2>                                      
			</div>
                        <p class="cls" style="display: none;padding:0 0 0 20px;">Check back tomorrow for a detailed review of your progress today</p>
			<div id="negative_feedback">
                            <?php $this->load->view('fatloss/nfeedback');?>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="feedback-bottom"></div>
	</div>
  </div>
</div>
<?php $this->load->view('fatloss/fatlosscoah_footer');?>
<script type="text/javascript">
$(function()
{							
	var activwindow;
	$('#tabset li a').click( function(){
		activwindow = $(this).attr('active');
                if(activwindow == "today")
		{ 
			$('#tab-1').css('display', 'block');
			$('#tab-2').css('display', 'none');
                        $('#positive_feedback').css('display', 'none');
                        $('#negative_feedback').css('display', 'none');
                        $("p.cls").css('display','block');
                }

                if(activwindow == "yesterday" || activwindow == "week" || activwindow == "month" || activwindow == "todate")
                {
                        $('#positive_feedback').css('display', 'block');
                        $('#negative_feedback').css('display', 'block');
                        $("p.cls").css('display', 'none');
                }
		
		load_coach(activwindow);		
	});
	
	$('.prevdate_fat').click( function(){
				
		var curdate=$('#currentdate_fat').html();
		var tempDate=new Date(curdate);
		tempDate.setDate(tempDate.getDate() - 1);
		formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
		$('#currentdate_fat').html($.datepicker.formatDate("mm/dd/yy", tempDate));		
		load_coach(formatDate);	
		return false;
	});	
	$('.nextdate_fat').click( function(){
				
		var curdate=$('#currentdate_fat').html();
		var tempDate=new Date(curdate);
		tempDate.setDate(tempDate.getDate() + 1);
		///////////////////////////check today///////
		var todaydate=new Date();
		if(tempDate<=todaydate)		
		{
			//////////////////////////////
			formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
			$('#currentdate_fat').html($.datepicker.formatDate("mm/dd/yy", tempDate));		
			load_coach(formatDate);	
		}
		return false;
	});
	///////////////////for next and prev month////////////	
	$('.prev_month_fat').click( function(){				
		var curmonth=$('#ref_monthstart').html();
		var tempDate=new Date(curmonth);
		var temp=tempDate.getMonth()-1;
		tempDate.setMonth(temp);
		tempDate.setDate(tempDate.getDate());
		formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
		$('#ref_ms').html(formatDate);
		load_coach("month");		
		return false;
	});	
	$('.next_month_fat').click( function(){				
		var curmonth=$('#ref_monthstart').html();
		var tempDate=new Date(curmonth);
		var temp=tempDate.getMonth()+1;
		tempDate.setMonth(temp);
		tempDate.setDate(tempDate.getDate());
		
		var todaydate=new Date();
		if(tempDate<=todaydate)		
		{
		 formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
		 $('#ref_ms').html(formatDate);
		 load_coach("month");		
		}
		return false;
	});
		$('.next_week_fat').click( function(){
				
		var curweek=$('#currentweek_fat').html();
		var splitarray=curweek.split("-");
		var weekstart=splitarray[0];
		var weekend=splitarray[1];
		
		var tempDate=new Date(weekend);		
		tempDate.setDate(tempDate.getDate() + 1);
		
		var todaydate=new Date();
		if(tempDate<=todaydate)		
		{		
			formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);		
			$('#ref_weekstart').html(formatDate);		
			load_coach("week");			
		}
		return false;
	});				
	$('.prev_week_fat').click( function(){
				
		var curweek=$('#currentweek_fat').html();
		var splitarray=curweek.split("-");
		var weekstart=splitarray[0];
		var weekend=splitarray[1];
		
		var tempDate=new Date(weekstart);
		tempDate.setDate(tempDate.getDate() - 7);
		formatDate=$.datepicker.formatDate("yy-mm-dd", tempDate);
		
		$('#ref_weekstart').html(formatDate);
		
		load_coach("week");			
		return false;
	});			
	///////////activate today tab///
	$('#tabset li').eq(0).addClass('active-in-tab');
	$('#tabset li').eq(1).removeClass('active-in-tab');
	//////////////for scroller////////////////////
	$('.fat-big-chart-scroll').jScrollHorizontalPane({showArrows:true,arrowSize:20,scrollbarHeight:16,scrollbarMargin:0});				
});
</script>