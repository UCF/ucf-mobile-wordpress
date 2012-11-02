<?php

/**
 * Create a javascript slideshow of each top level element in the
 * shortcode.  All attributes are optional, but may default to less than ideal
 * values.  Available attributes:
 * 
 * height     => css height of the outputted slideshow, ex. height="100px"
 * width      => css width of the outputted slideshow, ex. width="100%"
 * transition => length of transition in milliseconds, ex. transition="1000"
 * cycle      => length of each cycle in milliseconds, ex cycle="5000"
 * animation  => The animation type, one of: 'slide' or 'fade'
 *
 * Example:
 * [slideshow height="500px" transition="500" cycle="2000"]
 * <img src="http://some.image.com" .../>
 * <div class="robots">Robots are coming!</div>
 * <p>I'm a slide!</p>
 * [/slideshow]
 **/
function sc_slideshow($attr, $content=null){
	$content = cleanup(str_replace('<br />', '', $content));
	$content = DOMDocument::loadHTML($content);
	$html    = $content->childNodes->item(1);
	$body    = $html->childNodes->item(0);
	$content = $body->childNodes;
	
	# Find top level elements and add appropriate class
	$items = array();
	foreach($content as $item){
		if ($item->nodeName != '#text'){
			$classes   = explode(' ', $item->getAttribute('class'));
			$classes[] = 'slide';
			$item->setAttribute('class', implode(' ', $classes));
			$items[] = $item->ownerDocument->saveXML($item);
		}
	}
	
	$animation = ($attr['animation']) ? $attr['animation'] : 'slide';
	$height    = ($attr['height']) ? $attr['height'] : '100px';
	$width     = ($attr['width']) ? $attr['width'] : '100%';
	$tran_len  = ($attr['transition']) ? $attr['transition'] : 1000;
	$cycle_len = ($attr['cycle']) ? $attr['cycle'] : 5000;
	
	ob_start();
	?>
	<div 
		class="slideshow <?=$animation?>"
		data-tranlen="<?=$tran_len?>"
		data-cyclelen="<?=$cycle_len?>"
		style="height: <?=$height?>; width: <?=$width?>;"
	>
		<?php foreach($items as $item):?>
		<?=$item?>
		<?php endforeach;?>
	</div>
	<?php
	$html = ob_get_clean();
	
	return $html;
}
add_shortcode('slideshow', 'sc_slideshow');


/**
 * Outputs search form.
 **/
function sc_search_form() {
	ob_start();
	?>
	<div class="search">
		<?get_search_form()?>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('search_form', 'sc_search_form');


/**
 * Outputs a link for application links (store links), encapsulates tracking
 * code required for the links.
 **/
function sc_app_link($attrs, $content){
	$app = @$attrs['app'];
	
	if (!$app){return 'No application was defined to display a link for.';}
	$link = get_page_by_title($app, OBJECT, 'mobile_native_app');
	
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
add_shortcode('app-link', 'sc_app_link');


/**
 * Outputs list of all available native apps.
 **/
function sc_app_links($attrs) {
	$native_apps = get_posts(array(
		'post_type'		=> 'mobile_native_app',
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
					onclick="_gaq.push(['_trackEvent','Mobile_main_menu','Button_click','Download <?=$name?>'])">
					<?=$name?> <?=get_post_meta($native_app->ID, 'mobile_native_app_url_text', True)?> 
				</a>
				<? } else  { echo $name;} ?>
		<? } ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('app-links', 'sc_app_links');


/**
 * Outputs website feature list
 *
 * @return string
 * @author Chris Conover
 **/
function sc_app_list($attrs) {

	$features   = get_posts(array(
		'post_type'   => 'mobile_feat_module',
		'order'       => 'ASC',
		'orderby'     => 'menu_order',
		'numberposts' => -1,
	));
	
	ob_start();?>

	<h2>Website Features:</h2>
	<div id="home-features">
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
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('app-list', 'sc_app_list');

?>