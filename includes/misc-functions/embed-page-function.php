<?php
/**
 * Shortcode which is used by our custom page to embed the player and nothing else on a page
 */
function mp_player_embed_page( $atts ) {
	
	
	$player_embed = isset($_GET['player_embed']) ? $_GET['player_embed'] : NULL;
	
	if ($player_embed == true){
		
		//sanitize ID 
		$post_id = get_the_id();
		
		//sanitize slug
		$slug = get_post_meta($post_id, 'player', true);
		
		//Move the player outside the body
		?>
		<script type="application/javascript">
		jQuery(document).ready(function($){
		
		   $('#mp_embedable_video').insertAfter('body');
			
		});
		</script>
		<?php
		
		//CSS - hide everything in the body
		echo '<style scoped>';
		echo 'body{display:none;}';
		echo '.jp-toggles{display:none;}';
		echo '</style>';
		
		//Display Player
		echo '<div id="mp_embedable_video">';
		echo mp_player($post_id, $slug);
		echo '</div>';
		
		exit;
	}
}
add_action( 'loop_start', 'mp_player_embed_page' );