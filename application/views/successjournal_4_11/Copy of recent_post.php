<div class="add-journal">
                                                <div class="s-border-wrapper">
                                                    <div class="s-common-title">
                                                        <h2>
                                                            <div class="add-journal-heading">Recent Posts</div>
                                                            <div class="recent-post-calender"><a href="#"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-calc.gif" alt="Calender" /></a></div>
                                                            <div class="clear">&nbsp;</div>
                                                        </h2>
                                                    </div>
													<div class="recent-post-holder">
                                                    	
<?php
    $uid=$this->session->userdata('id');
    if (count($jpost)){
    foreach ($jpost as $key => $list){
?>
                                                    <div class="recent-post-rptr">
                                                        	<div class="recent-post-title">
                                                            	<div class="recent-blog-heading">
                                                                    <h3><a href="#"><?php echo $list['title']; ?></a> - <?php echo $list['showdate']; ?>th</h3>
                                                                    <ul class="post-manup-access">
                                                                        <li class="editlink"><?php if($list['uid']==$uid){ ?><a href="successjournal/edit/<?php echo $list['id']; ?>"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-edit-icon.gif" alt="Edit" /></a><?php } ?></li>
                                                                        <li><?php if($list['uid']==$uid){ ?><a class="delete" href="successjournal/postdel/<?php echo $list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/recent-post-delete-icon.gif" alt="Delete" /></a><?php } ?></li>
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
    
    <script languge="javascript" type="text/javascript">
/*   $(function(){ // added
    $('.delete').click(function(){
    $.ajax({
       type: "POST",
       url: "successjournal/postdel/<?php echo $list['id']; ?>",
       data: "id="+$(this).prev().text(),
       success: function(html){
           $("#show").html(html);
           }
    });

    return false
    });
    });*/ // added
    </script>
                                                      <!--<div class="recent-post-rptr">
                                                        	<div class="recent-post-title">
                                                            	<div class="recent-blog-heading">
                                                                    <h3><a href="#">Blog Post Title</a> - April 29th</h3>
                                                                    <ul class="post-manup-access">
                                                                        <li><a href="#"></a></li>
                                                                        <li><a href="#"></a></li>
                                                                    </ul>
                                                                </div>
                                                                <p>It used to be that when I sat around the house I sat "around the house" (if you know what I mean). Maecenas ac enim sit amet lacus semper tincidunt. Praesent iaculis, magna a blandit suscipit, leo tellus sollicitudin arcu, ut feugiat eros arcu sed risus. Cras felis arcu, lacinia lacinia sodales nec, pretium non nisi.</p>
                                                                <div class="post-info-line">
                                                                	<strong>Grade: A-  | BMI: 10 | Energy: 7 | Hunger: 9 | Esteem: 5 | Sleep: 7</strong>
                                                                    <a href="#" class="recent-post-readnore">Read More></a>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                     
  <div class="older-post-link"><a href="#">Older Posts&gt;</a></div>
                                                    </div>  
                                                </div>
                                            </div>