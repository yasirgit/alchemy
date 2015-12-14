 <script>  
         $  
         (  
             function()  
             {             
                 $("input[id^=chkMain]").click   
                 (   
                     function()   
                     {                 
                         var otherCks = $("input[id^=chkMain]").not(this);  
                         if( !$(this).is( ":checked" ))  
                         {                          
              
                            otherCks.removeAttr ( "disabled" );                    
                         }                     
                         else  
                         {                          
                           otherCks.attr("disabled" , true)  
                         }              
                     }  
                 );        
            }  
        );  
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
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="successjournal/up_uggoal" id="ulti" method="post">
                	<fieldset>
                    	<input name="losePounds" type="checkbox" value="1" <?php if($uglist['losePounds']==1){ echo "checked = 'checked'" ; } ?> />
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
                    	<input name="daySpa" id="chkMain" type="checkbox" value="1"  <?php if($uglist['daySpa']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input name="weekendTrip" id="chkMain" type="checkbox" value="1"  <?php if($uglist['weekendTrip']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input name="concertTickets" id="chkMain" type="checkbox" value="1"   <?php if($uglist['concertTickets']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="nightOuts" id="chkMain" type="checkbox" value="1"  <?php if($uglist['nightOuts']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="newOutfit" id="chkMain" type="checkbox" value="1"  <?php if($uglist['newOutfit']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input name="myOwnreward" id="chkMain" type="checkbox" value="1"  <?php if($uglist['myOwnreward']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>
                  <fieldset class="btn">
                    <input id="usave" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave" value="save" />    
                 <!--   <input id="usave" type="submit" name="ultimateGoalSave" value="save" />-->

                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="successjournal/ugoalentry" id="ulti" method="post">
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
                    	<input id="chkMain" name="daySpa" type="checkbox" value="1" />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" name="weekendTrip" type="checkbox" value="1" />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" name="concertTickets" type="checkbox" value="1" />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="nightOuts" type="checkbox" value="1" />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="newOutfit" type="checkbox" value="1" />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="myOwnreward" type="checkbox" value="1" />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>
                  <fieldset class="btn">
                    <input id="usave" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave" value="save" />    
                 <!--   <input id="usave" type="submit" name="ultimateGoalSave" value="save" />-->

                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
  <?php } ?>
    </div>
	
	<div id="backgroundPopup"></div>