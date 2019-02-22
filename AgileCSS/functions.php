<?php 
// Add Thema Support
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-format', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat']);
add_theme_support( 'html5' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'custom-backgroud' );
add_theme_support( 'custom-header' );
add_theme_support( 'custom-logo' );
add_theme_support( 'customize-selective-refresh-widgets' );
add_theme_support( 'starter-content' );
/**
 * Enqueue scripts and styles.
 */
function agilecss_scripts() {
	wp_enqueue_style( 'agilecss-style', get_template_directory_uri() . '/style.css', array(), time(), 'all');

}
add_action( 'wp_enqueue_scripts', 'agilecss_scripts' );

//Register Menu Locations
register_nav_menus( [
	'main_menu' => esc_html__( 'Main Menu', 'agilecss'),
	'footer_menu_left' => esc_html__( 'Footer Menu Left', 'agilecss'),
	'footer_menu_right' => esc_html__( 'Footer Menu Right', 'agilecss'),
] );

//Init Widgets Area
function AgileWidtgets_init(){
	register_sidebar([
		'name'          => 'Main advanteges',
		'id'            => 'index',
		'description'   => esc_html__( 'Add widgets for main page', 'agilecss' ),
		'before_widget' => '<div class="col-md-4">',
		'after_widget'  => '</div>',
	]);
	
}
add_action( 'widgets_init', 'AgileWidtgets_init' );

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