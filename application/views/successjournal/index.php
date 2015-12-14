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
	
	<?php } 

	 ?>

   /* $("#tabsmain").tabs({
         select: function(event, ui) {
         window.location = $.data(ui.tab, 'href.tabs');
        }
    });*/

	
	
	
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
<div class="success-journal-wrap" id="tabsmain">
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
                                                            <!--  ultimate-goal  -->
										<div class="ultimate-goal" id="snap_ultimate-goal">
					                        <? // ajax call-> "successjournal/snapshot_ultimate_goal"); ?>
                                                  
                                        </div>                    
                                                            <!--  week-goal  -->
										 <div class="ultimate-goal week-goal" id="snap_week_goal">					
                                             <?php // $this->load->view("successjournal/snapshot_8week_goal") ?> 
								          </div>                             
                                                            <!--  /week-goal  -->
                                    </div>
                                </div>
                            </div>
                            <div class="success-journal-link"><a href="javascript:void()" id="link-to-my-journal"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/success-journal-link.gif" alt="" /></a></div>
                        </div>
                        <div class="snap-bottom-right">
                             <?php $this->load->view("successjournal/snapshot_compliment") ?> 
							 
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
                        <?php $this->load->view("successjournal/todate_msm") ?> 
					</div>
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
						
                       	
                        <div id="tab-21" class="graph-replacer">
							  <ul class="grid-info-bar">
                                <li><strong>Starting Weight:</strong><?php echo $stweight; ?></li>
                                <li><strong>Current Weight:</strong>
									<?php if($last_dayMsr){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_bweight'];} }
								?></li>
                                <li><strong>Goal Weight:</strong> <? echo $row['goal_weight']; ?></li>
                              </ul> 
							  <div class="graph-replacer2">
								   <?php $this->load->view("successjournal/weight_graph") ;?>
                              </div>
                                                      
                      
					    </div>
						<div id="tab-22"  style="display:none;" class="graph-replacer">
						     <ul class="grid-info-bar">
                                <li><strong>Starting Inches:</strong><?php echo $first_dayMsr->um_waist; ?></li>
                                <li><strong>Current Inches:</strong>
									<?php if($last_dayMsr){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_waist'];} }
								?></li>
                                <li><strong>Goal Inches:</strong> 0</li>
                             </ul> 
							    <div class="graph-replacer2">
								    <?php $this->load->view("successjournal/inches_graph") ;?>
								 </div>
								
							   
						</div>	
							<div id="tab-23" class="graph-replacer" style="display:none;">
							<ul class="grid-info-bar">
                                <li><strong>Starting Bodyfat:</strong><?php echo $first_dayMsr->um_bodyfat;  ?></li>
                                <li><strong>Current Bodyfat:</strong>
									<?php if($last_dayMsr){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_bodyfat'];} }
								?></li>
                                <li><strong>Goal Bodyfat:</strong> 0</li>
                             </ul> 
							  <div class="graph-replacer2">
								     <?php $this->load->view("successjournal/bodyfat_graph") ;?>
							  </div>
					
							</div>
							
							<div id="tab-24" class="graph-replacer" style="display:none;">
							     <ul class="grid-info-bar">
                                    <li><strong>Starting Fat Weight:</strong><?php echo $first_dayMsr->um_fatweight; ?></li>
                                    <li><strong>Current Fat Weight:</strong>
									<?php if($last_dayMsr){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_fatweight'];} }
								    ?></li>
                                     <li><strong>Goal Fat Weight:</strong> 0</li>
                                 </ul> 
							     <div class="graph-replacer2">
								      <?php $this->load->view("successjournal/fatweight_graph") ;?>
								 </div>
						
							</div>
							<div id="tab-25" class="graph-replacer" style="display:none;">
								 <ul class="grid-info-bar">
                                    <li><strong>Starting BMI:</strong> <?php echo $first_dayMsr->um_bmi; ?></li>
                                    <li><strong>Current BMI:</strong> 
									<?php if($last_dayMsr){foreach($last_dayMsr as $umlist){echo $ldate = $umlist['um_bmi'];} }
								    ?></li>
                                     <li><strong>Goal BMI:</strong> 0</li>
                                 </ul> 
						     	<div class="graph-replacer2">
								     <?php $this->load->view("successjournal/bmi_graph") ;?>
								</div>
<!--								<ul class="period-tabbing" id="tabset">
                                    <li class="active"><a class="tab" href="#tab-26">All Time</a></li>
                                                            
                                </ul>-->
														  
							 </div>
                                          <ul class="period-tabbing" id="tabset">
                                    <li class="active"><a class="tab" href="javascript:void()">All Time</a></li>
                                                            
                               </ul>                          
                        </div>
                     </div>
                </div>
            </div>
            <div class="effective-wrap">
				<?php
					if(count($call_gallery)>0)
					{
										  
				?>
                <div class="compare-side">
                    <div class="compare-side-inner">
                        <h2 class="compare-header">My Before &amp; After Pictures</h2>
                        <div class="compare-content">
                            <p>Tracking your results with "Before" and "After" pictures is one of the best way to SEE your results! Now that you've taken the time to upload your "Before" pictures, feel free to not only add "After" pictures when you've completed the 21 Day Metabolism Makeover, but you can also add pictures each month thereafter, and any other time that you'd like to take a snapshot of your results to that point. Looking at these pictures side by side is a truly empowering feeling of accomplishment, and is fantastic motivation!</p>
                        
                        <div class="before-side">
                            <div class="period-text">before</div>
								<?php 
									if($get_latest_bf > 0 )
									{
										 foreach($get_latest_bf as $latest_before)
		                                 { 
											$date = $latest_before['created_date'];
			                                $split = explode("-", $date);

			  
		                                    if($split[1]==01){ 
			                                $mnth="Jan";
			                                }
			                                elseif($split[1]==02)
			                                {
			                                 $mnth="Feb";
			                                }
			                                elseif($split[1]==03)
			                                {
			                                  $mnth="Mar";
			                                }
			                                elseif($split[1]==04)
			                                {
			                                  $mnth="Apr";
			                                }
			                                elseif($split[1]==05)
			                                {
			                                  $mnth="May";
			                                }
			
			                                elseif($split[1]==06)
			                                {
			                                 $mnth="June";
			                                }
			                                elseif($split[1]==07)
			                                {
			                                  $mnth="July";
			                                }
			                                elseif($split[1]==08)
			                                {
			                                  $mnth="Aug";
			                                }
			                                elseif($split[1]==09)
			                                {
			                                 $mnth="Sep";
			                                }
			                                elseif($split[1]==10)
			                                {
			                                 $mnth="Oct";
			                                }
			                                elseif($split[1]==11)
			                                {
			                                 $mnth="Nov";
			                                }
			                                elseif($split[1]==12)
			                                {
			                                  $mnth="Dec";
			                                }
										?>
										<img src="<?=$this->config->item('base_url')?>/htdocs/gallery/before_img/<?php echo $latest_before['before_pic']; ?>" width="91" height="138"  alt="" />
										<?php
											} 
											}else{
										 ?>
                                        <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/before-thumb.gif" alt="" /><?php } ?>
															
                                        <span class="before-thumb-caption"><?php echo $mnth." ".$split[2].",". $split[0]; ?></span>
                        </div>
                        <div class="after-side">
                                                        	<div class="period-text">after</div>
															<?php 
															if($get_latest_after > 0 )
															{
															   foreach($get_latest_after as $latest_after)
		                                                        { 
																$date = $latest_after['created_date'];
			  $split = explode("-", $date);

			  
		    if($split[1]==01){ 
			   $mnth="Jan";
			}
			elseif($split[1]==02)
			{
			   $mnth="Feb";
			}
			elseif($split[1]==03)
			{
			   $mnth="Mar";
			}
			elseif($split[1]==04)
			{
			   $mnth="Apr";
			}
			elseif($split[1]==05)
			{
			  $mnth="May";
			}
			
			elseif($split[1]==06)
			{
			   $mnth="June";
			}
			elseif($split[1]==07)
			{
			   $mnth="July";
			}
			elseif($split[1]==08)
			{
			  $mnth="Aug";
			}
			elseif($split[1]==09)
			{
			   $mnth="Sep";
			}
			elseif($split[1]==10)
			{
			   $mnth="Oct";
			}
			elseif($split[1]==11)
			{
			   $mnth="Nov";
			}
			elseif($split[1]==12)
			{
			   $mnth="Dec";
																
			}												
			?>
															<img src="<?=$this->config->item('base_url')?>/htdocs/gallery/after_img/<?php echo $latest_after['after_pic']; ?>" width="91" height="138"  alt="" />
															<?php
															     } 
															}else{
															 ?>
															
                                                        	<img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/after-thumb.gif" alt="" /><?php } ?>  
															
                                                            <span class="before-thumb-caption"><?php echo $mnth." ".$split[2].",". $split[0]; ?></span>   
                        </div>
                        <div class="clear">&nbsp;</div>
                    
                
                <div class="share-links">
					<!-- AddThis Button BEGIN -->

                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4dd3d082655366e9"></script>
                    <!-- AddThis Button END -->
                    <a href="#" class="addthis_counter addthis_pill_style link-for-share">Share</a>
                    <span><a id="return_upload">Add More</a><a id="return_gview" >My Gallery</a></span>
                    <div class="clear">&nbsp;</div>
                </div>
				</div>
		        </div>
		        </div>

									<?php } else { ?>
											<!--after-->
										<div class="compare-side">
                                            	<div class="compare-side-inner">
                                                	<h2 class="compare-header">My Before &amp; After Pictures</h2>
                                                    <div class="compare-content">
                                                        <h2 class="img-up-title">Take &quot;Before&quot; pictures, you&#39;ll be very glad &quot;After&quot;.</h2>
																<div class="img-up-cont">
                                                                	<div class="img-up-left">
                                                                    	<p>One of the best ways to maintain motivation is to be able to see the tangible results you&#39;ll soon be getting. Take several &quot;Before&quot; pictures of yourself and save them here. Even if you don&#39;t normally like having your picture taken of yourself, do it here, in this private journal area. No one will see these photos except you, and as your weight begins to drop, you&#39;ll be glad to look back to see how far you&#39;ve come!</p>
                                                                    </div>
                                                                    <div class="img-up-right">
                                                                    	<a id="return_upload"><img src="<?= $this->config->item('base_url')?>/htdocs/images/img-up-cover.gif" alt="" alt="" /></a>
                                                                        <p>Photo taking tips &amp; tricks</p>
                                                                    </div>
                                                                    <p class="ft-text">&nbsp;</p>
                                                                </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
									<?php } ?> 
									<div class="days-counter">
                                            	<h2 class="days-no-holder"><?php echo $waitingDay ; ?> <? if($waitingDay>1){ echo "Days" ;} else {echo "Day" ;} ?></h2>
                                            </div>
                                    <div class="clear">&nbsp;</div>
			</div>	
		</div>	
		                <!-- **************************************************** -->
                                            
            
        
        </div>
        <div id="tab-3" class="tab-content">
                                  	<div class="holder">
					            <div class="tab-heading">
					              <h3 class="snapshot-day">Snapshot - Day <?php echo $fullDays ?></h3>
					              <div class="measure-btn"> <a class="sexybutton sexysimple sexygreen"><span class="print" id="return-measure3">Update Measurements</span></a></div>
					              <div class="clear">&nbsp;</div>
					              <!-- -->
					              <div>
					                <div class="box-holder">
									    <div class="lft-box" id="lft-box">
										       
											   
					                                <?php //ajax call->"successjournal/afterset_ultimategoal"); ?>
											   
									           
				                        </div>
										
										<div class="rht-box" id="rht-box">
									      <?php 
									               /* Ajax Call */
										   
										   ?> 
										</div>   
				                    </div>
									<!--    bonus goal start   -->
								<div class="bonus-box" id="bonus-box">	
                                     <? //ajax call bonus goal ?>
							    </div>
							   <!--  end  bonus goal start   -->
					                <div class="period-box" id="plan_goal_layout"><?php //plan goal//?>					
				                    </div>
									
							<!--  start  Bucket List start   -->
									<div class="bucket-box" id="bucket-box">
									<?php
                                           //ajax call bucket list 
									?>
									 </div>
									 <!--  end  Bucket List start   -->
				                  </div>
					              <div class="clear">&nbsp;</div>
				                </div>
					            <div class="effective-wrap"></div>
				              </div>
        </div>
		<?php /*   *** TAB 4 ****    */ ?>
        <div id="tab-4" class="rr tab-content">
                                  	<div class="holder">
									<?php
                                       if($msg==1){
									     $this->load->view("successjournal/editjournal");
										 /* $this->load->view($editJour);*/
									   }
									   else
									   {
                                         /* $this->load->view($editJour);*/
										  $this->load->view("successjournal/addjournal");
									   }
									    ?>
                                        <!--Recent Post-->

                                        <div class="journul-post journul-post-recent">
                                            <?php $this->load->view("successjournal/recent_post"); ?>
                                        </div>
                                        <!--Recent Post-->
                                    </div>
         </div>
	  </div>
	<?php /*                                       Tab 4 end       */ ?>								  
                                  <div class="clear">&nbsp;</div>
    </div>
                           
					
							
	<?php /*      popup start    */       ?>	
	  <?php $this->load->view("successjournal/popup_ultimate_goal"); ?>			
							
			
  				
<?php /*   Popup week   */ ?>

	         <?php $this->load->view("successjournal/popup_week"); ?>	
   
  
  <?php /*   Bonus Goal    */?>
             <?php $this->load->view("successjournal/popup_bonus_goal"); ?>	
			 
			 
  <?php /*   Popup Upload Gallery    */ ?>

	         <?php $this->load->view("successjournal/upload_gallery"); ?>				 
			 
  <?php /*   Popup My Gallery  */ ?>

	         <?php $this->load->view("successjournal/my_gallery"); ?>	
   
   
 	<?php /*  Plan goal popup  */ ?>  
   <div class="popup-plan-goal" id="popup-plan-goal">		
   </div>
   <div id="bgGoalPlanPopup"></div>

  
  <?php   /*    Bucket Popup    */?>
               <?php $this->load->view("successjournal/popup_bucketlist"); ?>	
			   <?php $this->load->view("successjournal/compliment_tracker_popup"); ?>	
			   <?php $this->load->view("successjournal/popup_tracker_list"); ?>	
              
  <?php /*     */?>	
	
  	 <div id="bgMeasurePopup"></div> 
   <?php  ?>
<div class="footer-banner"> <img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/successjournal-footer.jpg" alt="" />  </div>

