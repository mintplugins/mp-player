<?php
/**
 * Jquery for new player
 */
function mp_player($post_id, $content = 'mp_player'){
	
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
	global $previous_post_id;
	
	//Set blank html output
	$html_output = NULL;
	
	//Make sure we haven't created a jplayer with this id on this page already
	if ($post_id != $previous_post_id){
		
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
			
			//Set supplied array to empty array
			$supplied = array();
			
			/**
			 * Output Jquery and HTML for new player
			 */
			 
			
			$html_output = '<script type="text/javascript">
		
			//<![CDATA[
			
			jQuery(document).ready(function(){
			
				new jPlayerPlaylist({
			
					jPlayer: "#' . $post_id . '_jquery_jplayer",
			
					cssSelectorAncestor: "#' . $post_id . '_jp_container"
			
				}, [';
				
				foreach ($medias as $media){
					$html_output .= '{';
						
						$media_key_counter = 0;
						
						foreach ($media as $media_key => $media_item){
							
							//If this is not the first media key, finish the previous loop with a comma
							$html_output .= !empty($media_item) && $media_key_counter > 0 ? ',' : NULL;
							
							/**
							 * When creating your metabox
							 * Media keys (field_ids) should be named after what they represent
							 * EG: title, poster, artist, m4v, ogv, webmv
							 */
							$html_output .= !empty($media_item) ? $media_key . ':"' . $media_item . '"' : NULL;
							
							//Add this mediakey to the supplied array
							if (!in_array($media_key, $supplied) && !empty($media_item)){
								array_push($supplied, $media_key);
							}
							
							//Increment the media_key_counter
							$media_key_counter = $media_key_counter + 1;
						}
					$html_output .= '},';
				}
						
				
			
				$html_output .= '], {
					playlistOptions: {
						displayTime: 0,
						addTime: 0,
						removeTime: 0,
						shuffleTime: 0,
					},
					swfPath: "' . plugins_url( 'player', dirname(__FILE__)) . '",
					wmode: "window",
					supplied: "';
					
					$counter = 1;
					foreach ($supplied as $supply){
							$html_output .= $counter > 1 ? ',' : NULL;
							$counter = $supply != "title" ? $counter+1 : $counter;
							$html_output .= $supply != "title" ? $supply : NULL;
					}
					$html_output .= '"';
		
				$html_output .= '});
			
			});
			
			//]]>
			
			</script>
			<div id="' . $post_id . '_jp_container" class="mp-player-container jp-video jp-video-270p">
		
					<div class="jp-type-playlist">';
						
					   
						$html_output .= '<div id="' . $post_id . '_jquery_jplayer" class="jp-jplayer" ';
						
						//$html_output .= in_array('m4v', $supplied) ? 'style="display:block;"' : 'style="display:none;"'; <-- this line breaks jplayer on IOS6
					
						$html_output .= '></div><div class="jp-gui">
		
							<div class="jp-video-play">
		
								<a href="javascript:;" class="jp-video-play-icon icon-play" tabindex="1"></a>
		
							</div>
		
							<div class="jp-interface">
		
								<div class="jp-current-time"></div>
		
								<div class="jp-duration"></div>
		
								<div class="jp-controls-holder">
		
									<ul class="jp-controls">
										<!--previous-->
										<li><a href="javascript:;" class="jp-previous icon-to-start" tabindex="1"></a></li>
										<!--play-->
										<li><a href="javascript:;" class="jp-play icon-play" tabindex="1"></a></li>
										<!--pause-->
										<li><a href="javascript:;" class="jp-pause icon-pause" tabindex="1"></a></li>
										<!--next-->
										<li><a href="javascript:;" class="jp-next icon-to-end" tabindex="1"></a></li>
										<!--stop-->
										<li><a href="javascript:;" class="jp-stop icon-stop" tabindex="1"></a></li>
										<!--mute-->
										<li><a href="javascript:;" class="jp-mute icon-volume-off" tabindex="1" title="mute"></a></li>
										<!--unmute-->
										<li><a href="javascript:;" class="jp-unmute icon-volume-up" tabindex="1" title="unmute"></a></li>
										
									</ul>
									
									<div class="jp-progress">
									
										<div class="jp-seek-bar">
											<div class="jp-play-bar"></div>
										</div>
									</div>
											
									<div class="jp-volume-bar">
		
										<div class="jp-volume-bar-bg">
											<div class="jp-volume-bar-value"></div>
										</div>
										
									</div>';
									
									//If there is more than 1 track
									if (is_array($medias) && count($medias) > 1){
										$html_output .= '
										<ul class="jp-controls">
											<!--shuffle-->
											<li><a href="javascript:;" class="jp-shuffle icon-shuffle" tabindex="1" title="shuffle"></a></li>
											<!--shuffle off-->
											<li><a href="javascript:;" class="jp-shuffle-off icon-shuffle shuffle-off" tabindex="1" title="shuffle off"></a></li>
											<!--repeat-->
											<li><a href="javascript:;" class="jp-repeat icon-loop" tabindex="1" title="repeat"></a></li>
											<!--repeat off-->
											<li><a href="javascript:;" class="jp-repeat-off icon-loop loop-off" tabindex="1" title="repeat off"></a></li>
										</ul>';
									}
										
									$html_output .= '<ul class="jp-toggles">';
									if (in_array('m4v', $supplied)){
										$html_output .= '<!--full screen-->
										<li><a href="javascript:;" class="jp-full-screen icon-resize-full-alt" tabindex="1" title="full screen" ></a></li>
										<!--restore screen-->
										<li><a href="javascript:;" class="jp-restore-screen icon-resize-small" tabindex="1" title="restore screen"></a></li>';
									} 
									$html_output .= '</ul>
		
								</div>
		
								<div class="jp-title">
		
									<ul>
		
										<li></li>
		
									</ul>
		
								</div>
		
							</div>
		
						</div>';
			
						$html_output .= '<div class="jp-playlist" '; 
						$html_output .= !is_array($medias) || count($medias) == 1 ? 'style="display:none"' : NULL; 
						$html_output .= '>';
		
							$html_output .= '
							<ul>
		
								<!-- The method Playlist.displayPlaylist() uses this unordered list -->
		
								<li></li>
		
							</ul>
		
						</div>
						
                      
						<div class="jp-no-solution">
		
							<span>Update Required</span>
		
							To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		
						</div>
                       
					</div>
		
				</div>';
			
			//Set the global variable for the post id to the current one
			$previous_post_id = $post_id;
		}
	}
	
	return $html_output;
}