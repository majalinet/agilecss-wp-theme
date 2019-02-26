<?php 
	$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array('220','220'), true );
	$thumbnail_url = $thumbnail_url[0];
	
	
	$tags =  wp_get_post_tags( $post->ID );
	$tags_html = '';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );				 
		$tags_html .= "<span class='badge outline-color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
		$tags_html .= "{$tag->name}</a></span>";
	}
	unset( $tags );
	
?>
<?php if( !empty($thumbnail_url) ){?>
	<div class="col-md-4 m-v-2">
		<img src="<?php echo $thumbnail_url; ?>" class="img-responsive">
	</div>
<?php }?>
<?php if( !empty($thumbnail_url) ){?>
	<div class="col-md-8  m-v-2">
<?php }else{?>
	<div class="col-md-12  m-v-2">
<?php };?>
	<h2 class="h4 dark"><?php the_title();?></h2>
	<p><?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', array( 'class' => 'circle icon-s' ) ); ?>
		<span class="badge">
			<?php get_the_author_meta( 'display_name' )?esc_html_e(get_the_author_meta( 'display_name' )):esc_html_e(get_the_author_meta( 'login' )); ?> wrote on
			<?php the_time('d/m/Y');?>
		</span>
		<?php echo $tags_html; ?>
	</p>
	<?php the_excerpt(); ?>
</div>