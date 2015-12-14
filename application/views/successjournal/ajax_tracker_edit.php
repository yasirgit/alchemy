<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".tc_editid").click(function() {   

            var  id = $(this).attr("id");
			var name = $('#bloger_name').val();
			
            var blog = $('#bloger_text').val();
			var data = 'name=' + name + '&msg=' + blog + '&upid=' + id ;
			
			var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_tracker_editpost";
	   	
			//alert(data);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: data,
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
<script>
 $(function(){
   // var id =1;
	
    

     $(".CancelEdit").click(function() {  
         $('#loadDiv').css("display","none");
     });
     
       return false;
     });  
</script> 

<?
foreach($editId as $tracEdit){

  $msg=$tracEdit['blog'];
  $name=$tracEdit['name'];
  $id=$tracEdit['id'];
}
 ?>


<div class="popup-middle" id="loadDiv">
    <p class="heading">Edit Tracker Message</p>
     <div class="blog">
       <form action="successjournal/ajax_tracker_editpost" method="post">
	     <input type="hidden" name="bloger_id"  value="<? echo $id; ?>" />
    <fieldset>
   		<label>Name</label><input type="text" name="bloger_name" id="bloger_name" value="<? echo $name; ?>" />
    </fieldset> 
     <fieldset>
   		<label>Message</label><textarea name="bloger_text" id="bloger_text" cols="4" rows="2"><? echo $msg; ?></textarea>
    </fieldset>    
    <fieldset class="sub-btn btn" style="float:right; width:200px;">
   		<a  href="javascript:void()"><img class="CancelEdit" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
                             <a id="<? echo $id; ?>" class="tc_editid" href="javascript:void();"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ciTrackSave"/></a> 
    </fieldset>
 </form>  
     
        
     </div>
  
  </div>