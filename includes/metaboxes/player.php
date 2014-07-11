<?php
/**
 * This file contains the MP_Player_Cpt_Metabox class
 *
 * @link http://mintplugins.com/doc/mp-player-class/
 * @since 1.0.0
 *
 * @package    MP Core
 * @subpackage Classes
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * This class adds a pre-created 'mp_player' metabox to a passed-in post type
 *
 * @author     Philip Johnston
 * @link       http://mintplugins.com/doc/metabox-class/
 * @since      1.0.0
 * @usage      new MP_Player_Cpt_Metabox( 'cpt_slug' );
 * @return     void
 */
if (!class_exists('MP_Player_Cpt_Metabox')){
	class MP_Player_Cpt_Metabox{
				
		protected $_post_type;
		
		/**
		 * Constructor
		 *
		 * @access   public
		 * @since    1.0.0
		 * @link     http://mintplugins.com/doc/metabox-class/
		 * @author   Philip Johnston
		 * @see      MP_Player_Cpt_Metabox::mp_core_add_metabox()
		 * @see      MP_Player_Cpt_Metabox::mp_core_save_data()
		 * @see      MP_Player_Cpt_Metabox::mp_core_enqueue_scripts()
		 * @see      wp_parse_args()
		 * @see      sanitize_title()
		 * @param    array $post_type (required) See link for description.
		 * @param    array $items_array (required) See link for description.
		 * @return   void
		 */	
		public function __construct($post_type){
														
			//Get and parse args
			$this->_post_type = $post_type;
			
			add_action('plugins_loaded', array( $this->mp_player_create_meta_box ) );
			
		}
		
		
		/**
		 * Function which creates new Meta Box
		 *
		 */
		
		function mp_player_create_meta_box(){	
			/**
			 * Array which stores all info about the new metabox
			 *
			 */
			$mp_player_add_meta_box = array(
				'metabox_id' => 'mp_player_metabox', 
				'metabox_title' => __( 'MP Player Content', 'mp_player'), 
				'metabox_posttype' => $this->_post_type, 
				'metabox_context' => 'advanced', 
				'metabox_priority' => 'high' 
			);
			
			/**
			 * Custom filter to allow for themes to change the description of the sermon thumbnail. This allows for custom size description. IE: 200px by 100px
			 */
			$mp_player_thumbnail_description = has_filter('mp_player_thumbnail_description') ? apply_filters( 'mp_player_thumbnail_description', $mp_player_thumbnail_description) : 'Upload a poster image for this media (Optional)';
			
			/**
			 * Array which stores all info about the options within the metabox
			 *
			 */
			$mp_player_items_array = array(
				array(
					'field_id'			=> 'title',
					'field_title' 	=> __( 'Media\'s Title', 'mp_player'),
					'field_description' 	=> 'Enter the title of this media',
					'field_type' 	=> 'textbox',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'artist',
					'field_title' 	=> __( 'Media\'s Artist', 'mp_player'),
					'field_description' 	=> 'Enter the Artist\'s name of this media',
					'field_type' 	=> 'textbox',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'poster',
					'field_title' 	=> __( 'Media\'s Poster', 'mp_player'),
					'field_description' 	=> $mp_player_thumbnail_description,
					'field_type' 	=> 'mediaupload',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'mp3',
					'field_title' 	=> __( 'Media\'s MP3', 'mp_player'),
					'field_description' 	=> 'Insert your media\'s MP3 file here (Optional)',
					'field_type' 	=> 'mediaupload',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'ogv',
					'field_title' 	=> __( 'Media\'s OGG/OGV File', 'mp_player'),
					'field_description' 	=> 'Insert your media\'s OGG/OGV file here (Optional)',
					'field_type' 	=> 'mediaupload',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'm4v',
					'field_title' 	=> __( 'Media\'s MP4/M4V Video File', 'mp_player'),
					'field_description' 	=> 'Insert your media\'s MP4/M4V file here (Optional)',
					'field_type' 	=> 'mediaupload',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
				array(
					'field_id'			=> 'webmv',
					'field_title' 	=> __( 'Media\'s WEBM File', 'mp_player'),
					'field_description' 	=> 'Insert your media\'s WEBM file here (Optional)',
					'field_type' 	=> 'mediaupload',
					'field_value' => '',
					'field_repeater' => 'mp_player'
				),
			);
			
			
			/**
			 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
			 */
			$mp_player_add_meta_box = has_filter('mp_player_meta_box_array') ? apply_filters( 'mp_player_meta_box_array', $mp_player_add_meta_box) : $mp_player_add_meta_box;
			
			/**
			 * Custom filter to allow for add on plugins to hook in their own extra fields 
			 */
			$mp_player_items_array = has_filter('mp_player_items_array') ? apply_filters( 'mp_player_items_array', $mp_player_items_array) : $mp_player_items_array;
			
			/**
			 * Create Metabox class
			 */
			global $mp_player_meta_box;
			$mp_player_meta_box = new MP_Player_Cpt_Metabox($mp_player_add_meta_box, $mp_player_items_array);
		}
	}
}


