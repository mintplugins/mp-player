<?php
function enqueue_these_scripts(){

	//Filter or set default skin location for jplayer 
	$jplayer_skin_location = has_filter('mp_player_skin_location') ? apply_filters( 'mp_player_skin_location', $first_output) : plugins_url('css/player-mp-core-skin.css', dirname(__FILE__));
	
	//Enqueue skin for jplayer
	wp_enqueue_style('mp_player_mp_player_skin', $jplayer_skin_location);
	
	//Filter or set default skin for jplayer 
	$jplayer_font_location = has_filter('mp_player_font_css_location') ? apply_filters( 'mp_player_font_css_location', $first_output) : plugins_url('css/player-mp-core-icon-font.css', dirname(__FILE__));
	
	//Icon font for jplayer 
	wp_enqueue_style('mp_player_mp_player_icon_font', $jplayer_font_location);
	
	//jplayer
	wp_enqueue_script('mp_player', plugins_url('js/jplayer/jquery.jplayer.min.js', dirname(__FILE__)),  array( 'jquery') );
	
	//jplayer playlist addon
	wp_enqueue_script('mp_player_playlist', plugins_url('js/jplayer/jplayer.playlist.min.js', dirname(__FILE__)),  array( 'jquery', 'mp_player') );

}
add_action('wp_enqueue_scripts', 'enqueue_these_scripts');
/**
 * Jquery for new player
 *
 * Post ID must not contain an underscore. Can be any string (not necessarily a post id). Also must be unique.
 */
function mp_player($post_id, $content = 'mp_player', $player_options = NULL){
	
	//Filter or set default skin location for jplayer 
	$jplayer_skin_location = has_filter('mp_player_skin_location') ? apply_filters( 'mp_player_skin_location', $first_output) : plugins_url('css/player-mp-core-skin.css', dirname(__FILE__));
	
	//Enqueue skin for jplayer
	wp_enqueue_style('mp_player_mp_player_skin', $jplayer_skin_location);
	
	//Filter or set default skin for jplayer 
	$jplayer_font_location = has_filter('mp_player_font_css_location') ? apply_filters( 'mp_player_font_css_location', $first_output) : plugins_url('css/player-mp-core-icon-font.css', dirname(__FILE__));
	
	//Icon font for jplayer 
	wp_enqueue_style('mp_player_mp_player_icon_font', $jplayer_font_location);
	
	//jplayer
	wp_enqueue_script('mp_player', plugins_url('js/jplayer/jquery.jplayer.min.js', dirname(__FILE__)),  array( 'jquery') );
	
	//jplayer playlist addon
	wp_enqueue_script('mp_player_playlist', plugins_url('js/jplayer/jplayer.playlist.min.js', dirname(__FILE__)),  array( 'jquery', 'mp_player') );
	
	//Set/Call the $post_id global
	global $mp_player_previous_player_ids;
	
	//Make sure the global is an array (if this is the first player on the page
	$mp_player_previous_player_ids = !is_array( $mp_player_previous_player_ids ) ? array() : $mp_player_previous_player_ids;
	
	//Set blank html output
	$html_output = NULL;
	
	//Make sure we haven't created a player with this id on this page already
	if ( !in_array($post_id, $mp_player_previous_player_ids ) ){
		
		//If the $content variable isn't an array - which means that the array is attached to this post in a post meta
		if (!is_array($content)){
			$medias = get_post_meta( $post_id, $content, $single = true );
		}
		//If the $content variable IS an array - the array of mp3s has been passed directly to this function as an array
		else{
			$medias = $content;	
		}
		
		//If the first song doesn't have a title
		//there is a 99.99% chance that this array is either set up improperly,
		//or there are no songs that have been added - so only create the player if there is a title for the first song.
		if (!empty($medias[0]['title'])){
									
			//If this player should use jplayer
			$jplayer_output_and_supplied = mp_jplayer_js_output( $post_id, $medias, $player_options );
			$html_output .= $jplayer_output_and_supplied[0];
			
			$html_output .= '
			<div id="' . $post_id . '_jp_container" class="mp-player-container jp-video jp-video-270p">
		
					<div class="jp-type-playlist">';
						
						$html_output .= '
						
						<div class="mp-player-video-area">
							
							<div class="jp-video-play mp-player-video-play">
		
								<a href="javascript:;" class="jp-video-play-icon mp-player-video-play-icon icon-play" tabindex="1"></a>
		
							</div>
							
							<div id="' . $post_id . '_mp_player" class="jp-jplayer mp-player"></div>
							
						</div>
						
						<div class="jp-gui mp-player-gui">
		
							<div class="jp-interface mp-player-interface">
		
								<div class="jp-current-time mp-player-current-time"></div>
		
								<div class="jp-duration mp-player-duration"></div>
		
								<div class="jp-controls-holder mp-player-controls-holder">
		
									<ul class="jp-controls mp-player-controls">
										<!--previous-->
										<li><a href="javascript:;" class="jp-previous mp-player-previous icon-to-start" tabindex="1"></a></li>
										<!--play-->
										<li><a href="javascript:;" class="jp-play mp-player-play icon-play" tabindex="1"></a></li>
										<!--pause-->
										<li><a href="javascript:;" class="jp-pause mp-player-pause icon-pause" tabindex="1"></a></li>
										<!--next-->
										<li><a href="javascript:;" class="jp-next mp-player-next icon-to-end" tabindex="1"></a></li>
										<!--stop-->
										<li><a href="javascript:;" class="jp-stop mp-player-stop icon-stop" tabindex="1"></a></li>
										<!--mute-->
										<li><a href="javascript:;" class="jp-mute mp-player-mute icon-volume-off" tabindex="1" title="mute"></a></li>
										<!--unmute-->
										<li><a href="javascript:;" class="jp-unmute mp-player-unmute icon-volume-up" tabindex="1" title="unmute"></a></li>
										
									</ul>
									
									<div class="jp-progress mp-player-progress">
									
										<div class="jp-seek-bar mp-player-seek-bar">
											<div class="jp-play-bar mp-player-play-bar"></div>
										</div>
									</div>
											
									<div class="jp-volume-bar mp-player-volume-bar">
		
										<div class="jp-volume-bar-bg mp-player-volume-bar-bg">
											<div class="jp-volume-bar-value mp-player-volume-bar-value"></div>
										</div>
										
									</div>';
									
									//If there is more than 1 track
									if (is_array($medias) && count($medias) > 1){
										$html_output .= '
										<ul class="jp-controls jp-secondary-controls mp-player-secondary-controls">
											<!--shuffle-->
											<li><a href="javascript:;" class="jp-shuffle mp-player-shuffle icon-shuffle" tabindex="1" title="shuffle"></a></li>
											<!--shuffle off-->
											<li><a href="javascript:;" class="jp-shuffle-off mp-player-shuffle-off icon-shuffle shuffle-off" tabindex="1" title="shuffle off"></a></li>
											<!--repeat-->
											<li><a href="javascript:;" class="jp-repeat mp-player-repeat icon-loop" tabindex="1" title="repeat"></a></li>
											<!--repeat off-->
											<li><a href="javascript:;" class="jp-repeat-off mp-player-repeat-off icon-loop loop-off" tabindex="1" title="repeat off"></a></li>
										</ul>';
									}
										
									$html_output .= '<ul class="jp-toggles mp-player-toggles">';
									if (in_array('m4v', $jplayer_output_and_supplied[1] )){
										$html_output .= '<!--full screen-->
										<li><a href="javascript:;" class="jp-full-screen mp-player-full-screen icon-resize-full-alt" tabindex="1" title="full screen" ></a></li>
										<!--restore screen-->
										<li><a href="javascript:;" class="jp-restore-screen mp-player-restore-screen icon-resize-small" tabindex="1" title="restore screen"></a></li>';
									} 
									$html_output .= '</ul>
		
								</div>
		
								<div class="jp-title mp-player-title">
		
									<ul>
		
										<li></li>
		
									</ul>
		
								</div>
		
							</div>
		
						</div>';
			
						$html_output .= '<div class="jp-playlist mp-player-playlist" '; 
						$html_output .= !is_array($medias) || count($medias) == 1 ? 'style="display:none"' : NULL; 
						$html_output .= '>';
		
							$html_output .= '
							<ul>
		
								<!-- The method Playlist.displayPlaylist() uses this unordered list -->
		
								<li></li>
		
							</ul>
		
						</div>
						
                      
						<div class="jp-no-solution mp-player-no-solution">
		
							<span>Update Required</span>
		
							To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		
						</div>
                       
					</div>
		
				</div>';
			
			//Set the global variable for the post id to the current one
			//array_push( $mp_player_previous_player_ids, $post_id );
		}
	}
	
	return $html_output;
}