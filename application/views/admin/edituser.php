<?$CI =& get_instance();?>
<div class="register">
	<div class="page_head">Edit Admin User</div>
        <div></div>
        <div class="error"><?php //if(!empty($error)) { echo $error;} ?> <?php echo validation_errors(); ?></div>
        
        <form method="post" action="">
	<div class="registerBox">
		<div class="frmLebel">First Name <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->first_name;?>" id="first_name" name="first_name"></div>
		<div class="frmLebel">Last Name <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->last_name;?>" id="last_name" name="last_name"></div>
                <div class="frmLebel">Email <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->email;?>" id="email" name="email"></div>
		<div class="frmLebel">User Name <span class="required">*</span></div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->username;?>" id="username" name="username"></div>
		<div class="frmLebel">User Group</div>
		<div class="frmFiled">
                    <select name="group_id">
                        <?php $group=$user[0]->group_id;?>
                        <option value="1" <?php if($group==1) echo 'selected="selected"';?>>Super User</option>
                        <option value="2" <?php if($group==2) echo 'selected="selected"';?>>Regular Admin User</option>
                    </select>
		</div>
		<div class="frmLebel">Active</div>
		<div class="frmFiled">
                        <?php $active=$user[0]->active;?>
			<input type="radio" name="active" <?php if($active==1) echo 'checked="checked"';?>value="1" > Active
			<input type="radio" name="active" <?php if($active==0) echo 'checked="checked"';?> value="0"> Inactive Now
		</div>
		<div class="frmLebel">&nbsp;</div>
		<div class="buttonDiv">
                    <input type="hidden"  value="<?php echo $user[0]->id;?>" id="uId" name="uId">
                    <input type="submit" value="Submit" class="submit">
                </div>
	</div>
        </form>
</div>	
