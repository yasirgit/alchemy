
<div class="bucket-box">
					                  <div class="bucket-box-top">
					                    <!--Ie6-->
				                      </div>
					                  <div class="bucket-box-mid">
                                      		<div class="bucketBox-inner">                                         	
                                            </div>
                                            
                                            <div class="bucketBox-item"> 

                                               <form action="#">
		                                     <?php foreach ($bcklist as $key => $bklist)
                                              {
                                            ?>
                                               <p><input name="chkbox" type="checkbox" value="" /><label><?php echo $bklist['item']; ?></label></p>
                                               <!--<p><input name="chkbox" type="checkbox" value="" /><label>Ride a horse</label></p>
                                               <p><input name="chkbox" type="checkbox" value="" /><label>Buy 1 seat on
an airplane</label></p>
                                               <p><input name="chkbox" type="checkbox" value="" /><label>Look &amp; feel 
great for my 
son’s wedding</label></p>
                                               <p><input name="chkbox" type="checkbox" value="" /><label>Buy 1 seat on
an airplane</label></p>--><?php
											}
											?>
                                               <p class="edit"><a id="edit_bucket">+add/edit</a></p>
                                               </form>                                        	
                                            </div>
											
                                      
                                      </div>
					                  <div class="bucket-box-bottom"></div>
</div>