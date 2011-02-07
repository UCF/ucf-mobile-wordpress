<?php
# Custom Child Theme Functions
# http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/
require_once('custom-post-types.php');
require_once('shortcodes.php');

define('PROVOST_THEME_URL', get_bloginfo('stylesheet_directory'));
define('PROVOST_STATIC_URL', PROVOST_THEME_URL.'/static');
define('PROVOST_IMG_URL', PROVOST_STATIC_URL.'/img');
define('PROVOST_JS_URL', PROVOST_STATIC_URL.'/js');
define('PROVOST_CSS_URL', PROVOST_STATIC_URL.'/css');
define('PROVOST_MISC_URL', PROVOST_STATIC_URL.'/misc');

// Parent theme overrides and theme setttings
// ------------------------------------------

#Sets link to be included in head
$LINKS = array(
	"<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />",
	"\n\t<!-- jQuery UI CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/jquery-ui.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/jquery-uniform.css' media='screen, projection' />",
	"\n\t<!-- Blueprint CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-screen.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-print.css' media='print' />",
	"<!--[if lt IE 8]><link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-ie.css' media='screen, projection' /><![endif]-->",
	"\n\t<!-- Template CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/webcom-template.css' media='screen, projection' />",
);

#Sets scripts to be loaded at bottom of page
$SCRIPTS = array(
	"<!--[if IE]><script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script><![endif]-->",
	"<script src='http://universityheader.ucf.edu/bar/js/university-header.js' type='text/javascript' ></script>",
	"\n\t<!-- jQuery UI Scripts -->",
	"<script src='".PROVOST_JS_URL."/jquery-ui.js' type='text/javascript' ></script>",
	"<script src='".PROVOST_JS_URL."/jquery-browser.js' type='text/javascript' ></script>",
	"<script src='".PROVOST_JS_URL."/jquery-uniform.js' type='text/javascript' ></script>",
	"<script src='http://events.ucf.edu/tools/script.js' type='text/javascript'></script>",
	"<script type='text/javascript'>
		var PROVOST_MISC_URL = '".PROVOST_MISC_URL."';
	</script>",
	"<script src='".PROVOST_JS_URL."/script.js' type='text/javascript'></script>",
);


function remove_widgitized_areas($content){
	$widgets_to_remove = array(
		'Index Top',
		'Index Insert',
		'Index Bottom',
		'Single Top',
		'Single Insert',
		'Single Bottom',
		'Page Top',
		'Page Bottom',
	);
	foreach($widgets_to_remove as $widget){
		unset($content[$widget]);
	}
	return $content;
}
add_action('thematic_widgetized_areas', 'remove_widgitized_areas');

function provost_head_profile($profile){
	return "<head>";
}
add_filter('thematic_head_profile', 'provost_head_profile');


function provost_template_redirect(){
	global $post;
	$type  = $post->post_type;
	$title = get_the_title();
	switch($title){
		case 'Home':
			include('templates/home.php');
			die();
	}
	switch($type){
		case 'provost_update':
			include('templates/update.php');
			die();
	}
}
add_filter('template_redirect', 'provost_template_redirect');


#Set html 5
function provost_create_doctype() {
	$content  = "<!DOCTYPE html>\n";
	$content .= "<html";
    return $content;
} // end thematic_create_doctype
add_filter('thematic_create_doctype', 'provost_create_doctype');


#Set utf-8 meta charset
function provost_create_contenttype(){
	$content  = "\t<meta charset='utf-8'>\n";
	$content .= "\t<meta http-equiv='X-UA-COMPATIBLE' content='IE=edge'>\n";
	return $content;
}
add_filter('thematic_create_contenttype', 'provost_create_contenttype');


#Override default stylesheets
function provost_create_stylesheet($links){
	global $LINKS;
	$new_links = $LINKS;
	
	$links = explode("\n", $links);
	$links = array_map(create_function('$l', '
		return trim($l);
	'), $links);
	$links = array_filter($links, create_function('$l', '
		return (bool)trim($l);
	'));
	$links = array_merge($new_links, $links);
	
	return "\t".implode("\n\t", $links)."\n";
}
add_filter('thematic_create_stylesheet', 'provost_create_stylesheet');


#Override default scripts
function provost_head_scripts($scripts){}
add_filter('thematic_head_scripts', 'provost_head_scripts');


#Append scripts to bottom of page
function provost_after(){
	global $SCRIPTS;
	print "\t".implode("\n\t", $SCRIPTS);
}
add_filter('thematic_after', 'provost_after');

function provost_footer(){
	print wp_nav_menu(thematic_nav_menu_args());
}
add_action('wp_footer', 'provost_footer');


// Theme custom functions
// ----------------------

/**
 * Returns the name of the custom post type defined by $class
 *
 * @return string
 * @author Jared Lang
 **/
function get_custom_post_type($class){
	$installed = installed_custom_post_types();
	foreach($installed as $object){
		if (get_class($object) == $class){
			return $object->options('name');
		}
	}
	return null;
}


/**
 * Returns pages associated with the menu defined by $c;
 *
 * @return array
 * @author Jared Lang
 **/
function get_menu_pages($c){
	return get_posts(array(
		'numberposts' => -1,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'post_type'   => 'page',
		'category'    => get_category_by_slug($c)->term_id,
	));
}


/**
 * Returns published images as html string
 *
 * @return void
 * @author Jared Lang
 **/
function get_home_images($limit=null, $orderby=null){
	$limit       = ($limit) ? $limit : -1;
	$orderby     = ($orderby) ? $orderby : 'date';
	$home_images = new ProvostHomeImages();
	$images      = get_posts(array(
		'numberposts' => -1,
		'orderby'     => $orderby,
		'order'       => 'ASC',
		'post_type'   => $home_images->options('name'),
	));
	if ($images){
		$html = '';
		foreach($images as $image){
			$html .= get_the_post_thumbnail($image->ID);
		}
		return $html;
	}else{
		return '';
	}
}


/**
 * Tells you if this person has just commented within a given time frame and set
 * of comments.
 *
 * @return void
 * @author Jared Lang
 */
function user_just_commented($comments, $timeframe){
	/*/ This attempts to detect whether or not the user just commented by
	inspecting the last 10 comments passed and comparing their IP address and
	the current time to the comments IP address and post date.
	
	Unfortunately, if someone revists the the page this function is called on
	within the defined timeframe, it will return that they have just commented.
	/*/
	
	$limit    = 10; # Limit number of comments to search in
	$comments = array_slice($comments, -$limit);
	
	foreach($comments as $comment){
		$diff = time() - strtotime($comment->comment_date_gmt);
		if ($diff < $timeframe){
			if ($_SERVER["REMOTE_ADDR"] == $comment->comment_author_IP){
				return True;
			}
		}
	}
	return False;
}

function disallow_direct_load($page){
	if ( $page == basename($_SERVER['SCRIPT_FILENAME'])){
		die ( 'Please do not load this page directly. Thanks!' );
	}
}
?>