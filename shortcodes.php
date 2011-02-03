<?php 

/**
 * undocumented function
 *
 * @return void
 * @author Jared Lang
 **/
function sc_faculty_award_programs($attrs){
	$provost_award_program = new ProvostAwardProgram();
	$programs = get_posts(array(
		'numberposts' => -1,
		'orderby'     => $orderby,
		'order'       => 'ASC',
		'post_type'   => $provost_award_program->options('name'),
	));
	ob_start();
	?>
	
	<div class="faculty-award-programs">
		<h2>Faculty Award Programs</h2>
		<ul class="programs"><?php foreach($programs as $program):?>
			<li><a href="<?=get_post_meta($program->ID, 'provost_award_url', True)?>">
				<?=get_the_post_thumbnail($program->ID)?>
				<span class="caption"><?=$program->post_title?></span>
			</a></li>
		<?php endforeach;?></ul>
		<div class="end"><!-- --></div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('sc-faculty-award-programs', 'sc_faculty_award_programs');
?>