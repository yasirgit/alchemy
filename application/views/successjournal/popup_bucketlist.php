

<script type="text/javascript">

$(document).ready(function() {

    var i =5;
	$('a.add').click(function() {
        // alert("add");
         $('<fieldset id="rtest2"><span><input type="text" id="rv" name="item[]" value="" /></span><a class="rr"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a></fieldset>').animate({ opacity: "show" }, "slow").appendTo('#gg');
		i++;
		
		 $('a.rr').click(function() {
               $('#rtest2').animate({opacity:"hide"}, "slow").remove();
	     });
	});
	
	

	$('a.remove').click(function() {
	    
        $('#rtest').animate({opacity:"hide"}, "slow").remove();
	});
	
	
	 $("#bucketAdd").click(function() { 
	  
			$('#bcklist_frm').ajaxSubmit(
			{
						url:			"successjournal/bucketlist_update",
						type:			'post',	
						beforeSubmit:	function()
										{
											$('#load_before4').append("<img id='checkmark' src='<?php echo $this->config->item('base_url')?>/htdocs/images/successjournal/ajax-loader.gif' />" );	
											return true;
										},				
						success:		function (data)
										{  

										   $("#bucket-box").load('successjournal/ajax_show_bcklist');
										   $('#load_before4').css('display',"none");
										   disableAddBucketPopup();  
                                          // alert("success");
										 //window.location.reload('successjournal/ajax_ultimate');
										
   
										}
			});
			
			return false;
        });
		
	return false; 
	
});

</script>

 <style rel="stylesheet" type="text/css">

h1 { font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;}

.hide {visibility:hidden;}

img {border:none;}
#gg{
width:350px;
}
#rv{
width:250px;
padding:5px;
}
</style> 
  
<div class="popup-bucketBox" id="popup-bucketBox">
<?php 
if($bcklist > 0)
{ 

?>     
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>My Bucket List</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <div class="bucketBox-inner">
            </div>
			<form name="bcklist" method="post" action="successjournal/bucketlist_update" id="bcklist_frm">
			<?php foreach($bcklist as $key=> $bklist){ ?>
        	<fieldset id="rtest">
			         
            	<span><input type="hidden"  name="item[]" value="<?php echo $bklist['item']; ?>" /><?php echo $bklist['item']; ?></span><a class="remove"><img id="<?php echo $bklist['id']; ?>" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a>
            </fieldset>
			<?php } ?>
         
			<div id="gg"></div>

            <fieldset>
			<span id="inputs"></span>
			<a class="add"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addNewitem.gif"></a>
            	<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addNewitem.gif" value="" />-->
           </fieldset>
            <fieldset class="btn">
                <input class="close2" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<input name="bucketedit" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif" value="bb"  id="bucketAdd" />  
			<!--	<input id="bck_del_edit" name="bucketedit" type="submit" value="save"  />  -->        
           </fieldset>
           </form> 
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
<?php
}else{
?>
  		<div class="top">
           <a href="" class="close"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/close-btn.png" width="28" height="28" alt="close" /></a>
        	<div class="top-mid">
               <h2>My Bucket List</h2>               
          </div>
            <div class="top-right">
            </div>
   	    </div>
        <div class="popup-middle">
            <div class="bucketBox-inner">
            </div>
			<form name="bcklist" method="post" action="successjournal/bucketlist_update" id="bcklist_frm">
        	<fieldset id="rtest">
            	<span><input type="hidden" name="item[]" value="Run a 5k" />Run a 5k</span><a class="remove"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a>
            </fieldset>
           <fieldset id="rtest">
            	<span><input type="hidden" name="item[]" value="Ride a horse" />Ride a horse</span><a class="remove"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a>
            </fieldset>
           <fieldset  id="rtest">
            	<span><input type="hidden" name="item[]" value="Buy 1 seat on an airplane" />Buy 1 seat on an airplane</span><a class="remove"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a>
            </fieldset>
           <fieldset  id="rtest">
            	<span><input type="hidden" name="item[]" value="Look &amp; feel great for my son’s wedding" />Look &amp; feel great for my son’s wedding</span> <a class="remove"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" alt="remove input" ></a>
<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-remove.gif" value="" />-->

            </fieldset>
			<div id="gg"></div>

            <fieldset>
			<span id="inputs"></span>
			<a class="add"><img src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addNewitem.gif"></a>
            	<!--<input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-addNewitem.gif" value="" />-->
           </fieldset>
            <fieldset class="btn">
                <input type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-cancel.gif" value="" />
            	<input name="bucketAdd" type="image" src="<?=$this->config->item('base_url')?>/htdocs/images/successjournal/btn-save.gif"  id="bucketAdd" />               
           </fieldset>
           </form> 
        </div>
        <div class="bottom">
        	<div class="bottom-mid">
            </div>
            <div class="bottom-right">
            </div>
   	    </div>
		<?php
		}
		?>
  </div>
  
    <div id="bgAddBuketPopup"><div  id="load_before4"  style="margin:auto; width:250px; padding-top:40px;"></div></div>