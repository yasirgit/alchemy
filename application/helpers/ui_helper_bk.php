<?php
$CI =& get_instance();

define('NAVSECTION_EATING_JOURNAL',		'eating_journal');
define('NAVSECTION_RECIPE_FINDER',		'recipe_finder');
define('NAVSECTION_EATING_OUT_ADVISOR',	'eating_out_advisor');
define('NAVSECTION_SNACK_TREAT',		'snack_treat_guide');
define('NAVSECTION_MENU_PLANNER',		'menu_planner');
define('NAVSECTION_SUCCESS_JOURNAL',	'success_journal');

function getRightNavbar($CI) {
	$viewVars['eating']		= false;
	$viewVars['recipe']		= false;
	$viewVars['advisor']	= false;
	$viewVars['snack']		= false;
	$viewVars['planner']	= false;
	$viewVars['success']	= false;
	
	////////////////////////////////////////
	$mainclass=$CI->router->class;	
	if($mainclass=="recipefinder")
	{
		$viewVars['recipe'] = true;	
	}
	else if($mainclass=="eatingout")
	{
		$viewVars['advisor']=true;
	}
	//////////////////////////////////////////	
	
	switch($CI->router->method)
	{
		case NAVSECTION_EATING_JOURNAL:
			$viewVars['eating']		= true;
			break;
		case "list_all":
		case NAVSECTION_RECIPE_FINDER:
			$viewVars['recipe']		= true;
			break;
		case NAVSECTION_EATING_OUT_ADVISOR:
			$viewVars['advisor']	= true;
			break;
		case NAVSECTION_SNACK_TREAT:
			$viewVars['snack']		= true;
			break;
		case NAVSECTION_MENU_PLANNER:
			$viewVars['planner']	= true;
			break;
		case NAVSECTION_SUCCESS_JOURNAL:
			$viewVars['success']	= true;
			break;
	}
	
	return $CI->load->view('ui_elements/right_navigation', $viewVars);
}

function getCalendarNav($CI)
{
	return $CI->load->view('ui_elements/cal_navigation');//,$data);
}

function getContentFrameBorderCssClass($CI)
{
	$method = $CI->router->method;
	$replaced = str_replace('_', '-', $CI->router->method);
	$css['content'] = 'content-'.$replaced;
	$css['content_holder'] = 'content-holder-'.$replaced;
	$css['content_frame'] = 'content-frame-'.$replaced;
	return $css;
}

function button($title, $type, $js=false)
{
	$viewVars['title'] = $title;
	$viewVars['type'] = $type;
	$viewVars['js'] = $js;
	return $CI->load->view('ui_elements/button', $viewVars);
}