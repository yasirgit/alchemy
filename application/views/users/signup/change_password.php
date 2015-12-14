
<?php
$bInfo=array(); 
echo $this->load->view('users/banner',$bInfo); ?>
<div class="how-do-use" style="height:12px;"></div>
<form action="users/change_password" method="post" class="signup-form signup-form-update" autocomplete="off">
<fieldset>
<div class="block-in-blue block-in-blue-light-green additional-reciep-box">
				<div class="block-in-holder-blue">
					<div class="block-in-frame-blue">
						<div class="block-in-title-blue title-blue-wider">
							<h2 >Change Password</h2>
							
						</div>
						<div class="signup-type signup-type-up">							
						<?php ?> 
							<div style="font-weight:bold;color:#CC0000;">
								<?php
									if(!empty($error)) { echo "<br />".$error."<br />"; }
									echo validation_errors();
								    //
									
									foreach($uerror as $key=>$value)
									{
										if($key=="update_complete")
										echo "<span style='color:green;'>".$value."</span><br />";
										else
										echo $value."<br />";
									}	
									if($error_custom!=''){echo $error_custom ;}																								
								?>
							</div>
							<?php
							?>
							<div class="row">
								<div class="insFieldset">
                                                        <label>Old password:</label>
                                                            <div>
                                                            <span class="text"><input type="password" name="oldPass" value="" /></span>
                                                            </div>
                                                            <br class="clear" />
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>New password:</label>
                                                            <div><span class="text"><input type="password" name="password" value=""  /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="insFieldset">
                                                        <label>Verify password:</label>
                                                            <div><span class="text"><input type="password" name="cpassword" value="" /></span></div>
                                                            <div class="clear"></div>
                                                        </div>
														
                                                        
                                                        
                                                        
														
							</div>
						</div>
					</div>
				</div>			
			</div>
<div class="btn-area-form btn-area-form-right">
	<div class="sexybutton-area">
		<input type="hidden" name="uid" value="<?php echo $user['id']; ?>" />
		<button type="submit" class="sexybutton sexysimple sexygreen btn-submit"><span class="save">Save Changes</span></button>
	</div>
	<a href="users/myAccount" class="sexybutton sexysimple sexygreen btn-submit">Cancel</a>				
</div>			
</fieldset>
</form>