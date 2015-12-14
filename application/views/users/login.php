<?$CI =& get_instance();?>
<div><h3>Login</h3></div>
<div><?if(!empty($error)) { echo $error;} ?></div>
<?php echo validation_errors(); ?>
<div>
	<form method="post" action="login">
		Email:<br />
		<input type="text" name="email" id="email" value="<?=$CI->input->post('email');?>" /><br/>
		Password:<br/>
		<input type="password" name="password" id="password" /><br/>
		<button class="sexybutton sexyorange" type="submit">
			<span><span><span class="lock">Login</span></span></span>
		</button>
	</form>
</div>
