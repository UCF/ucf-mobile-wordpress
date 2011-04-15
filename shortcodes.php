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
	switch(@$attrs['mode']){
		default:
		case 'prod':
			$mobile_domain = "http://mobile.ucf.edu";
			$mobile_path   = "/";
			break;
		case 'qa':
			$mobile_domain = "http://mobile.qa.smca.ucf.edu";
			$mobile_path   = "/";
			break;
		case 'dev':
			$mobile_domain = "http://mobile.dev.smca.ucf.edu";
			$mobile_path   = "/";
			break;
		case 'webcom':
			$mobile_domain = "http://webcom.dev.smca.ucf.edu";
			$mobile_path   = "/harvard-mobile";
			break;
	}
	$mobile_home = $mobile_domain.$mobile_path."/home";
	$user_agent  = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16";
	$cache_key   = md5($mobile_home);
	
	$context = stream_context_create(array(
		'http' => array(
			'method'     => 'GET',
			'user_agent' => $user_agent,
			'timeout'    => 10,
		),
	));
	
	$html = get_transient($cache_key);
	if (True){#}$html === False){
		# Get home page html
		$failed = False;
		$html   = file_get_contents($mobile_home, False, $context);
		
		if (!$html){
			$failed = True;
			$html   = "<p>Failed to load menu.</p>";
		}
		
		# Find home module html code
		$find = '/<div id="Home">[\s]+<ul>.*<\/ul>[\s]+<\/div>/s';
		if (preg_match($find, $html, $match)){
			$html = $match[0];
		}else{
			$failed = True;
		}
	
		# Replace relative links with absolute
		var_dump($mobile_path, $mobile_domain);
		$html = str_replace(
			array('href="'.$mobile_path, 'src="'.$mobile_path),
			array('href="'.$mobile_domain.$mobile_path, 'src="'.$mobile_domain.$mobile_path),
			$html
		);
		
		if (!$failed){
			set_transient($cache_key, $html, 86400);
		}
	}
	
	ob_start();?>
	
	<h2>Website Features:</h2>
	<?=$html?>
	<?php
	return ob_get_clean();
}
add_shortcode('app-list', 'app_list');

?>