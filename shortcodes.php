<?php 

/**
 * Outputs a link for application links (store links), encapsulates tracking
 * code required for the links.
 **/
function app_link($attrs, $content){
	$app = @$attrs['app'];
	
	if (!$app){return 'No application was defined to display a link for.';}
	$link = get_page_by_title($app, OBJECT, get_custom_post_type('NativeApp'));
	
	if (!$link)   {return 'No application found for label '.$app;}
	if (!$content){$content = $app;}
	
	$image = get_the_post_thumbnail($link->ID);
	if (preg_match('/src="([^"]+)"/', $image, $match)){
		$background = $match[1];
	}else{
		$background = null;
	}
	
	ob_start();?>
	<a
		<?=($background) ? "style=\"background-image: url($background)\"": ''?>
		href="<?=get_post_meta($link->ID, 'mobile_native_app_url', True)?>"
		onclick="_gaq.push(['_trackEvent','Mobile_main_menu','Button_click','Download <?=$app?>'])">
			<?=$content?>
	</a>
	<?php return ob_get_clean();
}
add_shortcode('app-link', 'app_link');


/**
 * Outputs the mobile menu.
 *
 * @return string
 * @author Jared Lang
 **/
function app_list($attrs){
	$cache_key     = 'mobile_modules';
	switch(@$attrs['mode']){
		default:
		case 'prod':
			$mobile_domain = "http://mobile.ucf.edu";
			break;
		case 'qa':
			$mobile_domain = "http://mobile.qa.smca.ucf.edu";
			break;
		case 'dev':
			$mobile_domain = "http://webcom.dev.smca.ucf.edu/harvard-mobile/home";
			break;
	}
	$mobile_home   = $mobile_domain."/home";
	$user_agent    = $_SERVER['HTTP_USER_AGENT'];
	
	$context = stream_context_create(array(
		'http' => array(
			'method'     => 'GET',
			'user_agent' => $user_agent,
			'timeout'    => 3,
		),
	));
	
	$html = get_transient($cache_key);
	if ($html === False){
		# Get home page html
		$html = file_get_contents($mobile_home, False, $context);
	
		# Find home module html code
		$find = '/<div id="Home">[\s]+<ul>.*<\/ul>[\s]+<\/div>/s';
		if (preg_match($find, $html, $match)){
			$html = $match[0];
		}
	
		# Replace relative links with absolute
		$html = str_replace(
			array('href="/', 'src="/'),
			array('href="'.$mobile_domain.'/', 'src="'.$mobile_domain.'/'),
			$html
		);
		set_transient($cache_key, $html, 86400);
	}
	
	ob_start();?>
	
	<h2>Website Features:</h2>
	<?=$html?>
	<?php
	return ob_get_clean();
}
add_shortcode('app-list', 'app_list');

?>