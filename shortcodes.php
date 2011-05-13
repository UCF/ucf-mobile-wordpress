<?php 

/**
 * Outputs a link for application links (store links), encapsulates tracking
 * code required for the links.
 **/
/*
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
*/

function app_links($attrs) {
	$native_apps = get_posts(array(
		'post_type'		=> get_custom_post_type('NativeApp'),
		'order'			=> 'ASC',
		'orderby'		=> 'menu_order',
		'numberporsts'	=> -1
	));
	
	ob_start(); ?>
	<div id="apps">
		<h3>Native Apps Now Available For:</h3>
		<ul>
		<? foreach($native_apps as $native_app) {
			$image 	= wp_get_attachment_image_src(get_post_thumbnail_id($native_app->ID));
			$url 	= get_post_meta($native_app->ID, 'mobile_native_app_url', True);
			$name 	= get_post_meta($native_app->ID, 'mobile_native_app_name', True);
			?>
			<li class="app-<?=strtolower(get_post_meta($native_app->ID, 'mobile_native_app_name', True))?>">
				<? if(strlen($url) > 0) {?>
				<a 	<?= ($image) ? "style=\"background-image: url($image[0]);\"": '' ?>
					href="<?=$url?>"
					onclick="_gaq.push(['_trackEvent','Mobile_main_menu','Button_click','Download <?=$name?>">
					<?=$name?> <?=get_post_meta($native_app->ID, 'mobile_native_app_url_text', True)?> 
				</a>
				<? } else  { echo $name;} ?>
		<? } ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('app-links', 'app_links');

/**
 * Outputs website feature list
 *
 * @return string
 * @author Chris Conover
 **/
function app_list($attrs) {

	$features   = get_posts(array(
		'post_type'   => get_custom_post_type('FeaturedModule'),
		'order'       => 'ASC',
		'orderby'     => 'menu_order',
		'numberposts' => -1,
	));
	
	ob_start();?>

	<h2>Website Features:</h2>
	<ul>
	<? foreach($features as $feature) {?>
		<li>
			<a href="<?=get_post_meta($feature->ID, 'mobile_feat_module_url', True)?>">
				<?=preg_replace(Array('/width="\d+"/','/height="\d+"/'), '', get_the_post_thumbnail($feature->ID,'', Array('class' => 'icon')))?>
				<span class="heading"><?=get_post_meta($feature->ID, 'mobile_feat_module_heading', True)?></span>
				<span class="description"><?=get_post_meta($feature->ID, 'mobile_feat_module_desc', True)?></span>
				<span class="end"><?=get_post_meta($feature->ID, 'mobile_feat_module_end', True)?></span>
			</a>
		</li>
	
	<?} ?>
	</ul>
	<?php
	return ob_get_clean();
}
add_shortcode('app-list', 'app_list');
?>