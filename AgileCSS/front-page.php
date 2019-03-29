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
?>

	<section id="primary" class="<?php _e($layout_class); ?> content-area">
		<main id="main" class="site-main">
		<?php
		if ( have_posts() ) {
			
			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				
				get_template_part( 'template-parts/content' );
			}

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content', 'none' );

		}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->
	<?php get_sidebar( 'index' ); ?>
	

<?php
get_footer();
