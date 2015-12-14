
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
		<div class="recent-post-holder">
                                                    	
<?php
    $uid=$this->session->userdata('id');
    if (count($jpost)){
    foreach ($jpost as $key => $list){
?>
       <div class="recent-post-rptr" id="journal_entry_id<?php echo $list['id']; ?>">
            <div class="recent-post-title">
                <div class="recent-blog-heading">
                    <h3><a href="#"><?php echo $list['title']; ?></a> - <?php echo $list['showdate']; ?>th</h3>
                    <ul class="post-manup-access">
                        <li class="editlink"><?php if($list['uid']==$uid){ ?><a href="successjournal/jedit/<?php echo $list['id']; ?>"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a><?php } ?>
						</li>
						
            <!--            <li><?php if($list['uid']==$uid){ ?><a class="delete" href="successjournal/postdel/<?php echo $list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?>
						</li>-->
						  <li id=""><?php if($list['uid']==$uid){ ?><a href="#" id="<?php echo $list['id']; ?>" class="jdelete" ><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?>
						</li>
                     </ul>
                 </div>
                 <p><?php echo $list['details']; ?></p>
                 <div class="post-info-line">
                    <strong>Grade: A-  | BMI: 10 | Energy: <?php echo $list['energylevel']; ?> | Hunger: <?php echo $list['hungerlevel']; ?> | Esteem: <?php echo $list['esteemlevel']; ?> | Sleep: <?php echo $list['sleeplevel']; ?></strong>
                                                                    <a href="#" class="recent-post-readnore">Read More></a>
                 </div>
              </div>
         </div>


	<?php }} ?>       


                                                     
        <div class="older-post-link"><a href="#">Older Posts&gt;</a></div>
      </div>  
    </div>
</div>