<div class="sliderItemolder" style="position:relative;">
<?foreach($recipes['fat_loss'] as $ind=>$rval){
 if($ind==0)$style="left:0;";
 elseif($ind==1)$style="left:387px;";
 elseif($ind==2)$style="left:774px;";
 elseif($ind==3)$style="left:1161px;";
 elseif($ind==4)$style="left:1548px;";
 elseif($ind==5)$style="left:1935px;";
?>
<div class="block-in-content" style="<?echo $style;?>">
  <div class="image-place">
  		<ul>
    		<li><a href="recipefinder/recipe_info/<?echo $rval->rID;?>"><img src="<?echo "http://fatsecret.com/static/images/box/recipe_default.jpg";?>" alt="" width="166" height="166" /></a></li>
  		</ul>
  	  <a class="sexybutton sexyorange" href="recipefinder/my_recipebox/<?echo $rval->rID;?>"><span><span>Add to my recipe box</span></span></a>
  </div>
  <div class="block-in-text">
  		<h3><?echo $rval->title;?></h3>
  		<div class="stars"><a href="recipefinder/recipe_info/<?echo $rval->rID;?>"><img src="htdocs/images/img-star-4l.gif" alt="" width="98" height="21" /></a></div>
  		<p><?echo $rval->desc;?></p>
  </div>
</div>
													   
<?}?>
</div>
<div class="paging">
	<ul>
				<?foreach($recipes['fat_loss'] as $ind=>$rval){$pos=$ind+1;?>
        <li class="circle<?echo $pos;?>"><a cur="<?echo $pos;?>" href="#" class="eoa_slide<?echo $pos;?>" ><?echo $pos;?></a></li>
        <?}?>
										
	</ul>
</div>
												
