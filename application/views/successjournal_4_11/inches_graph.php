<?php
$st_date = $first_dayMsr->um_date; 
$week[]='';
$form[]='';
$vl[]='';
$line='';
foreach($last_dayMsr as $umlist){ $ldate = $umlist['um_date'];}
for($i=0; $i<10; $i++)
{

     $week[$i] = date('m/d/Y',strtotime('+1 week',strtotime($st_date)));
     $form[$i] = date('Y-m-d',strtotime('+1 week',strtotime($st_date)));
  
     //echo $i."=".$week[$i];echo "<br/>";
     foreach($all_val as $all)
     {      
            if($all['um_date']==$form[$i])
	        {
         
	   	        $vl[$i] = $all['um_waist'];
		        if( strtotime($form[$i]) <= strtotime($ldate))
                {   
                 $line.= "['".$week[$i]."',".$vl[$i]."],";
	          
                }

	        }

      }//end foreaach
      $st_date = $week[$i];

}

$line2=substr ($line,0,-1);
//echo "$x=". $line2;

?>


<style type="text/css">
	  .jqplot-point-label {white-space: nowrap;}
/*    .jqplot-yaxis-label {font-size: 14pt;}*/
/*    .jqplot-yaxis-tick {font-size: 7pt;}*/
    .jqplot {  /*border:1px solid #00CC33;*/
	  clear: both;
    display: block;
    height: 188px;
/*    margin: auto;*/
    padding: 12px 0 8px;
    text-align: center;
    width: 345px;
	float:left;
	margin-top:5px;
	position:relative;
	left:20px;
/*	margin-left:32px;*/
	}
</style>

<script type="text/javascript" language="javascript">
$(document).ready(function(){

jQuery('#tab_inches').bind('click.graph',function(){
	 
     $.jqplot.config.enablePlugins = true;
     
   // alert("rima");
    // document.write(line1);
    line2 = [<?php echo $line2; ?>]; 

	//line2 = [['02/25/2011',160],['03/04/2011',160], ['3/11/2011',155], ['3/18/2011',143], ['3/25/2011',138],['4/02/2011',134]];
	plot2 = $.jqplot('chart3', [line2], {

	 grid:{borderColor:'#858782',gridLineColor: '#4190BE',background:'#ffffff',shadow: false},

	 axes: {
	    xaxis: {
	     
	      renderer: $.jqplot.DateAxisRenderer,

		 tickOptions:{formatString:'Week',textColor: '#666666',showLabel:true,showGridline:false,mark: 'outside',showMark: true
},

		 min:'<?php echo $week[0] ?>', 
		 // 
		 
		 max:'<?php echo $week[9] ?>',
		 tickInterval:'7 day',
		 //borderColor:'#fe0',

	    },
	    yaxis: {
		  renderer: $.jqplot.LinearAxisRenderer,

		  tickOptions:{textColor: '#666666',show:true,showLabel:true,showMark: false,mark: 'outside',showMark: true},

		 tickInterval:'10',
		 
		 min: 10, max: 60,
		 numberTicks:6

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

<div class="jqplot" id="chart3"></div>
