<!--<tr class="<?php //$cellColor?>" rID="<?php //$rID?>" alt="double click to view" title="double click to view">
	<td><?php //$rID?></td>
	<td><?php //$title?></td>
	<td><?php //$createdOn?></td>
	<td style="border-right:1px solid #211f1f;">
		<a href="javascript:void(0);" class="delete" rID="<?php //$rID?>"><img src="htdocs/images/dialog-close.png" width="16" height="13" border="0" alt="delete <?php //$title?>" title="delete <?php //$title?>"></a>
	</td>
</tr>
-->

<div class="schedule-block-area">
	<div class="schedule-box <?php echo $cellColor; ?>">
		<div class="holder">
			<div class="image-box">
				<?php
				//print_r($imgages);
				//echo count($imgages);
				$defimg_properties = array(
				'src' => 'htdocs/images/62x62.jpg',
				'alt' => 'Image',
				'width' => '62',
				'height' => '62'
				);
				if(count($imgages)>0){
					if($imgages->thumb_img_name != ''){	
						$image_properties = array(
						'src' => 'htdocs/images/recipes/thumb/'.$imgages->thumb_img_name,
						'alt' => 'Image',
						'width' => '62',
						'height' => '62'
						);
						echo img($image_properties);
					}else{
						echo img($defimg_properties);
					}	
				}else{
					echo img($defimg_properties);
				}		
				?>
			</div>
			<div class="info-box">
				<h3 class="heding-info-box heding-info-box-like">
					<a href="recipefinder/recipe_info/<?=$rID?>"><?=$title?></a>
				</h3>
				<div class="text-box">
                                    <p><?php echo stripslashes($desc);?></p>
					<!--<strong class="title-recipe">by member: <a href="#">francescabella10</a></strong> -->
				</div>
				<ul class="user-access-link">
					<li><a href="users/recipe_finder/<?=$rID?>" class="note-access">Edit</a></li>
					<li><a href="javascript:void(0);" rID="<?=$rID?>" class="delete-access">Delete</a></li>
					<!--<li><a href="#" class="print-access">Print</a></li> -->
				</ul>
			</div>
			<div class="icon-holder">
				<ul>
					<?php if($direction['isProtein'] == 1) { ?>
					<li <?php if($direction['proteinStatus'] != 'solid'){ ?> class="protien" <?php } else { ?> class="protien-solid" <?php } ?> ><a href="javascript:void()" class="betterTip">PROTEIN</a></li>
					<?php } 
					if($direction['isSlowcarb'] == 1) {
					?>
					<li <?php if($direction['slowcarbStatus'] != 'solid'){ ?> class="slow-carb" <?php } else { ?> class="slow-carb-solid" <?php } ?> ><a href="javascript:void()">slow carb</a></li>
					<?php } 
					if($direction['isFirstcarb'] == 1) {
					?>
					<li <?php if($direction['firstcarbStatus'] != 'solid'){ ?> class="fast-carb" <?php } else { ?> class="fast-carb-solid" <?php } ?>><a href="javascript:void()">FAST carb</a></li>
					<?php
					}
					?>
				</ul>
			</div>
			<div class="icon-box-right">
				<?php
				if(count($ratings>0)){
					foreach($ratings as $rate)
					{
						$avg = 0;
						if($rate->totusers > 0){
						$avg = round($rate->totRat/$rate->totusers);
						}
						?>
							<img src="htdocs/images/img-stars<?php echo $avg; ?>.gif" alt="" /><br />
							<span>(<?php echo $rate->totusers; ?> people reviewed)</span>
						<?php
					}
				} else {	
				?>
					<img src="htdocs/images/img-stars0.gif" alt="" /><br />
					<span>(0 people reviewed)</span>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>