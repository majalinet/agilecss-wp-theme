<?php 
$tags =  wp_get_post_tags( $post->ID );
foreach ( $tags as $tag ) {
	if( $querytags ){
		$querytags.=',';
	}else{
		$querytags='';
	}
	$querytags.=$tag->name;
}
$related = new WP_Query( array( '!p' => $current->ID, 'tag' =>$querytags ) );?>
<?php if ( $related->have_posts() ){ ?>
	<div class="row">
		<?php while( $related->have_posts() ){
			$related->the_post();
			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($current->ID), array('220','220'), true );
			$thumbnail_url = $thumbnail_url[0];
			?>
			<div class="col-md-6 row">
				<div class="col-4 p0">
						<img src="<?php echo $thumbnail_url;?>" class="img-responsive">
				</div>
				<div class="col-8 left">
					<p>
						<span class="font-weight-400 left"><?php the_title();?></span>
						<span class="badge"><?php get_the_author_meta( 'display_name' )?esc_html_e(get_the_author_meta( 'display_name' )):esc_html_e(get_the_author_meta( 'login' )); ?>  wrote on <?php the_time('d/m/Y');?></span>
					</p>
					<p>									
						<?php the_excerpt();?>
					</p>
				</div>
			</div>
		<?php };?>
	</div>
<?php };?>
