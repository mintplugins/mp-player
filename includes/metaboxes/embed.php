<?php
/**
 * Function which creates new Meta Box
 *
 */
function mp_player_embed_create_meta_box(){	
	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_player_embed_add_meta_box = array(
		'metabox_id' => 'mp_player_embed_metabox', 
		'metabox_title' => __( 'Embed Player', 'mp_player'), 
		'metabox_posttype' => 'mp_player', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'high' 
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_player_embed_items_array = array(
		array(
			'field_id'			=> 'embed_height',
			'field_title' 	=> __( 'Height of Player', 'mp_player'),
			'field_description' 	=> 'If your player looks cut off below, add more to the height of it here. NOTE: You must update the post to preview the change.',
			'field_type' 	=> 'number',
			'field_value' => '100',
		),
		
		array(
			'field_id'			=> 'preview_player',
			'field_title' 	=> __( 'Preview Player', 'mp_player'),
			'field_description' 	=> '',
			'field_type' 	=> 'basictext',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'embed_code',
			'field_title' 	=> __( 'Embed Code (Copy and Paste)', 'mp_player'),
			'field_description' 	=> '',
			'field_type' 	=> 'basictext',
			'field_value' => '',
		),
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_player_embed_add_meta_box = has_filter('mp_player_embed_meta_box_array') ? apply_filters( 'mp_player_embed_meta_box_array', $mp_player_embed_add_meta_box) : $mp_player_embed_add_meta_box;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_player_embed_items_array = has_filter('mp_player_embed_items_array') ? apply_filters( 'mp_player_embed_items_array', $mp_player_embed_items_array) : $mp_player_embed_items_array;
	
	
	/**
	 * Create Metabox class
	 */
	global $mp_player_embed_meta_box;
	$mp_player_embed_meta_box = new MP_CORE_Metabox($mp_player_embed_add_meta_box, $mp_player_embed_items_array);
}
add_action('plugins_loaded', 'mp_player_embed_create_meta_box');

/**
 * Create filter to set the description to be the embed info for the jplayer. 
 * We do it in a filter because it makes the post_id available to us
 */ 
function mp_player_embed_set_embed_code($description, $post_id){
	
	//Get this repeater set
	$repeater_data = get_post_meta($post_id, 'jplayer', true);
	
	//Check if there is anything in the repater set
	if (!empty($repeater_data)){
		//Get embed page URL - created upon activation and has shortcode to show player inside
		$embed_page_permalink = get_permalink( get_option('mp_player_embed_page_id') );
		
		//Get user set height for this player
		$embed_height = get_post_meta($post_id, 'embed_height', true);
		$embed_height = !empty($embed_height) ? $embed_height : '100';
		
		//Set output for the description to display the embed code for the jplayer
		$description = '<br /><br />';
		$description .= '<textarea style="width: 766px; height: 41px;">';
		$description .= '<iframe id="mp_player_embed_' . $post_id . '" width="100%" height="' . $embed_height . 'px" src="' . get_permalink($post_id) . '?jplayer_embed=true" frameborder="0" allowfullscreen></iframe>';
		$description .= '</textarea>'; 
	}else{
		//Set output for the description to display the embed code for the jplayer
		$description = '<br /><br />';
		$description .= 'Add some data to preview the player';	
	}
	
	//Return the description
	return $description;
}
add_filter('mp_embed_code_description', 'mp_player_embed_set_embed_code', 10, 2);

/**
 * Create filter to set the description to be the preview for the jplayer. 
 * We do it in a filter because it makes the post_id available to us
 */ 
function mp_player_embed_set_preview_code($description, $post_id){
	
	//Get this repeater set
	$repeater_data = get_post_meta($post_id, 'jplayer', true);
	
	//Check if there is anything in the repater set
	if (!empty($repeater_data)){
		
		//Get user set height for this player
		$embed_height = get_post_meta($post_id, 'embed_height', true);
		$embed_height = !empty($embed_height) ? $embed_height : '100';
		
		//Set output for the description to display the embed code for the jplayer
		$description = '<br /><br />';
		$description .= '<iframe id="mp_player_embed_' . $post_id . '" width="560px" height="' . $embed_height . 'px" src="' . get_permalink($post_id) . '?jplayer_embed=true" frameborder="0" allowfullscreen></iframe>';
	}
	else{
		//Set output for the description to display the embed code for the jplayer
		$description = '<br /><br />';
		$description .= 'Add some data to preview the player';	
	}
		
	//Return the description
	return $description;
}
add_filter('mp_preview_player_description', 'mp_player_embed_set_preview_code', 10, 2);


