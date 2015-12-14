<script>
$(document).ready(function(){
      	var meter_url="successjournal/bonus_popup_meter_desc";
        
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:meter_url,
				 data:"1",
                 success: function(success){
				 	//alert(success);
					$('#ajax_bonus_data').html(success);
                   // alert("success");
                  }
               });	
	 

		
		return false; 

});
	
</script>
<div class="popup-bonus-goal" id="popup-bonus-goal">

<div id="ajax_bonus_data">

    </div>
	
  </div>


<div id="bgBonusPopup"></div>