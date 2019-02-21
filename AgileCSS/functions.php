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



?>