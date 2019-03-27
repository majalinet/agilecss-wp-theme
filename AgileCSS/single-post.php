<?php
get_header();
$agile_options = get_option( 'agile_option_name' );
switch($agile_options['layout_type']){
	case 'booked':
		$layout_class = 'container';
		break;
	default:
		$layout_class = 'container-fluid';
		break;
}
if ( have_posts() ) {
	the_post();
$tags =  wp_get_post_tags( $post->ID );
$tags_html = '';
foreach ( $tags as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );				 
	$tags_html .= "<span class='badge outline-color-1'><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>";
	$tags_html .= "{$tag->name}</a></span>";
}
unset( $tags );
$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
$thumbnail_url = $thumbnail_url[0];
$current=$post;



?>
	<div class="promo-box-s bg-light-grey">
		<div class="container">
			<h1 class=""><?php wp_title(''); ?></h1>

			<?php custom_breadcrumbs();?>
			<p>
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', array( 'class' => 'circle icon-s' ) ); ?> 
				<span class="badge">
					<?php get_the_author_meta( 'display_name' )?esc_html_e(get_the_author_meta( 'display_name' )):esc_html_e(get_the_author_meta( 'login' )); ?> 
					wrote on
					<?php the_time('d/m/Y');?>
				</span> 
				<?php echo $tags_html; ?>
			</p>
		</div>
	</div>
	<main class="<?php _e($layout_class); ?>">
        <article>
            <div class=" m-v-2">
                <img src="<?php echo $thumbnail_url; ?>" class="img-responsive">
            </div>

            <div>
				<?php the_content();?>
            </div>


        </article>
        <aside>
                <p class="m-v-2">
					<span class="font-weight-400">Aticle Tags: </span>
					<?php echo $tags_html; ?>
				</p>
			<?php
			$signature_img  = get_post_meta($post->ID, 'signature_image', 1);
			$signature_name = get_post_meta($post->ID, 'signature_name', 1);
			$signature_text = get_post_meta($post->ID, 'signature_text', 1);
			?>
			<?php if( $signature_img || $signature_name || $signature_text ){?>
            <div class="outline-light-grey rounded p1 m-v-4">
				<p>
					<?php if( $signature_img ){?>
						<img src="<?php echo $signature_img;?>" class="circle icon-m">  
					<?php };?>
					<?php if( $signature_name ){?>
						Posted by <span class="h5"><?php echo $signature_name;?></span>
					<?php };?>
				</p>
				<?php if( $signature_text ){?>
					<p>
						<?php echo $signature_text;?>
					</p>
				<?php };?>
            </div>
			<?php };?>
			
			<?php				
				get_template_part( 'template-parts/content', 'related' );				
			?>
            <div class="promo-box outline-color-1 rounded center w-100">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<p class="display-6">Join our newsletter to get free updates</p>
					</div>
					<form class="col-md-6 row">
						<div class="col-sm-12 col-md-7 ">

							<input type="email" class="form-control w-100 m0" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

						</div>
						<div class="col-sm-12 col-md-5 ">
							<button type="submit" class="btn btn-primary w-100 m0">Join</button>
						</div>
					</form>
				</div>
			</div>
			<?php $post=$current;?>
			<?php if( comments_open() ){?>
				<?php comments_template(); ?> 
			<?php };?> 
        </aside>
    </main>
<?php
}
get_footer();
?>