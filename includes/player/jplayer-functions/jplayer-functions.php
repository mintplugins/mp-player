<?php

/**
 * This function returns the js for a jplayer
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @see      function_name()
 * @param  	 string $post_id The ID of the post where the jplayer options have been filled out
 * @param  	 array $medias  An array containing the info about the tracks formatted like this:
array(
	array(
		'title' => The Title
		'artist' => The Artist
		'poster' => http://myimage.png
		'mp3' => http://mymp3.mp3
		'm4v' => http://mymp3.m4v
	)
)
 * @param  	 array $player_options An array contining info about how the player should behave formatted like this:
 array(
	'displayTime' => 0,
	'addTime' => 0,
	'removeTime' => 0,
	'shuffleTime' => 0,
	'autoPlay' => 0,
);
 * @return   void
 */
function mp_jplayer_js_output( $post_id, $medias, $player_options = array() ){
	
	//Set supplied array to empty array
	$supplied = array();
			
	$html_output = '
		<script type="text/javascript">
				
			//<![CDATA[
			
			var mp_player_' . $post_id . ';
			
			jQuery(document).ready(function(){
			
				mp_player_' . $post_id . ' = [';
				
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
							
							//Allow the poster to be filtered 						
							if ( $media_key == 'poster' ){
								if ( !empty($media_item) ){
									$html_output .= $media_key . ':"' . apply_filters( 'mp_player_track_poster', $media_item, $post_id ) . '"';
								}
							}
							else{
								$html_output .= !empty($media_item) ? $media_key . ':"' . $media_item . '"' : NULL;
							}
							
							//To allow the media poster for mp3s we send m4v with mp3s - jplayer works for some reason that way
							$html_output .= $media_key == "mp3" ?  ', m4v:"1"' : NULL;
							
							//Add this mediakey to the supplied array
							if (!in_array($media_key, $supplied) && !empty($media_item)){
								array_push($supplied, $media_key);
							}
							
							//Increment the media_key_counter
							$media_key_counter = $media_key_counter + 1;
						}
				
					$html_output .= '},';
				}
				
				$html_output .= '];';
				
				$html_output .= '
				
				new jPlayerPlaylist({
			
					jPlayer: "#' . $post_id . '_mp_player",
			
					cssSelectorAncestor: "#' . $post_id . '_jp_container"
			
				}, mp_player_' . $post_id . '';
				
				
				
				//Set defaults for player options if none set
				$player_options_defaults = array(
					'displayTime' => 0,
					'addTime' => 0,
					'removeTime' => 0,
					'shuffleTime' => 0,
					'autoPlay' => 0,
				);
			
				//Get and parse player options args
				$player_options = wp_parse_args( $player_options, $player_options_defaults );
			
				$html_output .= ', {
					playlistOptions: {';
					
					foreach( $player_options as $key => $player_option ){
						$html_output .= $key . ':' . $player_option . ',';
					}
				
				$html_output .= '
					},
					swfPath: "' . plugins_url( '', dirname(__FILE__)) . '",
					wmode: "window",
					supplied: "';
					
					$counter = 1;
					foreach ($supplied as $supply){
							//Should we show the comma?
							$html_output .= $counter > 1 ? ',' : NULL;
							//Increment the counter
							$counter = $supply != "title" ? $counter+1 : $counter;
							//add this type to the html output
							$html_output .= $supply != "title" ? $supply : NULL;
							//To allow the media poster for mp3s we send m4v with mp3s - jplayer works for some reason that way
							$html_output .= $supply == "mp3" ? ', m4v' : NULL;
							
					}
					$html_output .= '"';
			
				$html_output .= '});
			
			});
			
		//]]>
			
	</script>';
	
	return array( $html_output, $supplied );
	
}