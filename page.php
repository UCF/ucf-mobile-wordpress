<?php get_header(); the_post(); ob_start();?>
<div id="content" class="span-24 last">
	<!-- Pull in post content -->
	<?php the_content();?>
</div>
<?php cleanup(ob_get_clean(), 3); get_footer();?>