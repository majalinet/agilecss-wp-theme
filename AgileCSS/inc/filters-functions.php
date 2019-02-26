<?php

// Customizing read more link
function agile_read_more_link( $read_more_text ){
	global $post;
	$new_read_more_link = '<br/><a href="' . get_permalink( $post->ID ) . '">' . esc_html__( 'Read more', 'agilecss' ) . '</a>';
	return $new_read_more_link;
}
add_filter( 'excerpt_more', 'agile_read_more_link');

// Customizing WP structure to Agile structure
function agille_customize_content($content){
	if( !in_the_loop() ){
		return;
	}
	
	return preg_replace_callback_array ( [
		// customizing quote structure
		"~(.*?)<cite.*?>(.*?)<\/cite>(.*?)~is" => function( &$matches ){
			return $matches[1] . '<footer class="blockquote-footer">' . $matches[2] ."</footer>". $matches[3];
		}
	], $content );
}
add_filter( 'the_content', 'agille_customize_content', 10);
?>