	</div>
	</div>
<?php     
    $CI =& get_instance();
    $mainclass=$CI->router->class;
    if($mainclass=="successjournal")
    {         
               $this->load->view("layout/popup_measure"); 
       
    }
?>	
<!-- RipeTracker Button BEGIN -->
<script type="text/javascript">
var debugMode=true;
var bt_config_project_id = 69;
var bt_config_default_location = "Home Page";
var bt_config_btn_placement = "topLeft";
var bt_config_btn_style = "trans";
</script>
<script type="text/javascript" src="http://bugtracker.ripemedia.com/widget/js/embed.js"></script>
<!-- RipeTracker Button END -->	

</body>
</html>