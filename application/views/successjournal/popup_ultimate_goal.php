 
<script language="JavaScript" type="text/javascript">
 $(function(){
        $("#usave").click(function() { 
	  
			$('#ulti').ajaxSubmit(
			{
						url:			"successjournal/up_uggoal",
						type:			'post',	
						beforeSubmit:	function()
										{
											$('#load_before').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/successjournal/ajax-loader.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                  // $('#lft-box').html(data);
										   $("#lft-box").load('successjournal/ajax_ultimate');
										   $("#snap_ultimate-goal").load('successjournal/ajax_snapshot_ultimate');
										   $('#load_before').css('display',"none");
										  disablePopup();  
                                           //alert("success");
										 //window.location.reload('successjournal/ajax_ultimate');
										
   
										}
			});
			
			return false;
        });
		
    // disablePopup();  
	return false; 
 }); 
</script>
 



<div id="popupContact">
<?php  if(count($ugoalset)>0) {
foreach ($ugoalset as $key => $uglist)
{
?>
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
		    <form action="successjournal/up_uggoal" id="ulti" method="post">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	
                	<fieldset>
                    	<input name="losePounds" type="checkbox" type="radio" value="1" <?php if($uglist['losePounds']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Lose</label>
                        <select name="pounds">
						     <option value="0"></option>
							 <?php 
						     for($i=5; $i<=50; $i=$i+5)
							{

							?>
						     <option value="<?php echo $i; ?>" <?php if($uglist['pounds']== $i){ echo "selected='selected'";} ?> ><?php echo $i; ?></option>
						   <?php
                             }
						   ?>
					    </select>
                        <label>Pounds</label>
                  </fieldset>
                  <fieldset>
                    	<input name="loseClothing" type="checkbox" value="1" <?php if($uglist['loseClothing']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                    <select name="clothingSize">
					        <option value="0"></option>
							<?php 
						    for($j=1; $j<=10; $j++)
							{
						    ?>
					            <option value="<?php echo $j; ?>" <?php if($uglist['clothingSize']== $j){ echo "selected='selected'";} ?>  ><?php echo $j; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>Clothing Sizes</label>
                  </fieldset>
                  <fieldset>
                    	<input name="loseBodyfat" type="checkbox" value="1" <?php if($uglist['loseBodyfat']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                    <select name="bodyFat">
					       <option value="0"></option>
					       <?php 
						    for($k=1; $k<=20; $k++)
							{
						    ?>
					            <option value="<?php echo $k; ?>" <?php if($uglist['bodyFat']== $k){ echo "selected='selected'";} ?> ><?php echo $k; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>% body fat</label>
                  </fieldset>
                    
  
            </div>
            <p class="heading">Reward</p>
            <div class="form-cont">
            
                	<fieldset>
                    	<input name="daySpa" id="rdMain" type="radio" value="1"  <?php if($uglist['daySpa']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input name="weekendTrip" id="rdMain" type="radio" value="1"  <?php if($uglist['weekendTrip']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input name="concertTickets" id="rdMain" type="radio" value="1"   <?php if($uglist['concertTickets']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="nightOuts" id="rdMain" type="radio" value="1"  <?php if($uglist['nightOuts']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="newOutfit" id="rdMain" type="radio" value="1"  <?php if($uglist['newOutfit']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="myOwnreward" id="rdMain" class="rdMain6" type="radio" value="1"  <?php if($uglist['myOwnreward']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>
				    <fieldset id="ownUltiReward" style="display:none;">
				     <label>&nbsp;&nbsp;&nbsp;</label> 
                    	<input id="ownRewardText" name="ownRewardText" type="text" value="<?php echo $uglist['ownRewardText']; ?>" /> 
                                                                 
                  </fieldset>      
                  <fieldset class="btn">
                    <input id="usave" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave"  />    
                 <!--   <input id="usave" type="submit" name="ultimateGoalSave" value="save" />-->

                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
	
<?php } ?>
	
<?php	
	}else{
?>
   
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
		    <form action="successjournal/up_uggoal" id="ulti" method="post">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	
                	<fieldset>
                    	<input name="losePounds" type="checkbox" value="1" />
                        <label>Lose</label>
                        <select name="pounds">
						     <option value="0"></option>
							 <?php 
						     for($i=5; $i<=50; $i=$i+5)
							{

							?>
						     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						   <?php
                             }
						   ?>
					    </select>
                        <label>Pounds</label>
                  </fieldset>
                  <fieldset>
                    	<input name="loseClothing" type="checkbox" value="1" />
                        <label>Lose</label>
                    <select name="clothingSize">
					        <option value="0"></option>
							<?php 
						    for($j=1; $j<=10; $j++)
							{
						    ?>
					            <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>Clothing Sizes</label>
                  </fieldset>
                  <fieldset>
                    	<input name="loseBodyfat" type="checkbox" value="1" />
                        <label>Lose</label>
                    <select name="bodyFat">
					       <option value="0"></option>
					       <?php 
						    for($k=1; $k<=20; $k++)
							{
						    ?>
					            <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>% body fat</label>
                  </fieldset>
                    
  
            </div>
            <p class="heading">Reward</p>
            <div class="form-cont">
            
                	<fieldset>
                    	<input id="rdMain" name="daySpa" type="radio" value="1" />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input id="rdMain" name="weekendTrip" type="radio" value="1" />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input id="rdMain" name="concertTickets" type="radio" value="1" />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="rdMain" name="nightOuts" type="radio" value="1" />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="rdMain" name="newOutfit" type="radio" value="1" />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="rdMain" name="myOwnreward" class="rdMain6" type="radio" value="1" />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>
				  <fieldset id="ownUltiReward" style="display:none;">
				     <label>&nbsp;&nbsp;&nbsp;</label> 
                    	<input id="ownRewardText" name="ownRewardText" type="text" value="" /> 
                                                                 
                  </fieldset>  
                  <fieldset class="btn">
                    <input id="usave" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave" />    
                 <!--   <input id="usave" type="submit" name="ultimateGoalSave" value="save" />-->

                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
  <?php } ?>
    </div>
	
	<div id="backgroundPopup"><div  id="load_before"  style="margin:auto; width:250px; padding-top:40px;"></div></div>