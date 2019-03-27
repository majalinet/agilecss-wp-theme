<?php

add_filter( 'comment_form_submit_button', 'agile_comment_button', 10, 2 );
function agile_comment_button ( $submit_button, $args ){
	$new_submit_button = '<button type="submit" class="btn btn-primary">' . __('Leave a comment') . '</button>';

	return $new_submit_button;
}

function wpdocs_my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for:' ) . '"/>
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'wpdocs_my_search_form' );

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

add_filter( 'image_size_names_choose', 'my_custom_sizes' );
function my_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'icon' => 'Мой размерчик',
	) );
}
?>