
<?php
  $line='';
  $getweek[]='';
  $getallweek='';
  $week[]='';
  $bodyfat[]='';
  $i=0; 
  foreach($graph_week_val as $gval)
  {

	 $fatWeight[$i] = $gval['um_fatweight'];
	 
	
	$getDate= strtotime($gval['startWeekDate']);
	$getallweek .= date('m/d/Y',$getDate).",";
	$getweek[$i] = date('m/d/Y',$getDate);
	if($i<10){
	   $line.= "['".$getweek[$i]."',".$fatWeight[$i]."],";
	  
	}
	$i++;
	
  }
    $line2 = substr ($line,0,-1); //echo "<br/>";
    $week= explode(',',$getallweek);
    $curweek= $week['0']; 
    for($k=1; $k<10; $k++)
    {

       $week[$k] = date('m/d/Y',strtotime('+1 week',strtotime($curweek)));
	   $curweek=$week[$k] ;
	 
    }
   
?>





<script type="text/javascript" language="javascript">
$(document).ready(function(){

jQuery('#fatWeight').bind('click.graph',function(){
	 
     $.jqplot.config.enablePlugins = true;
     
   // alert("rima");
    // document.write(line1);
    line2 = [<?php echo $line2; ?>]; 

	//line2 = [['02/25/2011',160],['03/04/2011',160], ['3/11/2011',155], ['3/18/2011',143], ['3/25/2011',138],['4/02/2011',134]];
	plot2 = $.jqplot('chart5', [line2], {

	 grid:{borderColor:'#858782',gridLineColor: '#4190BE',background:'#ffffff',shadow: false},

	 axes: {
	    xaxis: {
	     
	      renderer: $.jqplot.DateAxisRenderer,

          ticks:[['<?php echo $week[0] ?>','Week 1 (<?php echo $week[0] ?>)'],['<?php echo $week[1] ?>','Week 2 (<?php echo $week[1] ?>)'],['<?php echo $week[2] ?>','Week 3 (<?php echo $week[2] ?>)'],['<?php echo $week[3] ?>','Week 4 (<?php echo $week[3] ?>)'],['<?php echo $week[4] ?>','Week 5 (<?php echo $week[4] ?>)'],['<?php echo $week[5] ?>','Week 6 (<?php echo $week[5] ?>)'],['<?php echo $week[6] ?>','Week 7 (<?php echo $week[6] ?>)'],['<?php echo $week[7] ?>','Week 8 (<?php echo $week[7] ?>)'],['<?php echo $week[8] ?>','Week 9 (<?php echo $week[8] ?>)'],['<?php echo $week[9] ?>','Week 10(<?php echo $week[9] ?>)']],
		  
		 tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
		  
		 tickOptions:{formatString:'week',fontSize:'8pt', fontFamily:'Tahoma',textColor: '#666666',showLabel:true,showGridline:false,mark: 'outside',showMark: true, angle:-40
},

		 min:'<?php echo $week[0] ?>', 
		 // 
		 
		 max:'<?php echo $week[9] ?>',
		 tickInterval:'7 day',
		 //borderColor:'#fe0',

	    },
	    yaxis: {
		  renderer: $.jqplot.LinearAxisRenderer,

		  tickOptions:{textColor: '#666666',fontFamily:'Tahoma',fontSize:'8pt',show:true,showLabel:true,showMark: false,mark: 'outside',showMark: true},

		 tickInterval:'5',
		 
		min: 10, max: +50,
		// numberTicks:10

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

<div class="jqplot" id="chart5"></div>
