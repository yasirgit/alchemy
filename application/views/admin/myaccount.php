<?$CI =& get_instance();?>
<div class="register">
	<div class="page_head">
            <div class="page_head_left">My Account</div>
            <div class="page_head_right"><a href="edituser/<?php echo $this->session->userdata('aid');?>">Edit</a></div>
        </div>
        <div></div>        
        <form method="post" action="">
	<div class="registerBox">
		<div class="frmLebel">First Name</div>
		<div class="frmFiled"><?php echo $user[0]->first_name;?></div>
		<div class="frmLebel">Last Name</div>
		<div class="frmFiled"><?php echo $user[0]->last_name;?></div>
                <div class="frmLebel">Email</div>
		<div class="frmFiled"><?php echo $user[0]->email;?></div>
		<div class="frmLebel">User Name</div>
		<div class="frmFiled"><?php echo $user[0]->username;?></div>
		<div class="frmLebel">User Group</div>
		<div class="frmFiled">                   
                       <?php $group=$user[0]->group_id;?>
                       <?php if($group==1) echo 'Super Use';?>
                       <?php if($group==2) echo 'Regular Admin User';?>
                    
		</div>
		<div class="frmLebel">Active</div>
		<div class="frmFiled">
                        <?php $active=$user[0]->username;?>
			<?php if($active==1) echo 'Active';?>		
			<?php if($active==0) echo 'Inactive';?>
		</div>
		<div class="frmLebel">&nbsp;</div>
		<div class="buttonDiv">
                   
                </div>
	</div>
        </form>
</div>	
