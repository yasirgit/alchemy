
 <div class="journul-post">
    <div class="add-journal">
       <div class="s-border-wrapper">
          <div class="s-common-title">
             <h2>
               <div class="add-journal-heading">Edit a Journal Entry</div>
               <div class="user-area" >
                   <ul id="tabset" class="journaltabset">
                      <li class="active" id="t13"><a class="tab" href="#tab-13" style="display:none;" ><span>Text</span></a></li>
                      <!--<li id="t14"><a class="tab" href="#tab-14"><span>Video</span></a></li>-->
                   </ul>
               </div>
               <div class="clear">&nbsp;</div>
             </h2>
          </div>
		  <?php  foreach ($editJournal as $key => $list){ ?>
	<script>

$(function() {

       $( "#slider-range-five" ).slider({
			range: false,
			value: <?php echo $list['hungerlevel'];  ?>,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#hungerlevel" ).val(ui.value );
			}
		});
		 $( "#hungerlevel" ).val( "$" + $( "#slider-range-first" ).slider( "value" ) );
		 
		 
		$( "#slider-range-six" ).slider({
			range: false,
			value: <?php echo $list['energylevel'];  ?>,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#energylevel" ).val(ui.value );
			}
		});
		
		$( "#energylevel" ).val( "$" + $( "#slider-range-first" ).slider( "value" ) );
		 
		$( "#slider-range-seven" ).slider({
			range: false,
			value: <?php echo $list['esteemlevel'];  ?>,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#esteemlevel" ).val(ui.value );
			}
		});
		 $( "#esteemlevel" ).val( "$" + $( "#slider-range-first" ).slider( "value" ) );
		 
	    $( "#slider-range-eight" ).slider({
			range: false,
			value: <?php echo $list['sleeplevel'];  ?>,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#sleepquality" ).val(ui.value );
			}
		});
		 $( "#sleepquality" ).val( "$" + $( "#slider-range-first" ).slider( "value" ) );
 
 

});

</script>	  
		  
		  
		  
					<form name="editJournal" method="post" action="successjournal/update/<?php echo $list['id'] ;?> " enctype="multipart/form-data" >
					<?php if($list['file']==''){ ?>
                        <div id="tab-13" class="add-journal-zone">
                             <p><strong>Keep track of your fat loss journey to help you remember what worked and didn't, how you felt each day along the journey to help keep yourself and others motivated until you reach your goal.</strong></p>
                             <p><i>(What did you do well?  What do you want to try to improve tomorrow? How was your energy level?  Hunger &amp; craving levels?  Mood?  What challenges did you face today? What was the best thing about today?)</i></p>
                                                   
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
                                              
                                                        
                       </div>
				<!--end tab13-->	 
				<!--tab14-->
													
													<div id="tab-14" class="add-journal-zone" style="display:none;">
                                                    	<p><strong>Keep track of your fat loss journey to help you remember what worked and didn't, how you felt each day along the journey to help keep yourself and others motivated until you reach your goal.</strong></p>
                                                        <p><i>(What did you do well?  What do you want to try to improve tomorrow? How was your energy level?  Hunger &amp; craving levels?  Mood?  What challenges did you face today? What was the best thing about today?)</i></p>
                                                       <!-- <form name="addJournal" method="post" action="successjournal/">-->
                                                        	<fieldset class="add-journal-fields">
                                                            	<label>Title:</label>
                                                                <span class="text"><input name="vaddtitle" type="text" /></span>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                            <fieldset class="add-journal-fields">
                                                            	<label>File:</label>
                                                                <div class="customize-browse"><input type="file" class="file_1" /></div>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
															<fieldset class="add-journal-fields">
                                                            	<label>Text:</label>
                                                                <textarea name="vdetails" class="" rows="" cols=""></textarea>
                                                                <div class="clear">&nbsp;</div>
                                                            </fieldset>
                                                      <!--  </form>-->
                                                        
                                                    </div>
													<!--tab14-->  
					   
					   
				<?php } else { ?>
                                 <script>
                                      $(document).ready(function(){

		                                    $('#t13').removeClass('active');
		                                    $('#t14').addClass('active');
		                                    $('#tab-13').css("display","none");
		                                    $('#tab-14').css('display',"block");
	
                                      });	
                                 </script>
 <!--tab-13-->
 <div id="tab-13" class="add-journal-zone">
                                                    	<p><strong>Keep track of your fat loss journey to help you remember what worked and didn't, how you felt each day along the journey to help keep yourself and others motivated until you reach your goal.</strong></p>
                                                        <p><i>(What did you do well?  What do you want to try to improve tomorrow? How was your energy level?  Hunger &amp; craving levels?  Mood?  What challenges did you face today? What was the best thing about today?)</i></p>
                                                       <!-- <form name="addJournal" method="post" action="successjournal/">-->
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
                                                        
                                                    </div>
 <!--tab 13 end-->
 



													<!--tab14-->
													
					<div id="tab-14" class="add-journal-zone">
                        <p><strong>Keep track of your fat loss journey to help you remember what worked and didn't, how you felt each day along the journey to help keep yourself and others motivated until you reach your goal.</strong></p>
                         <p><i>(What did you do well?  What do you want to try to improve tomorrow? How was your energy level?  Hunger &amp; craving levels?  Mood?  What challenges did you face today? What was the best thing about today?)</i></p>
                                                   
                         <fieldset class="add-journal-fields">
                             <label>Title:</label>
                                 <span class="text">
								 <input name="vaddtitle" type="text" value="<?php echo $list['title'];  ?>" /></span>
                                 <div class="clear">&nbsp;</div>
                         </fieldset>
                         <fieldset class="add-journal-fields">
                             <label>File:</label>
                           
							  <div class="customize-browse"><input type="file" name="userfile" class="file_1" id="videoup"  /></div>
                         <div class="clear">&nbsp;</div>
                         </fieldset>
						 <fieldset class="add-journal-fields">
                             <label>Text:</label>
                             <textarea name="vdetails" class="" rows="" cols=""><?php echo $list['details'];  ?></textarea>
                             <div class="clear">&nbsp;</div>
                         </fieldset>
                                                
                                                        
                    </div>
			  <?php } ?>
													
					<!--end tab14-->
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
                         <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-five">
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
			 <div><input name="englevel" id="energylevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden"  ></div>
             <div class="assesment-level">
                 <div class="assesment-point-level">
                    <span>Low</span><span class="satisfy hight-low">High</span>
                 </div>
                                                                    <div class="assesment-point-holder">
                <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-six">
                <div style="width: 2.71817%;" class="ui-slider-range ui-slider-range-min ui-widget-header"></div>
	            <a style="left: 2.71817%;" class="ui-slider-handle ui-state-default ui-corner-all ui-state-focus" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/perfromance-mitre-point.png" alt="" /></a>
	         </div>
		</div>
       </div>
       <div class="clear">&nbsp;</div>
      </div>
    <div class="self-assistment-rptr">
     <div class="assesment-icon"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/my-self-assest-esteem.gif" alt="" />
	 </div>
     <div class="assesment-level-text">Self Esteem Level:</div>
<input name="esteemlevel" id="esteemlevel" style="border: 0pt none; color: rgb(246, 147, 31); font-weight: bold;" type="hidden"  >
      <div class="assesment-level">
           <div class="assesment-point-level">
           <span>Low</span><span class="satisfy hight-low">High</span>
      </div>
      <div class="assesment-point-holder">
	  <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-seven">
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
                        <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider-range-eight">
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
                                                            	
              </div>
           </div>
	
		 </form><?php } ?>
       </div>
    </div>
 </div>
                                     
                                               