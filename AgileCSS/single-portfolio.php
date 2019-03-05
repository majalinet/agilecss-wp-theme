<?php
get_header();
if ( have_posts() ) {
	the_post();
$tags =  wp_get_post_tags( $post->ID );
$tags_html = '';
foreach ( $tags as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );				 
	$tags_html .= " <span class='badge outline-color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
	$tags_html .= "{$tag->name}</a></span>";
}
unset( $tags );

$tech =  wp_get_object_terms( $post->ID, 'technologies');
foreach ( $tech as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );				 
	$tech_html .= " <span class='badge bg-color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
	$tech_html .= "{$tag->name}</a></span>";
}
unset( $tech );

$serv =  wp_get_object_terms( $post->ID, 'services');
foreach ( $serv as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );				 
	$serv_html .= " <span class='badge color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
	$serv_html .= "{$tag->name}</a></span>";
}
unset( $serv );

$pack =  wp_get_object_terms( $post->ID, 'packages');
foreach ( $pack as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );				 
	$pack_html .= " <span class='badge color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
	$pack_html .= "{$tag->name}</a></span>";
}
unset( $pack );

$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
$thumbnail_url = $thumbnail_url[0];
$current=$post;
?>
	<div class="promo-box-s bg-light-grey">
		<div class="container">
			<h1 class=""><?php wp_title(''); ?></h1>
			<?php custom_breadcrumbs();?>			
		</div>
	</div>
	<main>
		<div class="container row m-v-4">
            <div class="col-md-8">
                <img src="<?php echo $thumbnail_url; ?>" class="img-responsive">
            </div>

            <div class="col-md-4">
                <h2 class="h4 dark">Project Description</h2>
                <p><?php echo $tags_html; ?></p>
                <p>
                    <?php the_content();?>
                </p>
                <p>
					<?php if( !empty($tech_html) ){ ?>
						<b>Technologies:</b><?php echo $tech_html; ?><br>
					<?php };?>
					<?php if( !empty($serv_html) ){ ?>
						<b>Services:</b><?php echo $serv_html; ?><br>
					<?php };?>
					<?php if( !empty($pack_html) ){ ?>
						<b>Package:</b> <?php echo $pack_html; ?>
					<?php };?>
				</p>
                        

            </div>
        </div>
		<?php 
		$requiremets = get_post_meta($post->ID, 'requiremets', 1);
		$results = get_post_meta($post->ID, 'results', 1);
		if( !empty($requiremets) || !empty($results) ){
		?>
		<div class="container row m-v-4">
			<?php if( !empty($requiremets) ){?>
				<div class="col-md-6">
					<h2 class="h4 dark"><?php echo get_post_meta($post->ID, 'requiremets_title', 1); ?></h2>
					<?php $tags = get_post_meta( $post->ID, 'requiremets_tags', false);?>
					<?php if( !empty($tags) ){?>
						<p>
							<?php foreach( $tags[0] as $tag ){?>
								<span class="badge bg-color-1"><?php echo $tag; ?></span>
							<?php }?>
						</p>
					<?php }?>
					<p>
						<?php echo get_post_meta($post->ID, 'requiremets_text', 1); ?>
					</p>
					<?php
					$custom_fields = get_post_meta($post->ID, 'requiremets_custom_fields', 1);
					if( !empty($custom_fields) ){
						foreach( $custom_fields as $key => $array ){
					?>
						<p><b><?php echo $array['name']; ?>:</b> 
							<?php $parts = explode(',', $array['value']); 
							foreach( $parts as $part ){
							?>							
								<span class="badge color-1"><?php echo trim($part); ?></span>
							<?php }?>
						</p>
						<?php }?>
					<?php }?>
				</div>
			<?php }?>

			<?php if( !empty($results) ){?>
				<div class="col-md-6">
					<h2 class="h4 dark"><?php echo get_post_meta($post->ID, 'results_title', 1); ?></h2>
					<?php $tags = get_post_meta( $post->ID, 'results_tags', false);?>
					<?php if( !empty($tags) ){?>
						<p>
							<?php foreach( $tags[0] as $tag ){?>
								<span class="badge outline-color-1"><?php echo $tag; ?></span>
							<?php }?>						
						</p>
					<?php }?>
					<p>
						<?php echo get_post_meta($post->ID, 'results_text', 1); ?>
					</p>
					<?php
					$custom_fields = get_post_meta($post->ID, 'results_custom_fields', 1);
					if( !empty($custom_fields) ){
						foreach( $custom_fields as $key => $array ){
					?>
						<p>
							<b><?php echo $array['name']; ?>:</b> 
							<?php $parts = explode(',', $array['value']); 
							foreach( $parts as $part ){
							?>	
								<span class="badge color-1"><?php echo trim($part); ?></span>
							<?php }?>							
						</p>
						<?php }?>
					<?php }?>
				</div> 
			<?php }?>			
		</div>
		<?php }?>
		
		<?php $sliderImgs = get_post_meta( $post->ID, 'slider_image', false);?>
		<?php if( $sliderImgs ){?>
		<div class="row justify-content-center m-v-4">
			
				<?php foreach( $sliderImgs[0] as $i=>$img ){
					$thumbnail_url = wp_get_attachment_image_src(pn_get_attachment_id_from_url($img), 'thumbnail', true );
					$thumbnail_url = $thumbnail_url[0];
					$bigImage = wp_get_attachment_image_src(pn_get_attachment_id_from_url($img), 'large', false );
					// $bigImage = $bigImage[0];
					?>
					<div class="light-box">
						<a class="light-box-link" href="#light-box-img<?php echo $i+1;?>">
						  <img src="<?php echo $thumbnail_url; ?>" alt="Demo image">
						</a>
						<div id="light-box-img<?php echo $i+1;?>" class="light-box-overlay fadeIn">
						  <figure class="light-box-content light-box-figure">
							<img src="<?php echo $bigImage[0]; ?>" alt="Demo image" style="height:<?php echo $bigImage[2];?>px">
						  </figure>
						  <a href="#light-box-untarget" class="light-box-close light-box-control">Close</a>
						  <?php if($i>0){?><a class="light-box-prev light-box-control" href="#light-box-img<?php echo $i;?>">Prev</a><?php };?>
						  <?php if( count($sliderImgs[0])>= $i+2 ){?><a class="light-box-next light-box-control" href="#light-box-img<?php echo $i+2;?>">Next</a><?php };?>
						</div>
					</div>
				<?php };?>
			
        </div>
		<?php };?>
		
		<?php $galleryImgs = get_post_meta( $post->ID, 'gallery_image', false);?>
		<?php if($galleryImgs){?>
		<div class="row justify-content-center container  m-v-2">
			<h2 class="center  m-v-2">Project Gallery</h2>
			<div class="masonry-container masonry-container-2col">
			<?php foreach($galleryImgs[0] as $img){	
				$sizes = getimagesize($img);
				if( $sizes[0] > 600 ){
					$imgclass="large";
				}elseif($sizes[0] < 300){
					$imgclass="small";
				}else{
					$imgclass="medium";
				}?>
				<div class="masonry-<?php echo $imgclass; ?> masonry-gallery-img">
				  <img src="<?php echo $img; ?>">
				</div>
				<?php };?>
			</div>
		</div>
		<?php };?>
    </main>
<?php
}
get_footer();
?>