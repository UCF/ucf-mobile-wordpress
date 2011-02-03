<?php
	$updates = get_posts(array(
		'numberposts' => -1,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => get_custom_post_type('ProvostUpdate'),
	));
?>
<?php if($updates):?>
<ul>
<?php foreach($updates as $update):?>
	<li><a href="<?=get_permalink($update->ID)?>" target="_blank"><?=$update->post_title?></a></li>
<?php endforeach;?>
</ul>
<?php else:?>
<p>No updates available.</p>
<?php endif;?>