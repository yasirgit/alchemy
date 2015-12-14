<div class="viewpage">
     <div class="page_head">User Manager</div>
     <div><?if(!empty($error)) { echo $error;} ?></div>
     <?php if($this->session->flashdata('viewVars')) : ?>
        <div class="alert_msg_green" style="text-align: center; color: red;"><?php echo $this->session->flashdata('viewVars'); ?></div>
     <?php endif; ?>
     <?php echo validation_errors(); ?>    
	<div class="viewpageBox">
            <table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
                <tbody>
                   <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Name</th>
                        <th>Active</th>
                        <th>Action</th>
                   </tr>
                  <?php
                      $user = $users->result();
                      for($i=0; $i<count($user); $i++){
                      $name=$user[$i]->first_name." ".$user[$i]->last_name;
                  ?>
                  <tr>
                    <td class="event"><?php echo $name;?></td>
                    <td class="event"><?php echo $user[$i]->email;?></td>
                    <td class="event"><?php echo $user[$i]->username;?></td>
                    <td class="event"><?php if($user[$i]->active == 2){ echo "Active"; } elseif($user[$i]->active==0){ echo "Inactive";} else { echo "Will Be Active";} ?></td>
                    <td class="event">
                        <?php if($user[$i]->active == 2): ?><a href="<?php echo $this->config->item('base_url')?>/access/loginBtn/<?php echo $user[$i]->id;?>" target="_blank">Login</a>&nbsp;|&nbsp;<?php endif; ?>
                            <a href="<?php echo base_url().'admin/'?>editfrontuser/<?php echo $user[$i]->id;?>">Edit</a>
                        <?php if($user[$i]->active == 0 && $user[$i]->activation_code == ''): ?>&nbsp;|&nbsp;<a href="<?php echo $this->config->item('base_url')?>/access/adminSignup/<?php echo $user[$i]->email;?>">Send Activation Link</a><?php endif;?>
                    </td>
                  </tr>
                  <?php } ?>
                  <tr>
                      <td align="center" class="pagenav" colspan="5"><?php echo $this->pagination->create_links(); ?></td>
                  </tr>
           </tbody>
            </table>
	</div>
</div>

