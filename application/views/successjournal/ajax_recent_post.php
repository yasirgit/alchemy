<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
	
     $(".rp").click(function() {   //alert(1);
	       var  id = $(this).attr("id"); 
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
       	  
		 });              
       return false;
     });  
</script>

<script languge="javascript" type="text/javascript">
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
</script>
<script>
var popupReadView =0 ;
function loadReadMorePopup(){
	//loads popup only if it is disabled
	if(popupReadView==0){
		$("#bgReadMorePopup").css({
			"opacity": "0.7"
		});
		$("#bgReadMorePopup").fadeIn("slow");
		$("#popup_read_more").fadeIn("slow");
		popupReadView = 1;
	}
}


//disable week Popup
function disableReadMorePopup(){
	//disables popup only if it is enabled
	if(popupReadView==1){
		$("#bgReadMorePopup").fadeOut("slow");
		$("#popup_read_more").fadeOut("slow");
		popupReadView = 0;
	}
}



//8 week center popup
function centerReadMorePopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup_read_more").height();
	var popupWidth = $("#popup_read_more").width();
	//centering
	$("#popup_read_more").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":700,
		"left":50

	});
	//only need force for IE6
	
	$("#bgReadMorePopup").css({
		"height": windowHeight
	});
	
	$(".close").click(function(){											 
    	disableReadMorePopup();
		return false;
	});
	
}
$(function(){ 
	$(".recent-post-readnore").click(function(){ 
		

	     var pid = $(this).attr("id"); 
		 $.ajax({
				  type: "POST",
				  url: "<?php echo $this->config->item('base_url')?>/successjournal/readdetails",
				  data: "pid="+pid,
				  success: function(html)
				  {
				  	//alert(html);
				  	$('#vdet').html(html);
				  }
			  });
			
		//centering with css
		
		//load popup
		centerReadMorePopup(); 
		loadReadMorePopup();
		
	});
	  return false;
});	

</script>

<?php $uid=$this->session->userdata('id');
    if (count($jpost)){
    foreach ($jpost as $key => $list){    
?>
       <div class="recent-post-rptr" id="journal_entry_id<?php echo $list->id; ?>">
            <div class="recent-post-title">
                <div class="recent-blog-heading">
                    <h3><a  id="<?php echo $list->id; ?>" href="javascript:void(0);" class="recent-post-readnore"><?php echo $list->title; ?></a> - <?php echo $list->showdate; ?> </h3>
                    <ul class="post-manup-access">
                        <li class="editlink"><?php if($list->uid==$uid){ ?><a href="successjournal/jedit/<?php echo $list->id; ?>"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a><?php } ?>
						</li>
						
            <!--            <li><?php if($list->uid==$uid){ ?><a class="delete" href="successjournal/postdel/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?>
						</li>-->
						  <li id=""><?php if($list->uid==$uid){ ?><a href="#" id="<?php echo $list->id; ?>" class="jdelete" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?>
						</li>
                     </ul>
                 </div>
                 <p><?php $short_desc = $list->details; 
				    echo substr($short_desc, 0, 150); 
				 ?>
				 </p>
                 <div class="post-info-line">
                    <strong>Grade: A-  | BMI: 10 | Energy: <?php echo $list->energylevel; ?> | Hunger: <?php echo $list->hungerlevel; ?> | Esteem: <?php echo $list->esteemlevel; ?> | Sleep: <?php echo $list->sleeplevel; ?></strong>
                        <a id="<?php echo $list->id; ?>" class="recent-post-readnore rp_readmore" href="javascript:void(0);">Read More></a>
                 </div>
              </div>
         </div>
         
             
	<?php }} ?>       
              

                                                     
        <div class="older-post-link"><?php echo $prev ;?>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $next; ?></div>
<div class="popup-ultimate" id="popup_read_more">
	  <div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png"  width="28" height="28" alt="close" /></a>
		<div class="top-mid">
		  <h2>Recent Post</h2>
		</div>
		<div class="top-right"> </div>
	  </div>
	 	<div id="vdet"></div>
	
	  <div class="bottom">
		<div class="bottom-mid"> </div>
		<div class="bottom-right"> </div>
	  </div>
</div>
<div id="bgReadMorePopup"></div>