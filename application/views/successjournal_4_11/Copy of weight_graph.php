<?php
$st_date = $first_dayMsr->um_date; 
$week[]='';
$form[]='';
$vl[]='';
foreach($last_dayMsr as $umlist){$ldate = $umlist['um_bweight'];}
for($i=0; $i<10; $i++)
{

  $week[$i] = date('m/d/Y',strtotime('+1 week',strtotime($st_date)));
  $form[$i] = date('Y-m-d',strtotime('+1 week',strtotime($st_date)));
  
  
  foreach($all_val as $all)
  {
      
      if($all['um_date']==$form[$i])
	  {
         //echo $i."=".$vl[$i] = $all['um_bweight'];
		$vl[$i] = $all['um_bweight'];

	  }

   }
/*   if( $week[$i] <= $ldate)
   {
       echo $line= "[".$week[$i].",".$vl[$i]."]";
   }
   */
    $st_date = $week[$i];
   

  
  
   //echo "<br/>";
}
//echo "<br/>--------------------------<br/>";


?>


<style type="text/css">
	  .jqplot-point-label {white-space: nowrap;}
/*    .jqplot-yaxis-label {font-size: 14pt;}*/
/*    .jqplot-yaxis-tick {font-size: 7pt;}*/
    .jqplot {  /*border:1px solid #00CC33;*/
	  clear: both;
    display: block;
    height: 174px;
/*    margin: auto;*/
    padding: 12px 0 8px;
    text-align: center;
    width: 326px;
	float:left;
	margin-top:5px;
	margin-left:50px;
	}
</style>

<script type="text/javascript" language="javascript">
$(document).ready(function(){

jQuery('#tt3').bind('click.graph',function(){
     $.jqplot.config.enablePlugins = true;


	line2 = [['2/25/2011', 160],['3/4/2011', 160], ['3/11/2011', 155], ['3/18/2011', 143], ['3/25/2011', 138],['4/02/2011', 134]];
	plot2 = $.jqplot('chart2', [line2], {

	 grid:{borderColor:'#858782',gridLineColor: '#4190BE',background:'#ffffff',shadow: false},

	 axes: {
	    xaxis: {
	     
	      renderer: $.jqplot.DateAxisRenderer,

		 tickOptions:{formatString:'Week',textColor: '#666666',showLabel:false,showGridline:false,mark: 'outside',showMark: true
},

		 min:'<?php echo $week[0] ?>', 
		 // 
		 
		 max:'<?php echo $week[9] ?>',
		 tickInterval:'7 day',
		 //borderColor:'#fe0',

	    },
	    yaxis: {
		  renderer: $.jqplot.LinearAxisRenderer,

		  tickOptions:{textColor: '#666666',show:true,showLabel:false,showMark: false},

		 tickInterval:'10',
		 
		 min: 120, max: 170
		  //numberTicks:5

	    },
     },//end axes
	 
	 seriesDefaults: {
	      //shadow: false, 
	      color:'#026BAA',
          lineWidth: 2.5,
		  markerOptions: {
               show: true,             // wether to show data point markers.
               style: 'circle',
			   size: 7,
			   color: '#3C90BD',
			   shadow: false,
			   }, 
		 
	  },
	  //series:[{color:'#5FAB78'}],

	
 });
 jQuery(this).unbind('click.graph');
 });
	
});
			
</script>

<div class="jqplot" id="chart2"></div>
