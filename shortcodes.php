<?php 

/**
 * undocumented function
 *
 * @return void
 * @author Jared Lang
 **/
function sc_provost_updates(){
	ob_start();
	include('templates/section-updates.php');
	return ob_get_clean();
}
add_shortcode('sc-provost-updates', 'sc_provost_updates');


/**
 * undocumented function
 *
 * @return void
 * @author Jared Lang
 **/
function sc_faculty_award_programs($attrs){
	ob_start();
	include('templates/section-faculty-award-programs.php');
	return ob_get_clean();
}
add_shortcode('sc-faculty-award-programs', 'sc_faculty_award_programs');


/**
 * undocumented function
 *
 * @return void
 * @author Jared Lang
 **/
function sc_org_chart(){
	ob_start();
	include('templates/section-organization.php');
	return ob_get_clean();
}
add_shortcode('sc-org-chart', 'sc_org_chart');


/**
 * undocumented function
 *
 * @return void
 * @author Jared Lang
 **/
function sc_forms(){
	ob_start();
	include('templates/section-forms.php');
	return ob_get_clean();
}
add_shortcode('sc-forms', 'sc_forms');
?>