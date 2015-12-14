<?php
if(count($dmessage)>0)
{
		for($i=0;$i<count($dmessage);$i++)
		{
?>		
		<div class="messages-box colored" id="messages-boxd<?php echo $i; ?>">
			<div style="padding:0 0 10px 5px;">
			<p><?php echo date("F j, Y, g:i a",strtotime($dmessage[$i]->mdate));?></p>
			</div>
			<a href="javascript:void(0);" class="close-opt" delid="messages-boxd<?php echo $i; ?>"><img src="htdocs/images/decline.png" alt="" /></a>
			<div class="image-holder">
			<a href="javascript:void(0);"><img src="htdocs/images/img4.gif" width="38" height="31" alt="" /></a>
			</div>
			<div class="text-box">
			<p><?php echo str_replace("<meal name>","last meal",$dmessage[$i]->message);?></p>
			</div>			
		</div>
<?php		
		}
}
?>