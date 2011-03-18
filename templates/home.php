<?php get_header(); the_post(); ob_start();?>
<div id="content" class="span-24 last">
	<div id="left" class="span-8 append-2">
		<!-- Pull in post content -->
		<?php the_content();?>
	</div>
	<div id="right" class="span-14 last">
		<!-- Pull in custom post type, app images -->
		<?php
		$images   = get_posts(array(
			'post_type'   => get_custom_post_type('AppImage'),
			'order'       => 'ASC',
			'orderby'     => 'menu_order',
			'numberposts' => -1,
		));
		$rows = array();
		$row  = 0;
		foreach($images as $image){
			if ($count == 2){
				$row++;
				$count = 0;
			}
			$rows[$row][] = $image;
			$count++;
		}?>
		<?php foreach($rows as $row):?>
		<div class="span-14 last row">
			<?php foreach($row as $last=>$image):?>
			<div class="span-7 col<?=($last)?' last':''?>">
				<?=get_the_post_thumbnail($image->ID)?>
				<div class="caption"><?=get_post_meta($image->ID, 'mobile_app_image_caption', True)?></div>
			</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>
</div>
<?php cleanup(ob_get_clean(), 3); get_footer();?>