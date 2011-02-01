<?php disallow_direct_load('comments.php');?>

<?php $req = get_option('require_name_email'); // Checks if fields are required.?>
<?php $just_commented = user_just_commented($comments, 10);?>

<?php if($just_commented):?>
<p class="message">Thank you for your feedback.</p>
<?php endif;?>

<form id="comment-form" action="<?=site_url('/wp-comments-post.php')?>" method="post">
	<?php if(!$user_ID):?>
	<div id="form-section-author" class="form-section">
		<div class="form-label"><label for="author"><?php _e('Name', 'thematic') ?></label> <?php if ($req):?><span class="required">required</span><?php else:?><span class="optional">optional</span><?php endif;?></div>
		<div class="form-input"><input id="author" name="author" type="text" placeholder="John Doe" size="30" maxlength="20" tabindex="3" /></div>
	</div><!-- #form-section-author .form-section -->
	
	<div id="form-section-email" class="form-section">
		<div class="form-label"><label for="email"><?php _e('Email', 'thematic') ?></label> <?php if ($req):?><span class="required">required</span><?php else:?><span class="optional">optional</span><?php endif;?></div>
		<div class="form-input"><input id="email" name="email" type="text" placeholder="example@email.com" size="30" maxlength="50" tabindex="4" /></div>
	</div><!-- #form-section-email .form-section -->
	<?php endif;?>
	
	<div id="form-section-comment" class="form-section">
		<div class="form-label"><label for="comment"><?php _e(thematic_commentbox_text(), 'thematic') ?></label></div>
		<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>
	</div><!-- #form-section-comment .form-section -->
	
	<?php do_action('comment_form', $post->id);?>
	<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e(thematic_commentbutton_text(), 'thematic') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>
	<?php comment_id_fields(); ?>    
</form>