<?php get_header();?>
	
	<div id="home">
		<div id="top" class="span-24 last">
			<div class="span-9">
				<!-- Provost Quote/Marketing -->
				<div id="quote">
					<?php the_content()?>
				</div>
				
				<!-- News and Announcement Posts -->
				<div id="announcements">
					<ul>
						<?php foreach(get_posts(array(
							'numberposts' => 3,
							'orderby'     => 'date',
							'order'       => 'DESC',
							'post_type'   => 'post',
							'category'    => get_category_by_slug('announcements')->term_id,
						)) as $post):?>
						<li><a href="<?=get_page_link($post->ID)?>"><?=$post->post_title?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				
				<div id="help">
					<?php $help = get_posts(array(
						'numberposts' => -1,
						'orderby'     => 'title',
						'order'       => 'ASC',
						'post_type'   => get_custom_post_type('ProvostHelp'),
					));?>
					<label for="help-select">Need Help Finding:</label>
					<select id="help-select" class="select-links">
						<option value="null" selected="selected">(Select a Topic)</option>
						<?php foreach($help as $link):?>
						<option value="<?=get_post_meta($link->ID, 'provost_help_url', True)?>"><?=$link->post_title?></option>
						<?php endforeach;?>
					</select>
				</div>
				
				<div id="search">
					<?php get_search_form();?>
				</div>
			</div>
			<div class="span-15 last">
				<!-- Slideshow-->
				<?php $gallery = get_home_images();?>
				<?php if ($gallery):?>
				<div class="slideshow">
					<?=$gallery?>
				</div>
				<?php endif;?>
			</div>
		</div>
		
		<div id="middle" class="span-24 last">
			<ul>
			<?php foreach(get_menu_pages('home-menu') as $i=>$page):$last=!(($i + 1) % 4);?>
				<li class="span-6<?=($last)?' last':'';?>"><a href="<?=get_page_link($page->ID)?>">
					<?=get_the_post_thumbnail($page->ID)?>
					<span class="title"><?=$page->post_title?></span>
				</a></li>
			<?php endforeach;?>
			</ul>
		</div>
		
		<div id="bottom" class="span-24 last">
			<h2 class="span-24 last">Reporting to the Provost</h2>

			<div id="links" class="span-18 border">
				<!-- Colleges-->
				<div id="home-colleges" class="span-9 append-1">
					<h3>Colleges</h3>
					<ul>
						<?php foreach(get_posts(array(
							'numberposts' => -1,
							'orderby'     => 'post_title',
							'order'       => 'ASC',
							'post_type'   => get_custom_post_type('ProvostUnit'),
							'category'    => get_category_by_slug('college')->term_id,
						)) as $i=>$college): $last=!(($i + 1)  % 3);?>
							<li class="college span-3<?=($last)?' last':'';?>">
								<a href="<?=get_post_meta($college->ID, 'provost_unit_url', True)?>">
									<?=get_the_post_thumbnail($college->ID)?>
									<span class="name"><?=$college->post_title?></span>
								</a>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
				
				<!-- Academic Units-->
				<div id="home-units" class="span-6 last">
					<h3>Academic Affairs Units</h3>
					<ul>
						<?php foreach(get_posts(array(
							'numberposts' => -1,
							'orderby'     => 'post_title',
							'order'       => 'ASC',
							'post_type'   => get_custom_post_type('ProvostUnit'),
							'category'    => get_category_by_slug('academic-unit')->term_id,
						)) as $i=>$unit): $last=!(($i + 1)  % 2);?>
							<li class="unit span-3<?=($last)?' last':'';?>">
								<a href="<?=get_post_meta($unit->ID, 'provost_unit_url', True)?>">
									<?=get_the_post_thumbnail($unit->ID)?>
									<span class="name"><?=$unit->post_title?></span>
								</a>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<div id="widgets" class="prepend-1 span-5 last">
				<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('primary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
			
		</div>
	</div>
	
<?php get_footer();?>