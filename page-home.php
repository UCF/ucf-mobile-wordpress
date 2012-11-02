<?php if (function_exists('disallow_direct_load')):?>
<?php disallow_direct_load('page-home.php');?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span4">
			<article>
				<!-- Pull in post content -->
				<?php the_content();?>
			</article>
		</div>
		<div class="span8">
			<!-- Pull in custom post type, app images -->
			<?php
			$images   = get_posts(array(
				'post_type'   => 'mobile_app_image',
				'order'       => 'ASC',
				'orderby'     => 'menu_order',
				'numberposts' => -1,
			));			
			
			$row_size = 2;
			$count = 0;
			foreach($images as $image) {

				if( ($count % $row_size) == 0) {
					if($count > 0) {
						?></div><?
					}
					?><div class="row"><?
				}

				?>
						<div class="mobile-app-image">
							<?=get_the_post_thumbnail($image->ID)?>
							<p class="caption"><?=get_post_meta($image->ID, 'mobile_app_image_caption', True)?></p>
						</div>
				<?
				$count++;
			}
			?>
				</div><!-- .row -->
			</div><!-- .span8 -->
		
	</div><!-- .row -->
<?php get_footer();?>
<?php endif;?>