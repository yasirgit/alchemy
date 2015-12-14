
<script language="JavaScript" type="text/javascript">
 $(function(){
 
    $(".reset-btn").click(function(e){ 
       $("#dd").load("go.php");
	 //  $('#eDte_db').css("display","none");
	   
	   <?  //$enddate =  date('Y-m-d h:i:s', strtotime('+8 week')); ?>
	    // $('<input type="hidden" id="endingDate" name="endingDate" value="<?php echo $enddate; ?>" />').appendTo('#eDte');
	});
	

	$("#weekGl").click(function() { 
	  
			$('#wGoal').ajaxSubmit(
			{
						url:			"successjournal/up_weekgoal",
						type:			'post',	
						beforeSubmit:	function()
										{
										   $('#load_before_img').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/successjournal/ajax-loader.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  
						                  // $('#lft-box').html(data);
										   $("#rht-box").load('successjournal/ajax_week');
										   $("#snap_week_goal").load('successjournal/ajax_snapshot_week');
										   $('#load_before_img').css('display',"none");
										   disableWeekPopup();  
                                          
   
										}
			});
			
			return false;
        }); 

		 
		 
       return false;
     });  
</script>
 


<div id="popupWeek">



<?php
  if(count($weekGoal)>0){ 

	foreach ($weekGoal as $key => $wglist) 
	{ 
	    
		 $enddate = $wglist['endingDate'];
         $curDate = date('Y-m-d h:i:s');   
		  $remainDays = strtotime($enddate)-strtotime($curDate);
		  $temp=$remainDays/86400; 
		  $days=floor($temp); 
		  $temp=24*($temp-$days);
	      $hours=floor($temp);
		  $temp=60*($temp-$hours);
		  $minutes=floor($temp);
		  $temp=60*($temp-$minutes);
		  $seconds=floor($temp);
	 //  echo   $countDays = floor($res/(60*60*24));
		  
?>
<script type="text/javascript">
   $(document).ready(function() {
         $('#popupCountdown').countdown({until:'+<? echo $days; ?>d +<? echo $hours; ?>h +<? echo $minutes; ?>m +<? echo $seconds; ?>s'});
    
   });
</script>
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
		    <form action="" id="wGoal" method="post">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	
                	<fieldset>
                    	<input name="losePounds" id="losePounds" type="checkbox" value="1" <?php if($wglist['losePounds']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                         <select name="pounds" id="pounds">
						     <option value="0"></option>
							 <?php 
						     for($i=5; $i<=50; $i=$i+5)
							{

							?>
						     <option value="<?php echo $i; ?>" <?php if($wglist['pounds']== $i){ echo "selected='selected'";} ?> ><?php echo $i; ?></option>
						   <?php
                             }
						   ?>
					    </select>
                        <label>Pounds</label>
                  </fieldset>
                  <fieldset>
                    	<input name="loseClothing" id="loseClothing" type="checkbox" value="1" <?php if($wglist['loseClothing']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                    <select name="clothingSize" id="clothingSize">
					        <option value="0"></option>
							<?php 
						    for($j=1; $j<=10; $j++)
							{
						    ?>
					            <option value="<?php echo $j; ?>" <?php if($wglist['clothingSize']== $j){ echo "selected='selected'";} ?>  ><?php echo $j; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>Clothing Sizes</label>
                  </fieldset>
                  <fieldset>
                       <input name="loseBodyfat" id="loseBodyfat" type="checkbox" value="1" <?php if($wglist['loseBodyfat']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Lose</label>
                    <select name="bodyFat" id="bodyFat">
					       <option value="0"></option>
					       <?php 
						    for($k=1; $k<=20; $k++)
							{
						    ?>
					       <option value="<?php echo $k; ?>" <?php if($wglist['bodyFat']== $k){ echo "selected='selected'";} ?> ><?php echo $k; ?></option>
								
							<?php 
							}
						   ?>
					</select>
                      <label>% body fat</label>
                  </fieldset>
                    
               
            </div>
            <p class="heading">Reward</p>
          
            <div class="form-cont" id="reward_box">
            	
                	<fieldset>
                    	<input id="chkMain" class="chkMain1" name="daySpa" type="radio" value="1" <?php if($wglist['daySpa']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" class="chkMain2" name="weekendTrip" type="radio" value="1"  <?php if($wglist['weekendTrip']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" class="chkMain3" name="concertTickets" type="radio" value="1" <?php if($wglist['concertTickets']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain4" name="nightOuts" type="radio" value="1"  <?php if($wglist['nightOuts']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain5" name="newOutfit" type="radio" value="1" <?php if($wglist['newOutfit']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain6" name="myOwnreward" type="radio" value="1" <?php if($wglist['myOwnreward']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>  
				  <fieldset id="enterOwnReward" style="display:none;">
				     <label>&nbsp;&nbsp;&nbsp;</label> 
                    	<input id="ownRewardText" name="ownRewardText" type="text" value="<?php echo $wglist['ownRewardText']; ?>" /> 
                                                                 
                  </fieldset>                
          
           
         </div>
            <p class="heading">Time Remaining</p>
			
			<div id="dd">
			<input id="endingDate" type="hidden" name="endingDate" value="<?php echo $enddate; ?>">
		
			 <div id="popupCountdown" class="snapshot-time-count"></div>
            
			</div>
         <div class="form-cont">
          
             <fieldset>  
			 <input type="button" class="reset-btn" value=""  style="cursor:pointer;"  />   
                    <!--<input id="reset" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-reset.gif" class="reset-btn"  />  -->                 
             </fieldset> 
             <p class="hr-line">&nbsp;</p>
             <fieldset class="btn">
 <input id="weekGl" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="WGoalSave"  />   
<!--  <input id="weekGl" type="submit" name="" value="save" />-->
                    <input class="close2"  type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
 <?php }
    }else{ 

 $enddate=  date('Y-m-d h:i:s', strtotime('+8 week'));
?>
<script>
$(document).ready(function(){
   $("#dd").load("go.php");
 
});
</script>

 
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
		    <form action="" id="wGoal" method="post">
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	
                	<fieldset>
                    	<input name="losePounds" id="losePounds" type="checkbox" value="1" />
                        <label>Lose</label>
                         <select name="pounds" id="pounds">
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
                    	<input name="loseClothing" id="loseClothing" type="checkbox" value="1" />
                        <label>Lose</label>
                    <select name="clothingSize" id="clothingSize">
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
                       <input name="loseBodyfat" id="loseBodyfat" type="checkbox" value="1" />
                        <label>Lose</label>
                    <select name="bodyFat" id="bodyFat">
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
                    	<input id="chkMain" class="chkMain1" name="daySpa" type="radio" value="1" />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" class="chkMain2" name="weekendTrip" type="radio" value="1" />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" class="chkMain3" name="concertTickets" type="radio" value="1" />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain4" name="nightOuts" type="radio" value="1" />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain5" name="newOutfit" type="radio" value="1" />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" class="chkMain6" name="myOwnreward" type="radio" value="1" />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>   
				  <fieldset id="enterOwnReward" style="display:none;">
				     <label>&nbsp;&nbsp;&nbsp;</label> 
                    	<input id="ownRewardText" class="" name="ownRewardText" type="text" value="" ?> 
                                                                 
                  </fieldset>                 
          
           
         </div>
            <p class="heading">Time Remaining</p>
			
			<div id="dd">
			 <input type="hidden" id="endingDate" name="endingDate" value="<?php echo $enddate; ?>">
			 <div id="initialCountdown" class="snapshot-time-count"></div>

			</div>

			
         <div class="form-cont">
          
             <fieldset>  <input type="button" class="reset-btn" value=""   style="cursor:pointer;"   />   
                    <!--<input id="reset" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-reset.gif" class="reset-btn"  />  -->                 
             </fieldset> 
             <p class="hr-line">&nbsp;</p>
             <fieldset class="btn">
 <input id="weekGl" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave"/>   

                    <input class="close2"  type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
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
  <?php  }?>
  </div>
  
  <div id="bgWeekPopup"><div  id="load_before_img"  style="margin:auto; width:250px; padding-top:40px;"></div></div>