<?$CI =& get_instance();?>
<div class="register">
	<div class="page_head">Edit <?php echo $user[0]->first_name;?> <?php echo $user[0]->last_name;?> Information</div>
        <div></div>
        <div><?php //if(!empty($error)) { echo $error;} ?></div>
        <?php //echo validation_errors(); ?>
        <form method="post" action="">
	<div class="registerBox">
		<div class="frmLebel">First Name</div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->first_name;?>" id="first_name" name="first_name"></div>
                <div class="frmLebel">Middle Name</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="middle_name" name="middle_name"></div>
		<div class="frmLebel">Last Name</div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->last_name;?>" id="last_name" name="last_name"></div>
                <div class="frmLebel">Email</div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->email;?>" id="email" name="email"></div>
		<div class="frmLebel">User Name</div>
		<div class="frmFiled"><input type="text" class="input"  value="<?php echo $user[0]->username;?>" id="username" name="username"></div>
                <div class="frmLebel">Street Address</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="street_address" name="street_address"></div>
                <div class="frmLebel">Street Address2</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="street_address_2" name="street_address_2"></div>
                <div class="frmLebel">City</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="city" name="city"></div>
                <div class="frmLebel">State</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="state" name="state"></div>
                <div class="frmLebel">Zip Code</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="zip_code" name="zip_code"></div>
                <div class="frmLebel">Country</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="country" name="country"></div>
                <div class="frmLebel">Customer Email</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="customer_email" name="customer_email"></div>
                <div class="frmLebel">Customer ID</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="customer_id" name="customer_id"></div>
                <div class="frmLebel">Free Trial Start</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="free_trial_start" name="free_trial_start"></div>
                <div class="frmLebel">Free Trial End</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="free_trial_end" name="free_trial_end"></div>
                <div class="frmLebel">Current Period Start</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="current_period_start" name="current_period_start"></div>
                <div class="frmLebel">Current Period End</div>
		<div class="frmFiled"><input type="text" class="input"  value="" id="current_period_end" name="current_period_end"></div>
                <div class="frmLebel">Active</div>
		<div class="frmFiled">
                        <?php //echo $user[0]->username; exit; ?>
                        <?php //$active = $user[0]->username;?>
			<input type="radio" name="active" <?php if($user[0]->active==2) echo 'checked="checked"';?>value="2" > Active
			<input type="radio" name="active" <?php if($user[0]->active==1) echo 'checked="checked"';?> value="1"> Will be Inactive as of
			<input type="radio" name="active" <?php if($user[0]->active==0) echo 'checked="checked"';?> value="0"> Inactive Now
		</div>
		<div class="frmLebel">&nbsp;</div>
		<div class="buttonDiv">
                    <input type="hidden"  value="<?php echo $user[0]->id;?>" id="uId" name="uId">
                    <input type="submit" value="Submit" class="submit">
                </div>
	</div>
        </form>
</div>	
