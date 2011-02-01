<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="<?=$post->post_name?>">
		<h2 class="span-24 last"><?php the_title();?></h2>
		
		<div id="left" class="span-6 append-1">
			
			<!-- Sub-page List-->
			<?php $children = get_pages(array(
				'child_of'    => $post->ID,
				'parent'      => $post->ID,
				'sort_column' => 'menu_order',
			));
			?>
			<?php if ($children):?>
			<div id="sub-pages">
				<ul>
					<?php foreach($children as $page):?>
					<li><a href="<?=get_permalink($page->ID)?>"><?=$page->post_title?></a></li>
					<?php endforeach;?>
				</ul>
			</div>
			<?php endif;?>
			
			<div id="widgets">
				<ul>
				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('secondary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
		</div>
		<div id="right" class="span-17 last">
			<article>
				<?php the_content();?>
			</article>
		</div>
		
	</div>

<?php get_footer();?>