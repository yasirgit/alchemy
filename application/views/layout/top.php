<?$CI =& get_instance();?>
<div id="header">
	<?if($CI->auth->isLoggedIn()) {?>
		<h1>Welcome <?=$user['first_name']?> <?=$user['last_name']?></h1>
	<?}?>
	<div class="header-block">
		<?if($CI->router->method == NAVSECTION_EATING_JOURNAL)
		{
			echo getCalendarNav($CI);
		}?>
		<ul class="add-nav">
			<?
			if($CI->auth->isLoggedIn())
			{
				if($CI->auth->isSetup())
				{
					?>
					<?php /*
					<li><a href="javascript:void(0);">My Community</a></li>
					<li><a href="javascript:void(0);">My Stats</a></li> 
					*/
					?>
					<li><a href="users/myAccount">My Account</a></li>
					<?
				}
				?>
				<li><a href="logout">Log Out</a></li>
				<?
			}
			else
			{
				?>
				<!--<li><a href="register">Register</a></li>
				-->
				<li><a href="access/signup">Register</a></li>				
				<li><a href="login">Log In</a></li>
				<?
			}
			?>
		</ul>
	</div>
</div>
<?php

$mainclass="";
if($CI->router->class=="recipefinder")
$mainclass='class="sub-page-yellow"';
else if($CI->router->class=="eatingout")
$mainclass='class="sub-page-blue"';
else if($CI->router->class=="successjournal")
$mainclass='class="sub-page-journal"';

?>
<div id="main" <?php echo $mainclass;?>>