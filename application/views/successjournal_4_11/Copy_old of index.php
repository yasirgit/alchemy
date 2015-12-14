<?php
if($edit!=''){
?>
<script>
$(document).ready(function(){

		$('#t1').removeClass('active');
		$('#t4').addClass('active');
		$('#tab-1').css("display","none");
		$('#tab-4').css('display',"block");
	//});
});	
</script>

<?php
}
?>

<div class="atchemy-banner">Alchemy banner 607 x 84</div>
<div class="how-do-use">
     <a class="about-page" href="#">How do I use this page</a>
	 <a  class="return-to">Show/Edit My Account</a>
</div>
<div class="success-journal-wrap">
    <ul class="tabset tabset-large" id="tabset">
        <li class="active" style="z-index:4;" id="t1">
			<a class="tab" href="#tab-1"><span>Snapshot</span></a>
		</li>
        <li style="z-index:3;"><a class="tab" id="tt3" href="#tab-2"><span>My Results</span></a></li>
        <li style="z-index:2;"><a class="tab" id="tt4" href="#tab-3"><span>My Goals</span></a></li>
        <li style="z-index:1;" id="t4">
			<a class="tab" id="tt6" href="#tab-4"><span>My Journal</span></a>
		</li>
    </ul>
    <div class="tab-content-holder">
        <div id="tab-1" class="tab-content">
            <div class="holder">
                <div class="tab-heading">
                    <h3 class="snapshot-day">Snapshot - Day 15</h3>
                        <div class="measure-btn">
                            <a class="sexybutton sexysimple sexygreen"><span class="print" id="return-measure">Update Measurements</span></a>
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
                                            	<div class="lost-box-rptr"><h3>You lost <br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div id="tab-6"  class="lost-boxes lost-boxes-tab">
                                            	<div class="lost-box-rptr"><h3>yyyyyyy<br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>kkkkkk <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div id="tab-7"  class="lost-boxes lost-boxes-tab">
                                            	<div class="lost-box-rptr"><h3>7777777<br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div id="tab-8" class="lost-boxes lost-boxes-tab">
                                            	<div class="lost-box-rptr"><h3>8888888 <br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                        </div>
                                        <div class="">
                                        <div class="snapsho-bottom-wrap">
                                        	<div class="snap-bottom-left">
                                                <div class="snap-meter-site">
                                                    <div class="snap-white-bottom">
                                                        <div class="snap-white-content">
                                                            <!--ultimate-goal-->
                                                            <div class="ultimate-goal">
                                                                <div class="ultimate-bottom-round">
                                                                    <div class="ultimate-title">
                                                                        <h2 class="meter-title"  id="return-to">Ultimate Goal</h2>
                                                                        <div class="loser-quantity"><span>Lose 50 lbs</span></div>
                                                                        <div class="clear">&nbsp;</div>
                                                                    </div>
                                                                    <div class="ultimate-miter">&nbsp;</div>
                                                                </div>
                                                            </div>
                                                            <!--/ultimate-goal-->
                                                            
                                                            <!--week-goal-->
                                                            <div class="ultimate-goal week-goal">
                                                                <div class="ultimate-bottom-round">
                                                                    <div class="ultimate-title">
                                                                        <h2 class="meter-title">8 Week Goal</h2>
                                                                        <div class="loser-quantity"><span>Lose 50 lbs</span></div>
                                                                        <div class="clear">&nbsp;</div>
                                                                    </div>
                                                                    <div class="time-label">Time Remaining</div>
                                                                    <ul class="snapshot-time-count">
                                                                        <li>47<small>Days</small></li>
                                                                        <li>29<small>Hours</small></li>
                                                                        <li>07<small>Minutes</small></li>
                                                                        <li>12<small>Second</small></li>
                                                                    </ul>
                                                                    <div class="ultimate-miter">&nbsp;</div>
                                                                </div>
                                                            </div>
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
                                                            	<div class="quote-body">“Congratulations on getting started – now you can change your body &amp; your life!”</div>
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
                                        	<h3 class="snapshot-day">Snapshot - Day 15</h3>
                                            <div class="measure-btn">
                                            	<a href="#" class="sexybutton sexysimple sexygreen"><span class="print">Update Measurements</span></a>
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
                                            	<div class="lost-box-rptr"><h3>second tab 1 <br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-10">
                                            	<div class="lost-box-rptr"><h3>Second tab 2 <br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-11">
                                            	<div class="lost-box-rptr"><h3>second tab 3<br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                            <div class="lost-boxes lost-boxes-result" id="tab-12">
                                            	<div class="lost-box-rptr"><h3>second tab 4<br /><span>2.5 lbs.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr length-bg"><h3>You lost <br /><span>2.5 in.</span><br />To Date</h3></div>
                                                <div class="lost-box-rptr weight-in-percent-bg"><h3>You lost <br /><span>1.8%</span><br />body fat<br />To Date</h3></div>
                                                <div class="view-all-measure"><a href="#">View More &gt;</a></div>
                                            </div>
                                        </div>
                                        <div class="grid-holder">
                                            <div class="grid-holder-bottom">
                                                <h2 class="grid-blank-title">&nbsp;</h2>
                                                <div class="grid-tab-wrapper">
                                                	<ul class="grid-tabbing">
                                                    	<li class="active-tab"><a href="#"><span>Weight</span></a></li>
                                                        <li><a href="#"><span>Inches</span></a></li>
                                                        <li><a href="#"><span class="up-status">% Body Fat</span></a></li>
                                                        <li><a href="#"><span>Fat Weight</span></a></li>
                                                        <li><a href="#"><span class="up-status">BMI</span></a></li>
                                                    </ul>
                                                    <div class="grid-content">
                                                    	<ul class="grid-info-bar">
                                                        	<li><strong>Starting Weight:</strong> 160</li>
                                                            <li><strong>Current Weight:</strong> 145</li>
                                                            <li><strong>Goal Weight:</strong> 135</li>
                                                        </ul>
                                                        <div class="graph-replacer"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/myreslut-grid.gif" alt="" /></div>
                                                        <ul class="period-tabbing">
                                                            <li class="active-tab"><a href="#">All Time</a></li>
                                                            <li><a href="#">This month</a></li>
                                                            <li><a href="#">Last month ggsf</a></li>
                                                            <li><a href="#">Custom</a></li>
                                                        </ul>
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
					              <h3 class="snapshot-day">Snapshot - Day 15</h3>
					              <div class="measure-btn"> <a href="#" class="sexybutton sexysimple sexygreen"><span class="print">Update Measurements</span></a></div>
					              <div class="clear">&nbsp;</div>
					              <!---->
					              <div>
					                <div class="box-holder">
					                  <div class="lft-box">
					                    <div class="lft-box-top">
					                      <h2 class="meter-title">Ultimate Goal</h2>
					                      <div class="box-holder-title"><a href="">edit</a></div>
				                        </div>
					                    <div class="lft-box-mid">
					                      <div class="lft-box-inner">
					                        <div class="weight-lose-box">
					                          <div class="lose">Lose </div>
					                          <div class="lose-amount">4 in </div>
				                            </div>
					                        <div class="weight-lose-graph"></div>
					                        <div class="ticket"></div>
				                          </div>
				                        </div>
					                    <div class="lft-box-bottom"></div>
				                      </div>
					                  <div class="rht-box">
					                    <div class="rht-box-top">
					                      <h2 class="meter-title" >8 Week Goal</h2>
					                      <div class="box-holder-title"><a href="">edit</a></div>
				                        </div>
					                    <div class="rht-box-mid">
					                      <div class="white-inner-box">
					                        <div class="white-top"></div>
					                        <div class="white-mid">
                                             <div class="body-text">
					                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum egestas ipsum eu ultricies. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin tempor, arcu at malesuada lobortis, ipsum nibh sodales magna, eu rutrum metus nisl at enim. </p>
					                        <!--  <form action="#">-->
					                           
					                             <div id="return-week"><input  type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addItem.gif" /></div>
				                               
				                           <!--   </form>-->
                                              </div>
				                            </div>
					                        <div class="white-bottom"></div>
				                          </div>
				                        </div>
					                    <div class="rht-box-bottom"></div>
				                      </div>
				                    </div>
					                <div class="bonus-box">
					                  <div class="bonus-box-top">
					                    <div class="meter-title">Bonus Goal</div>
					                    <div class="box-holder-title"><a href="">edit</a></div>
				                      </div>
					                  <div class="bonus-box-mid">
					                    <div class="bonus-text"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum egestas ipsum eu ultricies. Cum sociis natoque penatibus et </div>
					                    <div class="bonus-addItem">
					                   <!--   <form>-->
					                       <div id="return-bonus"> <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addItem.gif"  /></div>
				                     <!--     </form>-->
				                        </div>
				                      </div>
					                  <div class="bonus-box-bottom"></div>
				                    </div>
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
					                        <div class="meter-title" id="return-plans">Plan Goals - To Date</div>
					                        <div class="box-holder-title"><a href="">edit</a></div>
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
					                <div class="bucket-box">
					                  <div class="bucket-box-top">
					                    <!--Ie6-->
				                      </div>
					                  <div class="bucket-box-mid">
					                     <div class="bucketBox-inner"> </div>
					                    <div class="bucketBox-item"> 
                                          <div class="body-text">
					                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum egestas ipsum eu ultricies. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin tempor, arcu at malesuada lobortis, ipsum nibh sodales magna, eu rutrum metus nisl at enim. </p>
					                       
					                             <div id="return-addBucketList">
					                              <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addItem.gif" /></div>
				                               
				                             
                                              </div>
                                           </div>
				                      </div>
					                  <div class="bucket-box-bottom"></div>
				                    </div>
				                  </div>
					              <div class="clear">&nbsp;</div>
				                </div>
					            <div class="effective-wrap"></div>
				              </div>
                                  </div>
		<?php ///////////////////////////////**** TAB 4 ****/////////////////////////////////////////// ?>
                                  <div id="tab-4" class="rr tab-content">
                                  	<div class="holder">
                                        <div class="journul-post">
                                            <div class="add-journal">
                                                <div class="s-border-wrapper">
                                                    <div class="s-common-title">
                                                        <h2>
                                                            <div class="add-journal-heading">Add a Journal Entry</div>
                                                            <div class="user-area">
                                                                <ul>
                                                                    <li class="active"><a href="#"><span>Text</span></a></li>
                                                                    <li><a href="#"><span>Video</span></a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="clear">&nbsp;</div>
                                                        </h2>
                                                    </div>
                                                    <div class="add-journal-zone">
                                                    	<p><strong>Keep track of your fat loss journey to help you remember what worked and didn't, how you felt each day along the journey to help keep yourself and others motivated until you reach your goal.</strong></p>
                                                        <p><i>(What did you do well?  What do you want to try to improve tomorrow? How was your energy level?  Hunger &amp; craving levels?  Mood?  What challenges did you face today? What was the best thing about today?)</i></p>
                                                        <form name="addJournal" method="post" action="successjournal/">
                                                        	<fieldset class="add-journal-fields">
                                                            	<label>Title:</label>
                                                                <span class="text"><input name="addtitle" type="text" /></span>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                            <fieldset class="add-journal-fields">
                                                            	<label>Text:</label>
                                                                <textarea name="details" class="" rows="" cols=""></textarea>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                      <!--  </form>-->
                                                        <div class="self-assistment-zone">
                                                        	<h2 class="self-assistment-title">My Self Assessment</h2>
                                                        	<div class="self-assistment-rptr">
                                                            	<div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-hunger.gif" alt="" /></div>
                                                                <div class="assesment-level-text">Hunger Level:</div>
<div><input name="hungerlevel" id="hungerlevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" ></div>
                                                                <div class="assesment-level">
                                                                	<div class="assesment-point-level">
                                                                    	<span>Starving</span><span class="satisfy">Satisfied</span>
                                                                    </div>
                                                                    <div class="assesment-point-holder">
    <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-first">
        <div style="width: 2.71817%;" class="ui-slider-range ui-slider-range-min ui-widget-header"></div>
	     <a style="left: 2.71817%;" class="ui-slider-handle ui-state-default ui-corner-all ui-state-focus" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/perfromance-mitre-point.png" alt="" /></a>
	</div>
  </div>
                                                                   </div>
                                                                <div class="clear">&nbsp;</div>
                                                            </div>
                                                            <div class="self-assistment-rptr">
                                                            	<div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-energy.gif" alt="" /></div>
                                                                <div class="assesment-level-text">Energy Level:</div>
			<div><input name="englevel" id="energylevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" ></div>
                                                                <div class="assesment-level">
                                                                	<div class="assesment-point-level">
                                                                    	<span>Low</span><span class="satisfy hight-low">High</span>
                                                                    </div>
                                                                    <div class="assesment-point-holder">
<div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-two">
      <div style="width: 2.71817%;" class="ui-slider-range ui-slider-range-min ui-widget-header"></div>
	     <a style="left: 2.71817%;" class="ui-slider-handle ui-state-default ui-corner-all ui-state-focus" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/perfromance-mitre-point.png" alt="" /></a>
	  </div>
																	</div>
                                                                </div>
                                                                <div class="clear">&nbsp;</div>
                                                            </div>
                                                            <div class="self-assistment-rptr">
                                                            	<div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-esteem.gif" alt="" /></div>
                                                                <div class="assesment-level-text">Self Esteem Level:</div>
<input name="esteemlevel" id="esteemlevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" >
                                                                <div class="assesment-level">
                                                                	<div class="assesment-point-level">
                                                                    	<span>Low</span><span class="satisfy hight-low">High</span>
                                                                    </div>
                                                                    <div class="assesment-point-holder">
	<div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-three">
      <div style="width: 2.71817%;" class="ui-slider-range ui-slider-range-min ui-widget-header"></div>
	     <a style="left: 2.71817%;" class="ui-slider-handle ui-state-default ui-corner-all ui-state-focus" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/perfromance-mitre-point.png" alt="" /></a>
	  </div>
																	</div>
                                                                </div>
                                                                <div class="clear">&nbsp;</div>
                                                            </div>
                                                            <div class="self-assistment-rptr">
                                                            	<div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-sleep.gif" alt="" /></div>
                                                                <div class="assesment-level-text">Sleep Quality:</div>
<input name="sleepquality" id="sleepquality" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" >	
                                                                <div class="assesment-level">
                                                                	<div class="assesment-point-level">
                                                                    	<span>Poor</span><span class="satisfy">Excellent</span>
                                                                    </div>
                                                                    <div class="assesment-point-holder">
<div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-four">
      <div style="width: 2.71817%;" class="ui-slider-range ui-slider-range-min ui-widget-header"></div>
	     <a style="left: 2.71817%;" class="ui-slider-handle ui-state-default ui-corner-all ui-state-focus" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/perfromance-mitre-point.png" alt="" /></a>
	  </div>
																	</div>
                                                                </div>
                                                                <div class="clear">&nbsp;</div>
                                                            </div>
                                                            <div class="public-private-choose">
                                                            	<input type="radio" name="access-type" value="1" /> Public &nbsp;&nbsp;&nbsp; <input type="radio" name="access-type" value="2" /> Private
                                                            </div>
                                                            <div class="journal-post-btn">
				 <div class="sexybutton sexyorange"><span><span><input class="jpostbutton"  type="submit" name="journalEntry" value="Post It" /></span></span></div>
                                                            	<!--<a class="sexybutton sexyorange" href="#"><span><span>Post It</span></span></a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        <!--Recent Post-->

                                        <div class="journul-post journul-post-recent">
                                            <div class="add-journal">
                                                <div class="s-border-wrapper">
                                                    <div class="s-common-title">
                                                        <h2>
                                                            <div class="add-journal-heading">Recent Posts</div>
                                                            <div class="recent-post-calender"><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-calc.gif" alt="Calender" /></a></div>
                                                            <div class="clear">&nbsp;</div>
                                                        </h2>
                                                    </div>
													<div class="recent-post-holder">
                                                    	
<?php
    $uid=$this->session->userdata('id');
    if (count($jpost)){
    foreach ($jpost as $key => $list){
?>
                                                    <div class="recent-post-rptr">
                                                        	<div class="recent-post-title">
                                                            	<div class="recent-blog-heading">
                                                                    <h3><a href="#"><?php echo $list['title']; ?></a> - April 29th</h3>
                                                                    <ul class="post-manup-access">
                                                                        <li class="editlink"><?php if($list['uid']==$uid){ ?><a href="successjournal/index/edit/id/<?php echo $list['id']; ?>"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a><?php } ?></li>
                                                                        <li><?php if($list['uid']==$uid){ ?><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?></li>
                                                                    </ul>
                                                                </div>
                                                                <p><?php echo $list['details']; ?></p>
                                                                <div class="post-info-line">
                                                                	<strong>Grade: A-  | BMI: 10 | Energy: <?php echo $list['energylevel']; ?> | Hunger: <?php echo $list['hungerlevel']; ?> | Esteem: <?php echo $list['esteemlevel']; ?> | Sleep: <?php echo $list['sleeplevel']; ?></strong>
                                                                    <a href="#" class="recent-post-readnore">Read More></a>
                                                                </div>
                                                            </div>
                                                        </div><?php }} ?> 
                                                        <!--<div class="recent-post-rptr">
                                                        	<div class="recent-post-title">
                                                            	<div class="recent-blog-heading">
                                                                    <h3><a href="#">Blog Post Title</a> - April 29th</h3>
                                                                    <ul class="post-manup-access">
                                                                        <li><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a></li>
                                                                        <li><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a></li>
                                                                    </ul>
                                                                </div>
                                                                <p>It used to be that when I sat around the house I sat "around the house" (if you know what I mean). Maecenas ac enim sit amet lacus semper tincidunt. Praesent iaculis, magna a blandit suscipit, leo tellus sollicitudin arcu, ut feugiat eros arcu sed risus. Cras felis arcu, lacinia lacinia sodales nec, pretium non nisi.</p>
                                                                <div class="post-info-line">
                                                                	<strong>Grade: A-  | BMI: 10 | Energy: 7 | Hunger: 9 | Esteem: 5 | Sleep: 7</strong>
                                                                    <a href="#" class="recent-post-readnore">Read More></a>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <!--<div class="recent-post-rptr">
                                                        	<div class="recent-post-title">
                                                            	<div class="recent-blog-heading">
                                                                    <h3><a href="#">Blog Post Title</a> - April 29th</h3>
                                                                    <ul class="post-manup-access">
                                                                        <li><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a></li>
                                                                        <li><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a></li>
                                                                    </ul>
                                                                </div>
                                                                <p>It used to be that when I sat around the house I sat "around the house" (if you know what I mean). Maecenas ac enim sit amet lacus semper tincidunt. Praesent iaculis, magna a blandit suscipit, leo tellus sollicitudin arcu, ut feugiat eros arcu sed risus. Cras felis arcu, lacinia lacinia sodales nec, pretium non nisi.</p>
                                                                <div class="post-info-line">
                                                                	<strong>Grade: A-  | BMI: 10 | Energy: 7 | Hunger: 9 | Esteem: 5 | Sleep: 7</strong>
                                                                    <a href="#" class="recent-post-readnore">Read More></a>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                     
  <div class="older-post-link"><a href="#">Older Posts&gt;</a></div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Recent Post-->
                                    </div>
                                  </div>
	<?php /////////////////////////////////Tab 4 end ////////////////////////?>								  
                                  <div class="clear">&nbsp;</div>
                               </div>
                            </div>
							
	<?php /////////////////////////////////popup start ////////////////////////?>				
							
	<div id="popupContact">
    	<div class="popup-ultimate">
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png"  width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Ultimate Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="#">
                	<fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                        <select name="selected"><option value="1">1</option><option value="2">2</option></select>
                        <label>Pounds</label>
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                    <select name="selected"><option></option></select>
                      <label>Clothing Sizes</label>
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                    <select name="selected"><option></option></select>
                      <label>% body fat</label>
                  </fieldset>
                    
                </form>
            </div>
            <p class="heading">Reward</p>
            <div class="form-cont">
            	<form action="#">
                	<fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>
                  <fieldset class="btn">
                    <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif"  />
                    <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
                  </fieldset>    
                </form>
            </div>
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
    </div>		
  		<div id="backgroundPopup"></div>		
<?php /////////////////////////////////////////////// ?>

	<div id="popupWeek">
	<div class="popup-ultimate">
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>8 Week Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="#">
                	<fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                        <select name="selected"><option></option></select>
                        <label>Pounds</label>
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                    <select name="selected"><option></option></select>
                      <label>Clothing Sizes</label>
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Lose</label>
                    <select name="selected"><option></option></select>
                      <label>% body fat</label>
                  </fieldset>
                    
                </form>
            </div>
            <p class="heading">Reward</p>
            <form action="#">
            <div class="form-cont">
            	
                	<fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="chk-box" type="checkbox" value="" />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>                 
          
           
         </div>
            <p class="heading">Time Remaining</p>
             <ul class="snapshot-time-count">
               <li>47<small>Days</small></li>
               <li>29<small>Hours</small></li>
               <li>07<small>Minutes</small></li>
               <li>12<small>Second</small></li>
            </ul>
         <div class="form-cont">
          
             <fieldset>
                    <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-reset.gif" class="reset-btn"  />                   
             </fieldset> 
             <p class="hr-line">&nbsp;</p>
             <fieldset class="btn">
                    <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif"  />
                    <input  type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
             </fieldset> 
           
              </div> 
                </form> 
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div> 
  </div>
  <div id="bgWeekPopup"></div>
  
  <?php ////////////////////////////////////////////?>
  <div class="popup-bonus-goal" id="popup-bonus-goal">
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>Bonus Goal</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <p class="heading">Inches Lost - My Waist</p>
        	<div class="bonus-goal-graph">
            </div>
            <p class="graph-calc"><label>Current = -1.8 in</label><span><label>Goal =</label><input name="txt" type="text" /></span></p>
             <p class="heading">Other Options</p>
             <form action="#" class="feature">
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
               <fieldset>
                  <label class="current">Inches Lost - My Hips</label><p>Current = 1.2 in<br /><label>Goal</label><input type="text" name="" class="goal" /></p><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-makeFeature.gif" class="featureBtn"  />
               </fieldset>
             <fieldset class="btn saveBtn">
                <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
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
   <div id="bgBonusPopup"></div>
   
   
   <?php ////////////////////////////////////////////////?>
   
   
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
                        <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
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
  
  <?php /////////////////////////////////////////////////////?>
  
  <div class="popup-bucketBox" id="popup-bucketBox">
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>My Bucket List</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <div class="bucketBox-inner">
            </div>
        	<fieldset>
            	<span>Run a 5k</span><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" value="" />
            </fieldset>
           <fieldset>
            	<span>Ride a horse</span><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" value="" />
            </fieldset>
           <fieldset>
            	<span>Buy 1 seat on an airplane</span><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" value="" />
            </fieldset>
           <fieldset>
            	<span>Look &amp; feel great for my s
on’s wedding</span><input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" value="" />
            </fieldset>
            <fieldset>
            	<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addNewitem.gif" value="" />
           </fieldset>
            <fieldset class="btn">
                <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="" />               
           </fieldset>
            
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
    <div id="bgAddBuketPopup"></div>
	
  <?php /////////////////////////////////////////////////////?>	
	<div class="popup-measurement" id="popup-measurement" >
  		<div class="top">
           <a href="" class="close"><img src="images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>My Measurements</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
         
            <div class="popup-middle">
              <div class="left-side">
            <h2 class="heading">My Measurements<span>Record your starting weight and take your initial body measurements with a measuring tape (cloth measuring 
tape preffered.). If you find it difficult to do your own measurements, enlist the help of a friend to make it easier.</span></h2>
			
            <div class="left-table">
            	<ul class="col-01">
                	<li class="col-head">start <br /> 01/01/10</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li class="col-end">12 in</li>
                    <li class="col-head-02">210 lbs</li>
                    <li class="col-start">30%</li>
                    <li>30%</li>
                    <li class="col-end">30%</li>
                </ul>  
                <ul class="parent-table">              
                   <li><ul class="row-01">                   	
                        	 <li>01/03/10</li>
                             <li>01/03/10</li>
                             <li>01/03/10</li>
                             <li>01/03/10</li>                            
                             <li>01/03/10</li> 
                             <li class="no-right-border">01/03/10</li>                             
                </ul></li>
                   <li><ul class="row-02">                   	
                        	 <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li> 
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>     
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>     
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li> 
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>     
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>     
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>                            
                             <li class="col-end">11 in</li> 
                             <li class="no-right-border col-end">11 in</li>   
                             <li class="col-head-02">11 in</li>
                             <li class="col-head-02">11 in</li>
                             <li class="col-head-02">11 in</li>
                             <li class="col-head-02">11 in</li>                            
                             <li class="col-head-02">11 in</li> 
                             <li class="no-right-border col-head-02">11 in</li>
                             <li class="col-start">11 in</li>
                             <li class="col-start">11 in</li>
                             <li class="col-start">11 in</li>
                             <li class="col-start">11 in</li>                            
                             <li class="col-start">11 in</li> 
                             <li class="no-right-border col-start">11 in</li> 
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>
                             <li>11 in</li>                            
                             <li>11 in</li> 
                             <li class="no-right-border">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>
                             <li class="col-end">11 in</li>                            
                             <li class="col-end">11 in</li> 
                             <li class="no-right-border col-end">11 in</li>                               
                </ul></li>
                </ul>
                <ul class="col-01 summary-table">
                	<li class="col-head">start <br /> 01/01/10</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li>12 in</li>
                    <li class="col-end">12 in</li>
                    <li class="col-head-02">210 lbs</li>
                    <li class="col-start">30%</li>
                    <li>30%</li>
                    <li class="col-end">30%</li>
                </ul>
                
                <ul class="col-01 form-table">
                	<li class="col-head">start <br /> 01/01/10</li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li class="col-end"><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li class="col-head-02"><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li class="col-start"><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li><label>Neck</label> <input type="text" name="" value="" /> </li>
                    <li class="col-end"><label>Neck</label> <input type="text" name="" value="" /> </li>
                </ul>
				   
            </div>
			   <div style="float:right; margin-top:10px;">
                        <input type="image" src="images/successjournal/btn-cancel.gif" value="" />
                        <input type="image" src="images/successjournal/btn-save.gif" value="" />               
               </div>
            </div>
            <div class="right-side"></div>
  
         </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
  </div>
  
   <div id="bgMeasurePopup"></div>