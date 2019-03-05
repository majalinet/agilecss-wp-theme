<?php
//Get the Attachment ID from an Image URL
function pn_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

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
					<textarea name="signature-text" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'signature_description', 1); ?></textarea>
				</p>
			</div>
		</div>
	</div>
	<input type="hidden" name="extra_field_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	
	<?php
}

function portfolio_fields_box_func( $post ){
?>
	<?php  $slider = get_post_meta($post->ID, 'slider', 1);?>
	<div class="slider title" style="border-bottom:1px solid #e2e4e7">
		<span class="toggle-indicator" aria-hidden="true"></span>
		<h3 id="slider-title">Slider images</h3>
		<div class="slider <?php if( $slider == 'N' ){?>hidden<?php }?>" >
			<input type="hidden" id="slider" name="slider" value="<?php if( $slider != 'N' ){ echo $slider; }else{?>N<?php }?>">
			<?php $sliderImgs = get_post_meta( $post->ID, 'slider_image', false);?>
			<div id="slider_images">
			<?php if( $sliderImgs ){?>
				<?php foreach( $sliderImgs[0] as $i=>$img ){?>
					<p>							
						<img src="<?php echo $img; ?>" id="slider-image" class="slider-img" <?php if( !$img ){?>class="hidden"<?php }?>>
						<input type="hidden" id="slider-image-field" name="slider-image[]" value="<?php echo $img; ?>">
						<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
					</p>
				<?php };?>
			<?php };?>
			</div>
			<p><input id="slider-image-button" type="button" class="button" value="Upload" />  </p>
		</div>
	</div>
	
	<?php  $requiremets = get_post_meta($post->ID, 'requiremets', 1);?>
	<div class="requiremets title" style="border-bottom:1px solid #e2e4e7">
		<span class="toggle-indicator" aria-hidden="true"></span>
		<h3 id="requiremets-title">Project Requirments</h3>
		<div class="requiremets <?php if( $requiremets == 'N' ){?>hidden<?php }?>" >
			<input type="hidden" id="requiremets" name="requiremets" value="<?php if( $requiremets != 'N' ){ echo $requiremets; }else{?>N<?php }?>">			
			<div id="requiremets_container">
				<p>
					Title
					<input type="text" name="requiremets-title" value="<?php echo get_post_meta($post->ID, 'requiremets_title', 1); ?>" style="width:100%" /> 
				</p>
				<p>
					Text
					<textarea name="requiremets-text" rows="5" style="width:100%" ><?php echo get_post_meta($post->ID, 'requiremets_text', 1); ?></textarea> 
				</p>
				<p>
					Requiremets tags
					<div id="requiremets_tags_container">
						<input type="hidden" name="requiremets-tags" value="">
					
						<?php $tags = get_post_meta( $post->ID, 'requiremets_tags', false);?>
						<?php if( !empty($tags) ){
							foreach( $tags[0] as $tag ){
								?>
								<span class="custom-tags">
									<input type="hidden" name="requiremets-tags[]" value="<?php echo $tag?>">
									<?php echo $tag?>
									<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
								</span>
								<?php
							}
						}?>
					</div>
					<input type="text" id="requiremets-tags" /> 
					<button class="add_tags" data-field="requiremets-tags" data-target="requiremets_tags_container">Add</button>
					<p class="howto" id="new-tag-post_tag-desc">Separate tags with commas</p>
				</p>
				<p>
					Requiremets custom fields					
					<div id="requiremets_custom_fields_container">
						<input type="hidden" name="requiremets_custom_fields" value="">
						<?php
						$custom_fields = get_post_meta($post->ID, 'requiremets_custom_fields', 1);
						if( !empty($custom_fields) ){
							foreach( $custom_fields as $key => $array ){
						?>
								<p>
									<input type="text" name="requiremets_custom_fields[<?php echo $key; ?>][name]" value="<?php echo $array['name']; ?>" style="width:20%"/>
									<input type="text" name="requiremets_custom_fields[<?php echo $key; ?>][value]" value="<?php echo $array['value']; ?>" placeholder="Value" style="width:70%"/>
									<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
									
								</p>
							<?php }?>
						<?php }?>						
					</div>
					<?php if( !empty($custom_fields) ){?><p class="howto" id="new-tag-post_tag-desc">Separate value with commas</p><?php }?>
					<input type="text" id="requiremets_custom_fields" /> 
					<button class="add_custom_fileds" data-field="requiremets_custom_fields" data-target="requiremets_custom_fields_container">Add</button>
				</p>
			</div>
		</div>
	</div>
	
	<?php  $results = get_post_meta($post->ID, 'results', 1);?>
	<div class="results title" style="border-bottom:1px solid #e2e4e7">
		<span class="toggle-indicator" aria-hidden="true"></span>
		<h3 id="results-title">Project Results</h3>
		<div class="results <?php if( $results == 'N' ){?>hidden<?php }?>" >
			<input type="hidden" id="results" name="results" value="<?php if( $results != 'N' ){ echo $results; }else{?>N<?php }?>">			
			<div id="results_container">
				<p>
					Title
					<input type="text" name="results-title" value="<?php echo get_post_meta($post->ID, 'results_title', 1); ?>" style="width:100%" /> 
				</p>
				<p>
					Text
					<textarea name="results-text" rows="5" style="width:100%" ><?php echo get_post_meta($post->ID, 'results_text', 1); ?></textarea> 
				</p>
				<p>
					Results tags
					<div id="results_tags_container">
						<input type="hidden" name="results-tags" value="">
					
						<?php $tags = get_post_meta( $post->ID, 'results_tags', false);?>
						<?php if( !empty($tags) ){
							foreach( $tags[0] as $tag ){
								?>
								<span class="custom-tags">
									<input type="hidden" name="results-tags[]" value="<?php echo $tag?>">
									<?php echo $tag?>
									<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
								</span>
								<?php
							}
						}?>
					</div>
					<input type="text" id="results-tags" /> 
					<button class="add_tags" data-field="results-tags" data-target="results_tags_container">Add</button>
					<p class="howto" id="new-tag-post_tag-desc">Separate tags with commas</p>
				</p>
				<p>
					Results custom fields					
					<div id="results_custom_fields_container">
						<input type="hidden" name="results_custom_fields" value="">
						<?php
						$custom_fields = get_post_meta($post->ID, 'results_custom_fields', 1);
						if( !empty($custom_fields) ){
							foreach( $custom_fields as $key => $array ){
						?>
								<p>
									<input type="text" name="results_custom_fields[<?php echo $key; ?>][name]" value="<?php echo $array['name']; ?>" style="width:20%"/>
									<input type="text" placeholder="Value" name="results_custom_fields[<?php echo $key; ?>][value]" value="<?php echo $array['value']; ?>" style="width:70%"/>
									<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
								</p>
							<?php }?>						
						<?php }?>						
					</div>
					<?php if( !empty($custom_fields) ){?><p class="howto" id="new-tag-post_tag-desc">Separate value with commas</p><?php }?>	
					<input type="text" id="results_custom_fields" /> 
					<button class="add_custom_fileds" data-field="results_custom_fields" data-target="results_custom_fields_container">Add</button>
				</p>
			</div>
		</div>
	</div>	
	
	<?php  $gallery = get_post_meta($post->ID, 'gallery', 1);?>
	<div class="gallery title" style="border-bottom:1px solid #e2e4e7">
		<span class="toggle-indicator" aria-hidden="true"></span>
		<h3 id="gallery-title">Gallery images</h3>
		<div class="gallery <?php if( $gallery == 'N' ){?>hidden<?php }?>" >
			<input type="hidden" id="gallery" name="gallery" value="<?php if( $gallery != 'N' ){ echo $gallery; }else{?>N<?php }?>">
			<?php $galleryImgs = get_post_meta( $post->ID, 'gallery_image', false);?>
			<div id="gallery_images">
			<?php if( $galleryImgs ){?>
				<?php foreach( $galleryImgs[0] as $i=>$img ){?>
					<p>							
						<img src="<?php echo $img; ?>" id="gallery-image" class="gallery-img" <?php if( !$img ){?>class="hidden"<?php }?>>
						<input type="hidden" id="gallery-image-field" name="gallery-image[]" value="<?php echo $img; ?>">
						<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span>
					</p>
				<?php };?>
			<?php };?>
			</div>
			<p><input id="gallery-image-button" type="button" class="button" value="Upload" />  </p>
		</div>
	</div>
	<input type="hidden" name="extra_field_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php	
}
?>