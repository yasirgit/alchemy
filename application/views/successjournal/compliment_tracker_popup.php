<script> 
 $(function(){
   // var id =1;
	
     $("#ctrack").click(function() {   
	      // var  id = $(this).attr("id"); 
			var url="<?php echo $this->config->item('base_url')?>/successjournal/complimentTracker";
	   	     
			
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: '',
                 success: function(success){
				 	//alert(success);
					//$('#recent-post-holder').html(success);
                    // success.html(html);
                  }
               });               
       	  
		 });              
       return false;
     }); 

</script>


<div class="popup-ultimate" id="compli_track_popup">
  <div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png"  width="28" height="28" alt="close" /></a>
    <div class="top-mid">
      <h2>Compliment Tracker</h2>
    </div>
    <div class="top-right"> </div>
  </div>
  <div class="popup-middle">
    <p class="heading">Tracker Message</p>
     <div class="blog">
       <form action="successjournal/complimentTracker" method="post">
    <fieldset>
   		<label>Name</label><input type="text" name="bloger_name" id="" value="" />
    </fieldset> 
     <fieldset>
   		<label>Message</label><textarea name="bloger_text"></textarea>
    </fieldset>    
    <fieldset class="sub-btn btn">
   		<input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
                             <input  id="ctrack" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ciTrackSave" value="" /> 
    </fieldset>
 </form>  
     
        
     </div>
  
  </div>
  <div class="bottom">
    <div class="bottom-mid"> </div>
    <div class="bottom-right"> </div>
  </div>
</div>    
<div id="bgTrackerPopup"></div>