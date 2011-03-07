<?php get_header(); the_post();?>
<div id="content" class="span-24 last">
	<!-- Pull in post content -->
	<?php the_content();?>
</div>
<?php get_footer();?>