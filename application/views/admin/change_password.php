<div class="login" style="height:auto;">
    <div class="page_head">Change Password</div>
    <div>
        <?php
        if(!empty($error)) { echo "<br />".$error."<br />"; }
        echo validation_errors();       
        if($error_custom!=''){echo $error_custom ;}
        ?>
   </div>   
   <form method="post" action="change_password">
        <div class="loginArea">
            <div>Old Password</div>
            <div><input type="password" class="input" maxlength="32" size="20" value="" id="oldpassword" name="oldPass" style="width: 150px;" dir="ltr"></div>
            <div>Password</div>
            <div><input type="password" class="input" maxlength="32" size="20" value="" id="password" name="password" style="width: 150px;" dir="ltr"></div>
            <div>Confirm Password</div>
            <div><input type="password" class="input" maxlength="32" size="20" value="" id="conpassword" name="conpassword" style="width: 150px;" dir="ltr"></div>
            <div>&nbsp;</div>
            <div class="buttonDiv">                 
                 <input type="submit" value="Submit" class="submit">
            </div>
            <div>&nbsp;</div>
        </div>
  </form>
</div>	