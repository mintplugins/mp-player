<?php 
/**
 * Ways to use the Jplayer
 */
 
//You could declare the content for the jplayer like this:
$content = array(
	array(
			'title' => "Big Buck Bunny Trailer",
			'artist'=> "Blender Foundation",
			'free' => true,										
			'm4v' => "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",										
			'ogv' => "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",									
			'webmv' => "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",										
			'poster' => "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
	),
	array(
		'title' => "Big Buck Bunny Trailer",
		'artist'=> "Blender Foundation",
		'free' => false,										
		'm4v' => "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",										
		'ogv' => "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",									
		'webmv' => "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",										
		'poster' => "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
	)
);
//And then call it using a custom_id for the CSS and the $content variable we set above
echo mp_jplayer('custom_id', $content); 

/**
 * Or you could gather your repeatable fields into an array variable 
 * and then call it (with the field_id's set as above)
 */
$content = get_post_meta( $post->ID, 'sermons', $single = true ); 
echo mp_jplayer('custom_id', $content); 

/**
 * Or you can use the post id of a jplayer custom post type (2136 is a "jplayer" custom post) 
 * and the id of the repeater (see mp_core and metaboxes for details on setting up a repeater)
 */
echo mp_jplayer(2136, 'jplayer');

/**
 * Or inside the loop use it like this
 */
echo mp_jplayer($post->ID, 'jplayer');