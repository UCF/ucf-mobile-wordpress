<?php
	$college_deans = get_posts(array(
		'numberposts' => -1,
		'post_type'   => get_custom_post_type('ProvostPerson'),
		'category'    => get_category_by_slug('college-deans')->term_id,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	));
	$academic_officers = get_posts(array(
		'numberposts' => -1,
		'post_type'   => get_custom_post_type('ProvostPerson'),
		'category'    => get_category_by_slug('academic-officers')->term_id,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	));
	
	function display_people($people, $id=null){
		?>
		
		<ul class="people"<?php if($id):?> id="<?=$id?>"<?php endif;?>>
		<?php foreach($people as $person):?>
			<li class="person">
				<?=get_the_post_thumbnail($person->ID)?>
				<span class="name"><?=str_replace('', '&nbsp;', $person->post_title)?></span>
				<span class="description"><?=get_post_meta($person->ID, 'provost_person_description', True)?></span>
			</li>
		<?php endforeach;?>
		</ul>
		<div class="end"><!-- --></div>
		<?php
	}
?>
<div id="org-chart">
	<h2>Academic Affairs Organizational Structure</h2>
	<a href="#">Download PDF Org Chart</a>
	<?php display_people($academic_officers, 'academic-officers');?>
	
	<h2>College Deans</h2>
	<?php display_people($college_deans, 'college-deans');?>
</div>