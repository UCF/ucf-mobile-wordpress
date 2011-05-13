<?php
/*/ The base abstract CustomPostType covers a really simple post type,
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
abstract class CustomPostType{
	public 
		$name           = 'mobile_custom_post_type', # Must be 20 characters or less
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
		$use_title      = False,
		$use_metabox    = False;
	
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
		if ($this->options('use_metabox')){
			return array(
				'id'       => $this->options('name').'_metabox',
				'title'    => __($this->options('singular_name').' Attributes'),
				'page'     => $this->options('name'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => $this->fields(),
			);
		}
		return null;
	}
	
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				'mobile_show_meta_boxes',
				$metabox['page'],
				$metabox['context'],
				$metabox['priority']
			);
		}
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


class NativeApp extends CustomPostType{
	public
		$name           = 'mobile_native_app',
		$plural_name    = 'Native Apps',
		$singular_name  = 'Native App',
		$add_new_item   = 'Add Native App',
		$edit_item      = 'Edit Native App',
		$new_item       = 'New Native App',
		$public         = True,
		$use_thumbnails = True,
		$use_metabox    = True,
		$use_title      = True;
	
	public function fields(){
		return array(
			array(
				'name' 	=> __('Name'),
				'desc' 	=> __('Application Name - Used for Google Analytics hook. Concatenated with the `Link Text` field to form the final link string.'),
				'id'	=> $this->options('name').'_name',
				'type'	=> 'text'
			),
			array(
				'name' => __('Link URL'),
				'desc' => __('Application URL - If left blank, only the `Name` field will be rendered in the LI (no anchor tag).'),
				'id'   => $this->options('name').'_url',
				'type' => 'text',
			),
			array(
				'name' 	=> __('Link Text'),
				'desc' 	=> __('Application Link Text'),
				'id'	=> $this->options('name').'_url_text',
				'type'	=> 'text'
			)
		);
	}
}

class AppImage extends CustomPostType{
	public
		$name           = 'mobile_app_image',
		$plural_name    = 'App Images',
		$singular_name  = 'App Image',
		$add_new_item   = 'Add App Image',
		$edit_item      = 'Edit App Image',
		$new_item       = 'New App Image',
		$public         = True,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;
	
	public function fields(){
		return array(
			array(
				'name' => __('Caption'),
				'desc' => __('Image Caption'),
				'id'   => $this->options('name').'_caption',
				'type' => 'text',
			),
		);
	}
}

class FeaturedModule extends CustomPostType{
	public
		$name			= 'mobile_feat_module',
		$plural_name 	= 'Featured Modules',
		$singular_name	= 'Featured Module',
		$add_new_item	= 'Add Featured Module',
		$edit_item		= 'Edit Featured Module',
		$new_item		= 'New Featured Module',
		$public         = True,
		$use_thumbnails = True,
		$use_order      = True,
		$use_title      = True,
		$use_metabox    = True;

	public function fields(){
		return array(
			array(
				'name' 	=> __('URL'),
				'desc'	=> __('Link URL'),
				'id'	=> $this->options('name').'_url',
				'type'	=> 'text'				
			),
			array(
				'name' 	=> __('Heading'),
				'desc' 	=> __('Heading Text'),
				'id'	=> $this->options('name').'_heading',
				'type'	=> 'text'	
			),
			array(
				'name' 	=> __('Description'),
				'desc' 	=> __('Description Text'),
				'id'	=> $this->options('name').'_desc',
				'type'	=> 'text'	
			),
			array(
				'name' 	=> __('End'),
				'desc' 	=> __('End Text'),
				'id'	=> $this->options('name').'_end',
				'type'	=> 'text'	
			),
		);		
	}
}

/*/-------------------------------------
Register custom post types and functions for display
-------------------------------------/*/
function installed_custom_post_types(){
	$installed = array('NativeApp', 'AppImage', 'FeaturedModule');
	
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
function mobile_post_types(){
	#Register custom post types
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register();
	}
	
	#This ensures that the permalinks for custom posts work
	flush_rewrite_rules();
	
	#Override default page post type to use categories
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'mobile_post_types');


/**
 * Registers all metaboxes for install custom post types
 *
 * @return void
 * @author Jared Lang
 **/
function mobile_meta_boxes(){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		$custom_post_type->register_metaboxes();
	}
}
add_action('do_meta_boxes', 'mobile_meta_boxes');


/**
 * Saves the data for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function mobile_save_meta_data($post){
	#Register custom post types metaboxes
	foreach(installed_custom_post_types() as $custom_post_type){
		if (get_post_type($post) == $custom_post_type->options('name')){
			$meta_box = $custom_post_type->metabox();
			break;
		}
	}
	
	return _save_meta_data($post, $meta_box);
	
}
add_action('save_post', 'mobile_save_meta_data');


/**
 * Displays the metaboxes for a given post type
 *
 * @return void
 * @author Jared Lang
 **/
function mobile_show_meta_boxes($post){
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
	if (!wp_verify_nonce($_POST['mobile_meta_box_nonce'], basename(__FILE__))) {
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
	echo '<input type="hidden" name="mobile_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
	
		echo '<tr>',
			'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
			'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', htmlentities($meta ? $meta : $field['std']), '" size="30" style="width:97%" />', "\n", $field['desc'];
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