<?php
	$provost_forms = new ProvostForm();
	$categories    = get_categories(array(
		'orderby' => 'name',
		'order'   => 'ASC',
		'parent'  => get_category_by_slug('forms')->term_id,
	));
	
?>

<div id="forms-policies-procedures">
	<?php foreach($categories as $category):?>
	<h3><?=$category->name?></h3>
	<ul class="form-list">
		<?php
			$forms = get_posts(array(
				'numberposts' => -1,
				'orderby'     => 'title',
				'order'       => 'ASC',
				'post_type'   => get_custom_post_type('ProvostForm'),
				'category'    => $category->term_id,
			));
		?>
		<?php foreach($forms as $form):?>
		<li class="pdf">
			<a href="<?=get_post_meta($form->ID, $provost_forms->options('name').'_url')?>"><?=$form->post_title?></a>
		</li>
		<?php endforeach;?>
	</ul>
	<?php endforeach;?>
</div>