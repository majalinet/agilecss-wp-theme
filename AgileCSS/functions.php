<?php 
// Add Theame Support
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ]);
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

/*ACTIONS*/

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

/*END ACTIONS*/

/*FILTERS*/

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

/*END FILTERS*/

/*OTHER FUNCTIONS*/

//Page navigation bar
function agile_navi() {
	global $wp_query;
	
	$max = $wp_query->max_num_pages;
	if (!$current = get_query_var('paged')) $current = 1;
	
	$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
	$a['type'] = 'array';
	$a['total'] = $max;
	$a['current'] = $current;
	$a['mid_size'] = 3; 
	$a['end_size'] = 1; 
	$a['prev_text'] = '&laquo;'; 
	$a['next_text'] = '&raquo;';
	$pages=paginate_links($a);
	
	if($pages){
		if ($max > 1) echo '<ul class="pagination m1">';
		foreach($pages as $i => $page){
			$pg = preg_replace( '~page-numbers~', 'page-link', $page );
			if($i==0 && $current==1){
				$active = "active";
				echo '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>';
			}else{
				if( $current == $i ){
					$active = "active";
				}else{
					$active = "";
				}
			}
			
			echo '<li class="page-item ' . $active . '">' . $pg.'</li>';
		}
		
		if ($max > 1) echo '</ul>';
	}
}
// Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator               = '&gt;';
    $breadcrums_id           = 'breadcrumbs';
    $breadcrums_class        = 'breadcrumb';
    $breadcrums_item_class   = 'breadcrumb-item';
    $home_title              = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="' . $breadcrums_item_class . '"><a href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="' . $breadcrums_item_class . '">' . post_type_archive_title($prefix, false) . '</li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="' . $breadcrums_item_class . '"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="' . $breadcrums_item_class . '">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="' . $breadcrums_item_class . '"><a href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="' . $breadcrums_item_class . '">'.$parents.'</li>';
                    
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="' . $breadcrums_item_class . ' active">' . get_the_title() . '</li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="' . $breadcrums_item_class . '"><a href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
               
                echo '<li class="' . $breadcrums_item_class . ' active">' . get_the_title() . '</li>';
              
            } else {
                  
                echo '<li class="' . $breadcrums_item_class . '">' . get_the_title() . '</li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="' . $breadcrums_item_class . ' active">' . single_cat_title('', false) . '</li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="' . $breadcrums_item_class . '"><a href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="' . $breadcrums_item_class . ' active">' . get_the_title() . '</li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="' . $breadcrums_item_class . ' active">' . get_the_title() . '</li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="' . $breadcrums_item_class . ' active">' . $get_term_name . '</li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="' . $breadcrums_item_class . ' active">Search results for: ' . get_search_query() . '</li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }else{
			echo '<li>' . wp_title('') . '</li>';
		}
       
        echo '</ul>';
           
    }
       
}

/*END OTHER FUNCTIONS*/
?>