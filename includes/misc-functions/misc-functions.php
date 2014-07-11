<?php
/**
 * Misc Functions
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package     MP Player
 * @subpackage  Misc Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
 /**
 * Shortcode which is used by our custom page to embed the player and nothing else on a page
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @see      function_name()
 * @param    array $args See link for description.
 * @return   void
 */
function mp_player_youtube_js_api_embed( $atts ) {
	
	 return '<iframe id="player2" type="text/html" width="640" height="390" src="https://www.youtube.com/embed/he7NhGzP_Iw?controls=0&modestbranding=1&showinfo=0&enablejsapi=1&origin=http://localhost:8888" frameborder="0"></iframe>';
	
}
add_action( 'loop_start', 'mp_player_embed_page' );