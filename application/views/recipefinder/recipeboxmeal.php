<div class="schedule-block recipe-search-box schedule-block-update">
	<?php
	/*
		echo "<pre>";
			//print_r($result);
			//print_r($journal_item);
		echo "</pre>";
	*/
	for($i=0;$i<count($result);$i++)
	{		
		if(($i%2)==0)
		$class=' odd';
		else
		$class="";
	?>
		<div class="schedule-block-area">
			<div class="schedule-box<?php echo $class;?>">
				<div class="holder">
					<div class="image-box">										
											<?php if(isset($journal_image[$i][0]->name)&&strlen($journal_image[$i][0]->name)>0): ?>
													<img src="uploads/<?php echo $journal_image[$i][0]->name; ?>" alt="" width="62" height="62" />
											<?php else: ?>
												<img src="htdocs/images/62x62.jpg" alt="" width="62" height="62" />
											<?php endif; ?>										
					</div>
					<div class="info-box">
						<h3 class="heding-info-box">
							<?php echo stripslashes($result[$i]->name);?>
						</h3>
						<div class="text-box">
							<?php
							for($j=0;$j<count($journal_item[$i]);$j++)
							{
							?>
							<p><?php echo stripslashes($journal_item[$i][$j]->entryname)."(".$journal_item[$i][$j]->qty."-".stripslashes($journal_item[$i][$j]->serving).")";?></p>
							<?php
							}
							?>
						</div>
						<ul class="user-access-link">
							<li><a class="add-eating" href="javascript:void(0);" ujID="<?php echo $result[$i]->ujID; ?>">Add to Eating Journal</a></li>							
						</ul>
					</div>															
				</div>
			</div>
		</div>
	<?php
	}
	?>		
</div>
<div class="container">
	<div class="paging-holder2" style="float:right;">
		<?php 
		for($i=1;$i<=$total_page;$i++)
		{
		  if($i==$current_page)
		  echo "<span style='font-size:15px;'><b>".$i."</b></span> ";
		  else		  
		  echo "<span class='meals_button' p='$i' style='cursor:pointer;font-size:15px;'><u>".$i."</u></span> ";
		}
		?>
	</div>
</div>