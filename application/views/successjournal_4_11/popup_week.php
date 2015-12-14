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
<script>
$(document).ready(function(){
  $(".reset-btn").click(function(e){ //alert("gg");
    $("#dd").load("go.php");
  });
});
</script>

<div id="popupWeek">

<?php
  if(count($weekGoal)>0){
	foreach ($weekGoal as $key => $wglist)
	{ 
	      $enddate = $wglist['endingDate'];
		 /* $waittime=date("y-m-d h:i:s");
          $diff=strtotime($enddate)-strtotime($waittime);
             $temp=$diff/86400; 
          $days=floor($temp);
             $temp=24*($temp-$days);
          $hours=floor($temp);
             $temp=60*($temp-$hours);
          $minutes=floor($temp);
             $temp=60*($temp-$minutes);
          $seconds=floor($temp);*/
		  
		  $dt=explode('-',$enddate); $x=1;
          $s=$dt[1]-$x;
          $edate=$dt[0].",".$s.",".$dt[2];
		
?>
<script type="text/javascript">
   $(document).ready(function() {
          var austDay = new Date(<?php echo $edate; ?>); 
          $('#popupCountdown').countdown({until:austDay});
    
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
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="successjournal/up_weekgoal" id="wGoal" method="post">
                	<fieldset>
                    	<input name="losePounds" type="checkbox" value="1" <?php if($wglist['losePounds']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                         <select name="pounds">
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
                    	<input name="loseClothing" type="checkbox" value="1" <?php if($wglist['loseClothing']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Lose</label>
                    <select name="clothingSize">
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
                       <input name="loseBodyfat" type="checkbox" value="1" <?php if($wglist['loseBodyfat']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Lose</label>
                    <select name="bodyFat">
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
          
            <div class="form-cont">
            	
                	<fieldset>
                    	<input id="chkMain" name="daySpa" type="checkbox" value="1" <?php if($wglist['daySpa']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Day at the Spa</label>                       
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" name="weekendTrip" type="checkbox" value="1"  <?php if($wglist['weekendTrip']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Weekend Trip</label>                    
                  </fieldset>
                  <fieldset>
                    	<input id="chkMain" name="concertTickets" type="checkbox" value="1" <?php if($wglist['concertTickets']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Concert/Sporting Tickets</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="nightOuts" type="checkbox" value="1"  <?php if($wglist['nightOuts']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>Night Out</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="newOutfit" type="checkbox" value="1" <?php if($wglist['newOutfit']==1){ echo "checked = 'checked'" ; } ?> />
                        <label>New Outfit</label>                   
                  </fieldset>
                   <fieldset>
                    	<input id="chkMain" name="myOwnreward" type="checkbox" value="1" <?php if($wglist['myOwnreward']==1){ echo "checked = 'checked'" ; } ?>  />
                        <label>Enter my own Reward</label>                                          
                  </fieldset>                 
          
           
         </div>
            <p class="heading">Time Remaining</p>
			<div id="dd">
			<input type="hidden" name="endingDate" value="<?php echo $enddate; ?>">
			 <div id="popupCountdown" class="snapshot-time-count"></div>
            
			</div>
         <div class="form-cont">
          
             <fieldset>  <input type="button" class="reset-btn" value=""  />   
                    <!--<input id="reset" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-reset.gif" class="reset-btn"  />  -->                 
             </fieldset> 
             <p class="hr-line">&nbsp;</p>
             <fieldset class="btn">
 <input id="weekGl" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave" value="save" />   
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
	/* initial Popup */
echo "Star=". $startdate = strtotime($first_dayMsr->um_date); 
 
 echo "--End=".$enddate =  date('Y-m-d', strtotime('+8 week',$startdate));
 $dt=explode('-',$enddate); $x=1;
                  $s=$dt[1]-$x;
                  $edate=$dt[0].",".$s.",".$dt[2];


?>
<script type="text/javascript">
   $(document).ready(function() {
          var austDay = new Date(<?php echo $edate; ?>); 
          $('#initialCountdown').countdown({until:austDay});
    
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
        	<p class="heading">Goal</p>
            <div class="form-cont">
            	<form action="successjournal/weekgoal" id="wGoal" method="post">
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
          
           
         </div>
            <p class="heading">Time Remaining</p>
			<div id="dd">
			<input type="hidden" name="endingDate" value="<?php echo $enddate; ?>">
			 <div id="initialCountdown" class="snapshot-time-count"></div>

			</div>
         <div class="form-cont">
          
             <fieldset>  <input type="button" class="reset-btn" value=""  />   
                    <!--<input id="reset" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-reset.gif" class="reset-btn"  />  -->                 
             </fieldset> 
             <p class="hr-line">&nbsp;</p>
             <fieldset class="btn">
 <input id="weekGl" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ultimateGoalSave" value="save" />   
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
  
  <div id="bgWeekPopup"></div>