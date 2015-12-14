<link media="all" rel="stylesheet" href="application/views/_assets/css/searchResults.css" type="text/css" />

<div class="atchemy-banner"><img src="htdocs/images/reciep-finder-banner.jpg" alt="Alchemy banner" /></div>
<div class="how-do-use"><a class="about-page" href="#">How do I use this page</a><a href="#" class="return-to">&lt; Return to Recipe Finder</a></div>

<!--<ul class="tools">
	<li><a class="save" href="javascript:void(0);">SAVE AS TEMPLATE</a></li>
	<li><a class="print" href="javascript:void(0);">PRINT</a></li>
</ul>-->

<div class="search-result-up">
	<h2>Submitted Recipes <span>(<?php echo $totrows; ?>)</span></h2>
	<div class="paging-holder">
        <?php if ($paginator['current'] != 0) { ?>
			<a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['prevPage']?>" class="link-prev">&lt;</a>
		<?php } ?>
		<ul>
			<li><span>
				<?php foreach ($paginator['pages'] AS $k => $i) { ?>
					<?php if ($i == $paginator['current']) { ?>
						  <?=$k?>
					<?php }  ?>
				<?php } ?>
			</span></li>
			<li><strong>of</strong></li>
			<li><a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$lastid?>">
            <?php echo $number_pages;?></a></li>
		</ul>
        <?php if ($paginator['nextPage'] != 0) { ?>
			<a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['nextPage']?>" class="link-next"> &gt;</a>
		<?php } ?>
	</div>
</div>

<div class="links-block">
	<a class="journal" href="users/recipe_finder">My Recipe Builder</a>
	<a class="add" href="recipes/listAll">Submitted Recipes</a>
</div>
<div class="schedule-block">
	<!--<table>
		<tr>
			<td class="leftCell">
				<div class="leftCellContent">
					<table cellspacing="0">
						<tr>
							<td>
							<form action="recipes/listAll/init:yes" method="POST">
								<table border="0" cellpadding="0" cellspacing="2">
									<tr>
										<th>Title</th>
										<th></th>
									</tr>
									<tr>
										<td><input type="text" name="S_title" size="30" value="" /></td>
										<td><input class="button" type="submit" name="search" value="Search"></td>
									</tr>
								</table>
								</form>
							</td>
						</tr>
						<tr><td><?php //$this->load->view("paginator",$paginator); ?></td></tr>
						<tr>
							<td align="left">
								<table class="searchResult" cellspacing="0" style="width:400px;">
									<thead>
									<tr>
										<th style="width:50px;">ID</th>
										<th style="width:150px;">TITLE</th>
										<th style="width:150px;">CREATED ON</th>
										<th style="border-right:1px solid #211f1f;">ACTION</th>
									</tr>
									<?php
									/*if ($recipes)
									{
										$bg = false;
										foreach ($recipes AS $recipe)
										{
											if ($bg!==true)	{ $recipe->cellColor = "trCell2"; $bg=true; }
											else			{ $recipe->cellColor = "trCell1"; $bg=false; }
											$this->load->view('users/recipe_finder/panel', $recipe);
					
										}
									}
									else
									{ */
										?><tr class="trCell1"><td colspan="4">No recipes found</td></tr><?php
									//}
									?>
								</table>
							</td>
						</tr>
						<tr><td><?php //$this->load->view("paginator",$paginator); ?></td></tr>
					</table>
				</div>
			</td>
		</tr>
	</table> -->
	
	<div class="schedule-block recipe-search-box schedule-block-update">
		<?php
		if ($recipes)
		{
			$bg = false;
			foreach ($recipes AS $recipe)
			{
				if ($bg!==true)	
				{ 
					$recipe->cellColor = "odd"; 
					$bg=true; 
				}else{
					$recipe->cellColor = ""; 
					$bg=false; 
				}
				$this->load->view('users/recipe_finder/panel', $recipe);
			}
		}
		else
		{
			?><div>No recipes found</div><?php
		}
		?>
		
	</div>	
	
	<div class="container">
		<div class="paging-holder">
        <?php if ($paginator['current'] != 0) { ?>
			<a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['prevPage']?>" class="link-prev">&lt;</a>
		<?php } ?>
		<ul>
			<li><span>
                        <?php foreach ($paginator['pages'] AS $k => $i) { ?>
                            <?php if ($i == $paginator['current']) { ?>
                                  <?=$k?>
                            <?php }  ?>
                        <?php } ?>
                        </span></li>
			<li><strong>of</strong></li>
			<li><a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$lastid?>">
                        <?php echo $number_pages;?></a></li>
		</ul>
        <?php if ($paginator['nextPage'] != 0) { ?>
			<a href="<?=$paginator['controller']?>/<?=$paginator['method']?>/start:<?=$paginator['nextPage']?>" class="link-next"> &gt;</a>
		<?php } ?>
        </div>
	</div>
</div>
        <div style="position: absolute; bottom: 37px;"><img src="htdocs/images/reciep-finder-footer.jpg" width="608px;" alt="footer image" /></div>
