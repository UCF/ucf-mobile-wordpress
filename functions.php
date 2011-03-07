<?php
# Custom Child Theme Functions
# http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/
require_once('custom-post-types.php');
require_once('shortcodes.php');

define('MOBILE_GA_ACCOUNT', 'UA-20711945-1');
define('MOBILE_CB_ACCOUNT', '2806');
define('MOBILE_CB_DOMAIN', 'm.ucf.edu');
define('MOBILE_THEME_URL', get_bloginfo('stylesheet_directory'));
define('MOBILE_STATIC_URL', MOBILE_THEME_URL.'/static');
define('MOBILE_IMG_URL', MOBILE_STATIC_URL.'/img');
define('MOBILE_JS_URL', MOBILE_STATIC_URL.'/js');
define('MOBILE_CSS_URL', MOBILE_STATIC_URL.'/css');

// Parent theme overrides and theme setttings
// ------------------------------------------

#Sets link to be included in head
$LINKS = array(
	"<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />",
	"\n\t<!-- Blueprint CSS -->",
	"<link rel='stylesheet' type='text/css' href='".MOBILE_CSS_URL."/blueprint-screen.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".MOBILE_CSS_URL."/blueprint-print.css' media='print' />",
);

#Sets scripts to be loaded at bottom of page
$SCRIPTS = array(
	"<script src='http://universityheader.ucf.edu/bar/js/university-header.js' type='text/javascript' ></script>",
	"<script src='".MOBILE_JS_URL."/script.js' type='text/javascript'></script>",
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

function mobile_head_profile($profile){
	return "<head>";
}
add_filter('thematic_head_profile', 'mobile_head_profile');


function mobile_template_redirect(){
	global $post;
	switch($post->post_title){
		case 'Home':
			include('templates/home.php');
			die();
	}
}
add_filter('template_redirect', 'mobile_template_redirect');


#Set html 5
function mobile_create_doctype() {
	$content  = "<!DOCTYPE html>\n";
	$content .= "<html";
    return $content;
} // end thematic_create_doctype
add_filter('thematic_create_doctype', 'mobile_create_doctype');


#Set utf-8 meta charset
function mobile_create_contenttype(){
	$content  = "\t<meta charset='utf-8'>\n";
	$content .= "\t<meta http-equiv='X-UA-COMPATIBLE' content='IE=IE8'>\n";
	ob_start();
	?>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
	<![endif]-->
<?php
	$content .= ob_get_clean();
	return $content;
}
add_filter('thematic_create_contenttype', 'mobile_create_contenttype');


#Override default stylesheets
function mobile_create_stylesheet($links){
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
add_filter('thematic_create_stylesheet', 'mobile_create_stylesheet');


#Override default scripts
function mobile_head_scripts($scripts){
	ob_start();?>
	<script type="text/javascript">
		var GA_ACCOUNT = '<?=MOBILE_GA_ACCOUNT?>';
		var CB_ACCOUNT = <?=MOBILE_CB_ACCOUNT?>;
		var CB_DOMAIN  = '<?=MOBILE_CB_DOMAIN?>';
	</script>
	<script src="<?=MOBILE_JS_URL?>/header.js" type='text/javascript'></script>
	<?php return ob_get_clean();
}
add_filter('thematic_head_scripts', 'mobile_head_scripts');


#Append scripts to bottom of page
function mobile_after(){
	global $SCRIPTS;
	print "\t".implode("\n\t", $SCRIPTS);
}
add_filter('thematic_after', 'mobile_after');

function mobile_footer(){
	print wp_nav_menu(thematic_nav_menu_args());
}
add_action('wp_footer', 'mobile_footer');


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

function cleanup($content, $indent){
	$prefix = '';
	for ($i = 0; $i < $indent; $i++){
		$prefix .= "\t";
	}
	$lines = explode("\n", $content);
	$lines = array_filter($lines, create_function('$l', 'return (bool)trim($l);'));
	$lines = array_map(create_function('$l,$prefix="'.$prefix.'"', '
		return $prefix.trim($l);
	'), $lines);
	$lines = implode("\n", $lines);
	print "\n".$lines."\n";
}

?>