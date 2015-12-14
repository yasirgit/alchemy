<div class="login">
    <div class="page_head">Login</div>
    <div class="error"><?if(!empty($error)) { echo $error;} ?>    <?php echo validation_errors(); ?></div>
 
    <form method="post" action="adminlogin">
		<div class="loginArea">	   	
			<div>User Name <span class="required">*</span></div>
			<div><input type="text" class="input" maxlength="32" size="20" value="" id="username" name="username" style="width: 150px;" dir="ltr"></div>
			<div>Password <span class="required">*</span></div>
			<div><input type="password" class="input" maxlength="32" size="20" value="" id="password" name="password" style="width: 150px;" dir="ltr"></div>
			<div>&nbsp;</div>
			<div class="buttonDiv"><input type="submit" value="Login" class="submit"></div>
			<!--<div class="default"><br><a href="index.php?S=0&amp;C=login&amp;M=forgot">Forgot your password?</a></div>-->
		</div>
	 </form>
</div>	

