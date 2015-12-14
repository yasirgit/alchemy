<div class="popup-plan-goal" id="popup_gview">
  <div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
    <div class="top-mid">
      <h2>Upload Picture</h2>
    </div>
    <div class="top-right"> </div>
  </div>
  <div class="popup-middle">
    <h2 class="heading">Before Picture</h2>
    <div class="popup-content">
	<?php 
	    $k=5;
	   if(count($show_gallery)>0)
	   {
	      $k = 5-count($show_gallery);
		  foreach($show_gallery as $show_before)
		  { 
		      $date = $show_before['created_date'];
			  $split = explode("-", $date);

			  
		    if($split[1]==01){ 
			   $mnth="Jan";
			}
			elseif($split[1]==02)
			{
			   $mnth="Feb";
			}
			elseif($split[1]==03)
			{
			   $mnth="Mar";
			}
			elseif($split[1]==04)
			{
			   $mnth="Apr";
			}
			elseif($split[1]==05)
			{
			  $mnth="May";
			}
			
			elseif($split[1]==06)
			{
			   $mnth="June";
			}
			elseif($split[1]==07)
			{
			   $mnth="July";
			}
			elseif($split[1]==08)
			{
			  $mnth="Aug";
			}
			elseif($split[1]==09)
			{
			   $mnth="Sep";
			}
			elseif($split[1]==10)
			{
			   $mnth="Oct";
			}
			elseif($split[1]==11)
			{
			   $mnth="Nov";
			}
			elseif($split[1]==12)
			{
			   $mnth="Dec";
			}
			 $currentDay=date("M d, Y");
			 //echo $spilt[0];
	?>
       <div class="image-uploaded">
    	<div class="image-wrap">
        	<div class="image-wrap-top">
            </div>
            <div class="image-wrap-middle">
       	       <a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/gallery/before_img/<?php echo $show_before['before_pic']; ?>" width="91" height="139"  alt="" /></a>
            </div>
            <div class="image-wrap-bottom">
            </div>
        </div>
         <p><?php echo $mnth." ".$split[2].",". $split[0]; ?></p>
    </div> 
	<?php //}} ?>

	
<? }}
	   for($i=1;$i<=$k;$i++){?>
       <div class="image-uploaded">
    	<div class="image-wrap">
        	<div class="image-wrap-top">
            </div>
            <div class="image-wrap-middle">
       	       <a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/gallery-thumb-03.jpg" width="91" height="139"  alt="" /></a>
            </div>
            <div class="image-wrap-bottom">
            </div>
        </div>
        
        <p><?php echo $currentDay=date("M d, Y"); ?></p>
    </div>
	<?php } ?>
	<br class="clear" />
    </div>
    
     <h2 class="heading">After Pictures</h2>
    <div class="popup-content">
	<?php 
	    $k=5;
	   if(count($show_after_gallery)>0)
	   { 
	        $k = 5-count($show_after_gallery);
		  foreach($show_after_gallery as $show_after)
		  {  
		     
			  $date = $show_after['created_date'];
			  $split = explode("-", $date);

			  
		    if($split[1]==01){ 
			   $mnth="Jan";
			}
			elseif($split[1]==02)
			{
			   $mnth="Feb";
			}
			elseif($split[1]==03)
			{
			   $mnth="Mar";
			}
			elseif($split[1]==04)
			{
			   $mnth="Apr";
			}
			elseif($split[1]==05)
			{
			  $mnth="May";
			}
			
			elseif($split[1]==06)
			{
			   $mnth="June";
			}
			elseif($split[1]==07)
			{
			   $mnth="July";
			}
			elseif($split[1]==08)
			{
			  $mnth="Aug";
			}
			elseif($split[1]==09)
			{
			   $mnth="Sep";
			}
			elseif($split[1]==10)
			{
			   $mnth="Oct";
			}
			elseif($split[1]==11)
			{
			   $mnth="Nov";
			}
			elseif($split[1]==12)
			{
			   $mnth="Dec";
			}
       ?>  
       <div class="image-uploaded">
    	<div class="image-wrap">
        	<div class="image-wrap-top">
            </div>
            <div class="image-wrap-middle">
       	       <a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/gallery/after_img/<?php echo $show_after['after_pic']; ?>" width="91" height="139"  alt="" /></a>
            </div>
            <div class="image-wrap-bottom">
            </div>
        </div>
         <p><?php echo $mnth." ".$split[2].",". $split[0]; ?></p>
    </div>
	 

	<?
	
	} }
	 //echo "K=".$k;
	   for($i=1;$i<=$k;$i++){?>
    <div class="image-uploaded">
    	<div class="image-wrap">
        	<div class="image-wrap-top">
            </div>
            <div class="image-wrap-middle">
       	       <a href=""><img src="<?=$this->config->item('base_url')?>/htdocs/images/gallery-thumb-03.jpg" width="91" height="139"  alt="" /></a>
            </div>
            <div class="image-wrap-bottom">
            </div>
             <p><?php echo $currentDay=date("M d, Y"); ?></p>
        </div>
    </div>
	<?  } ?>
	<br class="clear" />
    </div>
  </div>
  <div class="bottom">
    <div class="bottom-mid"> </div>
    <div class="bottom-right"> </div>
  </div>
</div>

<div id="bgGalViewPopup"></div>