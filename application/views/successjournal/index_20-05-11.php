<?php
if($msg>0){
?>
<script>
$(document).ready(function(){
    <?php if(($msg==1 )||($msg==2)){ ?>
		$('#t1').removeClass('active');
		$('#t4').addClass('active');
		$('#tab-1').css("display","none");
		$('#tab-4').css('display',"block");
	//});
	<?php } ?>
});	
</script>

<?php
}
?>
<?php  
if($first_dayMsr!='')
{
   $fday= $first_dayMsr->um_date; 
   $stweight = $first_dayMsr->um_bweight;
   $curTime=date('y-m-d'); 
   $dateDiff = strtotime($curTime)-strtotime($fday);
 
   if($dateDiff < 1)
   {
    $fullDays =1;
   }
   else{
     $fullDays = floor($dateDiff/(60*60*24));
   }
 }
 else
 {
 $fday=0;
 $stweight =0;
 $fullDays =0;
 }
?>


<div class="atchemy-banner"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/successjournal-banner.jpg" alt="" /></div>
<div class="how-do-use">
     <a class="about-page" href="#">How do I use this page</a>
	 <a  class="return-to">Show/Edit My Account</a>
</div>
<div class="success-journal-wrap">
    <ul class="tabset tabset-large" id="tabset">
        <li class="active" style="z-index:4;" id="t1">
			<a class="tab" href="#tab-1"><span>Snapshot</span></a>
		</li>
        <li style="z-index:3;" id="t2"><a class="tab" id="tt3" href="#tab-2"><span>My Results</span></a></li>
        <li style="z-index:2;" id="t3"><a class="tab" id="tt4" href="#tab-3"><span>My Goals</span></a></li>
        <li style="z-index:1;" id="t4">
			<a class="tab" id="tt6" href="#tab-4"><span>My Journal</span></a>
		</li>
    </ul>
    <div class="tab-content-holder">
        <div id="tab-1" class="tab-content">
            <div class="holder">
                <div class="tab-heading">
                    <h3 class="snapshot-day">Snapshot - Day <?php echo $fullDays ?></h3>
                        <div class="measure-btn">
                            <a class="sexybutton sexysimple sexygreen"><span class="print" id="return-measure1" >Update Measurements</span></a>
                        </div>
                        <div class="clear">&nbsp;</div>
                </div>
                <div class="lost-wrapper">
                    <ul class="lost-tabbing lost-tabbing-click" id="tabset">
                        <li class="active"><a class="tab" href="#tab-5">To Date</a><span>&nbsp;</span></li>
                        <li><a class="tab" href="#tab-6">Week</a><span>&nbsp;</span></li>
                        <li><a class="tab" href="#tab-7">Month</a><span>&nbsp;</span></li>
                        <li><a class="tab" href="#tab-8">Year</a><span>&nbsp;</span></li>
                    </ul>
                    <div id="tab-5" class="lost-boxes lost-boxes-tab" >
                          <?php $this->load->view("successjournal/todate_msm") ?>                  	
                    </div>
                    <div id="tab-6"  class="lost-boxes lost-boxes-tab">
                          <?php $this->load->view("successjournal/week_msm") ?>                 
                    </div>
                    <div id="tab-7"  class="lost-boxes lost-boxes-tab">
                          <?php $this->load->view("successjournal/month_msm") ?>                	
                    </div>
                    <div id="tab-8" class="lost-boxes lost-boxes-tab">
                          <?php $this->load->view("successjournal/year_msm") ?>              	
                     </div>
                </div>
                <div class="">
                    <div class="snapsho-bottom-wrap">
                        <div class="snap-bottom-left">
                            <div class="snap-meter-site">
                                <div class="snap-white-bottom">
                                    <div class="snap-white-content">
                                                            <!--ultimate-goal-->
					      <?php $this->load->view("successjournal/snapshot_ultimate_goal") ?>
                                                            <!--<div class="ultimate-goal">
                                                                <div class="ultimate-bottom-round">
                                                                    <div class="ultimate-title">
                                                                        <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
                                                                        <div class="loser-quantity"><span>Lose 50 lbs</span></div>
                                                                        <div class="clear">&nbsp;</div>
                                                                    </div>
                                                                    <div class="ultimate-miter">&nbsp;</div>
                                                                </div>
                                                            </div>-->
                                                            <!--/ultimate-goal-->
                                                            
                                                            <!--week-goal-->
                                <?php $this->load->view("successjournal/snapshot_8week_goal") ?>                              
                                                            <!--/week-goal-->
                                                        </div>
                                    </div>
                                </div>
                                                <div class="success-journal-link"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/success-journal-link.gif" alt="" /></div>
                                            </div>
                                            <div class="snap-bottom-right">
                                            	<div class="compliment-wrapper">
                                                	<div class="compliment-bottom">
                                                    	<h3 class="compliment-title">Compliment Tracker</h3>
                                                        <div class="quote-part">
                                                        	<div class="quote-bottom-curv">
                                                            	<div class="quote-body">&#34;Congratulations on getting started &#45; now you can change your body &amp; your life!&#34;</div>
                                                            </div>
                                                        </div>
                                                        <div class="quote-owner">- Robert Ferguson<br /><a href="#">+ Add Another</a></div>
                                                    </div>
                                                </div>
                                                <div class=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/blank-thumb.gif" alt="" /></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div id="tab-2" class="tab-content" style="display:block;">
                                  	<div class="holder">
                                    	<div class="tab-heading">
                                        	<h3 class="snapshot-day">Snapshot - Day <?php echo $fullDays ?></h3>
                                            <div class="measure-btn">
                                            	<a class="sexybutton sexysimple sexygreen"><span class="print" id="return-measure2">Update Measurements</span></a>
                                            </div>
                                            <div class="clear">&nbsp;</div>
                                        </div>
                                        <div class="lost-wrapper">
                                        	<ul class="lost-tabbing active-in-tab-result" id="tabset" >
                                            	<li class="active"><a href="#tab-9">To Date</a><span>&nbsp;</span></li>
                                                <li><a class="tab" href="#tab-10">Week</a><span>&nbsp;</span></li>
                                                <li><a class="tab" href="#tab-11">Month</a><span>&nbsp;</span></li>
                                                <li><a class="tab" href="#tab-12">Year</a><span>&nbsp;</span></li>
                                            </ul>
                                            <div class="lost-boxes lost-boxes-result" id="tab-9">
                                            	<?php $this->load->view("successjournal/todate_msm") ?>                                                 </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-10">
                                            	<?php $this->load->view("successjournal/week_msm") ?>
                                            </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-11">
                                            	<?php $this->load->view("successjournal/month_msm") ?> 
                                            </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-12">
                                            	 <?php $this->load->view("successjournal/year_msm") ?>    
                                            </div>
                                        </div>
                                        <div class="grid-holder">
                                            <div class="grid-holder-bottom">
                                                <h2 class="grid-blank-title">&nbsp;</h2>
                                                <div class="grid-tab-wrapper">
                                                	<ul class="grid-tabbing"  id="tabset">
                                                    	<li class="active"><a class="tab" href="#tab-21"><span>Weight</span></a></li>
                                                        <li><a class="tab" href="#tab-22" id="tab_inches"><span>Inches</span></a></li>
                                                        <li><a class="tab" href="#tab-23" id="tab_fat"><span class="up-status">% Body Fat</span></a></li>
                                                        <li><a class="tab" href="#tab-24" id="fatWeight"><span>Fat Weight</span></a></li>
                                                        <li><a class="tab" href="#tab-25" id="bmi_graph"><span class="up-status">BMI</span></a></li>
                                                    </ul>
                                                    <div class="grid-content">
                                                    	<ul class="grid-info-bar">
                                                        	<li><strong>Starting Weight:</strong><?php echo $stweight; ?></li>
                                                            <li><strong>Current Weight:</strong>
															<?php if($last_dayMsr!=''){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_bweight'];} }else{echo $ldate= $fday;}
															?></li>
                                                            <li><strong>Goal Weight:</strong> 135</li>
                                                        </ul>
                                                        <div id="tab-21" class="graph-replacer">
														 <?php $this->load->view("successjournal/weight_graph") ;?>
<!--														<img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/myreslut-grid.gif" alt="" />-->
                                                      
                                                         <ul class="period-tabbing" id="tabset">
                                                            <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            <!--<li><a class="tab" href="#tab-27">This month</a></li>
                                                            <li><a class="tab" href="#tab-28">Last month</a></li>
                                                            <li><a class="tab" href="#tab-29">Custom</a></li>-->
                                                        </ul>
														</div>
														 <div id="tab-22" class="graph-replacer" style="display:none;">
														<?php $this->load->view("successjournal/inches_graph") ;?>
														 <ul class="period-tabbing" id="tabset">
                                                            <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                           
                                                        </ul>
														 </div>
														 <div id="tab-23" class="graph-replacer" style="display:none;">
														 <?php $this->load->view("successjournal/bodyfat_graph") ;?>
														 <ul class="period-tabbing" id="tabset">
                                                            <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            
                                                        </ul>
														</div>
														<div id="tab-24" class="graph-replacer" style="display:none;">
														   <?php $this->load->view("successjournal/fatweight_graph") ;?>
														  <ul class="period-tabbing" id="tabset">
                                                            <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            
                                                         </ul>
														</div>
														  <div id="tab-25" class="graph-replacer" style="display:none;">
														     <?php $this->load->view("successjournal/bmi_graph") ;?>
														     <ul class="period-tabbing" id="tabset">
                                                                <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            
                                                            </ul>
														  
														  </div>
                                                       <!-- <ul class="period-tabbing" id="tabset">
                                                            <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            <li><a class="tab" href="#tab-27">This month</a></li>
                                                            <li><a class="tab" href="#tab-28">Last month</a></li>
                                                            <li><a class="tab" href="#tab-29">Custom</a></li>
                                                        </ul>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="effective-wrap">
                                        	<div class="compare-side">
                                            	<div class="compare-side-inner">
                                                	<h2 class="compare-header">My Before &amp; After Pictures</h2>
                                                    <div class="compare-content">
                                                    <p>Some copy here Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas commodo sollicitudin leo ut mollis. Phasellus placerat, orci at imperdiet sagittis Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas com</p>
                                                    <div>
                                                    	<div class="before-side">
                                                        	<div class="period-text">before</div>
                                                        	<img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/before-thumb.gif" alt="" />
                                                            <span class="before-thumb-caption">Jan 1, 2010</span>
                                                        </div>
                                                        <div class="after-side">
                                                        	<div class="period-text">after</div>
                                                        	<img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/after-thumb.gif" alt="" />
                                                            <span class="before-thumb-caption">Jan 1, 2010</span>
                                                        </div>
                                                        <div class="clear">&nbsp;</div>
                                                    </div>
                                                    </div>
                                                    <div class="share-links">
                                                    	<a href="#" class="link-for-share">Share</a>
                                                    	<span><a href="#">Add More</a><a href="#">My Gallery</a></span>
                                                        <div class="clear">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="days-counter">
                                            	<h2 class="days-no-holder">6 Days</h2>
                                            </div>
                                            <div class="clear">&nbsp;</div>
                                        </div>
                                    </div>
                                  </div>
                                  <div id="tab-3" class="tab-content">
                                  	<div class="holder">
					            <div class="tab-heading">
					              <h3 class="snapshot-day">Snapshot - Day <?php echo $fullDays ?></h3>
					              <div class="measure-btn"> <a class="sexybutton sexysimple sexygreen"><span class="print" id="return-measure3">Update Measurements</span></a></div>
					              <div class="clear">&nbsp;</div>
					              <!---->
					              <div>
					                <div class="box-holder">
					                 <?php $this->load->view("successjournal/afterset_ultimategoal");?>
									   <?php 
									      if (count($weekcount) > 0){
									           $this->load->view("successjournal/afterset_8weekgoal");
										  }
										  else 
										  {
										       $this->load->view("successjournal/before_8weekgoal");
										  }
										   
										?>    
				                    </div>
									
					           <?php  
							    if (count($bonusGoal) > 0){
									 $this->load->view("successjournal/afterset_bonusgoal");
								}
								else 
								 { 
							         $this->load->view("successjournal/before_bonusgoal"); 
								 }
								?>
							   
					                <div class="period-box">
					                  <div class="period-box-top">
					                    <!--Ie6-->
				                      </div>
					                  <div class="period-box-mid">
					                    <div class="plangoal-schedular">
					                      <div class="plangoal-schedular-left">
					                        <label>Period:</label>
					                        <select name="select">
					                          <option>To Date</option>
				                            </select>
				                          </div>
					                      <div class="plangoal-schedular-right">
					                        <ul>
					                          <li><a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/date-next-arrow.gif" alt="next" width="16" height="15" /></a></li>
					                          <li>12/12/2010</li>
					                          <li>-</li>
					                          <li>12/17/2010</li>
					                          <li><a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/date-prev-arrow.gif" alt="next" width="16" height="15" /></a></li>
				                            </ul>
				                          </div>
				                        </div>
					                    <div class="plangoal-box">
					                      <div class="plangoal-box-top">
					                        <div class="meter-title">Plan Goals - To Date</div>
					                        <div class="box-holder-title"  id="return-plans"><a style="cursor:pointer;">edit</a></div>
				                          </div>
					                      <div class="plangoal-box-mid">
					                        <div class="plangoal-graph">
					                          <div class="plangoal-crcl-graph">
					                            <h2>Perfect 
					                              Plates</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif"  width="78" height="78" alt="" /></div>
					                          <div class="plangoal-crcl-graph">
					                            <h2>Perfect Snacks</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif"  width="78" height="78" alt="" /> </div>
					                          <div class="last-crcl-graph">
					                            <h2>Perfect Schedule</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif" width="78" height="78" alt="" /> </div>
				                            </div>
					                        <div class="graph-divider">&nbsp;</div>
					                        <div class="plangoal-graph plangoal-graph-btm">
					                          <div class="plangoal-crcl-graph">
					                            <h2>Eat A Fat Loss
					                              Breakfast within
					                              30 min. of 
					                              waking up</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif" width="78" height="78" alt="" /></div>
					                          <div class="plangoal-crcl-graph">
					                            <h2>Stop Eating in 
					                              the hour 
					                              before bed</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif" width="78" height="78" alt="" /> </div>
					                          <div class="last-crcl-graph">
					                            <h2>Take My 
					                              Nutritional 
					                              Supplements</h2>
					                            <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/circle-graph.gif"  width="78" height="78" alt="" /> </div>
				                            </div>
				                          </div>
					                      <div class="plangoal-box-bottom"></div>
				                        </div>
				                      </div>
					                  <div class="period-box-bottom"></div>
				                    </div>
									<?php
									if (count($bckcount) > 0){
					                 $this->load->view("successjournal/after_backetlist"); 
									}
									else{
									$this->load->view("successjournal/before_backet_list"); 
									}
									?>
									
				                  </div>
					              <div class="clear">&nbsp;</div>
				                </div>
					            <div class="effective-wrap"></div>
				              </div>
                                  </div>
		<?php ///////////////////////////////**** TAB 4 ****/////////////////////////////////////////// ?>
                                  <div id="tab-4" class="rr tab-content">
                                  	<div class="holder">
									<?php
                                       if($msg==1){
									     $this->load->view("successjournal/editjournal");
										 // $this->load->view($editJour);
									   }
									   else
									   {
                                         /// $this->load->view($editJour);
										  $this->load->view("successjournal/addjournal");
									   }
									    ?>
                                        <!--Recent Post-->

                                        <div class="journul-post journul-post-recent">
                                            <?php $this->load->view("successjournal/recent_post"); ?>
                                        </div>
                                        <!--/Recent Post-->
                                    </div>
                                  </div>
	<?php /////////////////////////////////Tab 4 end ////////////////////////?>								  
                                  <div class="clear">&nbsp;</div>
                               </div>
                           
					
							
	<?php /////////////////////////////////popup start ////////////////////////?>	
	  <?php $this->load->view("successjournal/popup_ultimate_goal"); ?>			
							
			
  				
<?php //////////////////////Popup week///////////////////////// ?>

	         <?php $this->load->view("successjournal/popup_week"); ?>	
   
  
  <?php //////////////////////Bonus Goal//////////////////////?>
             <?php $this->load->view("successjournal/popup_bonus_goal"); ?>	
  
   
   
   <?php ///////////////////Plan goal/////////////////////////////?>
   
   
   <div class="popup-plan-goal" id="popup-plan-goal">
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Plan Goals</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <h2 class="heading">Goals<span>Select the 6 goals to display on the Success Journal page and the frequency options to your goals below.</span></h2>
            <form action="#" class="feature formPlangoal">
            		<fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                    <fieldset>
                       <div class="checkItem">
                          <label>Display</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayTime">
                         <table width="136" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr><td valign="middle" height="50"> Perfect Plates</td></tr>
                         </table>
                         
                       </div>
                       <div class="displayItem">
                         
                       <table width="160" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          		<td width="100" align="center"><label>Times Per Week</label><select name="selected"><option></option><option></option></select></td>
                                <td width="25" align="center"> or</td>
                                <td width="35" align="center"><label>Daily</label><input type="checkbox" value="" />  </td>
                          </tr>
                       </table>
                       </div>
                      
                         <div class="displayDay">
                          <label>Mon</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Tue</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Wed</label>
                          <input type="checkbox" value="" />                       
                       </div>  
                       <div class="displayDay">
                          <label>Thu</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Fri</label>
                          <input type="checkbox" value="" />                       
                       </div>
                        <div class="displayDay">
                          <label>Sat</label>
                          <input type="checkbox" value="" />                       
                       </div>
                         <div class="displayDay">
                          <label>Sun</label>
                          <input type="checkbox" value="" />                       
                       </div>
                    </fieldset>
                      <fieldset class="btn saveBtn">
                        <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
                        <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />               
                     </fieldset>
            </form>
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
  
  <div id="bgGoalPlanPopup"></div>
  
  <?php ////////////////////////Bucket Popup/////////////////////////////?>
               <?php $this->load->view("successjournal/popup_bucketlist"); ?>	
  
  <?php /////////////////////////////////////////////////////?>	
	
  	 <div id="bgMeasurePopup"></div> 
   <?php  ?>
<div class="footer-banner"> <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/successjournal-footer.jpg" alt="" />  </div>
</div>