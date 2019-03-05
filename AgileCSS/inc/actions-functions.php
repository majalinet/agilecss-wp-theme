<?php
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
	add_meta_box( 'extra_fields', 'Дополнительные поля', 'extra_fields_box_func', 'post', 'normal', 'high'  );
}
add_action('add_meta_boxes', 'my_extra_fields', 1);

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
        'signature_text' => $_POST['signature-text']  
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
?>