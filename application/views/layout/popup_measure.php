<script language="JavaScript" type="text/javascript">
 $(function(){
    var id =1;
	var url="<?php echo $this->config->item('base_url')?>/successjournal/ajax_paging";
   /*  $(".goto").click(function() {   
	         id = $(this).attr("id"); 
	 });	*/	
	   	
			//alert(id);
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "p="+id,
                 success: function(success){
				 	//alert(success);
					$('#test').html(success);
                    // success.html(html);
                  }
               });               
       	  
		              
       return false;
     });  
</script>
<script type="text/javascript">
/*jQuery().ready(function(){
		jQuery('.right-side div').click(function(){
					var track=jQuery('.right-side div').index($(this));	
					alert(track);
								
		});				
						
		});*/
$(document).ready(function(){
	$('.right-side div').css('cursor', 'pointer');
	var classp = '';
	$('.right-side div').hover(function(){
		classp = $(this).attr('class');
		$(this).find('.dir-tooltip').show();
		$(this).addClass(classp+'-hover');
	},
	function(){
		$(this).removeClass(classp+'-hover');
		$(this).find('.dir-tooltip').hide();
	}
	);
});

</script>

<div class="popup-measurement  measurement-auto" id="popup-measurement" >
  <!--<div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
    <div class="top-mid">
      <h2>My Measurements</h2>
    </div>
    <div class="top-right"> </div>
  </div>-->
    <div class="top-title"> <a href="javascript:void(0)" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
    <div class="title-inner">
    	<div>My Measurements</div>
    </div>
  </div>

  <div class="popup-middle">
    <h2 class="heading"><span>Take your initial body measurements with a measuring tape (cloth measuring 
        tape preffered.).<br/>If you find it difficult to do your own measurements, enlist the help of a friend to make it easier.</span></h2>
				<div id="test" style=""></div>
         
    
    <div class="right-side">
      <div class="neck-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Neck:</strong><br />Measure the widest area around the neck.</p>
            </div>
        </div>
      </div>
      <div class="chest-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Chest:</strong><br />Measure the widest area of chest.</p>
            </div>
        </div>
      </div>
      <div class="arm-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Biceps:</strong><br />Measure widest area of biceps, in a relaxed state.</p>
            </div>
        </div>
      </div>
      <div class="waist-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Waist:</strong><br />Measure one inch above navel.</p>
            </div>
        </div>
      </div>
      <div class="hand-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Forearms:</strong><br />Measure widest area of forearms.</p>
            </div>
        </div>
      </div>
      <div class="wrist-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Wrist:</strong><br />Measure widest area of wrist.</p>
            </div>
        </div>
      </div>
      <div class="belly-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Hips:</strong><br />Measure widest area of hips.</p>
            </div>
        </div>
      </div>
      <div class="thumb-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Thighs:</strong><br />Measure widest area of thighs.</p>
            </div>
        </div>
      </div>
      <div class="leg-point">
      	<div class="dir-tooltip">
        	<div class="tooltip-inn">
            	<p><strong>Calves:</strong><br />Measure widest area of calves.</p>
            </div>
        </div>
      </div>
    </div>
  </div>
  
<!--   <div class="bottom">
    <div class="bottom-mid"> </div>
    <div class="bottom-right"> </div>
  </div>-->
  <div class="bottom-round"><div class="bottom-inner"><div>&nbsp;</div></div> <!--Measurement Bottom Round-->
  </div>
  
 </div>