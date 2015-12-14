<?php $this->CI = & get_instance(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	
<link media="all" rel="stylesheet" href="<?=$this->config->item('base_url')?>/htdocs/css/admin_style.css" type="text/css" />
</style>
    <head>
	<title>FoodLover Admin Panel</title>
	</head>
	<body>
	<div id="topBar">
		<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
			<tbody><tr>
				<td class="helpLinks">
				<div class="helpLinksLeft">				
				  <img height="48px"  width="207px" border="0" width="20" alt="FoodLovers Admin" src="<?=$this->config->item('base_url')?>/htdocs/images/fatloss_admin_logo.gif">
				</div>
				</td>
				<td class="helpLinks">
                                    <?php
                                    //echo $this->session->userdata('alogged_in');
                                    if($this->CI->auth->isAdminLoggedIn()) {?>
                                            <h1>Welcome  <?php echo $this->session->userdata('first_name');//$user['first_name']?> <?php echo $this->session->userdata('last_name');//$user['last_name']?></h1>
                                    <?}?>
                                            
                                    <?php
                                    if($this->CI->auth->isAdminLoggedIn())
                                    {
                                    ?>
                                        <a href="<?=$this->config->item('base_url')?>/admin/change_password">Change Password</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
					<a href="<?=$this->config->item('base_url')?>/adminlogout">Log-out</a>
                                    <?php } else {?>
					<a href="<?=$this->config->item('base_url')?>/adminlogin">Login</a>
                                    <?php } ?>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div id="header"></div>
         <?php
        if($this->CI->auth->isAdminLoggedIn())
        {
        ?>
	<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
			<tbody>
			<tr>
			<td class="navCell">
			&nbsp;
			</td>
			<td width="14%"  class="navCell">
				<div id="publish" class="cpNavOff">
					<a href="<?php echo $this->config->item('base_url');?>/admin/viewuser">Admin User Management</a>
				</div>	
			</td>
			<td width="14%"  class="navCell">
				<div id="publish" class="cpNavOff">
					<a href="<?=$this->config->item('base_url')?>/admin/listUser">User Management</a>
				</div>	
			</td>

			<td width="14%"  class="navCell">
				<div id="publish" class="cpNavOff">
					<a href="<?=$this->config->item('base_url')?>/admin/recipe">Recipe</a>
				</div>	
			</td>
			

			<td width="14%"  class="navCell">
				<div id="publish" class="cpNavOff">
					<a href="<?=$this->config->item('base_url')?>/admin/myaccount">My Account</a>
				</div>	
			</td>
			<td class="navCell">
			&nbsp;
			</td>
			</tr>
	</tbody>
</table>
<?php } ?>
<div class="top"></div>
<div id="contentNB">