<?$CI =& get_instance();?>
<div><h3>Register</h3></div>
<form method="post" action="register" autocomplete="off">
	<div style="width:800px;">
		<div style="float:left;">
			<span style="font-weight:bold;">Username:</span><br />
			<input type="text" name="username" id="username" value="<?=$CI->input->post('username');?>" /><br />
			<span style="font-weight:bold;">Email:</span><br />
			<input type="text" name="email" id="email" value="<?=$CI->input->post('email');?>" /><br />
			<span style="font-weight:bold;">Password:</span><br/>
			<input type="password" name="password" id="password" /><br/>
			<span style="font-weight:bold;">First Name:</span><br/>
			<input type="text" name="first_name" id="first_name" /><br/>
			<span style="font-weight:bold;">Last Name:</span><br/>
			<input type="text" name="last_name" id="last_name" /><br/>
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
