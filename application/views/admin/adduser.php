<?$CI =& get_instance();?>
<div class="register">
	<div class="page_head">Add Admin User</div>
            <?php echo validation_errors(); ?>
            <form method="post" action="adduser">
              <div class="registerBox">
		<div class="frmLebel">First Name  <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $CI->input->post('first_name');?>" id="first_name" name="first_name"></div>
		<div class="frmLebel">Last Name <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $CI->input->post('last_name');?>" id="last_name" name="last_name"></div>
                <div class="frmLebel">Email <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $CI->input->post('email');?>" id="email" name="email"></div>
		<div class="frmLebel">User Name <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $CI->input->post('username');?>" id="username" name="username"></div>
		<div class="frmLebel">Password <span class="required">*</span></div>
                <div class="frmFiled"><input type="password" class="input"  value="<?php echo $CI->input->post('password');?>" id="password" name="password"></div>
                <div class="frmLebel">Confirm Password</div>
		<div class="frmFiled"><input type="password" class="input"  value="<?php echo $CI->input->post('conpassword');?>" id="conpassword" name="conpassword"></div>
		<div class="frmLebel">User Group</div>
		<div class="frmFiled">
                    <select name="group_id">
                        <option value="1" selected="selected">Super User</option>
                        <option value="2">Regular Admin User</option>
                    </select>
		</div>
		<div class="frmLebel">Active</div>
		<div class="frmFiled">
			<input type="radio" name="active" value="1" checked="checked"> Active
			<input type="radio" name="active" value="0"> Inactive Now
		</div>
		<div class="frmLebel">&nbsp;</div>
		<div class="buttonDiv"><input type="submit" value="Submit" class="submit"></div>
	</div>
        </form>
</div>	
