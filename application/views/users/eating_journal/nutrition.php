<div class="circle-chart-area" style="width: 207px;">
	<div class="circle-chart-content">
		<div class="nutrition-facts">
			<h4 class="nutrition-head">Nutrition Facts</h4>
			<p>Serving Size <?php echo $qty;?> <?php echo $serving->measurement_description;?></p>
			<div class="nutrition-divider-bar">&nbsp;</div>
			<p><small>Amount Per Serving</small></p>
			<p><span class="black-label">Calories</span> <?php echo ($serving->calories)*$qty;?>  <span class="black-label">Calories from Fat</span> <?php echo isset($serving->fat)?9*(($serving->fat)*$qty):"";?></p>
			<div class="nutrition-divider-bar divider-gap">&nbsp;</div>
			<p><span class="black-label">Total Fat</span> <?php echo isset($serving->fat)?($serving->fat)*$qty:"";?>g</p>
			<p>&nbsp;&nbsp;Saturated Fat <?php echo isset($serving->saturated_fat)?($serving->saturated_fat)*$qty:"";?>g</p>
			<p>&nbsp;&nbsp;Polyunsaturated Fat <?php echo isset($serving->polyunsaturated_fat)?($serving->polyunsaturated_fat)*$qty:"";?>g </p>
			<p>&nbsp;&nbsp;Monounsaturated Fat <?php echo isset($serving->monounsaturated_fat)?($serving->monounsaturated_fat)*$qty:"";?>g</p>
			<p><span class="black-label">Cholesterol</span> <?php echo isset($serving->cholesterol)?($serving->cholesterol)*$qty:"";?>mg</p>
			<p><span class="black-label">Sodium</span> <?php echo isset($serving->sodium)?($serving->sodium)*$qty:"";?>mg</p>
			<p><span class="black-label">Potassium</span> <?php echo isset($serving->potassium)?($serving->potassium)*$qty:"";?>mg</p>
			<p><span class="black-label">Total Carbohydrates</span> <?php echo isset($serving->carbohydrate)?($serving->carbohydrate)*$qty:"";?>g</p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dietary Fiber <?php echo isset($serving->fiber)?($serving->fiber)*$qty:"";?>g</p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sugars <?php echo isset($serving->sugar)?($serving->sugar)*$qty:"";?>g</p> 
			<p><span class="black-label">Protein</span> <?php echo isset($serving->protein)?($serving->protein)*$qty:"";?>g</p>
			<div class="nutrition-divider-bar">&nbsp;</div>
			<div class="vitamin-fifty-wrap"><span class="vitamin-fifty">Vitamin A <?php echo isset($serving->vitamin_a)?$serving->vitamin_a:"";?>%</span><span class="vitamin-fifty">* Vitamin C <?php echo isset($serving->vitamin_c)?$serving->vitamin_c:"";?>%</span></div>
			<div class="vitamin-fifty-wrap"><span class="vitamin-fifty">Calcium <?php echo isset($serving->calcium)?$serving->calcium:"";?>%</span><span class="vitamin-fifty">* Iron <?php echo isset($serving->iron)?$serving->iron:"";?>%</span></div>
		</div>
		<div class="nutrition-facts chart-content-bottom">
			<div class="circle-chart-indicator">
			<h4>Calorie Breakdown:</h4>			
			<ul class="circle-char-indlist">
				<li class="carbohydred-ind">Carbohydrate (<?php echo $pCurb;?>%)</li>
				<li class="fat-ind">Fat (<?php echo $pFat;?>%)</li>
				<li class="protien-ind">Protein (<?php echo $pProt;?>%)</li>
			</ul>
		</div>
			<div class="circle-chart-place" style="width:50px;overflow:hidden;padding:20px 0 0 0;"><?php echo $pieimg;?></div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
	<div class="circle-chart-bottom">&nbsp;</div>
</div>
<div class="clear">&nbsp;</div>