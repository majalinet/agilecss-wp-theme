<?php
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
       
        echo '</ol>';
           
    }
       
}


function extra_fields_box_func( $post ){?>
<?php  $signature = get_post_meta($post->ID, 'signature', 1);?>
	<div class="signature title" style="border-bottom:1px solid #e2e4e7">
		<h3 id="signature-title">Post signature</h3>
		<div class="signature <?php if( $signature=='N' ){?>hidden<?php }?>" >
			<input type="hidden" id="signature" name="signature" value="<?php if( $signature!='N' ){ echo $signature; }else{?>N<?php }?>">
			<p style="display:block;width:50%;float:left">				
				<?php $signImg = get_post_meta( $post->ID, 'signature_image', 1);?>				
				<img src="<?php echo $signImg; ?>" id="signature-image" <?php if( !$signImg ){?>class="hidden"<?php }?>>
				User avatar
				<input type="hidden" id="signature-image-field" name="signature-image" value="<?php echo $signImg; ?>">
				<input id="signature-image-button" type="button" class="button" value="Upload" />  
			</p>
			<div  style="display:inline-block;width:50%">
				<p>
					Name
					<input type="text" name="signature-name" value="<?php echo get_post_meta($post->ID, 'signature_name', 1); ?>" style="width:100%" /> 
				</p>
				<p>Signature text (description):
					<textarea type="text" name="signature-text" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'signature_description', 1); ?></textarea>
				</p>
			</div>
		</div>
	</div>
	<input type="hidden" name="extra_field_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	
	<?php
}

?>