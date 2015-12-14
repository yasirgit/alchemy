<?$CI =& get_instance();?>
<div><h3>Register</h3></div>
<form method="post" action="access/signup/" autocomplete="off">
	<div style="width:800px;">
		<div style="float:left;">
			<span style="font-weight:bold;">Email:</span><br />
			<input type="text" name="email" id="email" value="<?=$CI->input->post('email');?>" /><br /><br />
		</div>

		<div style="clear:both;">
			<button class="sexybutton sexyorange" type="submit">
				<span><span><span class="lock">Register</span></span></span>
			</button>
		</div>
	</div>
</form>
<div style="font-weight:bold;color:#CC0000;">
	<?php
	if(!empty($error)) { echo "<br />".$error."<br />"; }
	echo validation_errors();
	?>
</div>
