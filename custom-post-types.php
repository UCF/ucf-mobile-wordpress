<?php
/*/ The base abstract ProvostCustomPostType covers a really simple post type,
one that does not require additional fields and metaboxes.  This means that
any object that inherits from this base class can safely ignore most of the
methods defined in it, and if it needs those additional methods it should
simply override and define it's own.

To install a new custom post type, add the class name to the array contained in 
installed_custom_post_types;
/*/


/*/----------------------------------
Custom post types
----------------------------------/*/
abstract class ProvostCustomPostType{
	public 
		$name           = 'provost_custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = False,
		$use_order      = False,
		$use_title      = False;
	
	public function options($key){
		$vars = get_object_vars($this);
		return $vars[$key];
	}
	
	public function fields(){
		return array();
	}
	
	public function supports(){
		#Default support array
		$supports = array();
		if ($this->options('use_title')){
			$supports = array_merge($supports, array('title'));
		}
		if ($this->options('use_order')){
			$supports = array_merge($supports, array('page-attributes'));
		}
		if ($this->options('use_thumbnails')){
			$supports = array_merge($supports, array('thumbnail'));
		}
		if ($this->options('use_editor')){
			$supports = array_merge($supports, array('editor'));
		}
		return $supports;
	}
	
	public function labels(){
		return array(
			'name'          => __($this->options('plural_name')),
			'singular_name' => __($this->options('singular_name')),
			'add_new_item'  => __($this->options('add_new_item')),
			'edit_item'     => __($this->options('edit_item')),
			'new_item'      => __($this->options('new_item')),
		);
	}
	
	public function metabox(){
		return;
	}
	
	public function register_metaboxes(){
		return;
	}
	
	public function register(){
		$registration = array(
			'labels'   => $this->labels(),
			'supports' => $this->supports(),
			'public'   => $this->options('public'),
		);
		if ($this->options('use_order')){
			$regisration = array_merge($registration, array('hierarchical' => True,));
		}
		register_post_type($this->options('name'), $registration);
		if ($this->options('use_categories')){
			register_taxonomy_for_object_type('category', $this->options('name'));
		}
	}
}

abstract class ProvostLink extends ProvostCustomPostType{
	public
		$name           = 'provost_form',
		$plural_name    = 'Forms',
		$singular_name  = 'Form',
		$add_new_item   = 'Add Form',
		$edit_item      = 'Edit Form',
		$new_item       = 'New Form',
		$public         = True,
		$use_title      = True;
	
	public function fields(){
		return array(
			array(
				'name' => __('url'),
				'desc' => __('URL'),
				'id'   => $this->options('name').'_url',
				'type' => 'text',
			),
		);
	}
	
	public function metabox(){
		return array(
			'id'       => $this->options('name').'_metabox',
			'title'    => __('Form Attributes'),
			'page'     => $this->options('name'),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => $this->fields(),
		);
	}
	
	public function register_metaboxes(){
		$metabox = $this->metabox();
		add_meta_box(
			$metabox['id'],
			$metabox['title'],
			'provost_show_meta_boxes',
			$metabox['page'],
			$metabox['context'],
			$metabox['priority']
		);
	}
}


class ProvostHelp extends ProvostLink{
	public
		$name           = 'provost_help',
		$plural_name    = 'Help',
		$singular_name  = 'Help',
		$add_new_item   = 'Add Help',
		$edit_item      = 'Edit Help',
		$new_item       = 'New Help',
		$public         = True;
}


class ProvostForm extends ProvostLink{
	public
		$name           = 'provost_form',
		$plural_name    = 'Forms',
		$singular_name  = 'Form',
		$add_new_item   = 'Add Form',
		$edit_item      = 'Edit Form',
		$new_item       = 'New Form',
		$public         = True,
		$use_categories = True;
}


class ProvostUpdate extends ProvostCustomPostType{
	public
		$name           = 'provost_update',
		$plural_name    = 'Updates',
		$singular_name  = 'Update',
		$add_new_item   = 'Add Update',
		$edit_item      = 'Edit Update',
		$new_item       = 'New Update',
		$public         = True,
		$use_editor     = True,
		$use_title      = True;
}


class ProvostHomeImages extends ProvostCustomPostType{
	public
		$name           = 'provost_home_images',
		$plural_name    = 'Home Images',
		$singular_name  = 'Home Image',
		$add_new_item   = 'Add Home Image',
		$edit_item      = 'Edit Home Image',
		$new_item       = 'New Home Image',
		$public         = True,
		$use_thumbnails = True,
		$use_title      = True;
	
	public function metabox(){
		return array(
			'id'       => $this->options('name').'_metabox',
			'title'    => __($this->options('singular_name').' Attributes'),
			'page'     => $this->options('name'),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => $this->fields(),
		);
	}
	
	public function register_metaboxes(){
		$metabox = $this->metabox();
		
		global $wp_meta_boxes;
		remove_meta_box('postimagediv', $metabox['page'], 'side');
		add_meta_box('postimagediv', __('Home Image'), 'post_thumbnail_meta_box', $metabox['page'], 'normal', 'high');
	}
}

class ProvostPerson extends ProvostCustomPostType{
	public
		$name           = 'provost_person',
		$plural_name    = 'People',
		$singular_name  = 'Person',
		$add_new_item   = 'Add Person',
		$edit_item      = 'Edit Person',
		$new_item       = 'New Person',
		$public         = True,
		$use_categories = True,
		$use_order      = True,
		$use_title      = True;
	
	public function fields(){
		return array(
			array(
				'name' => __('Description'),
				'desc' => __('Position, title, etc.'),
				'id'   => $this->options('name').'_description',
				'type' => 'text',
			),
		);
	}
	
	public function metabox(){
		return array(
			'id'       => $this->options('name').'_metabox',
			'title'    => __('Person Attributes'),
			'page'     => $this->options('name'),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => $this->fields(),
		);
	}
	
	public function register_metaboxes(){
		$metabox = $this->metabox();
		
		global $wp_meta_boxes;
		remove_meta_box('postimagediv', $metabox['page'], 'side');
		add_meta_box('postimagediv', __('Person Image'), 'post_thumbnail_meta_box', $metabox['page'], 'normal', 'high');
		
		add_meta_box(
			$metabox['id'],
			$metabox['title'],
			'provost_show_meta_boxes',
			$metabox['page'],
			$metabox['context'],
			$metabox['priority']
		);
	}
}


class ProvostUnit extends ProvostCustomPostType{
	public
		$name           = 'provost_unit',
		$plural_name    = 'Colleges/Units',
		$singular_name  = 'College/Unit',
		$add_new_item   = 'Add College/Unit',
		$edit_item      = 'Edit College/Unit',
		$new_item       = 'New College/Unit',
		$public         = True,
		$use_categories = True,
		$use_thumbnails = True,
		$use_title      = True;
		
	public function fields(){
		return array(
			array(
				'name' => __('URL'),
				'desc' => __('Web address of the college/unit'),
				'id'   => $this->options('name').'_url',
				'type' => 'text',
			),
		);
	}
	
	public function metabox(){
		return array(
			'id'       => $this->options('name').'_metabox',
			'title'    => __('College or Unit Attributes'),
			'page'     => $this->options('name'),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => $this->fields(),
		);
	}
	
	public function register_metaboxes(){
		$metabox = $this->metabox();
		add_meta_box(
			$metabox['id'],
			$metabox['title'],
			'provost_show_meta_boxes',
			$metabox['page'],
			$metabox['context'],
			$metabox['priority']
		);
		
		global $wp_meta_boxes;
		remove_meta_box('postimagediv', $metabox['page'], 'side');
		add_meta_box('postimagediv', __('College or Unit Image'), 'post_thumbnail_meta_box', $metabox['page'], 'normal', 'high');
	}
}


/*/-------------------------------------
Register custom post types and functions for display
-------------------------------------/*/
function installed_custom_post_types(){
	$installed = array(
		'ProvostUnit',
		'ProvostPerson',
		'ProvostUpdate',
		'ProvostHomeImages',
		'ProvostForm',
		'ProvostHelp',
	);
	
	return array_map(create_function('$class', '
		return new $class;
	'), $installed);
}


/**
 * Registers all installed custom post types
 *
 * @return void
 * @author Jared Lang
 **/
function provost_post_types(){
	#Register custom post types
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register();
	}
	
	#This ensures that the permalinks for custom posts work
	flush_rewrite_rules();
	
	#Override default page post type to use categories
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'provost_post_types');


/**
 * Registers all metaboxes for install custom post types
 *
 * @return void
 * @author Jared Lang
 **/
function provost_meta_boxes(){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register_metaboxes();
	}
}
add_action('do_meta_boxes', 'provost_meta_boxes');


/**
 * Saves the data for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function provost_save_meta_data($post){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		if (get_post_type($post) == $custom_post_type->options('name')){
			$meta_box = $custom_post_type->metabox();
			break;
		}
	}
	
	return _save_meta_data($post, $meta_box);
	
}
add_action('save_post', 'provost_save_meta_data');


/**
 * Displays the metaboxes for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function provost_show_meta_boxes($post){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		if (get_post_type($post) == $custom_post_type->options('name')){
			$meta_box = $custom_post_type->metabox();
			break;
		}
	}
	
	return _show_meta_boxes($post, $meta_box);
}

/**
 * Handles saving a custom post as well as it's custom fields and metadata.
 *
 * @return void
 * @author Jared Lang
 **/
function _save_meta_data($post_id, $meta_box){
	// verify nonce
	if (!wp_verify_nonce($_POST['provost_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

/**
 * Outputs the html for the fields defined for a given post and metabox.
 *
 * @return void
 * @author Jared Lang
 **/
function _show_meta_boxes($post, $meta_box){
	// Use nonce for verification
	echo '<input type="hidden" name="provost_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';
	
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
	
		echo '<tr>',
			'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
			'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', "\n", $field['desc'];
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', "\n", $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $k=>$option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', ' value="', $k, '">', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}
		echo     '<td>',
		'</tr>';
	}
	
	echo '</table>';
	
	if($meta_box['helptxt']) echo '<p style="font-size:13px; padding:5px 0; color:#666;">' . $meta_box['helptxt'] . "</p>";
}
?>