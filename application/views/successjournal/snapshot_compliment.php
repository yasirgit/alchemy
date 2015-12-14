<div class="compliment-wrapper">
    <div class="compliment-bottom">
	   <?php if (count($get_active_track)){
	              foreach ($get_active_track as $key => $activelist){ ?>
	                               <h3 class="compliment-title">Compliment Tracker</h3>
                                    <div class="quote-part">
                                        <div class="quote-bottom-curv">
                                            <div class="quote-body">&#34;<?php 
											          echo $activelist->blog; 
												 ?>&#34;
											</div>
                                        </div>
                                    </div>
                                    <div class="quote-owner">- <?  echo $activelist->name;  ?><br /><a id="return_tracker" href="javascript:void(0);">+ Add Another</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="return_list" href="javascript:void(0);">+ List </a></div>
	   
	   
	   
	  
		<?        }
		     }else{ ?>
							       
								    <h3 class="compliment-title">Compliment Tracker</h3>
                                    <div class="quote-part">
                                        <div class="quote-bottom-curv">
                                            <div class="quote-body" style="">
											    <? echo $ctrack_blog; ?>
											</div>
                                        </div>
                                    </div>
                                    <div class="quote-owner">-<? echo $ctrack_name; ?> <br /><a id="return_tracker" style="cursor:pointer;">+ Add Compliment</a></div>
		             <? } ?>
	 </div>
								
</div>