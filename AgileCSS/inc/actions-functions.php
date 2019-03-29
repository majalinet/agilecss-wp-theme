<?php
// Save the comment meta data along with comment
add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
  if ( ( isset( $_POST['author'] ) ) && ( $_POST['author'] != '') )
  $author = wp_filter_nohtml_kses($_POST['author']);
  add_comment_meta( $comment_id, 'author', $author );

  if ( ( isset( $_POST['email'] ) ) && ( $_POST['email'] != '') )
  $email = wp_filter_nohtml_kses($_POST['email']);
  add_comment_meta( $comment_id, 'email', $email );

  if ( ( isset( $_POST['website'] ) ) && ( $_POST['website'] != '') )
  $website = wp_filter_nohtml_kses($_POST['website']);
  add_comment_meta( $comment_id, 'website', $website );
}


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

// Count posts for page
function custom_posts_per_page($query){
    if(is_home()){
		$query->set('posts_per_page',8);
	}
	if(is_search()){
		$query->set('posts_per_page',-1);
	}
	if(is_archive()){
		$query->set('posts_per_page',5);
	}
} 
add_action('pre_get_posts','custom_posts_per_page');

// Add custom fields for posts
function my_extra_fields() {
	add_meta_box( 'extra_fields', 'Extra fields', 'extra_fields_box_func', 'post', 'normal', 'high'  );
	add_meta_box( 'portfolio_fields', 'Portfolio fields', 'portfolio_fields_box_func', 'portfolio', 'normal', 'high'  );
}
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_portfolio_extra_fields() {
	add_meta_box( 'portfolio_fields', 'Portfolio fields', 'portfolio_fields_box_func', 'portfolio', 'normal', 'high'  );
}

//Save custom fields data
function my_extra_fields_update( $post_id ){
	
	if ( !wp_verify_nonce($_POST['extra_field_nonce'], __FILE__) )  
		return false;                  
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  )  
		return false;   
    if ( !current_user_can('edit_post', $post_id) )  
		return false; 
	$extra_fields = array(  
        'signature' => $_POST['signature'],  
        'signature_image' => $_POST['signature-image'],  
        'signature_name' => $_POST['signature-name'],  
        'signature_text' => $_POST['signature-text'],
		
    ); 	
	$extra_fields = array_map('trim', $extra_fields);
	foreach( $extra_fields as $key=>$value ){              
		if( empty($value) )  
			delete_post_meta($post_id, $key);   
		if($value)  
			update_post_meta($post_id, $key, $value);  
    }  
  
    return $post_id;  
}
add_action( 'save_post', 'my_extra_fields_update', 0 );

function my_portfolio_fields_update ( $post_id ){	

	// $extra_fields = array(
		// 'gallery_images' => $_POST['gallery-image'],
		// 'gallery' => $_POST['gallery']
	// );
	foreach( $_POST as $key => $field ){
		$name = str_replace( '-', '_', $key);
		$extra_fields[$name] = $field;
	}
	if( is_array($extra_fields) ){
		foreach( $extra_fields as $key => $value ){              
			if( empty($value) )  
				delete_post_meta($post_id, $key);   
			if($value)  
				update_post_meta($post_id, $key, $value);  
		}
	}
}
add_action( 'save_post', 'my_portfolio_fields_update', 0 );

// Change Classes in main menu
add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes', 10, 4 );
function filter_nav_menu_css_classes( $classes, $item, $args, $depth ) {
	if ( $args->theme_location === 'main_menu' ) {
		$classes = [
			$args->menu_items_class
		];
	}
	return $classes;
}


// Add fields after default fields above the comment box, always visible

add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_before_fields', 'additional_fields' );

function additional_fields () {
	$name = get_the_author_meta( 'display_name' )?__(get_the_author_meta( 'display_name' )):__(get_the_author_meta( 'login' ));
	$email = __(get_the_author_meta( 'user_email' ));
	echo '<div class="form-row">';
		echo '<div class="form-group col-md-4">
			<input type="text" class="form-control" name="author" id="inputName" value="' . $name . '" placeholder="' . __( 'Name*' ) . '">
		</div>';
		echo '<div class="form-group col-md-4">
			<input type="email" class="form-control" name="email" value="' . $email . '" id="inputEmail4" placeholder="' . __( 'Email*' ) . '">
		</div>';
		echo '<div class="form-group col-md-4">
			<input type="email" class="form-control" name="website" id="inputWebsite" placeholder="' . __( 'Website' ) . '">
		</div>';
	echo '</div>';
}

/*
* Creating a function for custom post types
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Portfolios', 'Post Type General Name', 'agilecss' ),
        'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'agilecss' ),
        'menu_name'           => __( 'Portfolio', 'agilecss' ),
        'parent_item_colon'   => __( 'Parent Portfolio Category', 'agilecss' ),
        'all_items'           => __( 'All Portfolios', 'agilecss' ),
        'view_item'           => __( 'View Portfolio', 'agilecss' ),
        'add_new_item'        => __( 'Add New Portfolio', 'agilecss' ),
        'add_new'             => __( 'Add New', 'agilecss' ),
        'edit_item'           => __( 'Edit Portfolio', 'agilecss' ),
        'update_item'         => __( 'Update Portfolio', 'agilecss' ),
        'search_items'        => __( 'Search Portfolio', 'agilecss' ),
        'not_found'           => __( 'Not Found', 'agilecss' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'agilecss' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'portfolio', 'agilecss' ),
        'description'         => __( 'Portfolio news and reviews', 'agilecss' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes'),
        'taxonomies'          => array( 'technologies', 'services', 'post_tag', 'packages'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
		'register_meta_box_cb'=> 'my_portfolio_extra_fields',
    );
     
    register_post_type( 'portfolio', $args );
	
 
}
 
add_action( 'init', 'custom_post_type', 0 );

// Add taxonomies to custom post types
function create_agile_taxonomies() {
	$labels = array(
		'name'                       => _x( 'Technologies', 'taxonomy general name', 'agilecss' ),
		'singular_name'              => _x( 'Technologie', 'taxonomy singular name', 'agilecss' ),
		'search_items'               => __( 'Search Technologies', 'agilecss' ),
		'popular_items'              => __( 'Popular Technologies', 'agilecss' ),
		'all_items'                  => __( 'All Technologies', 'agilecss' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Technologie', 'agilecss' ),
		'update_item'                => __( 'Update Technologie', 'agilecss' ),
		'add_new_item'               => __( 'Add New Technologie', 'agilecss' ),
		'new_item_name'              => __( 'New Technologie Name', 'agilecss' ),
		'separate_items_with_commas' => __( 'Separate Technologies with commas', 'agilecss' ),
		'add_or_remove_items'        => __( 'Add or remove Technologies', 'agilecss' ),
		'choose_from_most_used'      => __( 'Choose from the most used Technologies', 'agilecss' ),
		'not_found'                  => __( 'No Technologies found.', 'agilecss' ),
		'menu_name'                  => __( 'Technologies', 'agilecss' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'technologies' ),
	);

	register_taxonomy( 'technologies', 'portfolio', $args );
	
	$labels = array(
		'name'                       => _x( 'Services', 'taxonomy general name', 'agilecss' ),
		'singular_name'              => _x( 'Service', 'taxonomy singular name', 'agilecss' ),
		'search_items'               => __( 'Search Services', 'agilecss' ),
		'popular_items'              => __( 'Popular Services', 'agilecss' ),
		'all_items'                  => __( 'All Services', 'agilecss' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Service', 'agilecss' ),
		'update_item'                => __( 'Update Service', 'agilecss' ),
		'add_new_item'               => __( 'Add New Service', 'agilecss' ),
		'new_item_name'              => __( 'New Service Name', 'agilecss' ),
		'separate_items_with_commas' => __( 'Separate Services with commas', 'agilecss' ),
		'add_or_remove_items'        => __( 'Add or remove Services', 'agilecss' ),
		'choose_from_most_used'      => __( 'Choose from the most used Services', 'agilecss' ),
		'not_found'                  => __( 'No Services found.', 'agilecss' ),
		'menu_name'                  => __( 'Services', 'agilecss' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'services' ),
	);

	register_taxonomy( 'services', 'portfolio', $args );
	
	$labels = array(
		'name'                       => _x( 'Packages', 'taxonomy general name', 'agilecss' ),
		'singular_name'              => _x( 'Package', 'taxonomy singular name', 'agilecss' ),
		'search_items'               => __( 'Search Packages', 'agilecss' ),
		'popular_items'              => __( 'Popular Packages', 'agilecss' ),
		'all_items'                  => __( 'All Packages', 'agilecss' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Package', 'agilecss' ),
		'update_item'                => __( 'Update Package', 'agilecss' ),
		'add_new_item'               => __( 'Add New Package', 'agilecss' ),
		'new_item_name'              => __( 'New Package Name', 'agilecss' ),
		'separate_items_with_commas' => __( 'Separate Packages with commas', 'agilecss' ),
		'add_or_remove_items'        => __( 'Add or remove Packages', 'agilecss' ),
		'choose_from_most_used'      => __( 'Choose from the most used Packages', 'agilecss' ),
		'not_found'                  => __( 'No Packages found.', 'agilecss' ),
		'menu_name'                  => __( 'Packages', 'agilecss' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'packages' ),
	);

	register_taxonomy( 'packages', 'portfolio', $args );
}
add_action( 'init', 'create_agile_taxonomies', 0 );

?>