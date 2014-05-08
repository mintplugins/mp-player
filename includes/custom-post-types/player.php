<?php
/**
 * Custom Post Types
 *
 * @package mp_player
 * @since mp_player 1.0
 */

/**
 * MP Player Custom Post Type
 */
function mp_player_post_type() {
	
	if (mp_core_get_option( 'mp_player_settings_general',  'enable_disable' ) != 'disabled' ){
		$slide_labels =  apply_filters( 'mp_player_slide_labels', array(
			'name' 				=> 'MP Players',
			'singular_name' 	=> 'MP Player Item',
			'add_new' 			=> __('Add New', 'mp_player'),
			'add_new_item' 		=> __('Add New MP Player', 'mp_player'),
			'edit_item' 		=> __('Edit MP Player', 'mp_player'),
			'new_item' 			=> __('New MP Player', 'mp_player'),
			'all_items' 		=> __('All MP Players', 'mp_player'),
			'view_item' 		=> __('View MP Players', 'mp_player'),
			'search_items' 		=> __('Search MP Players', 'mp_player'),
			'not_found' 		=>  __('No MP Players found', 'mp_player'),
			'not_found_in_trash'=> __('No MP Players found in Trash', 'mp_player'), 
			'parent_item_colon' => '',
			'menu_name' 		=> __('MP Players', 'mp_player')
		) );
		
			
		$slide_args = array(
			'labels' 			=> $slide_labels,
			'public' 			=> true,
			'publicly_queryable'=> true,
			'show_ui' 			=> true, 
			'show_in_menu' 		=> true, 
			'show_in_nav_menus' => false,
			'menu_position'		=> 5,
			'query_var' 		=> true,
			'rewrite' 			=> array( 'slug' => 'mp-player' ),
			'capability_type' 	=> 'post',
			'has_archive' 		=> true, 
			'hierarchical' 		=> false,
			'supports' 			=> apply_filters('mp_player_slide_supports', array( 'title' ) ),
		); 
		register_post_type( 'mp_player', apply_filters( 'mp_player_slide_post_type_args', $slide_args ) );
	}
}
add_action( 'init', 'mp_player_post_type', 0 );

/**
 * MP Player Taxonomy
 */
 
 /**
 * MP Player Cat taxonomy
 */
function mp_player_taxonomy() {  
	if (mp_core_get_option( 'mp_player_settings_general',  'enable_disable' ) != 'disabled' ){
		
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'                => __( 'MP Player Groups', 'mp_core' ),
			'singular_name'       => __( 'MP Player Group', 'mp_core' ),
			'search_items'        => __( 'Search MP Player Groups', 'mp_core' ),
			'all_items'           => __( 'All MP Player Groups', 'mp_core' ),
			'parent_item'         => __( 'Parent MP Player Group', 'mp_core' ),
			'parent_item_colon'   => __( 'Parent MP Player Group:', 'mp_core' ),
			'edit_item'           => __( 'Edit MP Player Group', 'mp_core' ), 
			'update_item'         => __( 'Update MP Player Group', 'mp_core' ),
			'add_new_item'        => __( 'Add New MP Player Group', 'mp_core' ),
			'new_item_name'       => __( 'New MP Player Group Name', 'mp_core' ),
			'menu_name'           => __( 'MP Player Groups', 'mp_core' ),
		); 	
  
		register_taxonomy(  
			'mp_player_groups',  
			'mp_player',  
			array(  
				'hierarchical' => true,  
				'label' => 'MP Player Groups',  
				'labels' => $labels,  
				'query_var' => true,  
				'with_front' => false, 
				'rewrite' => array('slug' => 'MP Players')  
			)  
		);  
	}
}  
add_action( 'init', 'mp_player_taxonomy' );  