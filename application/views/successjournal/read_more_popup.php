<?php $uid=$this->session->userdata('id');
 //print_r($thisPost);
  
    if (count($thisPost)){
    foreach ($thisPost as $key => $list){    
?>
  <div class="popup-middle">
    <p class="heading blog-title"><?php echo $list->title; ?><span> -&nbsp;&nbsp;<?php echo $list->showdate; ?></span></p>
      <div class="recent-post-rptr">
        <div class="recent-post-title" style="overflow-y: auto; height:170px; overflow-x:hidden">           
            <p><?php echo $list->details; ?></p>

            <div class="post-info-line">
                <strong>Grade: A-  | BMI: 10 | Energy: <?php echo $list->energylevel; ?> | Hunger: <?php echo $list->hungerlevel; ?> | Esteem: <?php echo $list->esteemlevel; ?> | Sleep: <?php echo $list->sleeplevel; ?></strong>
            </div>
        </div>
      </div>  
      
  <form>    
    <fieldset class="sub-btn btn">
   		                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif"  />
                    <input class="close2"  id="usave" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="ReadCall" /> 
    </fieldset>
 </form>     
  </div>
<? } }

?>