<?php 

/**
 * Outputs a list of the provost updates
 *
 * @return string
 * @author Jared Lang
 **/
function sc_provost_updates(){
	ob_start();
	include('templates/section-updates.php');
	return ob_get_clean();
}
add_shortcode('sc-provost-updates', 'sc_provost_updates');


/**
 * Outputs the horizontal faculty award programs list.
 *
 * @return string
 * @author Jared Lang
 **/
function sc_faculty_award_programs($attrs){
	ob_start();
	include('templates/section-faculty-award-programs.php');
	return ob_get_clean();
}
add_shortcode('sc-faculty-award-programs', 'sc_faculty_award_programs');


/**
 * Outputs the Academic Officers and College Deans listings
 *
 * @return string
 * @author Jared Lang
 **/
function sc_org_chart(){
	ob_start();
	include('templates/section-organization.php');
	return ob_get_clean();
}
add_shortcode('sc-org-chart', 'sc_org_chart');


/**
 * Outputs forms, organized by the sub-category of 'Forms' they are related to.
 * Uncategorized forms will not display.
 *
 * @return string
 * @author Jared Lang
 **/
function sc_forms(){
	ob_start();
	include('templates/section-forms.php');
	return ob_get_clean();
}
add_shortcode('sc-forms', 'sc_forms');
?>