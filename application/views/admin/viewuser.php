<div class="addlink"><a href="adduser">Add New Admin User</a></div>
<div class="viewpage">
     <div class="page_head">View Admin User</div>
     <div><?if(!empty($error)) { echo $error;} ?></div>
     <?php echo validation_errors(); ?>    
    <form method="post" action="adduser">
	<div class="viewpageBox">
            <table cellspacing="1" cellpadding="0" border="0" style="width: 100%;">
                <tbody>
                   <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Name</th>
                        <th>User Group</th>
                        <th>Active</th>
                        <th>Action</th> 
                  </tr>
                  <?php for($i=0; $i<count($user); $i++){
                  $name=$user[$i]->first_name." ".$user[$i]->last_name;
                  ?>
                  <tr>
                    <td class="event"><?php echo $name;?></td>
                    <td class="event"><?php echo $user[$i]->email;?></td>
                    <td class="event"><?php echo $user[$i]->username;?></td>
                    <td class="event"><?php if($user[$i]->group_id==1) echo "Super User"; else echo "Regular Admin User";?></td>
                    <td class="event"><?php if($user[$i]->active==1) echo "Active"; elseif($user[$i]->active==0) echo "Inactive"; else "Will Be Active";?></td>
                    <td class="event"><a href="edituser/<?php echo $user[$i]->id;?>">Edit</a>&nbsp;|&nbsp;<a href="delUser/<?php echo $user[$i]->id;?>">Delete</a></td>
                  </tr>
                  <?php } ?>
           </tbody>
            </table>
               
	</div>
      </form>     
</div>

