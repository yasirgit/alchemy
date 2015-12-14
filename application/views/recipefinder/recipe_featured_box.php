<div class="sliderItemolder" style="position:relative;">
<?php foreach($recipes['fat_loss'] as $ind=>$rval){
 if($ind==0)$style="left:0;";
 elseif($ind==1)$style="left:387px;";
 elseif($ind==2)$style="left:774px;";
 elseif($ind==3)$style="left:1161px;";
 elseif($ind==4)$style="left:1548px;";
// elseif($ind==5)$style="left:1935px;";
 
 $img = $rval->imgages;
 $burl = base_url()."recipefinder/recipe_info/".$rval->rID;
 $rec_url = '&original_referer='.$burl.'&url='.$burl;
 
 $fburl = urlencode("http://bglobal.ripemedia.com/fb_share.php?rid=".$rval->rID."&title=".$rval->title."&description=".$rval->desc);
?>
<div class="block-in-content" style="<?echo $style;?>">
  <div class="image-place">
  		<ul>
    		<li><a href="recipefinder/recipe_info/<?echo $rval->rID;?>">
			<img src="<?if(!empty($img->image_name)) echo 'htdocs/images/recipes/'.$img->image_name; else echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="166" height="166" />
			</a></li>
  		</ul>
  	  <a class="sexybutton sexyorange" href="recipefinder/my_recipebox/<? echo $rval->rID;?>"><span><span>Add to my recipe box</span></span></a>
	  
	  <a href="#" class="share-this-link" style="margin-left:10px;float:left;padding: 10px 0 0 20px;">SHARE THIS RECIPE</a>	
	  <div class="share-tooltip hidediv" id="trackid">
		<div class="share-tooltip-in">
			<div class="share-tol-content">
				<div class="share-pic-option">SHARE THIS RECIPE</div>
				<p>Share this meal with family and friends:</p>
				<div class="share-icon-links">
					<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $fburl; ?>" title="Share this recipe on Facebook" class="share-facebook">Facebook</a>
					<a target="_blank" href="http://twitter.com/share?text=Check out this recipe on Alchemy!<?php echo $rec_url; ?>" class="share-twitter">Twitter</a>
				</div>
			</div>
		</div>
	  </div>
	  
  </div>
  <div class="block-in-text">
  		<h3><a href="recipefinder/recipe_info/<?echo $rval->rID;?>"> <?echo $rval->title;?> </a> </h3>
  		<div class="stars">
		<?php
			//print_r($rval->ratings);
			$ratings = $rval->ratings;
			?>
			<?php
			if(count($ratings>0)){
				foreach($ratings as $rate)
				{
					$avg = 0;
					if($rate->totusers > 0){
					$avg = round($rate->totRat/$rate->totusers);
					}
					?>
						<a href="recipefinder/recipe_info/<? echo $rval->rID;?>">
						<img src="htdocs/images/img-stars<?php echo $avg; ?>.gif" alt="" />
						</a>
						<br />
						<span>(<?php echo $rate->totusers; ?> people reviewed)</span>
					<?php
				}
			} else {	
			?>
				<a href="recipefinder/recipe_info/<? echo $rval->rID;?>">
				<img src="htdocs/images/img-stars0.gif" alt="" />
				</a>
				<br />
				<span>(0 people reviewed)</span>
			<?php
			}
			?>
		</div>
                <p><?php echo stripslashes($rval->desc);?></p>
  </div>
</div>
													   
<?}?>
</div>
<div class="paging">
	<ul>
	   <?php foreach($recipes['fat_loss'] as $ind=>$rval){
	   $pos=$ind+1;
	   ?>
        <li class="circle<?php echo $pos;?>"><a cur="<?php echo $pos;?>" href="#" class="eoa_slide<?php echo $pos;?>" ><?php echo $pos;?></a></li>
        <?}?>
	</ul>
</div>