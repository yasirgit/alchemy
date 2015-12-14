<script language="JavaScript" type="text/javascript">
 $(function(){
    var id =1;
	//$('#older').click(function(){
	    var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_recent_post";	
	   	
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "p="+id,
                 success: function(success){
				 	//alert(success);
					$('#recent-post-holder').html(success);
                    // success.html(html);
                  }
               });               
       	  
		              
       return false;
	  // });
     });  
</script>
<!--x<script languge="javascript" type="text/javascript">
   $(function(){ // added
       $('.jdelete').click(function(){
	      var id = $(this).attr("id");
		  
          //alert("Are you sure you want to delete?");
          if(window.confirm("Are you sure you want to delete?"))
		  {
			  $.ajax({
				  type: "POST",
				  url: "<?php echo $this->config->item('base_url')?>/successjournal/postdel",
				  data: "id="+id,
				  success: function(html){
				  // $("#journal_entry_id"+id).hide('slow');
					
				  }
			  });
			   $("#journal_entry_id"+id).hide('slow');
		  }

         return false
       });
  }); // added
</script>--!>

<?php  //echo $this->config->item('base_url'); ?>
<!--<div id="show"></div>-->
<div class="add-journal">
    <div class="s-border-wrapper">
        <div class="s-common-title">
            <h2>
               <div class="add-journal-heading">Recent Posts</div>
               <div class="recent-post-calender">
	
	<a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-calc.gif" alt="Calender" /></a>
			  </div>
              <div class="clear">&nbsp;</div>
            </h2>
         </div>
		 
		<div class="recent-post-holder" id="recent-post-holder">
                                 	

      </div>  
	  
    </div>
</div>