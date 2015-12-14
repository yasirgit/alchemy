<?php
$food_id=$foods['food_id'];
$allservings=json_encode($foods['servings'][0]['serving']);
?>
<div style="float:left;">
<table id="getQuantity_table">
<input type="hidden" id="food_id" value="<?=$foods['food_id']?>" />
	<tbody>		
		<tr>
			<td width="70">Item: </td>
			<td id="name"><?=$foods['food_name']?></td>
		</tr>		
		<!--
		<tr>
			<td>Description: </td>
			<td><input id="entryname" value="" style="width:280px;" type="text" /></td>
		</tr> -->
		<tr>
			<td>Quantity: </td>
			<td>
				<input id="qty" value="1" onkeyup="portionchnage(document.getElementById('portionid').value,this.value,'<?php echo $food_id;?>');" style="padding-top:1px; height:14px; width:30px; font-size:8pt; vertical-align:middle;" type="text" />
				<select id="portionid" allservings='<?php echo base64_encode($allservings);?>' onchange="portionchnage(this.value,document.getElementById('qty').value,'<?php echo $food_id;?>');" autocomplete="off" style="height:20px; padding-bottom:0px; vertical-align:middle;">
					<?php
					foreach ($foods["servings"][0]["serving"] AS $serving)
					{
						$nutrition = $serving['serving_id']."~".$serving["calories"]."~".$serving["carbohydrate"]."~".$serving["protein"]."~".$serving["fat"];												
						?><option value="<?=$nutrition?>"><?=$serving['measurement_description']?></option><?php						
					}
					?>
				</select>
			</td>
		</tr>
		<?php
		if ($foods['type'] == "add")
		{
			?>
			<tr id="add_quantity">
				<td colspan="2">
					<input type="button" id="add" value="Add" /> or <input type="button" id="cancel" value="Cancel" />
				</td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr id="edit_quantity">
				<td colspan="2">
					<input type="button" id="edit" value="Edit" /> or <input type="button" id="cancel" value="Cancel" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<script>
if($('#qty_'+<?php echo $food_id;?>+' span').text().length>=1)	
portionchnage('0',$('#qty_'+<?php echo $food_id;?>+' span').text(),'<?php echo $food_id;?>');
else
portionchnage('0','1','<?php echo $food_id;?>');
</script>
<!--Circle Chart Area-->
<div id="nutritionchart" style="float:right;width:207px;text-align:left;">
	<img src="htdocs/images/ajax-loader.gif" alt="Circle chart">
</div>
<div style="clear:both;"></div>
<!--/Circle Chart Area-->
<?php
?>