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
														<?php  foreach ($editJournal as $key => $list){ ?>
                                                        <form name="editJournal" method="post" action="successjournal/update/<?php echo $list['id'] ;?> ">
                                                        	<fieldset class="add-journal-fields">
                                                            	<label>Title:</label> 
                                                             <span class="text"><input name="addtitle" type="text" value="<?php echo $list['title'];  ?>" /></span>  
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                            <fieldset class="add-journal-fields">
                                                            	<label>Text:</label>
                                                                <textarea name="details" class="" rows="" cols=""><?php echo $list['details'];  ?></textarea>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                      <!--  </form>-->
                                                        <div class="self-assistment-zone">
                                                        	<h2 class="self-assistment-title">My Self Assessment</h2>
                                                        	<div class="self-assistment-rptr">
                                                            	<div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-hunger.gif" alt="" /></div>
                                                                <div class="assesment-level-text">Hunger Level:</div>
<div><input name="hungerlevel" id="hungerlevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" value="<?php echo $list['hungerlevel'];  ?>" ></div>
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
			<div><input name="englevel" id="energylevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" value="<?php echo $list['energylevel'];  ?>" ></div>
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
<input name="esteemlevel" id="esteemlevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" value="<?php echo $list['esteemlevel'];  ?>" >
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
<input name="sleepquality" id="sleepquality" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden" value="<?php echo $list['sleeplevel'];  ?>" >	
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
                                                            	<input type="radio" name="access-type" <?php if($list['status']==1) echo "checked='checked'"; ?>  value="1" /> Public &nbsp;&nbsp;&nbsp; <input type="radio" name="access-type" <?php if($list['status']==2) echo "checked='checked'"; ?>  value="2" /> Private
                                                            </div>
                                                            <div class="journal-post-btn">
				 <div class="sexybutton sexyorange"><span><span><input class="jpostbutton"  type="submit" name="upJournal" value="Post It" /></span></span></div>
                                                            	<!--<a class="sexybutton sexyorange" href="#"><span><span>Post It</span></span></a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form><?php } ?>