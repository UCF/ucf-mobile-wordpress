<?php
	$deans_list = get_posts(array(
		'numberposts' => 1,
		'post_type'   => get_custom_post_type('ProvostForm'),
		'category'    => get_category_by_slug('deans-list')->term_id,
	));
	if (count($deans_list)){
		$deans_list = $deans_list[0];
	}
	$org_chart  = get_posts(array(
		'numberposts' => 1,
		'post_type'   => get_custom_post_type('ProvostForm'),
		'category'    => get_category_by_slug('org-chart')->term_id,
	));
	if (count($org_chart)){
		$org_chart = $org_chart[0];
	}
	
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
	<a href="<?=get_post_meta($org_chart->ID, 'provost_form_url', True)?>">Download PDF <?=$org_chart->post_title?></a>
	<?php display_people($academic_officers, 'academic-officers');?>
	
	<h2>College Deans</h2>
	<a href="<?=get_post_meta($deans_list->ID, 'provost_form_url', True)?>">Download PDF <?=$deans_list->post_title?></a>
	<?php display_people($college_deans, 'college-deans');?>
</div>