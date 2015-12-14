<script language="JavaScript" type="text/javascript">
 $(function(){
   // var id =1;
		$("#before_pic").click(function() { 
	  
			$('#bfp').ajaxSubmit(
			{
						url:			"successjournal/upload_before_img",
						type:			'post',
						dataType:		'xml',//'json',
						beforeSubmit:	function()
										{
											$('#beforeup').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/ajax-loader.gif' />");
											
											return true;
										},
						success:		function (data)
										{
						                  
										    $('#beforeup').css('display',"none");
											$('#customize-browse1').css('display',"none");
											$('.loaddiv').css('display',"block");
											$('#before_pic').css('display',"none");
											$('.loaddiv').html("Successfully Uploaded!") ;

										}
			});
        });
		
		$("#after_pic").click(function() { 
	  
			$('#afp').ajaxSubmit(
			{
						url:			"successjournal/upload_after_img",
						type:			'post',
						dataType:		'xml',//'json',
						beforeSubmit:	function()
										{
											$('#afterup').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/ajax-loader.gif' />" );
											
											return true;
										},
										
						success:		function (data)
										{
											
											$('#afterup').css('display',"none");
											$('#customize-browse2').css('display',"none");
											$('.loaddiv2').css('display',"block");
											$('#after_pic').css('display',"none");
											$('.loaddiv2').html("Successfully Uploaded!") ;
											
										}
			});
		});
		
		
		$(".save_gal").click(function() {   //alert(1);
	         //alert('reload');
			 location.reload(); 

		/*	var url="<?php //echo $this->config->item('base_url')?>/successjournal/index";
	   	    alert(photo);
			
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 //data: "p="+photo,
                 success: function(success){
				 	//alert(success);
					//$('#uppic').html(success);
                    // success.html(html);
                  }
               });               */
       	  
		 });              
	   return false;
	

});

    /* $("#before_pic").click(function() {   //alert(1);
	 
			var photo = $("#bf_img").val();

			var url="<?php echo $this->config->item('base_url')?>/successjournal/upload_before_img";
	   	    alert(photo);
			
			            
               $.ajax({
                 type: "POST",
                 url:url ,
				 data: "p="+photo,
                 success: function(success){
				 	//alert(success);
					$('#uppic').html(success);
                    // success.html(html);
                  }
               });               
       	  
		 });              
       return false;
     });  */
</script>

<div class="popup-plan-goal" id="popup_upload">
  <div class="top"> <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
    <div class="top-mid">
      <h2>Upload Picture</h2>
    </div>
    <div class="top-right"> </div>
  </div>
  <div class="popup-middle">
      <h2 class="heading">Before Picture</h2>
        <div class="popup-content upload-image">
		    <div id="beforeup" style="padding:5px;"></div>
        	<form action="successjournal/upload_before_img" name="imgform" method="post" enctype="multipart/form-data" id="bfp">
              
               <fieldset class="">
                   <label>Upload Image:</label> <div class="loaddiv" style="display:none;font-size: 17px;text-align: center;width: 350px; color:#F7F9C8;font-weight: bold;"></div>
                      <div class="customize-browse" id="customize-browse1">
                         <input type="file" class="file_2"  name="before_img" id="bf_img" />
                         </div>
						 <a id="before_pic"><img src="<?=$this->config->item('base_url')?>/htdocs/images/btn-upload-img.gif" style="padding:0 0 0 16px;"></a>
<!--                         <input id="before_pic" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/btn-upload-img.gif" style="padding:0 0 0 16px;" />-->
                       <div class="clear">&nbsp;</div>
                       <p class="browse-caption">Click 'Browse...' to choose your picture from your computer, then press 'upload picture' to change the image. </p>
               </fieldset>
            </form>
        </div>
          
      <h2 class="heading">After Pictures</h2>
      <div class="popup-content upload-image">
	        <div id="afterup" style="padding:5px;"></div>
        	<form action="successjournal/upload_after_img" method="post" enctype="multipart/form-data" id="afp" name="imgform2"> 
              
                 <fieldset class="">
                   <label>Upload Image:</label>
				     <div class="loaddiv2" style="display:none;font-size: 17px;text-align: center;width: 350px; color:#F7F9C8;font-weight: bold;"></div>
                      <div class="customize-browse"  id="customize-browse2">
                          <input type="file" class="file_2" id="af_img" name="after_img" />
					  </div>
					  <a id="after_pic"><img src="<?=$this->config->item('base_url')?>/htdocs/images/btn-upload-img.gif" style="padding:0 0 0 16px;"></a>
					 <!-- <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/btn-upload-img.gif" style="padding:0 0 0 16px;" />-->
                      <div class="clear">&nbsp;</div>
                       
                       <p class="browse-caption">Click 'Browse...' to choose your picture from your computer, then press 'upload picture' to change the image. </p>
               </fieldset>
             </form> 
			  <form action="successjournal/" method="post">  
               <fieldset class="submit-btn">
                  
                   <input type="image" value="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" name="upLoadImage" class="save_gal" >
                    <input type="image" value="" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" class="close2" >
                </fieldset>
            </form>
        </div>
  </div>
  <div class="bottom">
    <div class="bottom-mid"> </div>
    <div class="bottom-right"> </div>
  </div>
</div>

  <div id="bgUploadPopup"></div>