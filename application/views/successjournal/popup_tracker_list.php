<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".trackEdit").click(function() {   

            var  id = $(this).attr("id");
			
			var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_tracker_editpost";
	   	
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "eid="+id,
                 success: function(success){
				 	//alert(success);
					$('#list_edit').html(success);
                    // success.html(html);
						
                   
                  }
               });               
       	  
		 });   

         
       return false;
     });  
</script>


<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".tracKDelete").click(function() {   

            var  id = $(this).attr("id");
			
			var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_tracker_delete";
	   	
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "del="+id,
                 success: function(success){
				 	//alert(success);
					$("#field_"+id).hide('slow');
                    // success.html(html);
						
                   
                  }
               });               
       	  
		 });   

         
       return false;
     });  
</script>

<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".tActive").click(function() {   
 
        	 var  id = $(this).attr("id");   
			 if($(this).attr("checked")==true)
             {
               var setStatus = 1;
	
             }
			 else{
			   var setStatus = 0;
			 }

			  //alert(setStatus);
			
		      var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_tracker_active";
	          var data = 'actid=' + id + '&setStatus=' + setStatus;
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data:data,
                 success: function(success){
	
                  }
               });               
       	  
		 });   

         
       return false;
     });  
</script>



<div class="popup-bonus-goal" id="popup_tracker_list">
  <div class="top"> <a class="close" href=""><img width="28" height="28" alt="close" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png"></a>
    <div class="top-mid">
      <h2>Compliment Tracker List</h2>
    </div>
    <div class="top-right"> </div>
  </div>
  
  
    <?  /*  edit List */ ?>
	
	<div id="list_edit"></div>
  
  
  <?  /*  edit List */ ?>
  
  <div class="popup-middle">
   
    <div class="heading cheading">
	   <div class="head1" >Tracker List</div>
	   <div class="head2" >Edit</div>
	   <div class="head3" >Delete</div>
	   <div class="head4" >Active</div>
	</div>
    <form class="feature" action="successjournal/" id="listTrk">
	<? if($get_All_ctrack>0) {
	      foreach($get_All_ctrack as $trackList) 
		  {  //substr($short_desc, 0, 150); 
	?>
      <fieldset id="field_<? echo $trackList['id']; ?>">
          <label class="tracklist" ><? echo substr($trackList['blog'],0, 35); ?></label>
          <span class="edit_track"  >
               <a href="javascript:void" class="trackEdit" id="<? echo $trackList['id']; ?>"><img src="<?=$this->config->item('base_url')?>/htdocs/images/ico-edit.gif" /></a>
		  </span>
		  <span  class="delete_track">
		       <a href="javascript:void"  class="tracKDelete" id="<? echo $trackList['id']; ?>" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" /></a>
		  </span>
		  <span  class="active_track">
             <input id="<? echo $trackList['id']; ?>" class="tActive"  type="checkbox"  name="box" value="1" <?php if($trackList['active']==1){ echo "checked = 'checked'" ; } ?> />
          </span>
       
      </fieldset>
	  
	  <? } } ?>


      <fieldset class="btn saveBtn">
        <input type="image" value="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" class="close2">
        <a href="<?php echo $this->config->item('base_url')?>/successjournal/" id="trackSave">
		<img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" />
		</a>
      </fieldset>
    </form>
  </div>
  <div class="bottom">
    <div class="bottom-mid"> </div>
    <div class="bottom-right"> </div>
  </div>
</div>

<div id="bgTrackerList"></div>