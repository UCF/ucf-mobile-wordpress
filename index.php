<?php if (function_exists('disallow_direct_load')):?>
<?php disallow_direct_load('index.php');?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>
<?php endif;?>