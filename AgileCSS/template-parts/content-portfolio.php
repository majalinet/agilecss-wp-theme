<?php 
$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array('220','220'), true );
$thumbnail_url = $thumbnail_url[0];


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
?>

<div class="row m-v-4">
	<div class="col-md-8">
		<img src="<?php echo $thumbnail_url; ?>" class="img-responsive">
	</div>

	<div class="col-md-4">
			<h2 class="h4 dark"><?php the_title(); ?></h2>
		<p><?php echo $tags_html; ?></p>
		<p>
			<?php the_excerpt(); ?>
		</p>
		<p> <b>Technologies:</b> <?php echo $tech_html; ?><br>
			<b>Services:</b> <?php echo $serv_html; ?>
		</p>
		<button class="button-w-25" onclick="location.href='<?php echo esc_url( get_permalink( $post->ID ) ); ?>'">Project Details</button>
	</div>
</div>